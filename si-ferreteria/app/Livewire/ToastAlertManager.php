<?php

namespace App\Livewire;

use App\Models\ProductAlert;
use App\Services\ProductAlertChecker;
use Carbon\Carbon;
use Livewire\Component;

class ToastAlertManager extends Component
{
    public $alerts = [];
    public $lastCheckTime; // Timestamp de última verificación

    // Escuchar evento desde ProductManager
    protected $listeners = ['product-expired-detected' => 'addExpiredAlert'];

    public function mount(): void
    {
        // Solo mostrar alertas a empleados y administradores
        if (!$this->canSeeAlerts()) {
            return;
        }

        // Generar alertas frescas y cargar
        $this->generateAndLoadAlerts();
    }


     public function render()
    {
        return view('livewire.product-alert.toast-alert-manager');
    }

    /**
     * Generar alertas en background y cargar las visibles
     * IMPORTANTE: Solo CARGA alertas, NO las genera
     */
    public function generateAndLoadAlerts(): void
    {
        $this->loadAlerts();
        $this->lastCheckTime = Carbon::now()->toDateTimeString();
    }


    /**
     * Cargar alertas desde la base de datos
     */
    protected function loadAlerts(): void
    {
        if (!$this->canSeeAlerts()) {
            return;
        }

        $user = auth()->user();
        $userRoles = $user->roles->pluck('name')->toArray();

        // Consultar alertas activas y pendientes visibles para el usuario
        $dbAlerts = ProductAlert::activas()
            ->pendientes()
            ->where(function($query) use ($userRoles) {
                foreach ($userRoles as $role) {
                    $query->orWhereJsonContains('visible_to', $role);
                }
            })
            ->with('producto')
            ->orderByRaw("CASE priority WHEN 'high' THEN 1 WHEN 'medium' THEN 2 WHEN 'low' THEN 3 END")
            ->get();

        // Convertir a formato de toasts
        $this->alerts = $dbAlerts->map(function($alert) {
            return [
                'id' => 'alert-' . $alert->id,
                'alert_id' => $alert->id, // ID real en DB
                'titulo' => $this->getTitulo($alert),
                'descripcion' => $alert->message,
                'color' => $alert->color, // Accessor del modelo
                'autoCierre' => $alert->priority !== 'high', // High priority no se cierra solo
                'duracion' => $this->getDuracion($alert)
            ];
        })->toArray();
    }


    /**
     * Verificar si el usuario puede ver alertas
     */
    protected function canSeeAlerts(): bool
    {
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        // Verificar si tiene rol de empleado o administrador
        return $user->roles()
            ->whereIn('name', ['Administrador', 'Vendedor'])
            ->exists();
    }

    /**
     * Obtener título según tipo de alerta
     */
    protected function getTitulo($alert): string
    {
        return match($alert->alert_type) {
            'upcoming_expiration' => '⚠️ Producto próximo a vencer',
            'expired' => '🚨 Producto vencido',
            'low_stock' => '📦 Stock bajo',
            'out_of_stock' => '❌ Sin stock',
            'promotion' => '🎉 Oferta especial',
            default => '🔔 Alerta'
        };
    }

    /**
     * Obtener duración del toast según prioridad
     */
    protected function getDuracion($alert): int
    {
        return match($alert->priority) {
            'high' => 0,      // No se cierra automáticamente
            'medium' => 15,   // 15 segundos
            'low' => 10,      // 10 segundos
            default => 10
        };
    }

    /**
     * Agregar alerta de producto vencido (llamado desde ProductManager)
     * LEGACY: Ahora usamos DB, pero mantenemos compatibilidad
     */
    public function addExpiredAlert($titulo, $mensaje, $color): void
    {
        // Solo agregar si el usuario puede ver alertas
        if (!$this->canSeeAlerts()) {
            return;
        }

        // Recargar alertas desde DB
        $this->loadAlerts();
    }

    /**
     * Cerrar alerta (marcar como leída en DB)
     */
    public function cerrarAlert($id): void
    {
        // Extraer el ID real de la alerta (formato: alert-123)
        $alertId = str_replace('alert-', '', $id);

        // Marcar como leída en la base de datos
        $alert = ProductAlert::find($alertId);
        if ($alert) {
            $alert->marcarComoLeida();
        }

        // Remover del array local
        $this->alerts = array_filter($this->alerts, function($alert) use ($id) {
            return $alert['id'] !== $id;
        });
    }

    /**
     * Ignorar alerta (no volverá a aparecer)
     */
    public function ignorarAlert($id): void
    {
        // Extraer el ID real de la alerta (formato: alert-123)
        $alertId = str_replace('alert-', '', $id);

        // Marcar como ignorada en la base de datos
        $alert = ProductAlert::find($alertId);
        if ($alert) {
            $alert->ignorar();
        }

        // Remover del array local
        $this->alerts = array_filter($this->alerts, function($alert) use ($id) {
            return $alert['id'] !== $id;
        });
    }
}
