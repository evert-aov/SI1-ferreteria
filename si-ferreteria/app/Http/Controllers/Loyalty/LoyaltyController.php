<?php

namespace App\Http\Controllers\Loyalty;

use App\Http\Controllers\Controller;
use App\Models\Loyalty\LoyaltyAccount;
use App\Models\Loyalty\LoyaltyReward;
use App\Services\LoyaltyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoyaltyController extends Controller
{
    protected LoyaltyService $loyaltyService;

    public function __construct(LoyaltyService $loyaltyService)
    {
        $this->loyaltyService = $loyaltyService;
    }

    /**
     * Dashboard de puntos del cliente
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Obtener o crear cuenta de lealtad
        $defaultLevel = \App\Models\Loyalty\LoyaltyLevel::active()->ordered()->first();
        
        $loyaltyAccount = LoyaltyAccount::firstOrCreate(
            ['customer_id' => $user->id],
            [
                'total_points_earned' => 0,
                'available_points' => 0,
                'membership_level' => $defaultLevel ? $defaultLevel->code : 'bronze',
            ]
        );

        // Cargar transacciones recientes
        $recentTransactions = $loyaltyAccount->transactions()
            ->latest()
            ->take(10)
            ->get();

        // Puntos próximos a vencer
        $expiringPoints = $loyaltyAccount->expiringPoints(30);

        // Beneficios del nivel actual
        $benefits = $this->loyaltyService->getMembershipBenefits($loyaltyAccount->membership_level);

        // Progreso al siguiente nivel
        $progress = $loyaltyAccount->progress_to_next_level;

        return view('loyalty.dashboard', compact(
            'loyaltyAccount',
            'recentTransactions',
            'expiringPoints',
            'benefits',
            'progress'
        ));
    }

    /**
     * Catálogo de recompensas
     */
    public function rewards()
    {
        $user = Auth::user();
        $loyaltyAccount = $user->loyaltyAccount;

        if (! $loyaltyAccount) {
            $defaultLevel = \App\Models\Loyalty\LoyaltyLevel::active()->ordered()->first();
            
            $loyaltyAccount = LoyaltyAccount::create([
                'customer_id' => $user->id,
                'total_points_earned' => 0,
                'available_points' => 0,
                'membership_level' => $defaultLevel ? $defaultLevel->code : 'bronze',
            ]);
        }

        // Recompensas disponibles para el nivel del usuario
        $rewards = LoyaltyReward::active()
            ->available()
            ->forLevel($loyaltyAccount->membership_level)
            ->orderBy('points_cost', 'asc')
            ->get();

        // Canjes pendientes del usuario
        $pendingRedemptions = $loyaltyAccount->redemptions()
            ->pending()
            ->with('loyaltyReward')
            ->latest()
            ->get();

        return view('loyalty.rewards', compact('loyaltyAccount', 'rewards', 'pendingRedemptions'));
    }

    /**
     * Canjear una recompensa
     */
    public function redeem(Request $request, LoyaltyReward $reward)
    {
        try {
            $user = Auth::user();

            $redemption = $this->loyaltyService->redeemReward($user, $reward);

            return redirect()
                ->route('loyalty.rewards')
                ->with('success', "¡Recompensa canjeada exitosamente! Tu cupón es: {$redemption->code}");

        } catch (\Exception $e) {
            return redirect()
                ->route('loyalty.rewards')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Historial de transacciones
     */
    public function transactions()
    {
        $user = Auth::user();
        $loyaltyAccount = $user->loyaltyAccount;

        if (! $loyaltyAccount) {
            return redirect()->route('loyalty.dashboard');
        }

        $transactions = $loyaltyAccount->transactions()
            ->latest()
            ->paginate(20);

        return view('loyalty.transactions', compact('loyaltyAccount', 'transactions'));
    }

    /**
     * Historial de canjes
     */
    public function redemptionHistory()
    {
        $user = Auth::user();
        $loyaltyAccount = $user->loyaltyAccount;

        if (! $loyaltyAccount) {
            return redirect()->route('loyalty.dashboard');
        }

        $redemptions = $loyaltyAccount->redemptions()
            ->with('loyaltyReward')
            ->latest()
            ->paginate(10);

        return view('loyalty.redemption-history', compact('loyaltyAccount', 'redemptions'));
    }
}
