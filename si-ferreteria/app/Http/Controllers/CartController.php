<?php

namespace App\Http\Controllers;

use App\Models\Inventory\Product;
use App\Models\User_security\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = $this->calculateTotal($cart);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $newQuantity = $cart[$id]['quantity'] + $request->quantity;

            if ($newQuantity > $product->stock) {
                return redirect()->back()->with('error', 'No hay suficiente stock disponible.');
            }

            $cart[$id]['quantity'] = $newQuantity;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'quantity' => $request->quantity,
                'price' => $product->sale_price,
                'image' => $product->image,
                'currency' => $product->sale_price_unit,
                'stock' => $product->stock
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', '¡Producto agregado al carrito!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $product = Product::findOrFail($id);

            if ($request->quantity > $product->stock) {
                return redirect()->back()->with('error', 'No hay suficiente stock disponible.');
            }

            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Cantidad actualizada correctamente.');
        }

        return redirect()->back()->with('error', 'Producto no encontrado en el carrito.');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Producto eliminado del carrito.');
        }

        return redirect()->back()->with('error', 'Producto no encontrado en el carrito.');
    }

    public function clear()
    {
        session()->forget('cart');

        return redirect()->back()->with('success', 'Carrito vaciado correctamente.');
    }

    public function checkout()
    {
        // El middleware 'auth' ya garantiza que hay un usuario autenticado
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $total = $this->calculateTotal($cart);

        return view('cart.checkout', compact('cart', 'total'));
    }

    private function calculateTotal($cart)
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

    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        $count = 0;

        foreach ($cart as $details) {
            $count += $details['quantity'];
        }

        return response()->json(['count' => $count]);
    }

    /**
     * @throws \Throwable
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function processOrder(Request $request)
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
            'payment_method' => 'required|in:cash,paypal,qr',
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
                'order_notes' => $request->shipping_notes,
                'discount' => $request->discount,
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

            return redirect()->route('cart.success')->with('success', '¡Pedido realizado con éxito!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Error al procesar el pedido: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function success()
    {
        $order = session()->get('last_order');

        if (!$order) {
            return redirect()->route('products.index');
        }

        return view('cart.success', compact('order'));
    }
}
