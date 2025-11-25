<?php

namespace App\Livewire\Reports\CashRegister;

use App\Enums\MovementConcept;
use App\Enums\MovementType;
use App\Enums\PaymentMethod;
use App\Models\CashRegister;
use App\Services\CashMovementService;
use App\Services\CashRegisterService;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public ?CashRegister $cashRegister = null;
    public array $statistics = [];
    public array $paymentSummary = [];
    public array $expensesByConcept = [];

    // Para modal de movimiento manual
    public bool $showMovementModal = false;
    public string $type = 'income';
    public string $concept = 'other';
    public string $payment_method = 'cash';
    public float $amount = 0;
    public string $description = '';

    protected function rules()
    {
        return [
            'type' => 'required|in:income,expense',
            'concept' => 'required|in:sale,purchase,expense,withdrawal,deposit,other',
            'payment_method' => 'required|in:cash,credit_card,debit_card,qr',
            'amount' => 'required|numeric|min:0.01|max:100000',
            'description' => 'required|string|min:5|max:500',
        ];
    }

    protected $messages = [
        'type.required' => 'Selecciona el tipo de movimiento.',
        'concept.required' => 'Selecciona un concepto.',
        'payment_method.required' => 'Selecciona un método de pago.',
        'amount.required' => 'El monto es obligatorio.',
        'amount.min' => 'El monto debe ser mayor a 0.',
        'amount.max' => 'El monto no puede superar Bs. 100,000.',
        'description.required' => 'La descripción es obligatoria.',
        'description.min' => 'La descripción debe tener al menos 5 caracteres.',
        'description.max' => 'La descripción no puede superar 500 caracteres.',
    ];

    public function mount(
        CashRegisterService $cashRegisterService,
        CashMovementService $movementService
    ) {
        // Obtener caja abierta del usuario
        $this->cashRegister = $cashRegisterService->getOpenCashRegister(auth()->user());

        // Si no tiene caja abierta, redirigir a apertura
        if (!$this->cashRegister) {
            session()->flash('warning', 'No tienes una caja abierta.');
            return redirect()->route('cash-register.index');
        }

        // Cargar estadísticas
        $this->loadStatistics($movementService);
    }

    protected function loadStatistics(CashMovementService $movementService): void
    {
        $this->statistics = $movementService->getTurnStatistics($this->cashRegister);
        $this->paymentSummary = $movementService->getSummaryByPaymentMethod($this->cashRegister);
        $this->expensesByConcept = $movementService->getExpensesByConcept($this->cashRegister);
    }

    public function openMovementModal()
    {
        $this->showMovementModal = true;
    }

    public function closeMovementModal()
    {
        $this->showMovementModal = false;
        $this->reset(['type', 'concept', 'payment_method', 'amount', 'description']);
        $this->resetValidation();
    }

    public function registerMovement(CashMovementService $movementService)
    {
        $this->validate();

        try {
            $movementService->registerMovement(
                $this->cashRegister,
                MovementType::from($this->type),
                MovementConcept::from($this->concept),
                PaymentMethod::from($this->payment_method),
                $this->amount,
                $this->description
            );

            $this->closeMovementModal();
            $this->loadStatistics($movementService);
            
            session()->flash('success', 'Movimiento registrado exitosamente.');
            
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.reports.cash-register.dashboard', [
            'movements' => $this->cashRegister->movements()
                ->latest()
                ->paginate(10),
        ])->layout('layouts.app');
    }
}