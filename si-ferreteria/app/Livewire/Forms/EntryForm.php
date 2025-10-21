<?php

namespace App\Livewire\Forms;

use App\Models\Entry;
use App\Models\Product;
use Livewire\Features\SupportFormObjects\Form;

class EntryForm extends Form
{
    // Campos de Entry
    public $invoice_number = '';
    public $invoice_date = '';
    public $document_type = '';
    public $supplier_id = '';

    // Campos para agregar productos
    public $product_id = '';
    public $quantity = 1;
    public $purchase_price = 0;
    public $sale_price = 0;

    // Método de pago
    public $payment_method_id = '';
    public $payment_amount = 0;

    public $items = [];

    public function rules(): array
    {
        return [
            'invoice_number' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'document_type' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,user_id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.purchase_price' => 'required|numeric|min:0',
            'items.*.sale_price' => 'required|numeric|min:0',
        ];
    }

    public function addItem(): void
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
        ]);

        $product = Product::find($this->product_id);

        $subtotal = $this->quantity * $this->purchase_price;

        $this->items[] = [
            'product_id' => $this->product_id,
            'product_name' => $product->name,
            'quantity' => $this->quantity,
            'purchase_price' => $this->purchase_price,
            'sale_price' => $this->sale_price,
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
            'purchase_price',
            'sale_price'
        ]);

        $this->quantity = 1;
        $this->purchase_price = 0;
        $this->sale_price = 0;
    }

    public function getTotalAmount(): float
    {
        return collect($this->items)->sum('subtotal');
    }

    public function generateInvoiceNumber(): void
    {
        $lastEntry = Entry::where('document_type', $this->document_type)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastEntry) {
            preg_match('/\d+/', $lastEntry->invoice_number, $matches);
            $lastNumber = $matches[0] ?? 0;
            $newNumber = intval($lastNumber) + 1;
        } else {
            $newNumber = 1;
        }

        $this->invoice_number = $this->formatInvoiceNumber($newNumber);
    }

    private function formatInvoiceNumber(int $number): string
    {
        $prefix = match($this->document_type) {
            'FACTURA' => 'FAC',
            'RECIBO' => 'REC',
            'NOTA_FISCAL' => 'NF',
            'NOTA_CREDITO' => 'NC',
            'NOTA_DEBITO' => 'ND',
            default => 'DOC',
        };

        return sprintf('%s-%06d', $prefix, $number);
    }

    public function set($purchases): void
    {
        $this->invoice_date = $purchases->invoice_date;
        $this->document_type = $purchases->document_type;
        $this->supplier_id = $purchases->supplier_id;
        $this->product_id = $purchases->product_id;
        $this->quantity = $purchases->quantity;
        $this->purchase_price = $purchases->purchase_price;
        $this->sale_price = $purchases->sale_price;
        $this->payment_method_id = $purchases->payment_method_id;
        $this->payment_amount = $purchases->payment_amount;
    }
}
