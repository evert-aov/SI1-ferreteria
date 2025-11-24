<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

echo "=== PRUEBA DE DATOS DEL GRÁFICO ===\n\n";

// Prueba para 7 días
echo "📊 ÚLTIMOS 7 DÍAS:\n";
$dateFrom = Carbon::now()->subDays(7);
$sales = Sale::where('status', 'paid')
    ->where('created_at', '>=', $dateFrom)
    ->select(
        DB::raw("DATE(created_at) as period"),
        DB::raw('SUM(total) as total')
    )
    ->groupBy('period')
    ->orderBy('period')
    ->get();

echo "Períodos encontrados: " . $sales->count() . "\n";
foreach ($sales as $sale) {
    $formattedDate = Carbon::parse($sale->period)->format('d M');
    echo "  {$formattedDate}: $" . round($sale->total, 2) . "\n";
}

// Prueba para 30 días
echo "\n📊 ÚLTIMOS 30 DÍAS:\n";
$dateFrom = Carbon::now()->subDays(30);
$sales = Sale::where('status', 'paid')
    ->where('created_at', '>=', $dateFrom)
    ->select(
        DB::raw("DATE(created_at) as period"),
        DB::raw('SUM(total) as total')
    )
    ->groupBy('period')
    ->orderBy('period')
    ->get();

echo "Períodos encontrados: " . $sales->count() . "\n";
foreach ($sales->take(5) as $sale) {
    $formattedDate = Carbon::parse($sale->period)->format('d M');
    echo "  {$formattedDate}: $" . round($sale->total, 2) . "\n";
}
echo "  ... (mostrando solo los primeros 5)\n";

// Prueba para 12 meses
echo "\n📊 ÚLTIMOS 12 MESES:\n";
$dateFrom = Carbon::now()->subYear();
$sales = Sale::where('status', 'paid')
    ->where('created_at', '>=', $dateFrom)
    ->select(
        DB::raw("TO_CHAR(created_at, 'YYYY-MM') as period"),
        DB::raw('SUM(total) as total')
    )
    ->groupBy('period')
    ->orderBy('period')
    ->get();

echo "Períodos encontrados: " . $sales->count() . "\n";
foreach ($sales as $sale) {
    $formattedDate = Carbon::createFromFormat('Y-m', $sale->period)->format('M Y');
    echo "  {$formattedDate}: $" . round($sale->total, 2) . "\n";
}

echo "\n✅ Prueba completada\n";
