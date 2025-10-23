<?php

namespace App\Livewire\ReportAndAnalysis;

use App\Models\ReportAndAnalysis\ProductAlert;
use App\Models\Inventory\Product;
use App\Services\ProductAlertService;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\ToastManager;


class ProductAlertManager extends Component
{
    use WithPagination;

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

    protected $listeners = ['openModal' => 'openCreateModal',
        'closeToast' => 'closeAlert',
        'ignoreToast' => 'ignoreAlert',
        ];



    public $alertTypes = [
        'promotion' => '🎉 Oferta/Promoción',
        'low_stock' => '📦 Stock Bajo',
        'expired' => '❌ Vencido',
        'upcoming_expiration' => '⚠️ Próximo a Vencer',
        'out_of_stock' => '🔭 Sin Stock',
    ];

    public $priorities = [
        'low' => 'Baja',
        'medium' => 'Media',
        'high' => 'Alta',
    ];

    public $availableRoles = [
        'Administrador', 'Vendedor', 'Cliente', 'Proveedor',
    ];

    protected $rules = [
        'selectedProductId' => 'required|exists:products,id',
        'customMessage' => 'required|min:10|max:500',
        'selectedPriority' => 'required|in:low,medium,high',
        'selectedRoles' => 'required|array|min:1',
    ];

    public function mount()
    {
        $this->selectedRoles = ['Administrador', 'Vendedor'];
        $this->checkAccess();
    }

    public function render()
    {
        $products = Product::active()->orderBy('name')->get();

        $alerts = ProductAlert::with('producto')
            ->whereNotNull('user_id') // solo manuales
            ->when($this->search, fn($q) => $q->where('message', 'like', "%{$this->search}%")
                ->orWhereHas('producto', fn($q2) => $q2->where('name', 'like', "%{$this->search}%")))
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.product-alert.product-alert-manager', compact('alerts', 'products'))
            ->layout('layouts.app');
    }

    protected function checkAccess(): void
    {
        $this->hasAccess = auth()->user()?->roles()
            ->whereIn('name', ['Administrador', 'Vendedor'])
            ->exists() ?? false;
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->editing = null;
        $this->show = true;
    }

    public function closeModal()
    {
        $this->show = false;
        $this->resetForm();
    }

    public function save()
    {
        $rules = $this->rules;

        if (in_array($this->selectedAlertType, ['low_stock', 'upcoming_expiration'])) {
            $rules['thresholdValue'] = 'required|numeric|min:0';
        }

        $this->validate($rules);

        $product = Product::find($this->selectedProductId);

        if ($this->editing) {
            $alert = ProductAlert::find($this->editing);
            if (!$alert) return;

            $alert->update([
                'alert_type' => $this->selectedAlertType,
                'threshold_value' => $this->thresholdValue,
                'message' => $this->customMessage,
                'priority' => $this->selectedPriority,
                'visible_to' => $this->selectedRoles,
                'product_id' => $this->selectedProductId,
                'active' => $this->shouldAlertBeActive($product),
                'status' => 'pending',
            ]);
        } else {
            $alert = ProductAlert::create([
                'alert_type' => $this->selectedAlertType,
                'threshold_value' => $this->thresholdValue,
                'message' => $this->customMessage,
                'priority' => $this->selectedPriority,
                'visible_to' => $this->selectedRoles,
                'product_id' => $this->selectedProductId,
                'user_id' => auth()->id(),
                'status' => 'pending',
                'active' => $this->shouldAlertBeActive($product),
            ]);
        }

        $statusMessage = $this->getStatusMessage($alert->active, $this->editing !== null);
        session()->flash('message', $statusMessage);
        $this->closeModal();
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

    protected function shouldAlertBeActive($product): bool
    {
        if (!$product) return true;

        if ($this->selectedAlertType === 'low_stock') {
            return $product->stock <= $this->thresholdValue;
        }

        if ($this->selectedAlertType === 'upcoming_expiration' && $product->expiration_date) {
            $daysRemaining = now()->diffInDays($product->expiration_date, false);
            return $daysRemaining >= 0 && $daysRemaining <= $this->thresholdValue;
        }

        return true;
    }

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

    public function delete($alertId)
    {
        $alert = ProductAlert::find($alertId);

        if ($alert) {
            $alert->delete();
            session()->flash('message', 'Alerta eliminada exitosamente');
        }
    }

    protected function resetForm()
    {
        $this->reset(['selectedProductId', 'customMessage', 'thresholdValue', 'editing']);
        $this->selectedAlertType = 'promotion';
        $this->selectedPriority = 'medium';
        $this->selectedRoles = ['Administrador', 'Vendedor'];
    }

    public function runStockCheck()
    {
        $checker = app(ProductAlertService::class);

        $alerts = $checker->checkBajoStock();
        $alerts = array_merge($alerts, $checker->checkSinStock());

        $toasts = [];
        foreach ($alerts as $alert) {
            $toasts[] = $this->makeToast($alert, 'stock');
        }

        // Enviar directamente al ToastManager usando dispatch to
        $this->dispatch('toast:addToasts', toasts: $toasts)->to(ToastManager::class);

        session()->flash('message', 'Hay ' . count($toasts) . ' alertas de stock generadas');
    }

    public function runExpirationCheck()
    {
        $checker = app(ProductAlertService::class);

        $alerts = $checker->checkVencido();
        $alerts = array_merge($alerts, $checker->checkVencimientoProximo());

        $toasts = [];
        foreach ($alerts as $alert) {
            $toasts[] = $this->makeToast($alert, 'expiration');
        }

        // Enviar directamente al ToastManager usando dispatch to
        $this->dispatch('toast:addToasts', toasts: $toasts)->to(ToastManager::class);

        session()->flash('message', 'Hay ' . count($toasts) . ' alertas de vencimiento generadas');
    }

    private function makeToast(array|ProductAlert $alert, string $idPrefix): array
    {
        if ($alert instanceof ProductAlert) {
            return [
                'id' => "{$idPrefix}-{$alert->id}",
                'titulo' => "Alerta: {$alert->producto->name}",
                'descripcion' => $alert->message,
                'tipo' => match($alert->priority) {
                    'high' => 'error',
                    'medium' => 'warning',
                    'low' => 'info',
                    default => 'info',
                },
                'autoCierre' => $alert->priority !== 'high',
                'duracion' => match($alert->priority) {
                    'high' => 0,
                    'medium' => 15000,
                    'low' => 10000,
                    default => 10000,
                },
            ];
        }

        // Caso array (alertas automáticas del ProductAlertService)
        $priority = $alert['priority'] ?? 'low';

        return [
            'id' => "{$idPrefix}-{$alert['product_id']}-{$alert['alert_type']}",
            'titulo' => $alert['titulo'] ?? 'Alerta de producto',
            'descripcion' => $alert['message'] ?? '',
            'tipo' => match($priority) {
                'high' => 'error',
                'medium' => 'warning',
                'low' => 'info',
                default => 'info',
            },
            'autoCierre' => $priority !== 'high',
            'duracion' => match($priority) {
                'high' => 0,
                'medium' => 15000,
                'low' => 10000,
                default => 10000,
            },
        ];
    }

    /**
     * Ignorar una alerta (no mostrar más)
     */
    public function ignoreAlert($id): void
    {
        // Extraer el ID real de la alerta (formato: alert-123)
        $alertId = str_replace('alert-', '', $id);

        // Marcar como ignorada en la base de datos
        $alert = ProductAlert::find($alertId);
        if ($alert) {
            $this->checkAsIgnored($alertId);
        }

        $this->dispatch('toast:removeToast', id: $id)->to(ToastManager::class);

    }

    public function closeAlert($id): void
    {
        // Extraer el ID real de la alerta (formato: alert-123)
        $alertId = str_replace('alert-', '', $id);

        // Marcar como leída en la base de datos
        $alert = ProductAlert::find($alertId);
        if ($alert) {
            $this->checkAsRead($alertId);
        }

        $this->dispatch('toast:removeToast', id: $id)->to(ToastManager::class);
    }

    public function runManualAlerts(): void
    {
        $alerts = ProductAlert::where('status', 'pending')
            ->where('active', true)
            ->with('producto')
            ->get();

        $toasts = [];

        foreach ($alerts as $alert) {
            $product = $alert->producto;

            // Verificar si la alerta realmente cumple su condición
            $shouldTrigger = match($alert->alert_type) {
                'low_stock' => $product && $product->stock <= $alert->threshold_value,
                'upcoming_expiration' => $product && $product->expiration_date &&
                                        now()->diffInDays($product->expiration_date, false) >= 0 &&
                                        now()->diffInDays($product->expiration_date, false) <= $alert->threshold_value,
                'expired' => $product && $product->expiration_date && now()->greaterThanOrEqualTo($product->expiration_date),
                'out_of_stock' => $product && $product->stock == 0,
                'promotion' => true, // siempre se puede disparar
                default => false,
            };

            if ($shouldTrigger) {
                $toasts[] = $this->makeToast($alert, 'alert');

                // Opcional: marcar como leída/activada para no disparar nuevamente
                $this->checkAsRead($alert->id);
            }
        }

        if (!empty($toasts)) {
            $this->dispatch('toast:addToasts', toasts: $toasts)->to(ToastManager::class);
        }
    }

    public function markAsPending($alertId): void
    {
        $alert = ProductAlert::find($alertId);
        if ($alert) {
            $alert->status = 'pending';
            $alert->save();
        }
    }

    public function checkAsRead($alertId): void
    {
        $alert = ProductAlert::find($alertId);
        if ($alert) {
            $alert->checkAsRead();
        }
    }

    public function checkAsIgnored($alertId): void
    {
        $alert = ProductAlert::find($alertId);
        if ($alert) {
            $alert->checkAsIgnored();
        }
    }


}
