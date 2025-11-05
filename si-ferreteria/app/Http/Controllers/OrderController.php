<?php

namespace App\Http\Controllers;

use App\Models\Inventory\Product;
use App\Models\User_security\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class OrderController extends Controller
{
    /**
     * Procesar orden con método de pago en efectivo
     *
     * @throws \Throwable
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function process(Request $request): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_state' => 'required|string',
            'shipping_zip' => 'nullable|string',
            'shipping_notes' => 'nullable|string',
            'payment_method' => 'required|in:cash,qr',
            'order_notes' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0',
        ]);

        // Verificar stock de todos los productos ANTES de la transacción
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if (!$product || $product->stock < $details['quantity']) {
                return redirect()->back()
                    ->with('error', 'Stock insuficiente para el producto: ' . $details['name'])
                    ->withInput();
            }
        }

        try {
            DB::beginTransaction();

            $total = $this->calculateTotal($cart);

            /** @var User $user */
            $user = auth()->user();

            // Actualizar información del usuario
            $user->update([
                'name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'document_number' => $request->customer_nit,
            ]);

            $customerData = [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'nit' => $user->document_number,
            ];

            // Generar número de factura único
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            // Crear el array de datos de la orden
            $orderData = [
                'invoice_number' => $invoiceNumber,
                'customer' => $customerData,
                'shipping' => [
                    'address' => $request->shipping_address,
                    'city' => $request->shipping_city,
                    'state' => $request->shipping_state,
                    'zip' => $request->shipping_zip,
                ],
                'payment_method' => $request->payment_method,
                'order_notes' => $request->order_notes,
                'discount' => $request->discount ?? 0,
                'subtotal' => $total['subtotal'],
                'tax' => $total['tax'],
                'total' => $total['total'],
                'items' => $cart,
                'created_at' => now(),
            ];

            // Actualizar stock de productos
            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                $product->stock -= $details['quantity'];
                $product->output += $details['quantity'];
                $product->save();
            }

            DB::commit();

            session()->put('last_order', $orderData);
            session()->forget('cart');

            return redirect()->route('order.success')->with('success', '¡Pedido realizado con éxito!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Error al procesar el pedido: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Mostrar página de éxito después de completar la orden
     */
    public function success(): View|RedirectResponse
    {
        $order = session()->get('last_order');

        if (!$order) {
            return redirect()->route('products.index');
        }

        return view('cart.success', compact('order'));
    }

    /**
     * Calcular totales del carrito
     */
    private function calculateTotal($cart): array
    {
        $subtotal = 0;
        $items = [];

        foreach ($cart as $id => $details) {
            $itemTotal = $details['price'] * $details['quantity'];
            $subtotal += $itemTotal;

            $items[$id] = [
                'details' => $details,
                'total' => $itemTotal
            ];
        }

        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'tax' => $subtotal * 0.13,
            'total' => $subtotal * 1.13,
        ];
    }
}
