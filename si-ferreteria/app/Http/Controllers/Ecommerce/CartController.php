<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
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
            'quantity' => 'required|integer|min:1|max:'.$product->stock,
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
                'stock' => $product->stock,
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
            'quantity' => 'required|integer|min:1',
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
     * Aplicar cupón de descuento
     */
    public function applyDiscount(Request $request): RedirectResponse
    {
        $request->validate([
            'discount_code' => 'required|string',
        ]);

        $code = strtoupper(trim($request->discount_code));

        // Buscar el cupón
        $discount = \App\Models\Discount::where('code', $code)->first();

        if (! $discount) {
            return redirect()->back()->with('error', 'El cupón ingresado no existe.');
        }

        // Validar el cupón
        if (! $discount->isValid()) {
            return redirect()->back()->with('error', 'Este cupón ha expirado o no está activo.');
        }

        if (! $discount->canBeUsed()) {
            return redirect()->back()->with('error', 'Este cupón ya alcanzó su límite de usos.');
        }

        // Calcular subtotal para verificar monto mínimo
        $cart = session()->get('cart', []);
        $totals = $this->calculateTotal($cart);

        if (! $discount->meetsMinimumAmount($totals['subtotal'])) {
            return redirect()->back()->with('error', 'El monto mínimo para usar este cupón es $'.number_format($discount->min_amount, 2));
        }

        // Calcular descuento base
        $discountAmount = $discount->toApplyDiscount($totals['subtotal']);
        
        // Calcular el total después del descuento (incluyendo impuestos)
        $subtotalAfterDiscount = $totals['subtotal'] - $discountAmount;
        $tax = $subtotalAfterDiscount * 0.13;
        $totalAfterDiscount = $subtotalAfterDiscount + $tax;
        
        // Si el total es menor a $1, ajustar el descuento
        if ($totalAfterDiscount < 1) {
            // Calcular el descuento máximo permitido (dejando $1 para pagar)
            // Total debe ser >= 1
            // Total = (Subtotal - Descuento) * 1.13 >= 1
            // (Subtotal - Descuento) >= 1/1.13
            // Descuento <= Subtotal - (1/1.13)
            $maxDiscount = $totals['subtotal'] - (1 / 1.13);
            $discountAmount = max(0, $maxDiscount);
            
            $message = '¡Cupón aplicado! Descuento ajustado a $'.number_format($discountAmount, 2).' (debe quedar al menos $1 para pagar con PayPal)';
        } else {
            $message = '¡Cupón aplicado exitosamente! Descuento: $'.number_format($discountAmount, 2);
        }

        // Guardar el cupón en sesión
        session()->put('discount', [
            'id' => $discount->id,
            'code' => $discount->code,
            'type' => $discount->discount_type,
            'value' => $discount->discount_value,
            'amount' => $discountAmount,
        ]);

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remover cupón de descuento
     */
    public function removeDiscount(): RedirectResponse
    {
        session()->forget('discount');

        return redirect()->back()->with('success', 'Cupón de descuento removido.');
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
                'total' => $itemTotal,
            ];
        }

        // Obtener descuento de cupón si existe
        $discount = session()->get('discount', null);
        $discountAmount = 0;

        if ($discount) {
            $discountAmount = $discount['amount'];
        }

        // Obtener descuento de puntos si existe
        $loyaltyDiscount = session()->get('loyalty_discount', null);
        $loyaltyDiscountAmount = 0;

        if ($loyaltyDiscount) {
            $loyaltyDiscountAmount = $loyaltyDiscount['amount'];
        }

        // Calcular total después de ambos descuentos
        $subtotalAfterDiscount = $subtotal - $discountAmount - $loyaltyDiscountAmount;
        $tax = $subtotalAfterDiscount * 0.13;
        $total = $subtotalAfterDiscount + $tax;

        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'discount' => $discountAmount,
            'discount_code' => $discount['code'] ?? null,
            'loyalty_discount' => $loyaltyDiscountAmount,
            'loyalty_points_used' => $loyaltyDiscount['points_used'] ?? 0,
            'subtotal_after_discount' => $subtotalAfterDiscount,
            'tax' => $tax,
            'total' => $total,
        ];
    }
}
