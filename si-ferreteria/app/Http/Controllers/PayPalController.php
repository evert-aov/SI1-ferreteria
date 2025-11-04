<?php

namespace App\Http\Controllers;

use App\Models\Inventory\Product;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    /**
     * Crear el pago en PayPal
     */
    public function createPayment(Request $request)
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
                        'value' => number_format($details['price'], 2, '.', ''), // <-- 3. El valor va aquí
                    ],
                ];
            }

            $tax = $subtotal * 0.13; // 13% de impuesto
            $total = $subtotal + $tax;

            // Crear la orden de PayPal
            $order = $provider->createOrder([
                'intent' => 'CAPTURE',
                'application_context' => [
                    'brand_name' => 'Ferretería Nando',
                    'locale' => 'es-BO',
                    'landing_page' => 'BILLING',
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'PAY_NOW',
                    'return_url' => route('paypal.success'),
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

            if (isset($order['id']) && $order['id'] != null) { //
                // Encontrar el link de aprobación
                foreach ($order['links'] as $link) { //
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            //dd($order);
            return redirect()->route('cart.checkout')->with('error', 'Error al crear el pago en PayPal.');

        } catch (\Exception $e) {
            //dd($e);
            return redirect()->route('cart.checkout')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Capturar el pago después de la aprobación
     */
    public function capturePayment(Request $request)
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
                $tax = $subtotal * 0.13;
                $total = $subtotal + $tax;

                // Generar número de factura
                $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

                // Crear la orden
                \DB::beginTransaction();

                try {
                    // Crear la venta en la base de datos
                    $sale = \App\Models\Sale::create([
                        'invoice_number' => $invoiceNumber,
                        'customer_id' => auth()->id(), // null si no está autenticado
                        'shipping_address' => $checkoutData['shipping_address'],
                        'shipping_city' => 'Santa Cruz',
                        'shipping_state' => $checkoutData['shipping_state'],
                        'shipping_zip' => $checkoutData['shipping_zip'] ?? null,
                        'shipping_notes' => $checkoutData['shipping_notes'] ?? null,
                        'payment_method' => 'paypal',
                        'payment_transaction_id' => $result['purchase_units'][0]['payments']['captures'][0]['id'] ?? null,
                        'subtotal' => $subtotal,
                        'tax' => $tax,
                        'total' => $total,
                        'status' => 'paid', // PayPal ya está pagado
                        'notes' => $checkoutData['order_notes'] ?? null,
                        'sale_type' => 'online',
                        'paid_at' => now(),
                    ]);

                    // Crear los detalles de la venta
                    foreach ($cart as $id => $details) {
                        \App\Models\SaleDetail::create([
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

                    \DB::commit();

                    // Datos de la orden para la vista
                    $orderData = [
                        'invoice_number' => $invoiceNumber,
                        'sale_id' => $sale->id,
                        'paypal_order_id' => $orderId,
                        'paypal_payment_id' => $result['purchase_units'][0]['payments']['captures'][0]['id'] ?? null,
                        'customer' => [
                            'name' => $checkoutData['customer_name'],
                            'email' => $checkoutData['customer_email'],
                            'phone' => $checkoutData['customer_phone'],
                            'nit' => $checkoutData['customer_nit'],
                        ],
                        'shipping' => [
                            'address' => $checkoutData['shipping_address'],
                            'city' => $checkoutData['shipping_city'],
                            'state' => $checkoutData['shipping_state'],
                            'zip' => $checkoutData['shipping_zip'] ?? null,
                            'notes' => $checkoutData['shipping_notes'] ?? null,
                        ],
                        'payment_method' => 'paypal',
                        'payment_status' => 'completed',
                        'order_notes' => $checkoutData['order_notes'] ?? null,
                        'subtotal' => $subtotal,
                        'tax' => $tax,
                        'total' => $total,
                        'items' => $cart,
                        'created_at' => now(),
                        'paypal_response' => $result,
                    ];

                    // Guardar en sesión
                    session()->put('last_order', $orderData);

                    // Limpiar el carrito y datos de checkout
                    session()->forget('cart');
                    session()->forget('checkout_data');

                    return redirect()->route('cart.success')->with('success', '¡Pago procesado exitosamente!');

                } catch (\Exception $e) {
                    \DB::rollBack();
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
    public function cancelPayment()
    {
        return redirect()->route('cart.checkout')->with('error', 'Has cancelado el pago de PayPal.');
    }
}
