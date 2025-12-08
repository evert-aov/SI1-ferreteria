<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado - {{ $order['invoice_number'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 min-h-screen">
    <!-- Success Animation -->
    <div class="text-center py-8">
        <div class="inline-block">
            <div class="success-checkmark">
                <div class="check-icon">
                    <span class="icon-line line-tip"></span>
                    <span class="icon-line line-long"></span>
                    <div class="icon-circle"></div>
                    <div class="icon-fix"></div>
                </div>
            </div>
        </div>
        <h1 class="text-4xl font-bold text-white mt-4">¡Pedido Confirmado!</h1>
        <p class="text-gray-400 text-lg mt-2">Tu pedido ha sido registrado exitosamente</p>
    </div>

    <!-- Invoice Container -->
    <div class="max-w-4xl mx-auto px-4 pb-12">
        <!-- Invoice Card -->
        <div id="invoice-content" class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-white text-3xl font-bold">Ferretería Nando</h2>
                        <p class="text-blue-100 text-sm mt-1">Dirección: Santa Cruz, Bolivia</p>
                        <p class="text-blue-100 text-sm">Tel: +591 609 624 33</p>
                        <p class="text-blue-100 text-sm">Email: sandy@gmail.com</p>
                    </div>
                    <div class="text-right">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                            <p class="text-blue-100 text-xs uppercase tracking-wide">Factura</p>
                            <p class="text-white text-2xl font-bold">{{ $order['invoice_number'] }}</p>
                        </div>
                        <p class="text-blue-100 text-sm mt-2">{{ $order['created_at']->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Customer & Shipping Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-8 py-6 bg-gray-50">
                <div>
                    <h3 class="text-gray-700 font-bold text-sm uppercase tracking-wide mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Información del Cliente
                    </h3>
                    <div class="space-y-1 text-gray-600 text-sm">
                        <p><span class="font-semibold text-gray-800">Nombre:</span> {{ $order['customer']['name'] }}</p>
                        <p><span class="font-semibold text-gray-800">Email:</span> {{ $order['customer']['email'] }}</p>
                        <p><span class="font-semibold text-gray-800">Teléfono:</span>
                            {{ $order['customer']['phone'] ?? 'No proporcionado' }}</p>
                        <p><span class="font-semibold text-gray-800">NIT/CI:</span>
                            {{ $order['customer']['nit'] ?? 'No proporcionado' }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-gray-700 font-bold text-sm uppercase tracking-wide mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Dirección de Envío
                    </h3>
                    <div class="space-y-1 text-gray-600 text-sm">
                        <p class="text-gray-800 font-semibold">{{ $order['shipping']['address'] }}</p>
                        <p>{{ $order['shipping']['city'] }}, {{ $order['shipping']['state'] }}</p>
                        @if ($order['shipping']['zip'])
                            <p>CP: {{ $order['shipping']['zip'] }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="px-8 py-4 bg-blue-50 border-y border-blue-100">
                <div class="flex items-center gap-3">
                    @php
                        $paymentMethodName = $order['payment_method'] ?? 'Desconocido';
                    @endphp

                    @if (str_contains(strtolower($paymentMethodName), 'efectivo') ||
                            str_contains(strtolower($paymentMethodName), 'cash'))
                        <span class="text-3xl">💵</span>
                        <div>
                            <p class="text-gray-800 font-semibold">{{ $paymentMethodName }}</p>
                            <p class="text-gray-600 text-sm">Pago contra entrega</p>
                        </div>
                    @elseif(str_contains(strtolower($paymentMethodName), 'paypal'))
                        <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" alt="PayPal"
                            class="h-6">
                        <div>
                            <p class="text-gray-800 font-semibold">{{ $paymentMethodName }}</p>
                            <p class="text-gray-600 text-sm">
                                Estado: <span class="text-green-600 font-semibold">{{ ucfirst($order['payment_status']) }}</span>
                            </p>
                        </div>
                    @else
                        <span class="text-3xl">💳</span>
                        <div>
                            <p class="text-gray-800 font-semibold">{{ $paymentMethodName }}</p>
                            <p class="text-gray-600 text-sm">Método de pago seleccionado</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Products Table -->
            <div class="px-8 py-6">
                <h3 class="text-gray-700 font-bold text-sm uppercase tracking-wide mb-4">Productos</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-300">
                                <th class="text-left py-3 px-2 text-gray-700 font-semibold text-sm">Producto</th>
                                <th class="text-center py-3 px-2 text-gray-700 font-semibold text-sm">Cantidad</th>
                                <th class="text-right py-3 px-2 text-gray-700 font-semibold text-sm">Precio Unit.</th>
                                <th class="text-right py-3 px-2 text-gray-700 font-semibold text-sm">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order['items'] as $id => $item)
                                <tr class="border-b border-gray-200">
                                    <td class="py-4 px-2">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                                                class="w-12 h-12 object-contain rounded bg-gray-100">
                                            <span class="text-gray-800 font-medium text-sm">{{ $item['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-2 text-center text-gray-700">{{ $item['quantity'] }}</td>
                                    <td class="py-4 px-2 text-right text-gray-700">USD
                                        {{ number_format($item['price'], 2) }}</td>
                                    <td class="py-4 px-2 text-right text-gray-900 font-semibold">USD
                                        {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Totals -->
            <div class="px-8 py-6 bg-gray-50">
                <div class="max-w-sm ml-auto space-y-2">
                    <div class="flex justify-between text-gray-700">
                        <span>Subtotal:</span>
                        <span class="font-semibold">USD {{ number_format($order['subtotal'], 2) }}</span>
                    </div>

                    @if (isset($order['discount']) && $order['discount'] > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Descuento cupón:
                                @if (isset($order['discount_code']))
                                    <span class="text-xs">({{ $order['discount_code'] }})</span>
                                @endif
                            </span>
                            <span class="font-semibold">-USD {{ number_format($order['discount'], 2) }}</span>
                        </div>
                    @endif

                    @if (isset($order['loyalty_discount']) && $order['loyalty_discount'] > 0)
                        <div class="flex justify-between text-orange-600">
                            <span>Descuento puntos:
                                @if (isset($order['loyalty_points_used']))
                                    <span class="text-xs">({{ $order['loyalty_points_used'] }} pts)</span>
                                @endif
                            </span>
                            <span class="font-semibold">-USD {{ number_format($order['loyalty_discount'], 2) }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between text-gray-700">
                        <span>Impuestos (13%):</span>
                        <span class="font-semibold">USD {{ number_format($order['tax'], 2) }}</span>
                    </div>

                    <div class="flex justify-between text-gray-700">
                        <span>Envío:</span>
                        <span class="font-semibold text-green-600">Gratis</span>
                    </div>

                    <div class="border-t-2 border-gray-300 pt-3 flex justify-between">
                        <span class="text-xl font-bold text-gray-800">Total:</span>
                        <span class="text-2xl font-bold text-blue-600">USD
                            {{ number_format($order['total'], 2) }}</span>
                    </div>
                </div>
            </div>

            @if ($order['order_notes'])
                <div class="px-8 py-4 bg-yellow-50 border-t border-yellow-100">
                    <h4 class="text-gray-700 font-semibold mb-2 text-sm">Notas del pedido:</h4>
                    <p class="text-gray-600 text-sm">{{ $order['order_notes'] }}</p>
                </div>
            @endif

            <!-- Footer -->
            <div class="px-8 py-6 bg-gradient-to-r from-gray-100 to-gray-200 text-center">
                <p class="text-gray-600 text-sm">¡Gracias por tu compra!</p>
                <p class="text-gray-500 text-xs mt-1">Este es un comprobante de pedido electrónico</p>
            </div>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-blue-900/30 backdrop-blur-sm border border-blue-700 rounded-xl p-6">
            <h3 class="text-white font-bold mb-3 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                ¿Qué sigue?
            </h3>
            <ul class="space-y-2 text-gray-300">
                @if (isset($order['customer']['phone']) && $order['customer']['phone'])
                    <li class="flex items-start gap-2">
                        <span class="text-yellow-500">✓</span>
                        <span>Te contactaremos al {{ $order['customer']['phone'] }} para coordinar la entrega</span>
                    </li>
                @endif
                <li class="flex items-start gap-2">
                    <span class="text-yellow-500">✓</span>
                    <span>El tiempo estimado de entrega es de 2-5 días hábiles</span>
                </li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
            <button onclick="downloadPDF()"
                class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-500 hover:to-green-600 text-white font-semibold px-8 py-4 rounded-xl transition shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Descargar Factura PDF
            </button>
            <a href="{{ route('products.index') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-4 rounded-xl transition shadow-lg hover:shadow-xl text-center flex items-center justify-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                Seguir Comprando
            </a>
        </div>

        <!-- Contact -->
        <div class="text-center mt-8 text-gray-400">
            <p>¿Necesitas ayuda con tu pedido?</p>
            <p class="text-white font-semibold mt-1">Contáctanos: <a href="tel:+59160962433"
                    class="text-blue-400 hover:text-blue-300 hover:underline">+591 609 624 33</a></p>
        </div>
    </div>

    <style>
        /* Success Checkmark Animation */
        .success-checkmark {
            width: 80px;
            height: 80px;
            margin: 0 auto;
        }

        .success-checkmark .check-icon {
            width: 80px;
            height: 80px;
            position: relative;
            border-radius: 50%;
            box-sizing: content-box;
            border: 4px solid #4ade80;
        }

        .success-checkmark .check-icon::before {
            top: 3px;
            left: -2px;
            width: 30px;
            transform-origin: 100% 50%;
            border-radius: 100px 0 0 100px;
        }

        .success-checkmark .check-icon::after {
            top: 0;
            left: 30px;
            width: 60px;
            transform-origin: 0 50%;
            border-radius: 0 100px 100px 0;
            animation: rotate-circle 4.25s ease-in;
        }

        .success-checkmark .check-icon::before,
        .success-checkmark .check-icon::after {
            content: '';
            height: 100px;
            position: absolute;
            background: #1f2937;
            transform: rotate(-45deg);
        }

        .success-checkmark .check-icon .icon-line {
            height: 5px;
            background-color: #4ade80;
            display: block;
            border-radius: 2px;
            position: absolute;
            z-index: 10;
        }

        .success-checkmark .check-icon .icon-line.line-tip {
            top: 46px;
            left: 14px;
            width: 25px;
            transform: rotate(45deg);
            animation: icon-line-tip 0.75s;
        }

        .success-checkmark .check-icon .icon-line.line-long {
            top: 38px;
            right: 8px;
            width: 47px;
            transform: rotate(-45deg);
            animation: icon-line-long 0.75s;
        }

        .success-checkmark .check-icon .icon-circle {
            top: -4px;
            left: -4px;
            z-index: 10;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            position: absolute;
            box-sizing: content-box;
            border: 4px solid rgba(74, 222, 128, .5);
        }

        .success-checkmark .check-icon .icon-fix {
            top: 8px;
            width: 5px;
            left: 26px;
            z-index: 1;
            height: 85px;
            position: absolute;
            transform: rotate(-45deg);
            background-color: #1f2937;
        }

        @keyframes rotate-circle {
            0% {
                transform: rotate(-45deg);
            }

            5% {
                transform: rotate(-45deg);
            }

            12% {
                transform: rotate(-405deg);
            }

            100% {
                transform: rotate(-405deg);
            }
        }

        @keyframes icon-line-tip {
            0% {
                width: 0;
                left: 1px;
                top: 19px;
            }

            54% {
                width: 0;
                left: 1px;
                top: 19px;
            }

            70% {
                width: 50px;
                left: -8px;
                top: 37px;
            }

            84% {
                width: 17px;
                left: 21px;
                top: 48px;
            }

            100% {
                width: 25px;
                left: 14px;
                top: 45px;
            }
        }

        @keyframes icon-line-long {
            0% {
                width: 0;
                right: 46px;
                top: 54px;
            }

            65% {
                width: 0;
                right: 46px;
                top: 54px;
            }

            84% {
                width: 55px;
                right: 0px;
                top: 35px;
            }

            100% {
                width: 47px;
                right: 8px;
                top: 38px;
            }
        }
    </style>

    <script>
        async function downloadPDF() {
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            
            // Show loading state
            button.innerHTML = `
                <svg class="animate-spin h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Generando PDF...
            `;
            button.disabled = true;

            try {
                const element = document.getElementById('invoice-content');
                
                // Use html2canvas to capture the invoice
                const canvas = await html2canvas(element, {
                    scale: 2,
                    useCORS: true,
                    logging: false,
                    backgroundColor: '#ffffff'
                });

                const imgData = canvas.toDataURL('image/png');
                
                // Calculate PDF dimensions
                const imgWidth = 210; // A4 width in mm
                const pageHeight = 297; // A4 height in mm
                const imgHeight = (canvas.height * imgWidth) / canvas.width;
                let heightLeft = imgHeight;
                let position = 0;

                // Create PDF
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'a4');
                
                // Add first page
                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                // Add additional pages if needed
                while (heightLeft > 0) {
                    position = heightLeft - imgHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }

                // Download the PDF
                pdf.save('Factura-{{ $order["invoice_number"] }}.pdf');

                // Reset button
                button.innerHTML = originalText;
                button.disabled = false;
            } catch (error) {
                console.error('Error generating PDF:', error);
                alert('Hubo un error al generar el PDF. Por favor, intenta nuevamente.');
                button.innerHTML = originalText;
                button.disabled = false;
            }
        }
    </script>
</body>

</html>
