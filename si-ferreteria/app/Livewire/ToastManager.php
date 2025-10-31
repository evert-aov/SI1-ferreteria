<?php

namespace App\Livewire;

use Livewire\Component;

/**
 * Componente genérico para mostrar notificaciones toast
 * No tiene lógica de negocio específica, solo maneja la visualización
 */
class ToastManager extends Component
{
    public $toasts = [];



    // Escuchar eventos genéricos
    protected $listeners = [
        'toast:add' => 'addToast',
        'toast:clearAll' => 'clearAll',
        'toast:addToasts' => 'addToasts',
        'toast:ignore' => 'ignoreToast',
        'toast:close' => 'closeToast',
    ];

    public function render()
    {
        return view('livewire.toast-manager');
    }

    /**
     * Agregar un toast al stack
     *
     * @param array $toast [
     *   'id' => 'unique-id',
     *   'titulo' => 'Título',
     *   'descripcion' => 'Mensaje',
     *   'tipo' => 'success|error|warning|info',
     *   'color' => 'bg-green-500', // opcional, override de tipo
     *   'autoCierre' => true,
     *   'duracion' => 5000, // milisegundos
     *   'icono' => '✓' // opcional
     * ]
     */
    public function addToast(array $toast): void
    {
        // Validar datos mínimos
        if (!isset($toast['id']) || !isset($toast['titulo'])) {
            return;
        }

        // Aplicar defaults
        $toast = array_merge([
            'descripcion' => '',
            'tipo' => 'info',
            'color' => $this->getColorFromType($toast['tipo'] ?? 'info'),
            'autoCierre' => true,
            'duracion' => $this->getDuracionFromPriority($toast['prioridad'] ?? 'medium'),
            'icono' => $this->getIconFromType($toast['tipo'] ?? 'info')
        ], $toast);

        // Evitar duplicados
        if ($this->toastExists($toast['id'])) {
            return;
        }

        $this->toasts[] = $toast;
    }

    /**
     * Agregar múltiples toasts de una vez
     */
    public function addToasts(array $toasts): void
    {
        //dd($toasts);
        foreach ($toasts as $toast) {
            $this->addToast($toast);
        }
    }


    /**
     * Limpiar todos los toasts
     */
    public function clearAll(): void
    {
        $this->toasts = [];
    }

    /**
     * Verificar si ya existe un toast con ese ID
     */
    protected function toastExists(string $id): bool
    {
        foreach ($this->toasts as $toast) {
            if ($toast['id'] === $id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Obtener color según tipo
     */
    protected function getColorFromType(string $tipo): string
    {
        return match($tipo) {
            'success' => 'green',
            'error' => 'red',
            'warning' => 'yellow',
            'info' => 'blue',
            default => 'purple'
        };
    }

    /**
     * Obtener icono según tipo
     */
    protected function getIconFromType(string $tipo): string
    {
        return match($tipo) {
            'success' => '✓',
            'error' => '✕',
            'warning' => '⚠',
            'info' => 'ℹ',
            default => '🔔'
        };
    }

    /**
     * Cerrar alerta (marcar como leída)
     */
    public function closeToast($id): void
    {
        // Remover del array local
        $this->toasts = array_filter($this->toasts, function($toast) use ($id) {
            return $toast['id'] !== $id;
        });
    }

    /**
     * Ignorar alerta (no volverá a aparecer)
     */
    public function ignoreToast($id): void
    {
        // Remover del array local
        $this->toasts = array_filter($this->toasts, function($toast) use ($id) {
            return $toast['id'] !== $id;
        });
    }

    public function getDuracionFromPriority(string $priority): int
    {
        return match($priority) {
            'high' => 0,      // No se cierra automáticamente
            'medium' => 15000,   // 15 segundos
            'low' => 10000,      // 10 segundos
            default => 10000
        };
    }
}
