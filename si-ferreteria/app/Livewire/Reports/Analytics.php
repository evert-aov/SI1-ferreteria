<?php

namespace App\Livewire\Reports;

use App\Models\Sale;
use App\Models\SaleUnperson;
use App\Models\SaleDetail;
use App\Models\Purchase\Entry;
use App\Models\Inventory\Product;
use App\Models\Review;
use App\Models\ReportAndAnalysis\ProductAlert;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Analytics extends Component
{
    public string $dateFilter = '30'; // Últimos 30 días por defecto

    public array $filterOptions = [
        '7' => 'Últimos 7 días',
        '30' => 'Últimos 30 días',
        '365' => 'Últimos 12 meses',
    ];

    /**
     * Calcula los KPIs principales del dashboard
     */
    public function getKpisProperty(): array
    {
        $dateFrom = $this->getDateFrom();

        // Ingresos Totales - Sumar ambas tablas de ventas
        $totalRevenueSales = Sale::where('status', 'paid')
            ->where('created_at', '>=', $dateFrom)
            ->sum('total');

        $totalRevenueUnperson = SaleUnperson::where('status', 'paid')
            ->where('created_at', '>=', $dateFrom)
            ->sum('total');

        $totalRevenue = $totalRevenueSales + $totalRevenueUnperson;

        // Cantidad de ventas - Contar ambas tablas
        $salesCountSales = Sale::where('status', 'paid')
            ->where('created_at', '>=', $dateFrom)
            ->count();

        $salesCountUnperson = SaleUnperson::where('status', 'paid')
            ->where('created_at', '>=', $dateFrom)
            ->count();

        $salesCount = $salesCountSales + $salesCountUnperson;

        // Ticket Promedio
        $averageTicket = $salesCount > 0 ? $totalRevenue / $salesCount : 0;

        // Stock Crítico - Productos con alertas de stock bajo o sin stock
        $criticalStock = ProductAlert::where('alert_type', 'low_stock')
            ->where('status', 'pending')
            ->where('active', true)
            ->distinct('product_id')
            ->count();

        // Si no hay alertas, hacer un cálculo básico (stock <= 10 unidades como crítico)
        if ($criticalStock === 0) {
            $criticalStock = Product::where('stock', '<=', 10)
                ->where('is_active', true)
                ->count();
        }

        // Egresos/Compras
        $totalExpenses = Entry::where('invoice_date', '>=', $dateFrom)
            ->sum('total');

        return [
            'total_revenue' => round($totalRevenue, 2),
            'average_ticket' => round($averageTicket, 2),
            'critical_stock' => $criticalStock,
            'total_expenses' => round($totalExpenses, 2),
        ];
    }

    /**
     * Obtiene los datos para el gráfico de tendencia de ventas
     */
    public function getSalesChartDataProperty(): array
    {
        $dateFrom = $this->getDateFrom();
        $groupBy = $this->dateFilter === '365' ? 'month' : 'day';

        if ($groupBy === 'month') {
            // Agrupar por mes - Combinar ambas tablas con UNION
            $salesQuery = "(
                SELECT TO_CHAR(created_at, 'YYYY-MM') as period, SUM(total) as total
                FROM sales
                WHERE status = 'paid' AND created_at >= ?
                GROUP BY period
                UNION ALL
                SELECT TO_CHAR(created_at, 'YYYY-MM') as period, SUM(total) as total
                FROM sale_unpersons
                WHERE status = 'paid' AND created_at >= ?
                GROUP BY period
            ) as combined_sales";

            $sales = DB::table(DB::raw($salesQuery))
                ->select('period', DB::raw('SUM(total) as total'))
                ->setBindings([$dateFrom, $dateFrom])
                ->groupBy('period')
                ->orderBy('period')
                ->get();

            // Formatear fechas para el gráfico
            $categories = $sales->map(function ($sale) {
                return Carbon::createFromFormat('Y-m', $sale->period)->format('M Y');
            })->toArray();

        } else {
            // Agrupar por día - Combinar ambas tablas con UNION
            $salesQuery = "(
                SELECT DATE(created_at) as period, SUM(total) as total
                FROM sales
                WHERE status = 'paid' AND created_at >= ?
                GROUP BY period
                UNION ALL
                SELECT DATE(created_at) as period, SUM(total) as total
                FROM sale_unpersons
                WHERE status = 'paid' AND created_at >= ?
                GROUP BY period
            ) as combined_sales";

            $sales = DB::table(DB::raw($salesQuery))
                ->select('period', DB::raw('SUM(total) as total'))
                ->setBindings([$dateFrom, $dateFrom])
                ->groupBy('period')
                ->orderBy('period')
                ->get();

            // Formatear fechas para el gráfico
            $categories = $sales->map(function ($sale) {
                return Carbon::parse($sale->period)->format('d M');
            })->toArray();
        }

        $data = $sales->pluck('total')->map(fn($val) => round($val, 2))->toArray();

        return [
            'categories' => $categories,
            'data' => $data,
        ];
    }

    /**
     * Obtiene el Top 5 de productos más vendidos
     */
    public function getTopProductsProperty(): array
    {
        $dateFrom = $this->getDateFrom();

        // Combinar detalles de ambas tablas de ventas
        $topProductsQuery = "
            SELECT product_id, SUM(quantity) as total_quantity
            FROM (
                SELECT sd.product_id, sd.quantity
                FROM sale_details sd
                INNER JOIN sales s ON sd.sale_id = s.id
                WHERE s.status = 'paid' AND s.created_at >= ?
                UNION ALL
                SELECT sd.product_id, sd.quantity
                FROM sale_details sd
                INNER JOIN sale_unpersons su ON sd.sale_unperson_id = su.id
                WHERE su.status = 'paid' AND su.created_at >= ?
            ) as combined_details
            GROUP BY product_id
            ORDER BY total_quantity DESC
            LIMIT 5
        ";

        $topProducts = DB::select($topProductsQuery, [$dateFrom, $dateFrom]);

        return collect($topProducts)
            ->map(function ($item) {
                $product = Product::select('id', 'name', 'image')->find($item->product_id);
                return [
                    'name' => $product->name ?? 'N/A',
                    'image' => $product->image ?? null,
                    'quantity' => (int) $item->total_quantity,
                ];
            })
            ->toArray();
    }

    /**
     * Obtiene el Top 5 de productos mejor calificados
     */
    public function getTopRatedProductsProperty(): array
    {
        return Review::select('product_id', DB::raw('AVG(rating) as avg_rating'), DB::raw('COUNT(*) as review_count'))
            ->where('status', 'approved')
            ->with('product:id,name,image')
            ->groupBy('product_id')
            ->havingRaw('COUNT(*) >= 3') // Al menos 3 reviews para ser considerado
            ->orderByDesc('avg_rating')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->product->name ?? 'N/A',
                    'image' => $item->product->image ?? null,
                    'rating' => round($item->avg_rating, 1),
                    'review_count' => (int) $item->review_count,
                ];
            })
            ->toArray();
    }

    /**
     * Obtiene los productos con stock crítico
     */
    public function getCriticalStockProductsProperty(): array
    {
        return Product::where('is_active', true)
            ->where(function ($query) {
                $query->where('stock', '<=', 10)
                      ->orWhere('stock', '=', 0);
            })
            ->select('id', 'name', 'image', 'stock')
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->name,
                    'image' => $product->image,
                    'stock' => $product->stock,
                    'min_stock' => 10, // Stock mínimo recomendado fijo
                    'status' => $product->stock === 0 ? 'sin_stock' : 'bajo_stock',
                ];
            })
            ->toArray();
    }

    /**
     * Calcula la fecha de inicio según el filtro seleccionado
     */
    private function getDateFrom(): Carbon
    {
        return match ($this->dateFilter) {
            '7' => Carbon::now()->subDays(7),
            '30' => Carbon::now()->subDays(30),
            '365' => Carbon::now()->subYear(),
            default => Carbon::now()->subDays(30),
        };
    }

    /**
     * Renderiza el componente
     */
    public function render()
    {
        return view('livewire.reports.analytics', [
            'kpis' => $this->kpis,
            'salesChartData' => $this->salesChartData,
            'topProducts' => $this->topProducts,
            'topRatedProducts' => $this->topRatedProducts,
            'criticalStockProducts' => $this->criticalStockProducts,
        ])->layout('layouts.app');
    }
}
