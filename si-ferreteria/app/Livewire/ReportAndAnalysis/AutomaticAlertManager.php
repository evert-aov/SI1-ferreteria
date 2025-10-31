<?php

namespace App\Livewire\ReportAndAnalysis;

use App\Models\ReportAndAnalysis\ProductAlert;
use App\Services\ProductAlertChecker;
use Livewire\Component;
use Livewire\WithPagination;

class AutomaticAlertManager extends Component
{
    use WithPagination;

    public $checkResults = [];

    public $alertTypes = [
        'promotion' => '🎉 Oferta/Promoción',
        'low_stock' => '📦 Stock Bajo',
        'expired' => '❌ Vencido',
        'upcoming_expiration' => '⚠️ Próximo a Vencer',
        'out_of_stock' => '📭 Sin Stock',
    ];

    public function render()
    {
        // Obtener estadísticas por tipo de alerta
        $alertStats = ProductAlert::whereNull('user_id')
            ->selectRaw('alert_type,
                         COUNT(*) as total,
                         SUM(CASE WHEN active = true THEN 1 ELSE 0 END) as activas,
                         SUM(CASE WHEN active = false THEN 1 ELSE 0 END) as inactivas')
            ->groupBy('alert_type')
            ->get()
            ->keyBy('alert_type');

        return view('livewire.product-alert.automatic-alert-manager',
            compact('alertStats'))
            ->layout('layouts.app');
    }

    /**
     * Ejecutar verificación automática de vencimientos
     */
    public function runExpirationCheck()
    {
        $checker = app(ProductAlertChecker::class);

        $checker->checkVencido();
        $checker->checkVencimientoProximo();

        $expiredCount = ProductAlert::tipo('expired')->pendientes()->count();
        $upcomingCount = ProductAlert::tipo('upcoming_expiration')->pendientes()->count();

        $this->checkResults = [
            'vencido' => "✅ {$expiredCount} alertas de productos vencidos",
            'vencimiento_proximo' => "✅ {$upcomingCount} alertas de vencimiento próximo",
        ];

        session()->flash('message', "Se generaron {$expiredCount} alertas de vencidos y {$upcomingCount} de próximos a vencer");
    }

    /**
     * Ejecutar verificación de stock
     */
    public function runStockCheck()
    {
        $checker = app(ProductAlertChecker::class);

        $checker->checkSinStock();
        $checker->checkBajoStock();

        $outOfStockCount = ProductAlert::tipo('out_of_stock')->pendientes()->count();
        $lowStockCount = ProductAlert::tipo('low_stock')->pendientes()->count();

        $this->checkResults = [
            'sin_stock' => "✅ {$outOfStockCount} alertas de sin stock",
            'bajo_stock' => "✅ {$lowStockCount} alertas de stock bajo",
        ];

        session()->flash('message', "Se encontraron {$outOfStockCount} productos sin stock y {$lowStockCount} con stock bajo");
    }


    /**
     * Desactivar todas las alertas de un tipo específico
     */
    public function deactivateAllByType($alertType)
    {
        $count = ProductAlert::whereNull('user_id')
            ->where('alert_type', $alertType)
            ->where('active', true)
            ->update(['active' => false]);

        session()->flash('message', "{$count} alertas de tipo '{$this->alertTypes[$alertType]}' desactivadas");
    }

    /**
     * Activar todas las alertas de un tipo específico
     */
    public function activateAllByType($alertType)
    {
        $count = ProductAlert::whereNull('user_id')
            ->where('alert_type', $alertType)
            ->where('active', false)
            ->update(['active' => true]);

        session()->flash('message', "{$count} alertas de tipo '{$this->alertTypes[$alertType]}' activadas");
    }
}
