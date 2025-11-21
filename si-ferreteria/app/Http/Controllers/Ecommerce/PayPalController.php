<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Product;
use App\Models\Payment;
use App\Models\Purchase\PaymentMethod;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    /**
     * Crear el pago en PayPal
     */
    public function createPayment(Request $request): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        // Validar datos del cliente
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_state' => 'required|string',
            'shipping_zip' => 'nullable|string',
            'shipping_notes' => 'nullable|string',
        ]);

        // Guardar datos del cliente en sesión para usarlos después
        session()->put('checkout_data', $request->all());

        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);

            // Calcular totales
            $subtotal = 0;
            $items = [];

            foreach ($cart as $id => $details) {
                $itemTotal = $details['price'] * $details['quantity'];
                $subtotal += $itemTotal;

                $items[] = [
                    'name' => $details['name'],
                    'quantity' => $details['quantity'],
                    'unit_amount' => [
                        'currency_code' => 'USD',
                        'value' => number_format($details['price'], 2, '.', ''),
                    ],
                ];
            }
            
            // Aplicar descuento si existe
            $discount = session()->get('discount', null);
            $discountAmount = $discount ? $discount['amount'] : 0;
            $subtotalAfterDiscount = $subtotal - $discountAmount;

            $tax = $subtotalAfterDiscount * 0.13; // 13% de impuesto
            $total = $subtotalAfterDiscount + $tax;

            // Crear la orden de PayPal
            $order = $provider->createOrder([
                'intent' => 'CAPTURE',
                'application_context' => [
                    'brand_name' => 'Ferretería Nando',
                    'locale' => 'es-BO',
                    'LANDING_PAGE' => 'BILLING',
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'PAY_NOW',
                    'return_url' => route('paypal.capture'),
                    'cancel_url' => route('paypal.cancel'),
                ],
                'purchase_units' => [
                    [
                        'reference_id' => 'ORDER-' . uniqid(),
                        'description' => 'Compra en Ferretería Nando',
                        'amount' => [
                            'currency_code' => 'USD',
                            'value' => number_format($total, 2, '.', ''),
                            'breakdown' => [
                                'item_total' => [
                                    'currency_code' => 'USD',
                                    'value' => number_format($subtotal, 2, '.', ''),
                                ],
                                'discount' => $discountAmount > 0 ? [
                                    'currency_code' => 'USD',
                                    'value' => number_format($discountAmount, 2, '.', ''),
                                ] : null,
                                'tax_total' => [
                                    'currency_code' => 'USD',
                                    'value' => number_format($tax, 2, '.', ''),
                                ],
                            ],
                        ],
                        'items' => $items,
                    ],
                ],
            ]);

            if (isset($order['id']) && $order['id'] != null) {
                // Encontrar el link de aprobación
                foreach ($order['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            return redirect()->route('cart.checkout')->with('error', 'Error al crear el pago en PayPal.');

        } catch (\Exception $e) {
            return redirect()->route('cart.checkout')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Capturar el pago después de la aprobación
     */
    public function capturePayment(Request $request): RedirectResponse
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $orderId = $request->get('token');

        try {
            $result = $provider->capturePaymentOrder($orderId);

            if (isset($result['status']) && $result['status'] === 'COMPLETED') {
                // Obtener datos del checkout
                $checkoutData = session()->get('checkout_data');
                $cart = session()->get('cart', []);

                // Calcular totales
                $subtotal = 0;
                foreach ($cart as $id => $details) {
                    $subtotal += $details['price'] * $details['quantity'];
                }
                
                // Aplicar descuento si existe
                $discount = session()->get('discount', null);
                $discountAmount = $discount ? $discount['amount'] : 0;
                $discountCode = $discount ? $discount['code'] : null;
                $subtotalAfterDiscount = $subtotal - $discountAmount;

                $tax = $subtotalAfterDiscount * 0.13;
                $total = $subtotalAfterDiscount + $tax;

                // Generar número de factura
                $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

                DB::beginTransaction();

                try {
                    // 1. Obtener el método de pago PayPal
                    $paymentMethod = PaymentMethod::where('slug', 'paypal')->firstOrFail();

                    // 2. Crear el registro de pago
                    $payment = Payment::create([
                        'payment_method_id' => $paymentMethod->id,
                        'transaction_id' => $result['purchase_units'][0]['payments']['captures'][0]['id'] ?? $orderId,
                        'amount' => $total,
                        'currency' => 'USD',
                        'status' => 'completed',
                        'gateway_response' => $result, // Guardar respuesta completa de PayPal
                        'paid_at' => now(),
                    ]);

                    // 3. Crear la venta
                    $sale = Sale::create([
                        'invoice_number' => $invoiceNumber,
                        'customer_id' => auth()->id(),
                        'shipping_address' => $checkoutData['shipping_address'],
                        'shipping_city' => 'Santa Cruz',
                        'shipping_state' => $checkoutData['shipping_state'],
                        'shipping_zip' => $checkoutData['shipping_zip'] ?? null,
                        'shipping_notes' => $checkoutData['shipping_notes'] ?? null,
                        'payment_id' => $payment->id,
                        'subtotal' => $subtotal,
                        'discount' => $discountAmount,
                        'discount_code' => $discountCode,
                        'tax' => $tax,
                        'total' => $total,
                        'currency' => 'USD',
                        'status' => 'paid',
                        'notes' => $checkoutData['order_notes'] ?? null,
                        'sale_type' => 'online',
                        'paid_at' => now(),
                    ]);

                    // 4. Crear los detalles de la venta
                    foreach ($cart as $id => $details) {
                        SaleDetail::create([
                            'sale_id' => $sale->id,
                            'product_id' => $id,
                            'quantity' => $details['quantity'],
                            'unit_price' => $details['price'],
                            'subtotal' => $details['price'] * $details['quantity'],
                        ]);

                        // Actualizar stock
                        $product = Product::find($id);
                        if ($product) {
                            $product->stock -= $details['quantity'];
                            $product->output += $details['quantity'];
                            $product->save();
                        }
                    }
                    
                    // 5. Incrementar uso del cupón si se aplicó
                    if ($discount) {
                        $discountModel = \App\Models\Discount::find($discount['id']);
                        if ($discountModel) {
                            $discountModel->incrementUsage();
                        }
                    }

                    DB::commit();

                    // Datos de la orden para la vista
                    $orderData = [
                        'invoice_number' => $invoiceNumber,
                        'sale_id' => $sale->id,
                        'paypal_order_id' => $orderId,
                        'paypal_payment_id' => $payment->transaction_id,
                        'customer' => [
                            'name' => $checkoutData['customer_name'] ?? auth()->user()->name,
                            'email' => $checkoutData['customer_email'] ?? auth()->user()->email,
                            'phone' => $checkoutData['customer_phone'] ?? null,
                            'nit' => $checkoutData['customer_nit'] ?? null,
                        ],
                        'shipping' => [
                            'address' => $checkoutData['shipping_address'],
                            'city' => 'Santa Cruz',
                            'state' => $checkoutData['shipping_state'],
                            'zip' => $checkoutData['shipping_zip'] ?? null,
                            'notes' => $checkoutData['shipping_notes'] ?? null,
                        ],
                        'payment_method' => $payment->paymentMethod->name,
                        'payment_status' => $payment->status,
                        'order_notes' => $checkoutData['order_notes'] ?? null,
                        'subtotal' => $subtotal,
                        'discount' => $discountAmount,
                        'discount_code' => $discountCode,
                        'tax' => $tax,
                        'total' => $total,
                        'items' => $cart,
                        'created_at' => now(),
                    ];

                    // Guardar en sesión
                    session()->put('last_order', $orderData);

                    // Limpiar el carrito, datos de checkout y descuento
                    session()->forget('cart');
                    session()->forget('checkout_data');
                    session()->forget('discount');

                    return redirect()->route('paypal.success')->with('success', '¡Pago procesado exitosamente!');

                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->route('cart.checkout')->with('error', 'Error al procesar la orden: ' . $e->getMessage());
                }

            } else {
                return redirect()->route('cart.checkout')->with('error', 'El pago no se completó correctamente.');
            }

        } catch (\Exception $e) {
            return redirect()->route('cart.checkout')->with('error', 'Error al capturar el pago: ' . $e->getMessage());
        }
    }

    /**
     * Pago cancelado
     */
    public function cancelPayment(): RedirectResponse
    {
        return redirect()->route('cart.checkout')->with('error', 'Has cancelado el pago de PayPal.');
    }

    /**
     * Página de éxito
     */
    public function success(): View|RedirectResponse
    {
        $order = session()->get('last_order');

        if (!$order) {
            return redirect()->route('products.index');
        }

        return view('cart.success', compact('order'));
    }
}
