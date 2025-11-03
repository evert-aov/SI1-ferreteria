# Módulo de Gestión de Ventas Presenciales

## 📋 Resumen de Implementación

Se ha implementado un módulo completo de gestión de ventas presenciales siguiendo los patrones y estándares del proyecto existente.

## 🗂️ Archivos Creados/Modificados

### Modelos (app/Models/)
- ✅ **Sale.php** - Modelo de ventas con relaciones y método updateTotal()
- ✅ **SaleDetail.php** - Modelo de detalles de venta con relaciones
- ✅ **Payment.php** - Modelo de pagos con relaciones

### Formularios (app/Livewire/Forms/)
- ✅ **SaleForm.php** - Formulario Livewire para gestión de ventas
  - Validaciones de stock
  - Cálculo de descuentos por producto
  - Generación automática de número de factura
  - Carga automática de precios

### Componentes Livewire (app/Livewire/Sales/)
- ✅ **SaleManager.php** - Componente principal de gestión de ventas
  - Manejo de transacciones
  - Actualización de inventario
  - Registro de pagos
  - Validaciones de negocio

### Vistas (resources/views/livewire/sales/)
- ✅ **sale-manager.blade.php** - Vista principal
- ✅ **sale-form.blade.php** - Formulario de venta
- ✅ **components/header-sale.blade.php** - Encabezado
- ✅ **components/table-header.blade.php** - Encabezados de tabla
- ✅ **components/table-rows.blade.php** - Filas de tabla

### Rutas (routes/)
- ✅ **web.php** - Agregada ruta `/sales` con nombre `sales.index`

### Navegación
- ✅ **layouts/sidebar.blade.php** - Agregado enlace "Registrar Venta Presencial" en sección "Gestión de Compras"

### Migraciones (database/migrations/)
- ✅ **2025_11_02_000001_add_sale_id_to_payments_table.php** - Migración para actualizar tabla payments

## 🚀 Pasos para Activar el Módulo

### 1. Instalar Dependencias (si aún no lo hiciste)

```powershell
# En la carpeta del proyecto
cd 'C:\Users\Usuario\OneDrive\Desktop\Ferreteria\si1-ferreteria\si-ferreteria'

# Instalar dependencias PHP
composer install

# Instalar dependencias JavaScript (ya lo hiciste)
npm install
```

### 2. Ejecutar Migraciones

```powershell
# Aplicar la nueva migración de payments
php artisan migrate
```

Si la migración falla porque las tablas ya existen, puedes:

**Opción A - Refrescar todo (¡CUIDADO! Borra datos):**
```powershell
php artisan migrate:fresh --seed
```

**Opción B - Solo ejecutar la nueva migración:**
```powershell
php artisan migrate --path=database/migrations/2025_11_02_000001_add_sale_id_to_payments_table.php
```

### 3. Verificar Base de Datos

Asegúrate de que PostgreSQL esté corriendo y que la base de datos tenga:
- ✅ Tabla `sales` con sus campos
- ✅ Tabla `sale_details` con sus campos
- ✅ Tabla `payments` con campo `sale_id` agregado
- ✅ Tabla `payment_methods` con métodos de pago activos
- ✅ Tabla `products` con stock > 0
- ✅ Tabla `users` con clientes

### 4. Poblar Datos de Prueba (Opcional)

Si necesitas datos de prueba, crea un seeder o inserta manualmente:

```sql
-- Ejemplo: Agregar método de pago
INSERT INTO payment_methods (name, is_active, created_at, updated_at) 
VALUES 
    ('Efectivo', true, NOW(), NOW()),
    ('Tarjeta de Crédito', true, NOW(), NOW()),
    ('Transferencia', true, NOW(), NOW());
```

### 5. Levantar el Servidor

```powershell
# Terminal 1: Servidor Laravel
php artisan serve

# Terminal 2: Servidor Vite (en otra ventana)
npm run dev
```

### 6. Acceder al Módulo

1. Abre tu navegador en: `http://127.0.0.1:8000`
2. Inicia sesión
3. En el sidebar, busca la sección **"Gestión de Compras"**
4. Haz clic en **"Registrar Venta Presencial"**

## ✨ Funcionalidades Implementadas

### ✅ Formulario de Venta
- Selección de cliente
- Número de factura auto-generado (formato: VEN-000001)
- Método de pago
- Monto pagado

### ✅ Agregar Productos
- Selección de producto con stock disponible
- Cantidad (validación de stock)
- Precio unitario (se carga automáticamente del producto)
- Descuento por producto (%)
- Botón "Agregar Producto"

### ✅ Lista de Productos en Venta
- Tabla con productos agregados
- Botón para eliminar productos
- Cálculo automático de subtotales

### ✅ Resumen de Venta
- Subtotal
- Descuento general
- Impuesto
- Total destacado

### ✅ Lógica de Negocio
- ✅ Validación de stock antes de agregar productos
- ✅ Actualización automática de inventario (reduce stock)
- ✅ Registro de salida en campo `output` del producto
- ✅ Cálculo de totales y subtotales
- ✅ Transacciones de base de datos (rollback en caso de error)
- ✅ Registro de pagos vinculado a la venta
- ✅ Estado de venta: "paid" (pagado)

## 🎨 Diseño

El diseño sigue el mismo patrón visual del resto del proyecto:
- ✅ Colores consistentes (gradientes verde/teal para ventas)
- ✅ Espaciado y tipografía uniforme
- ✅ Componentes reutilizables (`x-container-div`, `x-table`, etc.)
- ✅ Iconos Lucide consistentes
- ✅ Mensajes de éxito/error con estilos Tailwind
- ✅ Responsive design

## 📊 Estructura de Datos

### Tabla: sales
- id
- invoice_number (único)
- customer_id → users
- payment_id → payments (nullable)
- subtotal
- discount
- tax
- total
- status (draft/pending_payment/paid/cancelled)
- notes
- timestamps

### Tabla: sale_details
- id
- sale_id → sales
- product_id → products
- quantity
- unit_price
- discount_percentage
- subtotal
- timestamps

### Tabla: payments (actualizada)
- id
- **sale_id → sales** (NUEVO)
- payment_method_id → payment_methods
- amount
- **transaction_reference** (NUEVO)
- **payment_date** (NUEVO)
- status
- timestamps

## ⚠️ Notas Importantes

1. **No se ha ejecutado ningún commit** - Como solicitaste, solo se crearon/modificaron los archivos
2. **Migración pendiente** - Debes ejecutar `php artisan migrate` para actualizar la tabla payments
3. **Stock** - El módulo verifica stock antes de agregar productos y lo actualiza al guardar la venta
4. **Validaciones** - Incluye validaciones de formulario y de negocio (stock, campos requeridos, etc.)
5. **Transacciones** - Usa DB transactions para garantizar consistencia de datos

## 🔧 Próximos Pasos Sugeridos (Opcional)

- [ ] Agregar vista de listado de ventas realizadas
- [ ] Implementar búsqueda y filtros de ventas
- [ ] Agregar impresión de factura (PDF)
- [ ] Implementar devoluciones/cancelaciones
- [ ] Agregar reportes de ventas por período
- [ ] Implementar descuentos globales por cliente
- [ ] Agregar múltiples métodos de pago por venta

## 🐛 Troubleshooting

### Error: "Class SaleManager not found"
```powershell
composer dump-autoload
```

### Error: "Table payments doesn't have column sale_id"
```powershell
php artisan migrate
```

### Error: "No products available"
Verifica que haya productos con stock > 0:
```sql
SELECT * FROM products WHERE stock > 0;
```

### Error: "No payment methods available"
Inserta métodos de pago:
```sql
INSERT INTO payment_methods (name, is_active) VALUES ('Efectivo', true);
```

---

**¡Módulo de Ventas Presenciales implementado exitosamente!** 🎉

Cuando ejecutes `php artisan migrate` y levantes el servidor, podrás empezar a registrar ventas presenciales desde el sidebar.
