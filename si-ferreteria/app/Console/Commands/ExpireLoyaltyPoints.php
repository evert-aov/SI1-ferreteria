<?php

namespace App\Console\Commands;

use App\Services\LoyaltyService;
use Illuminate\Console\Command;

class ExpireLoyaltyPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loyalty:expire-points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire loyalty points that have passed their expiration date';

    /**
     * Execute the console command.
     */
    public function handle(LoyaltyService $loyaltyService): int
    {
        $this->info('Expirando puntos de lealtad vencidos...');

        $expiredCount = $loyaltyService->expirePoints();

        $this->info("Se expiraron {$expiredCount} transacciones de puntos.");

        return Command::SUCCESS;
    }
}
