<?php

namespace App\Livewire\Sales;

use App\Livewire\Forms\SaleForm;
use App\Models\Inventory\Product;
use App\Models\Payment;
use App\Models\Purchase\PaymentMethod;
use App\Models\SaleDetail;
use App\Models\SaleUnperson;
use App\Models\User_security\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;


class SaleManager extends Component
{
    use WithPagination;

    protected $pagination_theme = 'tailwind';

    public SaleForm $form;
    public $allCustomers = [];
    public $allProducts = [];
    public $allPaymentMethods = [];

    public function mount(): void
    {
        $this->getRelations();
        $this->form->generateInvoiceNumber();
    }

    public function updatedFormProductId(): void
    {
        $this->form->loadProductPrice();
    }

    public function getRelations(): void
    {
        $this->allProducts = Product::where('stock', '>', 0)->get();

        // Obtener solo usuarios que tienen el rol 'cliente' (case insensitive)
        $this->allCustomers = User::with('roles')
            ->whereHas('roles', function($query) {
                $query->whereRaw('LOWER(name) = ?', ['cliente']);
            })
            ->get();

        $this->allPaymentMethods = PaymentMethod::where('is_active', true)->get();
    }

    public function render(): View
    {
        $sales = SaleUnperson::with(['customer', 'saleDetails.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.sales.sale-manager', compact('sales'))
            ->layout('layouts.app');
    }

    public function addItem(): void
    {
        try {
            $this->form->addItem();
            session()->flash('message', 'Producto agregado a la lista');
        } catch (ValidationException $e) {
            $this->dispatch('validation-error', $e->getMessage());
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
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
            // Crear la venta
            $sale = SaleUnperson::create([
                'invoice_number' => $this->form->invoice_number,
                'customer_id' => $this->form->customer_id,
                'payment_id' => null,
                'subtotal' => 0,
                'discount' => $this->form->discount,
                'tax' => $this->form->tax,
                'total' => 0,
                'status' => 'paid',
                'notes' => $this->form->notes,
            ]);

            // Crear los detalles de venta y actualizar el inventario
            foreach ($this->form->items as $item) {
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount_percentage' => $item['discount_percentage'] ?? 0,
                    'subtotal' => $item['subtotal'],
                ]);

                // Actualizar stock del producto
                $product = Product::find($item['product_id']);
                $product->output += $item['quantity'];
                $product->stock -= $item['quantity'];
                $product->save();
            }

            // Actualizar el total de la venta
            $sale->updateTotal();

            // Crear el pago
            if ($this->form->payment_amount > 0) {
                $payment = Payment::create([
                    'sale_id' => $sale->id,
                    'payment_method_id' => $this->form->payment_method_id,
                    'amount' => $this->form->payment_amount > 0 ? $this->form->payment_amount : $sale->total,
                    'transaction_reference' => null,
                    'payment_date' => now(),
                    'status' => 'completed',
                ]);

                $sale->payment_id = $payment->id;
                $sale->save();
            }

            DB::commit();

            session()->flash('success', 'Venta registrada exitosamente');
            $this->form->items = [];
            $this->form->reset();
            $this->form->generateInvoiceNumber();
            $this->getRelations();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al registrar la venta: ' . $e->getMessage());
        }
    }
}
