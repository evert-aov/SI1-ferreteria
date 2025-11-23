<?php

namespace App\Livewire\Reports\CashRegister;

use App\Models\CashRegister;
use App\Services\CashCountService;
use App\Services\CashRegisterService;
use Livewire\Component;

class Count extends Component
{
    public ?CashRegister $cashRegister = null;
    public float $systemBalance = 0;

    // Billetes bolivianos
    public int $bills_200 = 0;
    public int $bills_100 = 0;
    public int $bills_50 = 0;
    public int $bills_20 = 0;
    public int $bills_10 = 0;

    // Monedas bolivianas
    public int $coins_5 = 0;
    public int $coins_2 = 0;
    public int $coins_1 = 0;
    public float $coins_050 = 0;

    // Otros métodos de pago
    public float $total_cards = 0;
    public float $total_qr = 0;

    // Totales calculados
    public float $total_cash = 0;
    public float $total_counted = 0;
    public float $difference = 0;
    public float $difference_percentage = 0;

    public ?string $justification = null;

    protected function rules()
    {
        return [
            'bills_200' => 'required|integer|min:0|max:1000',
            'bills_100' => 'required|integer|min:0|max:1000',
            'bills_50' => 'required|integer|min:0|max:1000',
            'bills_20' => 'required|integer|min:0|max:1000',
            'bills_10' => 'required|integer|min:0|max:1000',
            'coins_5' => 'required|integer|min:0|max:1000',
            'coins_2' => 'required|integer|min:0|max:1000',
            'coins_1' => 'required|integer|min:0|max:1000',
            'coins_050' => 'required|numeric|min:0|max:10000',
            'total_cards' => 'required|numeric|min:0|max:100000',
            'total_qr' => 'required|numeric|min:0|max:100000',
            'justification' => 'nullable|string|max:500',
        ];
    }

    public function mount(CashRegisterService $cashRegisterService)
    {
        $this->cashRegister = $cashRegisterService->getOpenCashRegister(auth()->user());

        if (!$this->cashRegister) {
            session()->flash('warning', 'No tienes una caja abierta.');
            return redirect()->route('cash-register.index');
        }

        $this->systemBalance = $this->cashRegister->getCurrentBalance();
    }

    public function updated($propertyName)
    {
        // Recalcular totales cuando cambia cualquier campo
        if (str_starts_with($propertyName, 'bills_') || 
            str_starts_with($propertyName, 'coins_') || 
            $propertyName === 'total_cards' || 
            $propertyName === 'total_qr') {
            $this->calculateTotals();
        }
    }

    public function calculateTotals()
    {
        // Calcular total efectivo
        $this->total_cash = 
            ($this->bills_200 * 200) +
            ($this->bills_100 * 100) +
            ($this->bills_50 * 50) +
            ($this->bills_20 * 20) +
            ($this->bills_10 * 10) +
            ($this->coins_5 * 5) +
            ($this->coins_2 * 2) +
            ($this->coins_1 * 1) +
            $this->coins_050;

        // Calcular total contado
        $this->total_counted = $this->total_cash + $this->total_cards + $this->total_qr;

        // Calcular diferencia
        $this->difference = $this->total_counted - $this->systemBalance;

        // Calcular porcentaje
        if ($this->systemBalance > 0) {
            $this->difference_percentage = ($this->difference / $this->systemBalance) * 100;
        } else {
            $this->difference_percentage = 0;
        }
    }

    public function performCount(CashCountService $countService)
    {
        $this->validate();

        // Validar justificación si hay diferencia crítica
        if (abs($this->difference_percentage) > 2 && empty($this->justification)) {
            session()->flash('error', 'Debes justificar la diferencia mayor al 2%.');
            return;
        }

        try {
            // Preparar datos del arqueo
            $countData = [
                'system_amount' => $this->systemBalance,
                'bills_200' => $this->bills_200,
                'bills_100' => $this->bills_100,
                'bills_50' => $this->bills_50,
                'bills_20' => $this->bills_20,
                'bills_10' => $this->bills_10,
                'coins_5' => $this->coins_5,
                'coins_2' => $this->coins_2,
                'coins_1' => $this->coins_1,
                'coins_050' => $this->coins_050,
                'total_cash' => $this->total_cash,
                'total_cards' => $this->total_cards,
                'total_qr' => $this->total_qr,
                'total_counted' => $this->total_counted,
                'difference' => $this->difference,
                'difference_percentage' => $this->difference_percentage,
                'justification' => $this->justification,
            ];

            // Determinar estado
            $absPercentage = abs($this->difference_percentage);
            if ($absPercentage > 2) {
                $countData['status'] = 'critical';
            } elseif ($this->difference != 0) {
                $countData['status'] = 'with_difference';
            } else {
                $countData['status'] = 'normal';
            }

            // Guardar directamente en el modelo
            $this->cashRegister->counts()->create($countData);

            session()->flash('success', '¡Arqueo realizado exitosamente!');
            
            return redirect()->route('cash-register.dashboard');
            
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.reports.cash-register.count')->layout('layouts.app');
    }
}