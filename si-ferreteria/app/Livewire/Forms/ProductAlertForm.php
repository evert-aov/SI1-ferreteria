<?php

namespace App\Livewire\Forms;

use App\Models\Inventory\Product;

use Livewire\Form;


class ProductAlertForm extends Form
{
    public $alert_type = '';
    public $threshold_value = 0;
    public $message = '';
    public $priority = 'low';
    public $visible_to = [];
    public $product_id = null;
    public $user_id = null;
    public $status = 'pending';
    public $active = 1;

    public function rules(): array
    {
        return [
            'alert_type' => ['required',
                'in:promotion,low_stock,upcoming_expiration,out_of_stock,expired'],
            'threshold_value' => 'nullable|numeric|min:0',
            'message' => 'required|string|max:500',
            'priority' => 'required|in:low,medium,high',
            'visible_to' => 'required|array',
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,read,ignored',
            'active' => 'boolean',
        ];
    }

    public function set($productAlert): void
    {
        $this->alert_type = $productAlert->alert_type;
        $this->threshold_value = $productAlert->threshold_value;
        $this->message = $productAlert->message;
        $this->priority = $productAlert->priority;
        $this->visible_to = $productAlert->visible_to;
        $this->product_id = $productAlert->product_id;
        $this->user_id = $productAlert->user_id;
    }

    public function getData(): array
    {
        $product = Product::find($this->product_id);
        $this->active = $this->shouldAlertBeActive($product) ? 1 : 0;

        $this->status = 'pending';

        return [
            'alert_type' => $this->alert_type,
            'threshold_value' => $this->threshold_value,
            'message' => $this->message,
            'priority' => $this->priority,
            'visible_to' => $this->visible_to,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'active' => (bool)$this->active,
        ];
    }

    public function reset(...$properties): void
    {
        $this->alert_type = 'promotion';
        $this->threshold_value = null;
        $this->message = '';
        $this->priority = 'medium';
        $this->visible_to = ['Administrador','Vendedor'];
        $this->product_id = null;
    }

    protected function shouldAlertBeActive($product): bool
    {
        if (!$product) return true;

        if ($this->alert_type === 'low_stock') {
            return $product->stock <= $this->threshold_value;
        }

        if ($this->alert_type === 'upcoming_expiration' && $product->expiration_date) {
            $daysRemaining = now()->diffInDays($product->expiration_date, false);
            return $daysRemaining >= 0 && $daysRemaining <= $this->threshold_value;
        }

        return true;
    }

    protected function getStatusMessage(bool $isActive, bool $isEditing = false): string
    {
        if ($isActive) {
            return $isEditing ? 'Alerta actualizada y activada' : 'Alerta creada y activada';
        }

        $action = $isEditing ? 'actualizada' : 'guardada';

        return match($this->alert_type) {
            'low_stock' => "Configuración {$action} (se activará cuando stock ≤ {$this->threshold_value})",
            'upcoming_expiration' => "Configuración {$action} (se activará cuando falten {$this->threshold_value} días o menos)",
            default => "Configuración {$action}"
        };
    }
}
