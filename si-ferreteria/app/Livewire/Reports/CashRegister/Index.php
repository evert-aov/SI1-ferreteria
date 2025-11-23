<?php

namespace App\Livewire\Reports\CashRegister;

use App\Models\CashRegister;
use App\Services\CashRegisterService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function mount(CashRegisterService $cashRegisterService)
    {
        // Si el usuario tiene caja abierta, redirigir al dashboard
        if ($cashRegisterService->hasOpenCashRegister(auth()->user())) {
            return redirect()->route('cash-register.dashboard');
        }
    }

    public function render()
    {
        $recentCashRegisters = CashRegister::where('user_id', auth()->id())
            ->latest('opened_at')
            ->limit(10)
            ->get();

        // Calcular estadísticas
        $closedToday = CashRegister::where('user_id', auth()->id())
            ->whereNotNull('closed_at')
            ->whereDate('closed_at', today())
            ->count();

        return view('livewire.reports.cash-register.index', [
            'recentCashRegisters' => $recentCashRegisters,
            'closedToday' => $closedToday,
            'totalCashRegisters' => $recentCashRegisters->count(),
        ])->layout('layouts.app');
    }
}