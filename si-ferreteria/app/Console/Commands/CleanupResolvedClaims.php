<?php

namespace App\Console\Commands;

use App\Models\Claim;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CleanupResolvedClaims extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'claims:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete claims that have been resolved (approved/rejected) for more than 48 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting cleanup of resolved claims...');

        // Get claims that are approved or rejected and reviewed more than 48 hours ago
        $cutoffTime = Carbon::now()->subHours(48);
        
        $claims = Claim::whereIn('status', ['aprobada', 'rechazada'])
            ->whereNotNull('reviewed_at')
            ->where('reviewed_at', '<=', $cutoffTime)
            ->get();

        $count = $claims->count();

        if ($count === 0) {
            $this->info('No claims to cleanup.');
            return 0;
        }

        $this->info("Found {$count} claim(s) to delete...");

        foreach ($claims as $claim) {
            $this->line("Deleting claim #{$claim->id} (Status: {$claim->status_label}, Reviewed: {$claim->reviewed_at->diffForHumans()})");
            $claim->delete();
        }

        $this->info("Successfully deleted {$count} claim(s).");
        
        return 0;
    }
}
