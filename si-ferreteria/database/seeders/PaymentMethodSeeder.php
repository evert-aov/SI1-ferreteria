<?php

namespace Database\Seeders;

use App\Models\Purchase\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'name' => 'PayPal',
                'slug' => 'paypal',
                'provider' => 'paypal_api',
                'description' => 'Pago seguro con PayPal. Acepta tarjetas de crédito/débito y cuentas PayPal.',
                'is_active' => true,
                'requires_gateway' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Stripe',
                'slug' => 'stripe',
                'provider' => 'stripe_api',
                'description' => 'Pago con tarjeta de crédito/débito a través de Stripe.',
                'is_active' => false, // Desactivado hasta configurar
                'requires_gateway' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Efectivo',
                'slug' => 'cash',
                'provider' => null,
                'description' => 'Pago en efectivo al recibir el pedido o en tienda.',
                'is_active' => true,
                'requires_gateway' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'Transferencia Bancaria',
                'slug' => 'bank_transfer',
                'provider' => null,
                'description' => 'Transferencia a cuenta bancaria. Debe enviar comprobante para confirmar el pedido.',
                'is_active' => true,
                'requires_gateway' => false,
                'sort_order' => 4,
            ],
            [
                'name' => 'QR Simple',
                'slug' => 'qr',
                'provider' => null,
                'description' => 'Pago por código QR de banco. Debe enviar captura del comprobante.',
                'is_active' => true,
                'requires_gateway' => false,
                'sort_order' => 5,
            ],
            [
                'name' => 'Tarjeta en Tienda',
                'slug' => 'card_pos',
                'provider' => null,
                'description' => 'Pago con tarjeta en punto de venta (POS) físico.',
                'is_active' => true,
                'requires_gateway' => false,
                'sort_order' => 6,
            ],
            [
                'name' => 'Contra Entrega',
                'slug' => 'cash_on_delivery',
                'provider' => null,
                'description' => 'Pago en efectivo al momento de recibir el pedido.',
                'is_active' => true,
                'requires_gateway' => false,
                'sort_order' => 7,
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::updateOrCreate(
                ['slug' => $method['slug']], // Buscar por slug
                $method // Crear o actualizar con estos datos
            );
        }

        $this->command->info('Métodos de pago creados exitosamente.');
    }
}
