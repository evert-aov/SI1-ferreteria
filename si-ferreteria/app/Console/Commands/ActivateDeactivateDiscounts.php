<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Discount;
use Carbon\Carbon;

class ActivateDeactivateDiscounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discounts:activate-deactivate';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activa o desactiva descuentos según su fecha';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        $countDeactivated = Discount::where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->where('end_date', '<', $now)
                  ->orWhere('start_date', '>', $now)
                  ->orWhereRaw('used_count >= max_uses');
            })
            ->update(['is_active' => false]);

        $countActivated = Discount::where('is_active', false)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->whereRaw('used_count < max_uses')
            ->update(['is_active' => true]);

        $this->info("Descuentos activados: {$countActivated}");
        $this->info("Descuentos desactivados: {$countDeactivated}");
    }
}
