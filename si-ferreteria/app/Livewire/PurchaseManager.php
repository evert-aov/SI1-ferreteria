<?php

namespace App\Livewire;

use App\Livewire\Forms\EntryForm;
use App\Models\Entry;
use App\Models\EntryDetail;
use App\Models\EntryPayment;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PurchaseManager extends Component
{
    use WithPagination, WithFileUploads;

    protected $pagination_theme = 'tailwind';

    public EntryForm $form;
    public $allSuppliers = [];
    public $allProducts = [];
    public $allPayment = [];

    public function mount(): void
    {
        $this->getRelations();
        $this->form->invoice_date = now()->format('Y-m-d');
    }


    public function updatedFormDocumentType(): void
    {
        $this->form->generateInvoiceNumber();
    }

    public function getRelations(): void
    {
        $this->allProducts = Product::all();
        $this->allSuppliers = Supplier::all();
        $this->allPayment = PaymentMethod::all();
    }

    public function render(): View
    {
        $purchases = Entry::all();
        return view('livewire.purchase.purchase-manager', compact('purchases'))
            ->layout('layouts.app');
    }

    public function addItem(): void
    {
        try {
            $this->form->addItem();
            session()->flash('message', 'Producto agregado a la lista');
            $this->form->clearProductFields();
        } catch (ValidationException $e) {
            $this->dispatch('validation-error', $e->getMessage());
        }

    }

    public function removeItem($index): void
    {
        $this->form->removeItem($index);
        session()->flash('message', 'Producto eliminado de la lista');
    }


    public function create(): void
    {
        $this->form->validate();

        DB::beginTransaction();

        try {
            $entry = Entry::create([
                'invoice_number' => $this->form->invoice_number,
                'invoice_date' => $this->form->invoice_date,
                'document_type' => $this->form->document_type,
                'supplier_id' => $this->form->supplier_id,
                'total' => 0,
            ]);


            foreach ($this->form->items as $item) {
                EntryDetail::create([
                    'entry_id' => $entry->id,
                    'product_id' => $item['product_id'],
                    'price' => $item['purchase_price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['purchase_price'] * $item['quantity'],
                ]);


                $product = Product::find($item['product_id']);
                $product->input += $item['quantity'];
                $product->stock += $item['quantity'];
                $product->purchase_price = $item['purchase_price'];
                $product->sale_price = $item['sale_price'];
                $product->save();
            }


            $entry->updateTotal();


            if ($this->form->payment_amount > 0) {
                EntryPayment::create([
                    'entry_id' => $entry->id,
                    'payment_method_id' => $this->form->payment_method_id,
                    'amount' => $this->form->payment_amount,
                ]);
            }

            DB::commit();

            session()->flash('success', 'Compra registrada exitosamente');
            $this->form->items = [];
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al registrar la compra: ' . $e->getMessage());
        }
        $this->form->reset();
    }
}
