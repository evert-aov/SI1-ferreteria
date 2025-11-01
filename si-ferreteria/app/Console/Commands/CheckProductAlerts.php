<?php

namespace App\Console\Commands;

use App\Services\ProductAlertChecker;
use Illuminate\Console\Command;

class CheckProductAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alerts:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check products and update system and user alerts';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $checker = new ProductAlertChecker();

        $checker->checkVencimientoProximo(15);
        $checker->checkVencido();
        $checker->checkBajoStock();
        $checker->checkSinStock();
        $checker->cleanResolvedAlerts();

        $this->info('Revisión de alertas completada.');
    }
}
