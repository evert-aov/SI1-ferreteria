# Caso de Uso - Dashboard Analítico

## CU-Analytics: Visualizar Dashboard Analítico y Métricas del Negocio

| Campo | Descripción |
|-------|-------------|
| **Caso de uso** | CU-Analytics - Visualizar Dashboard Analítico y Métricas del Negocio |
| **Propósito** | Permite al Administrador visualizar métricas clave del negocio (ingresos, ticket promedio, stock crítico, egresos), analizar tendencias de ventas mediante gráficos interactivos, identificar productos más vendidos y mejor calificados, y detectar productos con stock crítico que requieren reabastecimiento. |
| **Actores** | • Administrador<br>• Sistema (gestión de datos y cálculos automáticos) |
| **Iniciador** | Administrador |
| **Precondición** | • El Administrador debe haber iniciado sesión en el sistema con rol de Administrador.<br>• Deben existir datos históricos de ventas, compras, productos y reseñas en la base de datos. |
| **Flujo** | 1. El Administrador accede al Dashboard Analítico desde el menú principal (`/dashboard`).<br>2. El sistema carga el componente con filtro de fecha por defecto (Últimos 30 días).<br>3. El sistema calcula y muestra 4 KPIs principales: Ingresos Totales, Ticket Promedio, Stock Crítico y Egresos/Compras.<br>4. El sistema renderiza un gráfico de área mostrando la tendencia de ventas (por día para 7/30 días, por mes para 12 meses).<br>5. El sistema muestra el Top 5 de Productos Más Vendidos (cantidad vendida por producto).<br>6. El sistema muestra el Top 5 de Productos Mejor Calificados (rating promedio con mínimo 3 reseñas).<br>7. Si existen productos con stock ≤ 10 unidades, el sistema muestra una sección de alerta con productos críticos clasificados por color (rojo: sin stock, naranja: bajo stock).<br>8. El Administrador puede cambiar el filtro de período (7 días, 30 días, 12 meses).<br>9. Al cambiar el filtro, el sistema actualiza todos los KPIs, recalcula los datos del gráfico y actualiza las listas de Top productos.<br>10. El Administrador puede interactuar con el gráfico (ver tooltips, descargar imagen). |
| **Postcondición** | • El Administrador visualiza información consolidada y actualizada del negocio.<br>• No se modifica ningún dato en la base de datos (solo consultas de lectura).<br>• El sistema mantiene el estado del filtro seleccionado durante la sesión.<br>• Si corresponde, las acciones de acceso pueden registrarse en auditoría. |
| **Excepción** | • **No existen datos para el período seleccionado**: El sistema muestra KPIs en 0 y mensaje "No hay datos disponibles" en gráfico y tablas.<br>• **No existen productos con stock crítico**: La sección de stock crítico no se muestra.<br>• **Error de conexión a la base de datos**: El sistema muestra mensaje de error y sugiere recargar la página.<br>• **Datos inconsistentes o corruptos**: El sistema omite registros problemáticos y muestra "N/A" en campos afectados.<br>• **Timeout en consultas complejas**: El sistema sugiere seleccionar un período más corto.<br>• **Error en librería ApexCharts**: El sistema muestra los datos en formato de tabla alternativo.<br>• **Productos sin imagen**: El sistema muestra un ícono genérico de producto. |

---

## Reglas de Negocio

| ID | Regla |
|----|-------|
| **RN1** | Solo se cuentan ventas con `status = 'paid'` para calcular ingresos y tendencias. Se incluyen ventas de las tablas `sales` (ventas registradas) y `sale_unpersons` (ventas sin registro de usuario). |
| **RN2** | Un producto tiene stock crítico si: `stock <= 10 unidades` o `stock = 0` (solo productos activos). |
| **RN3** | Un producto aparece en Top Calificados solo si tiene al menos 3 reseñas aprobadas (`status = 'approved'`). |
| **RN4** | Agrupación de datos: 7/30 días = diaria, 12 meses = mensual. |
| **RN5** | Montos se redondean a 2 decimales, calificaciones a 1 decimal. |
| **RN6** | Límites: Top 5 productos vendidos, Top 5 calificados, máximo 10 productos con stock crítico. |

---

## Datos de Prueba

Para demostrar el funcionamiento, ejecutar:

```bash
# Generar 2,228 ventas, 562 compras, 21 reseñas
php artisan db:seed --class=AnalyticsDemoDataSeeder

# Crear productos con stock crítico (3 sin stock, 5 bajo stock)
php update_critical_stock.php
```

---

## Archivos del Caso de Uso

| Archivo | Ubicación | Propósito |
|---------|-----------|-----------||
| `Analytics.php` | `app/Livewire/Reports/Analytics.php` | Componente Livewire principal con lógica de negocio (incluye ventas de `sales` y `sale_unpersons`) |
| `analytics.blade.php` | `resources/views/livewire/reports/analytics.blade.php` | Vista del dashboard con KPIs, gráfico y tablas |
| `web.php` | `routes/web.php` | Ruta `/dashboard` |
| `AnalyticsDemoDataSeeder.php` | `database/seeders/` | Generador de datos de prueba |
| `diagrama-clases-analytics.puml` | `docs/` | Diagrama UML de clases |
