# Dashboard Analítico - Documentación

## 📊 Descripción General
El Dashboard Analítico es un componente completo de Livewire 3 que proporciona métricas clave de rendimiento (KPIs) y análisis visual de datos para administradores.

## 🚀 Acceso al Dashboard

### URL de Acceso (Panel Principal)
```
http://localhost:8000/dashboard
```

### Ruta Configurada
```php
// Dashboard - Panel Principal con Analytics
Route::get('/dashboard', Analytics::class)->name('dashboard');
```

### Acceso desde el Menú
- **Panel Principal** (sidebar superior) - Acceso directo al dashboard
- **Reportes y Alertas** > **Dashboard Analítico** - Menú desplegable

## ✨ Características Implementadas

### 1. **Filtro de Fecha Reactivo** (Top Right)
- **Últimos 7 días**
- **Últimos 30 días** (predeterminado)
- **Últimos 12 meses**

El filtro es completamente reactivo usando `wire:model.live`, lo que significa que todos los datos se actualizan automáticamente sin recargar la página.

### 2. **Tarjetas de KPIs** (4 Cards Principales)

#### A. Ingresos Totales 💰
- Suma total de ventas con estado "paid" en el periodo seleccionado
- Color: Verde
- Icono: Moneda

#### B. Ticket Promedio 📊
- Cálculo: Total Ventas / Cantidad de Ventas
- Color: Azul
- Icono: Calculadora

#### C. Stock Crítico ⚠️
- Muestra productos con alertas de stock bajo activas
- Si no hay alertas, cuenta productos con stock <= 10 unidades
- **Alerta visual**: Borde rojo y texto rojo cuando hay productos críticos
- Color: Rojo (cuando hay alertas) / Gris (sin alertas)
- Icono: Caja de inventario

#### D. Egresos/Compras 🛒
- Suma total de compras (tabla `entries`) en el periodo seleccionado
- Color: Naranja
- Icono: Bolsa de compras

### 3. **Gráfico de Tendencia de Ventas** (ApexCharts)

#### Características del Gráfico:
- **Tipo**: Gráfico de ÁREA con gradiente verde
- **Agrupación Inteligente**:
  - Filtro 7 días o 30 días → Agrupado por DÍA
  - Filtro 12 meses → Agrupado por MES
- **Interactividad**:
  - Hover para ver valores exactos
  - Descarga del gráfico habilitada
  - Animaciones suaves
- **Actualización Reactiva**: Se redibuja automáticamente al cambiar el filtro

#### Formato de Datos:
- Eje Y: Formato monetario ($XX,XXX.XX)
- Eje X: Fechas formateadas ("d M" o "M Y")

### 4. **Tablas de Ranking** (2 Columnas)

#### A. Top 5 Productos Más Vendidos 📈
- Basado en la suma de `quantity` en `SaleDetail`
- Solo considera ventas con estado "paid"
- Muestra:
  - Posición (1-5)
  - Imagen del producto (o placeholder)
  - Nombre del producto
  - Cantidad vendida

#### B. Top 5 Productos Mejor Calificados ⭐
- Promedio de `rating` de la tabla `Review`
- **Requisito**: Mínimo 3 reviews aprobadas por producto
- Muestra:
  - Posición (1-5)
  - Imagen del producto (o placeholder)
  - Nombre del producto
  - Estrellas visuales (★★★★★)
  - Rating numérico (X.X)
  - Cantidad de reseñas

## 🛠️ Tecnologías Utilizadas

### Backend
- **Laravel 10/11**
- **Livewire 3** (Componentes reactivos)
- **Carbon** (Manejo de fechas)
- **PostgreSQL** (Base de datos)

### Frontend
- **Tailwind CSS** (Estilos y diseño responsivo)
- **ApexCharts** (Visualización de datos)
- **Blade Templates** (Motor de plantillas)

### Optimizaciones
- Consultas SQL optimizadas con agregaciones
- Uso de `with()` para Eager Loading
- Computed Properties de Livewire para cacheo automático
- Índices en las consultas de base de datos

## 📁 Estructura de Archivos

```
app/
└── Livewire/
    └── Reports/
        └── Analytics.php          # Componente Livewire

resources/
└── views/
    └── livewire/
        └── reports/
            └── analytics.blade.php # Vista Blade

routes/
└── web.php                        # Ruta configurada
```

## 🎨 Diseño y UX

### Paleta de Colores
- **Verde** (#10B981): Ingresos/Ganancias
- **Azul** (#3B82F6): Métricas generales
- **Rojo** (#EF4444): Alertas/Stock crítico
- **Naranja** (#F59E0B): Egresos/Compras
- **Amarillo** (#FBBF24): Calificaciones

### Características Visuales
- Cards con sombras suaves y hover effects
- Bordes redondeados (`rounded-xl`)
- Diseño responsivo (móvil, tablet, desktop)
- Iconos SVG inline para mejor rendimiento
- Transiciones suaves en todos los elementos interactivos

## 🔧 Configuración Adicional

### Middleware de Autenticación
El dashboard está protegido con el middleware `auth`, lo que significa que solo usuarios autenticados pueden acceder.

### Permisos y Acceso
El dashboard está configurado como **Panel Principal** para todos los usuarios autenticados. Solo los usuarios con rol **Administrador** pueden verlo en el menú de "Reportes y Alertas".

Para restringir el acceso solo a administradores en el panel principal, modifica la ruta en `web.php`:

```php
Route::get('/dashboard', Analytics::class)
    ->middleware(['verified', 'role:Administrador'])
    ->name('dashboard');
```

## 📊 Modelos Utilizados

### Sale
- Campo principal: `total`, `status`, `created_at`
- Relación: `saleDetails`

### SaleDetail
- Campos: `quantity`, `product_id`, `sale_id`
- Relaciones: `sale`, `product`

### Entry (Compras)
- Campos: `total`, `invoice_date`

### Product
- Campos: `stock`, `name`, `image`, `is_active`
- Relaciones: `reviews`

### Review
- Campos: `rating`, `product_id`, `status`
- Relación: `product`

### ProductAlert
- Campos: `alert_type`, `status`, `active`, `product_id`

## 🚀 Cómo Probar el Dashboard

### 1. Acceder al Dashboard
```bash
# Asegúrate de que el servidor esté corriendo
php artisan serve

# Visita en tu navegador
http://localhost:8000/analytics
```

### 2. Generar Datos de Prueba (Opcional)
Si necesitas datos de prueba, puedes crear seeders o usar Tinker:

```bash
php artisan tinker
```

```php
// Crear ventas de prueba
\App\Models\Sale::factory()->count(50)->create();

// Crear reviews de prueba
\App\Models\Review::factory()->count(100)->create();
```

### 3. Probar Filtros
- Cambia entre "Últimos 7 días", "Últimos 30 días" y "Últimos 12 meses"
- Observa cómo el gráfico y todos los KPIs se actualizan automáticamente

## 🐛 Troubleshooting

### El gráfico no se muestra
**Solución**: Verifica que el CDN de ApexCharts esté cargando correctamente:
```html
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
```

### Error "Class 'ProductAlert' not found"
**Solución**: Verifica que el namespace sea correcto:
```php
use App\Models\ReportAndAnalysis\ProductAlert;
```

### Las imágenes de productos no se muestran
**Solución**: Asegúrate de que el storage esté vinculado:
```bash
php artisan storage:link
```

### Los datos no se actualizan al cambiar el filtro
**Solución**: Verifica que estés usando `wire:model.live` en el select del filtro.

## 🔮 Mejoras Futuras Sugeridas

1. **Exportar Reportes**: Agregar botones para exportar a PDF/Excel
2. **Comparación de Periodos**: Mostrar % de cambio vs periodo anterior
3. **Más Filtros**: Agregar filtros por categoría, sucursal, etc.
4. **Gráficos Adicionales**: Agregar gráfico de egresos, margen de ganancia, etc.
5. **Alertas en Tiempo Real**: Notificaciones push cuando hay stock crítico
6. **Dashboard Personalizable**: Permitir al usuario reordenar/ocultar widgets

## 📞 Soporte

Si tienes problemas o necesitas ayuda adicional con el dashboard, revisa:
- Logs de Laravel: `storage/logs/laravel.log`
- Consola del navegador (F12) para errores de JavaScript
- Documentación de Livewire: https://livewire.laravel.com

---

**Desarrollado con ❤️ usando Laravel, Livewire y Tailwind CSS**
