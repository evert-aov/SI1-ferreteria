<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            /*/ Métodos en línea
            [
                'name' => 'Stripe',
                'slug' => 'stripe',
                'provider' => 'Stripe',
                'description' => 'Pago con tarjeta de crédito/débito a través de Stripe',
                'credentials' => json_encode([
                    'public_key' => env('STRIPE_PUBLIC_KEY', ''),
                    'secret_key' => env('STRIPE_SECRET_KEY', ''),
                    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET', ''),
                ]),
                'is_active' => true,
                'requires_gateway' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],*/
            [
                'name' => 'PayPal',
                'slug' => 'paypal',
                'provider' => 'PayPal',
                'description' => 'Pago a través de cuenta PayPal',
                'credentials' => json_encode(value: [
                    'client_id' => env('PAYPAL_CLIENT_ID', ''),
                    'secret' => env(key: 'PAYPAL_SECRET', default: ''),
                    'mode' => env('PAYPAL_MODE', 'sandbox'), // sandbox o live
                ]),
                'is_active' => true,
                'requires_gateway' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],/*
            [
                'name' => 'Mercado Pago',
                'slug' => 'mercadopago',
                'provider' => 'Mercado Pago',
                'description' => 'Pago con Mercado Pago (tarjetas, efectivo, transferencia)',
                'credentials' => json_encode([
                    'public_key' => env('MERCADOPAGO_PUBLIC_KEY', ''),
                    'access_token' => env('MERCADOPAGO_ACCESS_TOKEN', ''),
                ]),
                'is_active' => true,
                'requires_gateway' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Métodos tradicionales
            [
                'name' => 'Efectivo',
                'slug' => 'cash',
                'provider' => null,
                'description' => 'Pago en efectivo al momento de la entrega o en tienda',
                'credentials' => null,
                'is_active' => true,
                'requires_gateway' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Transferencia Bancaria',
                'slug' => 'bank_transfer',
                'provider' => null,
                'description' => 'Transferencia bancaria directa',
                'credentials' => json_encode([
                    'bank_name' => 'Banco Nacional',
                    'account_holder' => 'Tu Empresa S.A.',
                    'account_number' => '1234567890',
                    'account_type' => 'Cuenta Corriente',
                ]),
                'is_active' => true,
                'requires_gateway' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Depósito Bancario',
                'slug' => 'bank_deposit',
                'provider' => null,
                'description' => 'Depósito en cuenta bancaria',
                'credentials' => json_encode([
                    'bank_name' => 'Banco Nacional',
                    'account_holder' => 'Tu Empresa S.A.',
                    'account_number' => '1234567890',
                ]),
                'is_active' => true,
                'requires_gateway' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Contra Entrega',
                'slug' => 'cash_on_delivery',
                'provider' => null,
                'description' => 'Pago al recibir el producto',
                'credentials' => null,
                'is_active' => true,
                'requires_gateway' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Billeteras digitales
            [
                'name' => 'Tigo Money',
                'slug' => 'tigo_money',
                'provider' => 'Tigo Money Bolivia',
                'description' => 'Pago con billetera Tigo Money',
                'credentials' => json_encode([
                    'merchant_code' => env('TIGO_MERCHANT_CODE', ''),
                    'api_key' => env('TIGO_API_KEY', ''),
                ]),
                'is_active' => false,
                'requires_gateway' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'QR Simple',
                'slug' => 'qr_simple',
                'provider' => 'QR Simple Bolivia',
                'description' => 'Pago mediante código QR interbancario',
                'credentials' => json_encode([
                    'gloss' => 'Pago de productos',
                    'callback_url' => env('APP_URL') . '/api/qr-callback',
                ]),
                'is_active' => false,
                'requires_gateway' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Débito/Crédito Manual',
                'slug' => 'card_manual',
                'provider' => null,
                'description' => 'Pago con tarjeta procesado manualmente (POS físico)',
                'credentials' => null,
                'is_active' => true,
                'requires_gateway' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],*/
        ];

        DB::table('payment_methods')->insert($paymentMethods);
    }
}
