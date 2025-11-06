<?php

namespace App\Http\Controllers;

use App\Models\Inventory\Product;
use App\Models\Purchase\PaymentMethod;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CartController extends Controller
{
    /**
     * Mostrar el carrito
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): View
    {
        $cart = session()->get('cart', []);
        $total = $this->calculateTotal($cart);

        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Agregar producto al carrito
     */
    public function add(Request $request, $id): RedirectResponse
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

    /**
     * Actualizar cantidad de producto en el carrito
     */
    public function update(Request $request, $id): RedirectResponse
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

    /**
     * Eliminar producto del carrito
     */
    public function remove($id): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Producto eliminado del carrito.');
        }

        return redirect()->back()->with('error', 'Producto no encontrado en el carrito.');
    }

    /**
     * Vaciar el carrito
     */
    public function clear(): RedirectResponse
    {
        session()->forget('cart');

        return redirect()->back()->with('success', 'Carrito vaciado correctamente.');
    }

    /**
     * Mostrar página de checkout
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $total = $this->calculateTotal($cart);
        $paymentMethods = PaymentMethod::active()->orderBy('sort_order')->get();

        return view('cart.checkout', compact(['cart', 'total', 'paymentMethods']));
    }

    /**
     * Obtener cantidad de items en el carrito
     */
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
     * Calcular totales del carrito
     */
    protected function calculateTotal($cart): array
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
