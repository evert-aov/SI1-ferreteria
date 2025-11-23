<?php

namespace App\Livewire\Reports\CashRegister;

use App\Services\CashRegisterService;
use Livewire\Component;

class Open extends Component
{
    public float $opening_amount = 0;
    public string $opening_notes = '';

    protected $rules = [
        'opening_amount' => 'required|numeric|min:0|max:100000',
        'opening_notes' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'opening_amount.required' => 'El monto inicial es obligatorio.',
        'opening_amount.numeric' => 'El monto debe ser un número válido.',
        'opening_amount.min' => 'El monto no puede ser negativo.',
        'opening_amount.max' => 'El monto no puede exceder 100,000 Bs.',
    ];

    public function mount(CashRegisterService $cashRegisterService)
    {
        // Si ya tiene caja abierta, redirigir al dashboard
        if ($cashRegisterService->hasOpenCashRegister(auth()->user())) {
            return redirect()->route('cash-register.dashboard');
        }
    }

    public function openCashRegister(CashRegisterService $cashRegisterService)
    {
        $this->validate();

        try {
            $cashRegister = $cashRegisterService->openCashRegister(
                auth()->user(),
                $this->opening_amount,
                $this->opening_notes ?: null
            );

            session()->flash('success', 'Caja abierta exitosamente.');
            
            return redirect()->route('cash-register.dashboard');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.reports.cash-register.open')
            ->layout('layouts.app');
    }
}