<?php

namespace App\Console\Commands;

<<<<<<< HEAD
use App\Services\ProductAlertChecker;
=======
use App\Services\ProductAlertService;
>>>>>>> 679fb29ee78332f574d5aa0d005233931cdb9840
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
        $service = new ProductAlertService();

        $stockToasts = $service->runStockCheckAutomatic();
        $expToasts = $service->runExpirationCheckAutomatic();

        //$manager->cleanResolvedAlerts();

        $this->info('Product alerts checked and toasts generated. Count expired: ' . count($expToasts) . ', Count low stock: ' . count($stockToasts));
    }
}
