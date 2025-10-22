<?php

namespace App\Livewire\ReportAndAnalysis;

use Livewire\Component;

class ProductAlertManager extends Component
{
    public string $activeTab = 'manual';
    public bool $hasAccess = false;

    public function mount()
    {
        $this->checkAccess();
    }

    public function render()
    {
        return view('livewire.product-alert.product-alert-manager')
            ->layout('layouts.app');
    }

    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }

    /**
     * Verificar si el usuario tiene acceso al módulo
     */
    protected function checkAccess(): void
    {
        $user = auth()->user();

        if (!$user) {
            $this->hasAccess = false;
            return;
        }

        // Solo Administrador y Vendedor tienen acceso
        $this->hasAccess = $user->roles()
            ->whereIn('name', ['Administrador', 'Vendedor'])
            ->exists();
    }
}
