<?php

namespace App\Livewire\Reports\CashRegister;

use App\Models\CashRegister;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class History extends Component
{
    use WithPagination;

    // Filtros
    public ?string $date_from = null;
    public ?string $date_to = null;
    public ?string $status_filter = null;
    public string $search = '';

    // Estadísticas del período
    public array $periodStats = [];

    public function mount()
    {
        // Establecer fechas por defecto (último mes)
        $this->date_from = now()->subMonth()->format('Y-m-d');
        $this->date_to = now()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function applyFilters()
    {
        $this->resetPage();
        $this->calculatePeriodStats();
    }

    public function clearFilters()
    {
        $this->reset(['date_from', 'date_to', 'status_filter', 'search']);
        $this->mount();
        $this->resetPage();
    }

    protected function calculatePeriodStats()
    {
        $query = CashRegister::where('user_id', auth()->id());

        if ($this->date_from) {
            $query->whereDate('opened_at', '>=', $this->date_from);
        }

        if ($this->date_to) {
            $query->whereDate('opened_at', '<=', $this->date_to);
        }

        if ($this->status_filter === 'open') {
            $query->whereNull('closed_at');
        } elseif ($this->status_filter === 'closed') {
            $query->whereNotNull('closed_at');
        }

        $cashRegisters = $query->get();

        $this->periodStats = [
            'total' => $cashRegisters->count(),
            'open' => $cashRegisters->where('closed_at', null)->count(),
            'closed' => $cashRegisters->where('closed_at', '!=', null)->count(),
            'total_opening' => $cashRegisters->sum('opening_amount'),
            'total_closing' => $cashRegisters->whereNotNull('closed_at')->sum('closing_amount_real'),
            'total_difference' => $cashRegisters->whereNotNull('closed_at')->sum('difference'),
        ];
    }

    public function exportToPDF($cashRegisterId)
    {
        // TODO: Implementar exportación a PDF
        session()->flash('info', 'Funcionalidad de exportación próximamente.');
    }

    public function render()
    {
        $query = CashRegister::where('user_id', auth()->id())
            ->with(['user', 'movements', 'counts']);

        // Aplicar filtros de fecha
        if ($this->date_from) {
            $query->whereDate('opened_at', '>=', $this->date_from);
        }

        if ($this->date_to) {
            $query->whereDate('opened_at', '<=', $this->date_to);
        }

        // Aplicar filtro de estado
        if ($this->status_filter === 'open') {
            $query->whereNull('closed_at');
        } elseif ($this->status_filter === 'closed') {
            $query->whereNotNull('closed_at');
        }

        // Aplicar búsqueda por notas
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('opening_notes', 'like', '%' . $this->search . '%')
                  ->orWhere('closing_notes', 'like', '%' . $this->search . '%');
            });
        }

        $cashRegisters = $query->latest('opened_at')->paginate(15);

        // Calcular estadísticas del período
        $this->calculatePeriodStats();

        return view('livewire.reports.cash-register.history', [
            'cashRegisters' => $cashRegisters,
        ])->layout('layouts.app');
    }
}