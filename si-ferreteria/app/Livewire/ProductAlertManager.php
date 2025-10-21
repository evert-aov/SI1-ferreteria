<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductAlert;
use App\Services\ProductAlertChecker;
use Livewire\Component;
use Livewire\WithPagination;

class ProductAlertManager extends Component
{
    use WithPagination;

    // Properties for data-table component
    public $show = false;
    public $search = '';
    public $editing = null;
    public bool $hasAccess = false;

    // Form properties
    public $selectedAlertType = 'promotion';
    public $selectedProductId = null;
    public $customMessage = '';
    public $selectedPriority = 'medium';
    public $selectedRoles = ['Administrador', 'Vendedor'];
    public $thresholdValue = null;

    public $checkResults = [];

    // Available options
    public $alertTypes = [
        'promotion' => '🎉 Oferta/Promoción',
        'low_stock' => '📦 Stock Bajo',
        'expired' => '❌ Vencido',
        'upcoming_expiration' => '⚠️ Próximo a Vencer',
        'out_of_stock' => '📭 Sin Stock',
    ];

    public $priorities = [
        'low' => 'Baja',
        'medium' => 'Media',
        'high' => 'Alta',
    ];

    public $availableRoles = [
        'Administrador',
        'Vendedor',
        'Cliente',
        'Proveedor',
    ];

    protected $listeners = [
        'openModal' => 'openCreateModal',
    ];

    public function mount()
    {
        $this->selectedRoles = ['Administrador', 'Vendedor'];
        $this->checkAccess();
    }

    public function render()
    {
        $products = Product::active()->orderBy('name')->get();

        // Solo mostrar alertas MANUALES (creadas por usuarios)
        $alerts = ProductAlert::with('producto')
            ->whereNotNull('user_id') // Solo alertas creadas manualmente
            ->when($this->search, function($query) {
                $query->where('message', 'like', '%' . $this->search . '%')
                      ->orWhereHas('producto', function($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.product-alert.product-alert-manager',
            compact('alerts', 'products'))->layout('layouts.app');
    }

    /**
     * Abrir modal para crear alerta
     */
    public function openCreateModal()
    {
        $this->resetForm();
        $this->editing = null;
        $this->show = true;
    }

    /**
     * Cerrar modal
     */
    public function closeModal()
    {
        $this->show = false;
        $this->resetForm();
    }

    protected function checkAccess(): void
    {
        $user = auth()->user();

        if (!$user) {
            $this->hasAccess = false;
            return;
        }

        // Solo Administrador y Vendedor tienen acceso
        $this->hasAccess = $user->roles()
            ->whereIn('name', ['Administrador', 'Vendedor'])
            ->exists();
    }

    protected $rules = [
            'selectedProductId' => 'required|exists:products,id',
            'customMessage' => 'required|min:10|max:500',
            'selectedPriority' => 'required|in:low,medium,high',
            'selectedRoles' => 'required|array|min:1',
    ];

    /**
     * Guardar (crear o actualizar)
     */
    public function save()
    {
        $rules = $this->rules;

        // Validar umbral para tipos que lo requieren
        if (in_array($this->selectedAlertType, ['low_stock', 'upcoming_expiration'])) {
            $rules['thresholdValue'] = 'required|numeric|min:0';
        }

        $this->validate($rules);

        if ($this->editing) {
            // Actualizar
            $alert = ProductAlert::find($this->editing);

            if ($alert) {
                $product = Product::find($this->selectedProductId);

                // Determinar si debe estar activa después de la actualización
                $shouldBeActive = $this->shouldAlertBeActive($product);

                $alert->update([
                    'alert_type' => $this->selectedAlertType,
                    'threshold_value' => $this->thresholdValue,
                    'message' => $this->customMessage,
                    'priority' => $this->selectedPriority,
                    'visible_to' => $this->selectedRoles,
                    'product_id' => $this->selectedProductId,
                    'active' => $shouldBeActive,
                    'status' => 'pending',
                ]);

                $statusMessage = $this->getStatusMessage($shouldBeActive, true);
                session()->flash('message', $statusMessage);
            }
        } else {
            // Crear
            $product = Product::find($this->selectedProductId);

            // Verificar si se debe activar inmediatamente según el tipo de alerta
            $shouldShowNow = $this->shouldAlertBeActive($product);

            ProductAlert::create([
                'alert_type' => $this->selectedAlertType,
                'threshold_value' => $this->thresholdValue,
                'message' => $this->customMessage,
                'priority' => $this->selectedPriority,
                'status' => 'pending', // Siempre pending, el control es con 'active'
                'visible_to' => $this->selectedRoles,
                'user_id' => auth()->id(),
                'product_id' => $this->selectedProductId,
                'active' => $shouldShowNow, // Solo activa si cumple condición
            ]);

            $statusMessage = $this->getStatusMessage($shouldShowNow);
            session()->flash('message', $statusMessage);
        }

        $this->closeModal();
    }

    protected function shouldAlertBeActive(Product $product): bool
    {
        if ($this->selectedAlertType === 'low_stock') {
            return $product->stock <= $this->thresholdValue;
        } elseif ($this->selectedAlertType === 'upcoming_expiration' && $product->expiration_date) {
            $daysRemaining = now()->diffInDays($product->expiration_date, false);
            return $daysRemaining >= 0 && $daysRemaining <= $this->thresholdValue;
        }

        return true;
    }

    protected function getStatusMessage(bool $isActive, bool $isEditing = false): string
    {
        if ($isActive) {
            return $isEditing ? 'Alerta actualizada y activada' : 'Alerta creada y activada';
        }

        $action = $isEditing ? 'actualizada' : 'guardada';

        return match($this->selectedAlertType) {
            'low_stock' => "Configuración {$action} (se activará cuando stock ≤ {$this->thresholdValue})",
            'upcoming_expiration' => "Configuración {$action} (se activará cuando falten {$this->thresholdValue} días o menos)",
            default => "Configuración {$action}"
        };
    }

    /**
     * Editar alerta
     */
    public function edit($alertId)
    {
        $alert = ProductAlert::find($alertId);

        if ($alert) {
            $this->editing = $alert->id;
            $this->selectedAlertType = $alert->alert_type;
            $this->selectedProductId = $alert->product_id;
            $this->customMessage = $alert->message;
            $this->selectedPriority = $alert->priority;
            $this->selectedRoles = $alert->visible_to ?? ['Administrador', 'Vendedor'];
            $this->thresholdValue = $alert->threshold_value;
            $this->show = true;
        }
    }

    /**
     * Eliminar alerta
     */
    public function delete($alertId)
    {
        $alert = ProductAlert::find($alertId);

        if ($alert) {
            $alert->delete();
            session()->flash('message', 'Alerta eliminada exitosamente');
        }
    }

    /**
     * Cambiar estado de notificación a "Pendiente"
     */
    public function markAsPending($alertId)
    {
        $alert = ProductAlert::find($alertId);

        if ($alert && $alert->user_id !== null) {
            $alert->update(['status' => 'pending']);
            session()->flash('message', 'Alerta marcada como pendiente');
        }
    }

    /**
     * Cambiar estado de notificación a "Leída"
     */
    public function markAsRead($alertId)
    {
        $alert = ProductAlert::find($alertId);

        if ($alert && $alert->user_id !== null) {
            $alert->marcarComoLeida();
            session()->flash('message', 'Alerta marcada como leída');
        }
    }

    /**
     * Cambiar estado de notificación a "Ignorada"
     */
    public function markAsIgnored($alertId)
    {
        $alert = ProductAlert::find($alertId);

        if ($alert && $alert->user_id !== null) {
            $alert->ignorar();
            session()->flash('message', 'Alerta marcada como ignorada');
        }
    }

    /**
     * Resetear formulario
     */
    protected function resetForm()
    {
        $this->reset(['selectedProductId', 'customMessage', 'thresholdValue', 'editing']);
        $this->selectedAlertType = 'upcoming_expiration';
        $this->selectedPriority = 'medium';
        $this->selectedRoles = ['Administrador', 'Vendedor'];
    }

        /**
     * Ejecutar verificación automática de vencimientos
     */
    public function runExpirationCheck()
    {
        $checker = app(ProductAlertChecker::class);

        $checker->checkVencido();
        $checker->checkVencimientoProximo();

        $expiredCount = ProductAlert::tipo('expired')->pendientes()->count();
        $upcomingCount = ProductAlert::tipo('upcoming_expiration')->pendientes()->count();

        $this->checkResults = [
            'vencido' => "✅ {$expiredCount} alertas de productos vencidos",
            'vencimiento_proximo' => "✅ {$upcomingCount} alertas de vencimiento próximo",
        ];

        session()->flash('message', "Se generaron {$expiredCount} alertas de vencidos y {$upcomingCount} de próximos a vencer");
    }

    /**
     * Ejecutar verificación de stock
     */
    public function runStockCheck()
    {
        $checker = app(ProductAlertChecker::class);

        $checker->checkSinStock();
        $checker->checkBajoStock();

        $outOfStockCount = ProductAlert::tipo('out_of_stock')->pendientes()->count();
        $lowStockCount = ProductAlert::tipo('low_stock')->pendientes()->count();

        $this->checkResults = [
            'sin_stock' => "✅ {$outOfStockCount} alertas de sin stock",
            'bajo_stock' => "✅ {$lowStockCount} alertas de stock bajo",
        ];

        session()->flash('message', "Se encontraron {$outOfStockCount} productos sin stock y {$lowStockCount} con stock bajo");
    }


    /**
     * Desactivar todas las alertas de un tipo específico
     */
    public function deactivateAllByType($alertType)
    {
        $count = ProductAlert::whereNull('user_id')
            ->where('alert_type', $alertType)
            ->where('active', true)
            ->update(['active' => false]);

        session()->flash('message', "{$count} alertas de tipo '{$this->alertTypes[$alertType]}' desactivadas");
    }

    /**
     * Activar todas las alertas de un tipo específico
     */
    public function activateAllByType($alertType)
    {
        $count = ProductAlert::whereNull('user_id')
            ->where('alert_type', $alertType)
            ->where('active', false)
            ->update(['active' => true]);

        session()->flash('message', "{$count} alertas de tipo '{$this->alertTypes[$alertType]}' activadas");
    }
}
