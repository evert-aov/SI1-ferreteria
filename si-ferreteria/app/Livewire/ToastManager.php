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

    public function mount()
    {
        // Cargar toasts desde la sesión al montar el componente
        $this->toasts = session()->get('active_toasts', []);
    }


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
        $defaults = [
            'descripcion' => '',
            'tipo' => 'info',
            'autoCierre' => true,
            'duracion' => 10000,
            'icono' => $this->getIconFromType($toast['tipo'] ?? 'info')
        ];

        $toast = array_merge($defaults, $toast);

        // Establecer color basado en tipo
        if (!isset($toast['color'])) {
            $toast['color'] = $this->getColorFromType($toast['tipo']);
        }

        // Evitar duplicados
        if ($this->toastExists($toast['id'])) {
            return;
        }

        $this->toasts[] = $toast;
        $this->saveToastsToSession();
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
        // Disparar evento para que otros componentes manejen la lógica de negocio
        $this->dispatch('closeToast', id: $id);
        $this->removeToast($id);
    }

    /**
     * Ignorar alerta (no volverá a aparecer)
     */
    public function ignoreToast($id): void
    {
        // Disparar evento para que otros componentes manejen la lógica de negocio
        $this->dispatch('ignoreToast', id: $id);
        $this->removeToast($id);
    }

    /**
     * Remover un toast del array (método auxiliar)
     */
    protected function removeToast($id): void
    {
        $this->toasts = array_values(array_filter($this->toasts, function($toast) use ($id) {
            return $toast['id'] !== $id;
        }));

        $this->saveToastsToSession();
    }

    /**
     * Guardar toasts en la sesión para persistencia entre vistas
     */
    protected function saveToastsToSession(): void
    {
        if (count($this->toasts) > 0) {
            session()->put('active_toasts', $this->toasts);
        } else {
            session()->forget('active_toasts');
        }
    }

}
