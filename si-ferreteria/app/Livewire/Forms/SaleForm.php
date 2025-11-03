<?php

namespace App\Livewire\Forms;

use App\Models\Inventory\Product;
use App\Models\SaleUnperson;
use Livewire\Features\SupportFormObjects\Form;

class SaleForm extends Form
{
    // Campos de Sale
    public $invoice_number = '';
    public $customer_id = '';
    public $payment_method_id = '';
    public $discount = 0;
    public $tax = 0;
    public $notes = '';

    // Campos para agregar productos
    public $product_id = '';
    public $quantity = 1;
    public $unit_price = 0;
    public $discount_percentage = 0;

    // Método de pago
    public $payment_amount = 0;

    public $items = [];

    public function rules(): array
    {
        return [
            'invoice_number' => 'required|string|max:255',
            'customer_id' => 'required|exists:users,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
        ];
    }

    public function addItem(): void
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'unit_price' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $product = Product::find($this->product_id);

        // Verificar stock disponible
        if ($product->stock < $this->quantity) {
            throw new \Exception("Stock insuficiente. Disponible: {$product->stock}");
        }

        $subtotalBruto = $this->quantity * $this->unit_price;
        $descuento = $subtotalBruto * ($this->discount_percentage / 100);
        $subtotal = $subtotalBruto - $descuento;

        $this->items[] = [
            'product_id' => $this->product_id,
            'product_name' => $product->name,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'discount_percentage' => $this->discount_percentage,
            'subtotal' => $subtotal,
        ];

        $this->clearProductFields();
    }

    public function removeItem(int $index): void
    {
        if (isset($this->items[$index])) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }
    }

    public function clearProductFields(): void
    {
        $this->reset([
            'product_id',
            'quantity',
            'unit_price',
            'discount_percentage'
        ]);

        $this->quantity = 1;
        $this->unit_price = 0;
        $this->discount_percentage = 0;
    }

    public function getTotalAmount(): float
    {
        return collect($this->items)->sum('subtotal');
    }

    public function getSubtotal(): float
    {
        return $this->getTotalAmount();
    }

    public function getTotal(): float
    {
        return $this->getSubtotal() - $this->discount + $this->tax;
    }

    public function generateInvoiceNumber(): void
    {
        $lastSale = SaleUnperson::orderBy('id', 'desc')->first();

        if ($lastSale) {
            preg_match('/\d+/', $lastSale->invoice_number, $matches);
            $lastNumber = $matches[0] ?? 0;
            $newNumber = intval($lastNumber) + 1;
        } else {
            $newNumber = 1;
        }

        $this->invoice_number = $this->formatInvoiceNumber($newNumber);
    }

    public function loadProductPrice(): void
    {
        if ($this->product_id) {
            $product = Product::find($this->product_id);
            if ($product) {
                $this->unit_price = $product->sale_price;
            }
        }
    }

    public function set($sale): void
    {
        $this->invoice_number = $sale->invoice_number;
        $this->customer_id = $sale->customer_id;
        $this->payment_method_id = $sale->payment_method_id;
        $this->discount = $sale->discount;
        $this->tax = $sale->tax;
        $this->notes = $sale->notes;
    }

    private function formatInvoiceNumber(int $number): string
    {
        $prefix = 'FAC';
        return sprintf('%s-%06d', $prefix, $number);
    }
}
