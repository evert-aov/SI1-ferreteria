<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class AuditLog extends Component
{
    use WithPagination;

    public $search = '';

    public $user = null;
    public $action = '';
    public $affected_model = null;
    public $changes = '';
    public $affected_model_id = null;
    public $ip_address = '';
    public $user_agent = '';
    public $created_at = '';
    public $updated_at = '';

    protected $pagination_theme = 'tailwind';

    public function render()
    {
        $query = \App\Models\AuditLog::query();

        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('action', 'ILIKE', $searchTerm)
                    ->orWhere('affected_model', 'ILIKE', $searchTerm)
                    ->orWhere('changes', 'ILIKE', $searchTerm)
                    ->orWhere('ip_address', 'ILIKE', $searchTerm)
                    ->orWhere('user_agent', 'ILIKE', $searchTerm);
            });
        }

        $auditLogs = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.audit.audit-log', compact('auditLogs'))->layout('layouts.app');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
    }
}
