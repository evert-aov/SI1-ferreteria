<?php

namespace App\Livewire\Inventory;

use App\Models\ReportAndAnalysis\ProductAlert;
use App\Models\Inventory\Product;
use App\Services\ProductAlertService;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Forms\ProductAlertForm;
use Exception;
use Illuminate\Contracts\View\View;
use Livewire\WithFileUploads;

class ProductAlertManager extends Component
{
    use WithPagination, WithFileUploads;

    public ProductAlertForm $form;

    public $show = false;
    public $search = '';
    public $editing = null;
    public bool $hasAccess = false;
    protected $pagination_theme = 'tailwind';

    protected $listeners = ['openModal' => 'openCreateModal',
        'closeToast' => 'closeAlert',
        'ignoreToast' => 'ignoreAlert',
        ];

    public function mount()
    {
        $this->checkAccess();
    }

    public function render(): View
    {
        $products = Product::active()->orderBy('name')->get();

        $alerts = ProductAlert::with('producto')
            ->whereNotNull('user_id') // solo manuales
            ->when($this->search, fn($q) => $q->where('message', 'like', "%{$this->search}%")
                ->orWhereHas('producto', fn($q2) => $q2->where('name', 'like', "%{$this->search}%")))
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.inventory.product-alert.product-alert-manager', compact('alerts', 'products'))
            ->layout('layouts.app');
    }

    protected function checkAccess(): void
    {
        $this->hasAccess = auth()->user()?->roles()
            ->whereIn('name', ['Administrador', 'Vendedor'])
            ->exists() ?? false;
    }

    public function save()
    {
        // Asignar user_id ANTES de validar
        $this->form->user_id = auth()->id();

        $this->form->validate();

        try {
            $data = $this->form->getData();
            if ($this->editing) {
                $alert = ProductAlert::find($this->editing);
                if (!$alert) {
                    session()->flash('error', 'Alerta no encontrada para actualizar');
                    $this->closeModal();
                    return;
                }
                $user_id = $alert->user_id;

                // Mantener el user_id original
                $data['user_id'] = $user_id;
                $this->form->user_id = $user_id;
                $alert->update($data);

            } else {
                $alert = ProductAlert::create($data);
            }


            $statusMessage = $alert->active
                ? ($this->editing ? 'Alerta actualizada y activa' : 'Alerta creada y activa')
                : ($this->editing ? 'Alerta actualizada pero inactiva' : 'Alerta creada pero inactiva');

            session()->flash('message', $statusMessage);
            $this->closeModal();
        } catch (Exception $e) {
            session()->flash('error', 'Error al guardar la alerta: ' . $e->getMessage());
        }
    }

    public function edit($alertId): void
    {
        $this->clearForm();

        $alert = ProductAlert::find($alertId);
        if (!$alert) {
            session()->flash('error', 'Alerta no encontrada');
            return;
        }

        $this->editing = $alert->id;
        $this->form->set($alert);
        $this->show = true;
    }

    public function openCreateModal(): void
    {
        $this->clearForm();
        $this->editing = null;
        $this->show = true;
    }

    public function closeModal(): void
    {
        $this->clearForm();
        $this->show = false;
        $this->dispatch('modal-closed');
    }

    public function clearForm(): void
    {
        $this->form->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function delete($alertId): void
    {
        $alert = ProductAlert::find($alertId);

        try {
            if (!$alert) {
                session()->flash('error', 'Alerta no encontrada');
                return;
            }

            $alert->delete();
            session()->flash('message', 'Alerta eliminada correctamente');
        } catch (Exception $e) {
            session()->flash('error', 'Error al eliminar la alerta: ' . $e->getMessage());
        }
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

        $this->dispatch('toast:addToasts', toasts: $toasts);
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

        $this->dispatch('toast:addToasts', toasts: $toasts);
        session()->flash('message', 'Hay ' . count($toasts) . ' alertas de vencimiento generadas');
    }

    private function makeToast(array|ProductAlert $alert, string $idPrefix): array
    {
        // Normalizar datos
        $id = $alert instanceof ProductAlert ? $alert->id : $alert['product_id'];
        $titulo = $alert instanceof ProductAlert
            ? "Alerta: {$alert->producto->name}"
            : ($alert['titulo'] ?? 'Alerta de producto');
        $descripcion = $alert instanceof ProductAlert
            ? $alert->message
            : ($alert['message'] ?? '');
        $priority = $alert instanceof ProductAlert
            ? $alert->priority
            : ($alert['priority'] ?? 'low');

        $duracion = $this->getDuracionFromPriority($priority);

        return [
            'id' => "{$idPrefix}-{$id}",
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'tipo' => $this->getTipoFromPriority($priority),
            'duracion' => $duracion,
            'autoCierre' => $duracion > 0, // Solo autocierre si duracion > 0
        ];
    }

    private function getTipoFromPriority(string $priority): string
    {
        return match($priority) {
            'high' => 'error',
            'medium' => 'warning',
            default => 'info',
        };
    }

    private function getDuracionFromPriority(string $priority): int
    {
        return match($priority) {
            'high' => 0,
            'medium' => 15000,
            default => 10000,
        };
    }

    /**
     * Ignorar una alerta (no mostrar más)
     */
    public function ignoreAlert($id): void
    {
        // Extraer el ID numérico: "prefix-123"
        $parts = explode('-', $id);
        $alertId = end($parts);

        // Marcar como ignorada en la base de datos
        $alert = ProductAlert::find($alertId);
        if ($alert) {
            $alert->markAsIgnored();
        }
    }

    public function closeAlert($id): void
    {
        $parts = explode('-', $id);
        $alertId = end($parts);

        // Marcar como leída en la base de datos
        $alert = ProductAlert::find($alertId);
        if ($alert) {
            $alert->markAsRead();
        }
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
                'promotion' => true, // aun no implementado
                default => false,
            };

            if ($shouldTrigger) {
                $toasts[] = $this->makeToast($alert, 'alert');
            }
        }

        if (!empty($toasts)) {
            $this->dispatch('toast:addToasts', toasts: $toasts);
        }
    }


}
