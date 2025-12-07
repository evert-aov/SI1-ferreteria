<?php

namespace App\Http\Controllers\Admin\Loyalty;

use App\Http\Controllers\Controller;
use App\Models\Loyalty\LoyaltyAccount;
use App\Models\Loyalty\LoyaltyReward;
use App\Models\Loyalty\LoyaltyTransaction;
use App\Services\LoyaltyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminLoyaltyController extends Controller
{
    protected LoyaltyService $loyaltyService;

    public function __construct(LoyaltyService $loyaltyService)
    {
        $this->loyaltyService = $loyaltyService;
    }

    /**
     * Panel de configuración
     */
    public function config()
    {
        $totalAccounts = LoyaltyAccount::count();
        $bronzeCount = LoyaltyAccount::where('membership_level', 'bronze')->count();
        $silverCount = LoyaltyAccount::where('membership_level', 'silver')->count();
        $goldCount = LoyaltyAccount::where('membership_level', 'gold')->count();

        $totalPointsIssued = LoyaltyTransaction::where('type', 'earn')->sum('points');
        $totalPointsRedeemed = abs(LoyaltyTransaction::where('type', 'redeem')->sum('points'));
        
        $rewards = LoyaltyReward::withCount('redemptions')
            ->orderBy('points_cost', 'asc')
            ->get();

        return view('admin.loyalty.config', compact(
            'totalAccounts',
            'bronzeCount',
            'silverCount',
            'goldCount',
            'totalPointsIssued',
            'totalPointsRedeemed',
            'rewards'
        ));
    }

    /**
     * Mostrar formulario para crear recompensa
     */
    public function createReward()
    {
        return view('admin.loyalty.rewards.form', [
            'reward' => null,
            'isEdit' => false,
        ]);
    }

    /**
     * Crear recompensa
     */
    public function storeReward(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_cost' => 'required|integer|min:1',
            'reward_type' => 'required|in:discount_percentage,discount_amount,free_product',
            'reward_value' => 'required|numeric|min:0',
            'stock_limit' => 'nullable|integer|min:0',
            'minimum_level' => 'required|in:bronze,silver,gold',
            'image' => 'nullable|image|max:2048',
        ]);

        // Manejar imagen
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('loyalty/rewards', 'public');
        }

        // Establecer available_count si hay stock_limit
        if ($validated['stock_limit']) {
            $validated['available_count'] = $validated['stock_limit'];
        }

        LoyaltyReward::create($validated);

        return redirect()
            ->route('admin.loyalty.config')
            ->with('success', 'Recompensa creada exitosamente');
    }

    /**
     * Mostrar formulario para editar recompensa
     */
    public function editReward(LoyaltyReward $reward)
    {
        return view('admin.loyalty.rewards.form', [
            'reward' => $reward,
            'isEdit' => true,
        ]);
    }

    /**
     * Actualizar recompensa
     */
    public function updateReward(Request $request, LoyaltyReward $reward)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_cost' => 'required|integer|min:1',
            'reward_type' => 'required|in:discount_percentage,discount_amount,free_product',
            'reward_value' => 'required|numeric|min:0',
            'stock_limit' => 'nullable|integer|min:0',
            'available_count' => 'nullable|integer|min:0',
            'minimum_level' => 'required|in:bronze,silver,gold',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        // Manejar imagen
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior
            if ($reward->image) {
                Storage::disk('public')->delete($reward->image);
            }
            $validated['image'] = $request->file('image')->store('loyalty/rewards', 'public');
        }

        $reward->update($validated);

        return redirect()
            ->route('admin.loyalty.config')
            ->with('success', 'Recompensa actualizada exitosamente');
    }

    /**
     * Activar/Desactivar recompensa
     */
    public function toggleReward(LoyaltyReward $reward)
    {
        $reward->update(['is_active' => !$reward->is_active]);

        $status = $reward->is_active ? 'activada' : 'desactivada';
        
        return redirect()
            ->route('admin.loyalty.config')
            ->with('success', "Recompensa {$status} exitosamente");
    }

    /**
     * Eliminar recompensa
     */
    public function destroyReward(LoyaltyReward $reward)
    {
        // Verificar que no tenga canjes asociados
        if ($reward->redemptions()->count() > 0) {
            return redirect()
                ->route('admin.loyalty.config')
                ->with('error', 'No se puede eliminar una recompensa con canjes asociados');
        }

        // Eliminar imagen
        if ($reward->image) {
            Storage::disk('public')->delete($reward->image);
        }

        $reward->delete();

        return redirect()
            ->route('admin.loyalty.config')
            ->with('success', 'Recompensa eliminada exitosamente');
    }

    /**
     * Reportes del programa de lealtad
     */
    public function reports()
    {
        // Distribución de clientes por nivel
        $levelDistribution = [
            'bronze' => LoyaltyAccount::where('membership_level', 'bronze')->count(),
            'silver' => LoyaltyAccount::where('membership_level', 'silver')->count(),
            'gold' => LoyaltyAccount::where('membership_level', 'gold')->count(),
        ];

        // Recompensas más populares
        $topRewards = LoyaltyReward::withCount('redemptions')
            ->orderBy('redemptions_count', 'desc')
            ->take(5)
            ->get();

        // Puntos emitidos vs canjeados por mes (últimos 6 meses)
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyStats[] = [
                'month' => $month->format('M Y'),
                'earned' => LoyaltyTransaction::where('type', 'earn')
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('points'),
                'redeemed' => abs(LoyaltyTransaction::where('type', 'redeem')
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('points')),
            ];
        }

        // Top clientes por puntos
        $topCustomers = LoyaltyAccount::with('customer')
            ->orderBy('total_points_earned', 'desc')
            ->take(10)
            ->get();

        return view('admin.loyalty.reports', compact(
            'levelDistribution',
            'topRewards',
            'monthlyStats',
            'topCustomers'
        ));
    }

    /**
     * Ajustar puntos manualmente
     */
    public function adjustPoints(Request $request, LoyaltyAccount $account)
    {
        $validated = $request->validate([
            'points' => 'required|integer|not_in:0',
            'description' => 'required|string|max:255',
        ]);

        if ($validated['points'] > 0) {
            $account->addPoints($validated['points'], 'Ajuste manual: ' . $validated['description']);
        } else {
            $account->redeemPoints(abs($validated['points']), 'Ajuste manual: ' . $validated['description']);
        }

        return redirect()
            ->back()
            ->with('success', 'Puntos ajustados exitosamente');
    }
}
