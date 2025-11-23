<?php

namespace App\Livewire\Reports\CashRegister;

use App\Models\CashRegister;
use App\Services\CashMovementService;
use App\Services\CashRegisterService;
use Livewire\Component;

class Close extends Component
{
    public ?CashRegister $cashRegister = null;
    public array $statistics = [];
    public array $paymentSummary = [];
    public ?string $closing_notes = null;
    public bool $confirmClose = false;

    protected function rules()
    {
        return [
            'closing_notes' => 'nullable|string|max:500',
        ];
    }

    public function mount(
        CashRegisterService $cashRegisterService,
        CashMovementService $movementService
    ) {
        $this->cashRegister = $cashRegisterService->getOpenCashRegister(auth()->user());

        if (!$this->cashRegister) {
            session()->flash('warning', 'No tienes una caja abierta.');
            return redirect()->route('cash-register.index');
        }

        // Verificar que tenga al menos un arqueo
        if (!$this->cashRegister->hasCount()) {
            session()->flash('error', 'Debes realizar al menos un arqueo antes de cerrar la caja.');
            return redirect()->route('cash-register.count');
        }

        // Cargar estadísticas finales
        $this->statistics = $movementService->getTurnStatistics($this->cashRegister);
        $this->paymentSummary = $movementService->getSimplePaymentSummary($this->cashRegister); // ← CAMBIAR AQUÍ
    }

    public function closeCashRegister(CashRegisterService $cashRegisterService)
    {
        
        if (!$this->confirmClose) {
            session()->flash('error', 'Debes confirmar que deseas cerrar la caja.');
            return;
        }

        $this->validate();

        try {
            $cashRegisterService->closeCashRegister(
                $this->cashRegister,
                $this->closing_notes
            );

            session()->flash('success', '¡Caja cerrada exitosamente!');
            
            return redirect()->route('cash-register.index');
            
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        $lastCount = $this->cashRegister->getLastCount();

        return view('livewire.reports.cash-register.close', [
            'lastCount' => $lastCount,
            'statistics' => $this->statistics,
            'paymentSummary' => $this->paymentSummary,
        ])->layout('layouts.app');
    }
}