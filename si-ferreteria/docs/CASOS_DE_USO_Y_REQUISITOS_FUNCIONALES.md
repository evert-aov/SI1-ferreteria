# Casos de Uso y Requisitos Funcionales - Sistema de Ferretería

> **Proyecto:** SI1 - Sistema de Información para Ferretería  
> **Fecha:** Diciembre 2025  
> **Framework:** Laravel 10+ con Livewire 3

---

## 📋 Índice

1. [Módulo de Seguridad y Usuarios](#1-módulo-de-seguridad-y-usuarios)
2. [Módulo de Inventario](#2-módulo-de-inventario)
3. [Módulo de Compras](#3-módulo-de-compras)
4. [Módulo de Ventas](#4-módulo-de-ventas)
5. [Módulo de E-commerce](#5-módulo-de-e-commerce)
6. [Módulo de Caja Registradora](#6-módulo-de-caja-registradora)
7. [Módulo de Reportes y Análisis](#7-módulo-de-reportes-y-análisis)
8. [Módulo de Entregas](#8-módulo-de-entregas)
9. [Módulo de Reclamos](#9-módulo-de-reclamos)
10. [Resumen de Actores](#resumen-de-actores)

---

## 1. Módulo de Seguridad y Usuarios

### CU-001: Gestión de Usuarios

| Campo                 | Descripción                                                                                                                                                                                                                                                                                  |
| --------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-001 - Gestión de Usuarios                                                                                                                                                                                                                                                                 |
| **Propósito**         | Permite al Administrador crear, modificar, visualizar y eliminar cuentas de usuario del sistema.                                                                                                                                                                                             |
| **Actores**           | Administrador, Sistema                                                                                                                                                                                                                                                                       |
| **Precondición**      | El Administrador debe haber iniciado sesión con rol de Administrador.                                                                                                                                                                                                                        |
| **Flujo Principal**   | 1. El Administrador accede al módulo "/users".<br>2. El sistema muestra la lista de usuarios registrados.<br>3. El Administrador puede realizar operaciones CRUD sobre usuarios.<br>4. El sistema valida los datos y ejecuta la operación.<br>5. El sistema registra la acción en auditoría. |
| **Postcondición**     | Usuario creado/modificado/eliminado correctamente. Registro en auditoría.                                                                                                                                                                                                                    |
| **Reglas de Negocio** | • El email debe ser único.<br>• Al menos un Administrador debe existir siempre.<br>• Se registran todas las acciones en audit_logs.                                                                                                                                                          |

**Ruta:** `/users`  
**Componente:** `App\Livewire\Admin\Security\UserManager`

---

### CU-002: Gestión de Roles

| Campo                 | Descripción                                                                                                                                                                                                               |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-002 - Gestión de Roles                                                                                                                                                                                                 |
| **Propósito**         | Permite al Administrador definir y gestionar roles del sistema (Administrador, Empleado, Cliente, Repartidor).                                                                                                            |
| **Actores**           | Administrador, Sistema                                                                                                                                                                                                    |
| **Precondición**      | El Administrador debe haber iniciado sesión.                                                                                                                                                                              |
| **Flujo Principal**   | 1. El Administrador accede a "/roles".<br>2. El sistema muestra roles existentes.<br>3. El Administrador puede crear/editar/eliminar roles.<br>4. El sistema asigna permisos a cada rol.<br>5. El sistema guarda cambios. |
| **Postcondición**     | Roles y permisos actualizados.                                                                                                                                                                                            |
| **Reglas de Negocio** | • El rol "Administrador" no puede eliminarse.<br>• Los roles se asocian a permisos específicos.                                                                                                                           |

**Ruta:** `/roles`  
**Componente:** `App\Livewire\Admin\Security\RoleManager`

---

### CU-003: Gestión de Permisos

| Campo               | Descripción                                                                                                                                                                               |
| ------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**     | CU-003 - Gestión de Permisos                                                                                                                                                              |
| **Propósito**       | Permite al Administrador definir permisos granulares para controlar acceso a funcionalidades.                                                                                             |
| **Actores**         | Administrador, Sistema                                                                                                                                                                    |
| **Precondición**    | El Administrador debe haber iniciado sesión.                                                                                                                                              |
| **Flujo Principal** | 1. El Administrador accede a "/permissions".<br>2. El sistema muestra permisos disponibles.<br>3. El Administrador puede crear/editar permisos.<br>4. El sistema asocia permisos a roles. |
| **Postcondición**   | Permisos creados/modificados.                                                                                                                                                             |

**Ruta:** `/permissions`  
**Componente:** `App\Livewire\Admin\Security\PermissionManager`

---

### CU-004: Auditoría del Sistema

| Campo                 | Descripción                                                                                                                                                                                                                                                                   |
| --------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-004 - Visualizar Registro de Auditoría                                                                                                                                                                                                                                     |
| **Propósito**         | Permite al Administrador revisar todas las acciones realizadas en el sistema para trazabilidad.                                                                                                                                                                               |
| **Actores**           | Administrador, Sistema                                                                                                                                                                                                                                                        |
| **Precondición**      | El Administrador debe estar autenticado.                                                                                                                                                                                                                                      |
| **Flujo Principal**   | 1. El Administrador accede a "/audit-logs".<br>2. El sistema muestra registro cronológico de acciones (tabla: audit_logs).<br>3. El Administrador puede filtrar por usuario, acción, fecha, tabla.<br>4. El sistema muestra detalles de cada acción (old_values, new_values). |
| **Postcondición**     | El Administrador visualiza trazabilidad completa.                                                                                                                                                                                                                             |
| **Reglas de Negocio** | • Se registran automáticamente: CREATE, UPDATE, DELETE.<br>• Se guardan valores antiguos y nuevos en formato JSON.                                                                                                                                                            |

**Ruta:** `/audit-logs`  
**Componente:** `App\Livewire\Reports\AuditLog`  
**Modelo:** `App\Models\ReportAndAnalysis\AuditLog`

---

## 2. Módulo de Inventario

### CU-005: Gestión de Productos

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                     |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-005 - Gestión de Productos                                                                                                                                                                                                                                                                                                   |
| **Propósito**         | Permite al Administrador/Empleado gestionar el catálogo de productos de la ferretería.                                                                                                                                                                                                                                          |
| **Actores**           | Administrador, Empleado, Sistema                                                                                                                                                                                                                                                                                                |
| **Precondición**      | Usuario autenticado con permisos de gestión de inventario.                                                                                                                                                                                                                                                                      |
| **Flujo Principal**   | 1. El usuario accede a "/product-inventory".<br>2. El sistema muestra lista de productos con stock, precio, categoría.<br>3. El usuario puede crear/editar/eliminar productos.<br>4. El usuario puede asignar especificaciones técnicas, categorías, marcas.<br>5. El sistema valida stock mínimo y genera alertas automáticas. |
| **Postcondición**     | Producto creado/modificado/eliminado. Alertas de stock generadas si aplica.                                                                                                                                                                                                                                                     |
| **Reglas de Negocio** | • Stock no puede ser negativo.<br>• Precio debe ser mayor a 0.<br>• Se registra entrada/salida de productos.                                                                                                                                                                                                                    |

**Ruta:** `/product-inventory`  
**Componente:** `App\Livewire\Inventory\ProductManager`  
**Modelo:** `App\Models\Inventory\Product`

---

### CU-006: Gestión de Categorías

| Campo               | Descripción                                                                                                                                                                                                           |
| ------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**     | CU-006 - Gestión de Categorías                                                                                                                                                                                        |
| **Propósito**       | Permite organizar productos en categorías para facilitar búsqueda y navegación.                                                                                                                                       |
| **Actores**         | Administrador, Sistema                                                                                                                                                                                                |
| **Precondición**    | Administrador autenticado.                                                                                                                                                                                            |
| **Flujo Principal** | 1. El Administrador accede a "/categories".<br>2. El sistema muestra árbol de categorías.<br>3. El Administrador puede crear/editar categorías con subcategorías.<br>4. El sistema actualiza los productos asociados. |
| **Postcondición**   | Categorías actualizadas. Productos reclasificados.                                                                                                                                                                    |

**Ruta:** `/categories`  
**Componente:** `App\Livewire\Inventory\CategoryManager`  
**Modelo:** `App\Models\Inventory\Category`

---

### CU-007: Alertas de Stock Crítico

| Campo                 | Descripción                                                                                                                                                                                                                                                                    |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| **Caso de uso**       | CU-007 - Gestión de Alertas de Stock                                                                                                                                                                                                                                           |
| **Propósito**         | Permite monitorear productos con stock bajo o agotado para reabastecimiento oportuno.                                                                                                                                                                                          |
| **Actores**           | Administrador, Empleado, Sistema                                                                                                                                                                                                                                               |
| **Precondición**      | Usuario autenticado.                                                                                                                                                                                                                                                           |
| **Flujo Principal**   | 1. El usuario accede a "/product-alerts".<br>2. El sistema muestra productos con stock ≤ umbral configurado.<br>3. El sistema categoriza alertas por severidad (rojo: sin stock, naranja: bajo).<br>4. El usuario puede marcar alerta como resuelta o generar orden de compra. |
| **Postcondición**     | Alertas visualizadas. Acciones de reabastecimiento iniciadas.                                                                                                                                                                                                                  |
| **Reglas de Negocio** | • Stock crítico = stock ≤ 10 unidades.<br>• Sin stock = stock = 0.<br>• Se generan alertas automáticas al actualizar inventario.                                                                                                                                               |

**Ruta:** `/product-alerts`  
**Componente:** `App\Livewire\Inventory\ProductAlertManager`  
**Modelo:** `App\Models\ReportAndAnalysis\ProductAlert`

---

### CU-008: Notas de Salida

| Campo                 | Descripción                                                                                                                                                                                                                            |
| --------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-008 - Gestión de Notas de Salida                                                                                                                                                                                                    |
| **Propósito**         | Permite registrar salidas de inventario por motivos distintos a ventas (donaciones, mermas, traslados).                                                                                                                                |
| **Actores**           | Administrador, Empleado, Sistema                                                                                                                                                                                                       |
| **Precondición**      | Usuario autenticado con permisos de inventario.                                                                                                                                                                                        |
| **Flujo Principal**   | 1. El usuario accede a "/exit-notes".<br>2. El usuario crea una nota de salida indicando motivo y productos.<br>3. El sistema reduce el stock de los productos indicados.<br>4. El sistema registra la salida con fecha y responsable. |
| **Postcondición**     | Nota de salida creada. Stock actualizado.                                                                                                                                                                                              |
| **Reglas de Negocio** | • El stock no puede quedar negativo.<br>• Se requiere justificación del motivo.                                                                                                                                                        |

**Ruta:** `/exit-notes`  
**Componente:** `App\Livewire\Inventory\ExitNoteManager`  
**Modelo:** `App\Models\Inventory\ExitNote`

---

## 3. Módulo de Compras

### CU-009: Gestión de Proveedores

| Campo                 | Descripción                                                                                                                                                                                                                            |
| --------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-009 - Gestión de Proveedores                                                                                                                                                                                                        |
| **Propósito**         | Permite administrar el directorio de proveedores de la ferretería.                                                                                                                                                                     |
| **Actores**           | Administrador, Empleado, Sistema                                                                                                                                                                                                       |
| **Precondición**      | Usuario autenticado con permisos de compras.                                                                                                                                                                                           |
| **Flujo Principal**   | 1. El usuario accede a "/suppliers".<br>2. El sistema muestra lista de proveedores activos.<br>3. El usuario puede crear/editar proveedores (nombre, contacto, NIT).<br>4. El sistema guarda información de contacto y datos fiscales. |
| **Postcondición**     | Proveedor creado/modificado.                                                                                                                                                                                                           |
| **Reglas de Negocio** | • El NIT debe ser único.<br>• Se requiere al menos un contacto válido.                                                                                                                                                                 |

**Ruta:** `/suppliers`  
**Componente:** `App\Livewire\Commerce\SupplierManager`  
**Modelo:** `App\Models\Purchase\Supplier`

---

### CU-010: Registro de Compras

| Campo                 | Descripción                                                                                                                                                                                                                                                                                    |
| --------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-010 - Registro de Compras a Proveedores                                                                                                                                                                                                                                                     |
| **Propósito**         | Permite registrar compras de mercancía a proveedores, actualizando inventario y costos.                                                                                                                                                                                                        |
| **Actores**           | Administrador, Empleado, Sistema                                                                                                                                                                                                                                                               |
| **Precondición**      | Usuario autenticado. Proveedores y productos registrados.                                                                                                                                                                                                                                      |
| **Flujo Principal**   | 1. El usuario accede a "/purchase".<br>2. El usuario selecciona proveedor y agrega productos con cantidad y precio de compra.<br>3. El usuario registra método de pago y monto.<br>4. El sistema incrementa stock de productos.<br>5. El sistema calcula costo total y actualiza contabilidad. |
| **Postcondición**     | Compra registrada. Stock incrementado. Pago registrado.                                                                                                                                                                                                                                        |
| **Reglas de Negocio** | • Se actualiza campo `input` de productos.<br>• Se registra en tabla `entries` y `entry_details`.                                                                                                                                                                                              |

**Ruta:** `/purchase`  
**Componente:** `App\Livewire\Commerce\PurchaseManager`  
**Modelo:** `App\Models\Purchase\Entry`

---

## 4. Módulo de Ventas

### CU-011: Registro de Ventas Presenciales

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          |
| --------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-011 - Registro de Ventas Presenciales                                                                                                                                                                                                                                                                                                                                                                                                                                                             |
| **Propósito**         | Permite a empleados registrar ventas en mostrador, generando factura y actualizando inventario.                                                                                                                                                                                                                                                                                                                                                                                                      |
| **Actores**           | Empleado, Administrador, Sistema                                                                                                                                                                                                                                                                                                                                                                                                                                                                     |
| **Precondición**      | Usuario autenticado. Caja registradora abierta. Productos con stock disponible.                                                                                                                                                                                                                                                                                                                                                                                                                      |
| **Flujo Principal**   | 1. El empleado accede a "/sales".<br>2. El empleado selecciona cliente (o registra venta sin usuario).<br>3. El empleado agrega productos al carrito especificando cantidad.<br>4. El sistema verifica stock disponible.<br>5. El empleado aplica descuentos si corresponde.<br>6. El empleado registra método de pago y monto recibido.<br>7. El sistema genera factura con número único (VEN-XXXXXX).<br>8. El sistema reduce stock de productos vendidos.<br>9. El sistema registra pago en caja. |
| **Postcondición**     | Venta registrada con estado "paid". Stock reducido. Factura generada. Pago en caja.                                                                                                                                                                                                                                                                                                                                                                                                                  |
| **Reglas de Negocio** | • Stock no puede ser negativo.<br>• Número de factura auto-incremental.<br>• Se actualiza campo `output` de productos.<br>• Se usa transacción DB para garantizar consistencia.                                                                                                                                                                                                                                                                                                                      |

**Ruta:** `/sales`  
**Componente:** `App\Livewire\Commerce\SaleManager`  
**Modelos:** `App\Models\Sale`, `App\Models\SaleDetail`, `App\Models\Payment`

---

### CU-012: Gestión de Descuentos

| Campo                 | Descripción                                                                                                                                                                                                                                                             |
| --------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-012 - Gestión de Cupones de Descuento                                                                                                                                                                                                                                |
| **Propósito**         | Permite crear y administrar cupones de descuento para promociones.                                                                                                                                                                                                      |
| **Actores**           | Administrador, Sistema                                                                                                                                                                                                                                                  |
| **Precondición**      | Administrador autenticado.                                                                                                                                                                                                                                              |
| **Flujo Principal**   | 1. El Administrador accede a "/discounts".<br>2. El Administrador crea cupón especificando código, tipo (porcentaje/monto), valor, fecha inicio/fin, monto mínimo.<br>3. El sistema valida unicidad del código.<br>4. El sistema activa/desactiva cupones según fechas. |
| **Postcondición**     | Cupón creado y disponible para aplicar en ventas.                                                                                                                                                                                                                       |
| **Reglas de Negocio** | • Código de cupón único.<br>• Descuento porcentual ≤ 100%.<br>• Se valida monto mínimo de compra.<br>• Cupones tienen vigencia (start_date, end_date).                                                                                                                  |

**Ruta:** `/discounts`  
**Componente:** `App\Livewire\Commerce\DiscountManager`  
**Modelo:** `App\Models\Discount`

---

## 5. Módulo de E-commerce

### CU-013: Catálogo de Productos Público

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                  |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| **Caso de uso**       | CU-013 - Visualizar Catálogo de Productos                                                                                                                                                                                                                                                                    |
| **Propósito**         | Permite a visitantes y clientes navegar el catálogo de productos disponibles en línea.                                                                                                                                                                                                                       |
| **Actores**           | Cliente, Visitante, Sistema                                                                                                                                                                                                                                                                                  |
| **Precondición**      | Ninguna (ruta pública).                                                                                                                                                                                                                                                                                      |
| **Flujo Principal**   | 1. El usuario accede a "/products" o "/catalog".<br>2. El sistema muestra productos activos con imagen, precio, stock.<br>3. El usuario puede filtrar por categoría, marca, rango de precio.<br>4. El usuario puede buscar por nombre.<br>5. El usuario puede ordenar por precio, popularidad, calificación. |
| **Postcondición**     | Productos visualizados.                                                                                                                                                                                                                                                                                      |
| **Reglas de Negocio** | • Solo se muestran productos activos (`is_active = true`).<br>• Se muestra disponibilidad de stock.                                                                                                                                                                                                          |

**Ruta:** `/products`, `/catalog`  
**Componente:** `App\Livewire\Ecommerce\ProductCatalog`  
**Controlador:** `App\Http\Controllers\Ecommerce\ProductController`

---

### CU-014: Detalle de Producto

| Campo               | Descripción                                                                                                                                                                                                                                                                                                            |
| ------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**     | CU-014 - Visualizar Detalle de Producto                                                                                                                                                                                                                                                                                |
| **Propósito**       | Permite ver información detallada de un producto (especificaciones, imágenes, reseñas).                                                                                                                                                                                                                                |
| **Actores**         | Cliente, Visitante, Sistema                                                                                                                                                                                                                                                                                            |
| **Precondición**    | Ninguna (ruta pública).                                                                                                                                                                                                                                                                                                |
| **Flujo Principal** | 1. El usuario selecciona un producto del catálogo.<br>2. El sistema muestra ficha completa (descripción, precio, stock, especificaciones técnicas).<br>3. El sistema muestra galería de imágenes.<br>4. El sistema muestra reseñas de clientes con calificaciones.<br>5. El usuario puede agregar producto al carrito. |
| **Postcondición**   | Información completa visualizada.                                                                                                                                                                                                                                                                                      |

**Ruta:** `/products/{id}`, `/catalog/product/{id}`  
**Componente:** `App\Livewire\Ecommerce\ProductDetail`

---

### CU-015: Carrito de Compras

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                                 |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-015 - Gestión del Carrito de Compras                                                                                                                                                                                                                                                                                                     |
| **Propósito**         | Permite a usuarios agregar productos a un carrito temporal para posterior compra.                                                                                                                                                                                                                                                           |
| **Actores**           | Cliente, Visitante, Sistema                                                                                                                                                                                                                                                                                                                 |
| **Precondición**      | Ninguna (funciona con sesión, no requiere login).                                                                                                                                                                                                                                                                                           |
| **Flujo Principal**   | 1. El usuario agrega productos al carrito desde el catálogo.<br>2. El sistema almacena productos en sesión/cookie.<br>3. El usuario puede actualizar cantidades o eliminar productos.<br>4. El sistema recalcula totales automáticamente.<br>5. El usuario puede aplicar cupones de descuento.<br>6. El usuario puede proceder al checkout. |
| **Postcondición**     | Carrito actualizado. Totales calculados.                                                                                                                                                                                                                                                                                                    |
| **Reglas de Negocio** | • Se valida stock disponible al agregar.<br>• Un cupón por compra.<br>• Carrito persiste en sesión.                                                                                                                                                                                                                                         |

**Ruta:** `/carrito/*`  
**Controlador:** `App\Http\Controllers\Ecommerce\CartController`

---

### CU-016: Checkout y Pago en Línea

| Campo                   | Descripción                                                                                                                                                                                                                                                                                                                                                                                                          |
| ----------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**         | CU-016 - Procesar Compra en Línea (PayPal)                                                                                                                                                                                                                                                                                                                                                                           |
| **Propósito**           | Permite a clientes completar compra con pago electrónico mediante PayPal.                                                                                                                                                                                                                                                                                                                                            |
| **Actores**             | Cliente, Sistema, PayPal                                                                                                                                                                                                                                                                                                                                                                                             |
| **Precondición**        | Cliente autenticado. Carrito con productos.                                                                                                                                                                                                                                                                                                                                                                          |
| **Flujo Principal**     | 1. El cliente accede a "/carrito/checkout".<br>2. El cliente confirma dirección de entrega.<br>3. El cliente selecciona método de pago (PayPal).<br>4. El sistema redirige a pasarela de PayPal.<br>5. El cliente completa pago en PayPal.<br>6. PayPal redirige a URL de captura del sistema.<br>7. El sistema valida pago, crea venta, reduce stock, registra pago.<br>8. El sistema envía confirmación por email. |
| **Postcondición**       | Venta creada con estado "paid". Stock reducido. Cliente redirigido a página de éxito.                                                                                                                                                                                                                                                                                                                                |
| **Flujos Alternativos** | • **Pago cancelado**: PayPal redirige a `/paypal/cancel`. Carrito se mantiene.<br>• **Pago fallido**: Sistema muestra error y solicita reintentar.                                                                                                                                                                                                                                                                   |
| **Reglas de Negocio**   | • Se valida stock antes de procesar pago.<br>• Se usa transacción DB.<br>• Se registra en tabla `sale_unpersons` si cliente no registrado.                                                                                                                                                                                                                                                                           |

**Ruta:** `/carrito/checkout`, `/paypal/*`  
**Controlador:** `App\Http\Controllers\Ecommerce\PayPalController`, `App\Http\Controllers\Ecommerce\CartController`

---

### CU-017: Sistema de Reseñas de Productos

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                                                              |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| **Caso de uso**       | CU-017 - Enviar y Visualizar Reseñas de Productos                                                                                                                                                                                                                                                                                                                        |
| **Propósito**         | Permite a clientes calificar y comentar productos comprados.                                                                                                                                                                                                                                                                                                             |
| **Actores**           | Cliente, Administrador, Sistema                                                                                                                                                                                                                                                                                                                                          |
| **Precondición**      | Cliente autenticado. Producto comprado anteriormente.                                                                                                                                                                                                                                                                                                                    |
| **Flujo Principal**   | 1. El cliente accede a página de producto comprado.<br>2. El cliente envía reseña con calificación (1-5 estrellas) y comentario.<br>3. El sistema guarda reseña con estado "pending".<br>4. El Administrador accede a "/admin/reviews" para moderar.<br>5. El Administrador aprueba o rechaza reseña.<br>6. El sistema publica reseñas aprobadas en página del producto. |
| **Postcondición**     | Reseña enviada/aprobada/rechazada.                                                                                                                                                                                                                                                                                                                                       |
| **Reglas de Negocio** | • Solo clientes que compraron el producto pueden reseñar.<br>• Una reseña por cliente por producto.<br>• Estados: pending, approved, rejected.                                                                                                                                                                                                                           |

**Ruta:** `/products/{product}/reviews`, `/admin/reviews`  
**Controlador:** `App\Http\Controllers\Ecommerce\ReviewController`  
**Componente:** `App\Livewire\Ecommerce\SubmitReview`, `App\Livewire\Ecommerce\ProductReviews`  
**Modelo:** `App\Models\Review`

---

## 6. Módulo de Caja Registradora

### CU-018: Apertura de Caja

| Campo                 | Descripción                                                                                                                                                                                                                                |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| **Caso de uso**       | CU-018 - Apertura de Caja Registradora                                                                                                                                                                                                     |
| **Propósito**         | Permite a cajeros abrir turno de caja registrando monto inicial.                                                                                                                                                                           |
| **Actores**           | Cajero, Administrador, Sistema                                                                                                                                                                                                             |
| **Precondición**      | Usuario autenticado. No debe tener caja abierta activa.                                                                                                                                                                                    |
| **Flujo Principal**   | 1. El cajero accede a "/cash-register/open".<br>2. El cajero ingresa monto de apertura (efectivo inicial).<br>3. El sistema crea registro en tabla `cash_registers` con estado "open".<br>4. El sistema habilita funcionalidades de venta. |
| **Postcondición**     | Caja abierta. Cajero puede registrar ventas y movimientos.                                                                                                                                                                                 |
| **Reglas de Negocio** | • Un usuario solo puede tener una caja abierta a la vez.<br>• Se registra fecha/hora de apertura.                                                                                                                                          |

**Ruta:** `/cash-register/open`  
**Componente:** `App\Livewire\Reports\CashRegister\Open`  
**Modelo:** `App\Models\CashRegister`

---

### CU-019: Dashboard de Caja

| Campo               | Descripción                                                                                                                                                                                                                                                                       |
| ------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**     | CU-019 - Visualizar Dashboard de Caja Activa                                                                                                                                                                                                                                      |
| **Propósito**       | Permite a cajeros ver estado actual de caja (ventas, movimientos, saldo).                                                                                                                                                                                                         |
| **Actores**         | Cajero, Sistema                                                                                                                                                                                                                                                                   |
| **Precondición**    | Caja abierta para el usuario.                                                                                                                                                                                                                                                     |
| **Flujo Principal** | 1. El cajero accede a "/cash-register/dashboard".<br>2. El sistema muestra resumen: monto inicial, total ventas, ingresos adicionales, egresos, saldo esperado.<br>3. El cajero puede registrar movimientos (ingresos/egresos).<br>4. El cajero puede proceder a arqueo o cierre. |
| **Postcondición**   | Información actualizada visualizada.                                                                                                                                                                                                                                              |

**Ruta:** `/cash-register/dashboard`  
**Componente:** `App\Livewire\Reports\CashRegister\Dashboard`

---

### CU-020: Arqueo de Caja

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                    |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| **Caso de uso**       | CU-020 - Realizar Arqueo de Caja                                                                                                                                                                                                                                                                                               |
| **Propósito**         | Permite al cajero contar físicamente el dinero en caja y comparar con sistema.                                                                                                                                                                                                                                                 |
| **Actores**           | Cajero, Sistema                                                                                                                                                                                                                                                                                                                |
| **Precondición**      | Caja abierta.                                                                                                                                                                                                                                                                                                                  |
| **Flujo Principal**   | 1. El cajero accede a "/cash-register/count".<br>2. El cajero ingresa conteo físico de billetes y monedas.<br>3. El sistema calcula total contado.<br>4. El sistema compara con saldo esperado del sistema.<br>5. El sistema muestra diferencia (faltante/sobrante).<br>6. El cajero registra observaciones si hay diferencia. |
| **Postcondición**     | Arqueo registrado en tabla `cash_counts`.                                                                                                                                                                                                                                                                                      |
| **Reglas de Negocio** | • Se registra diferencia (positiva/negativa).<br>• Se pueden realizar múltiples arqueos antes del cierre.                                                                                                                                                                                                                      |

**Ruta:** `/cash-register/count`  
**Componente:** `App\Livewire\Reports\CashRegister\Count`  
**Modelo:** `App\Models\CashCount`

---

### CU-021: Cierre de Caja

| Campo                 | Descripción                                                                                                                                                                                                                                                                    |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| **Caso de uso**       | CU-021 - Cierre de Caja Registradora                                                                                                                                                                                                                                           |
| **Propósito**         | Permite cerrar turno de caja finalizando operaciones del día.                                                                                                                                                                                                                  |
| **Actores**           | Cajero, Administrador, Sistema                                                                                                                                                                                                                                                 |
| **Precondición**      | Caja abierta. Arqueo realizado.                                                                                                                                                                                                                                                |
| **Flujo Principal**   | 1. El cajero accede a "/cash-register/close".<br>2. El sistema muestra resumen final (apertura, ventas, movimientos, arqueo).<br>3. El cajero confirma cierre.<br>4. El sistema actualiza estado de caja a "closed".<br>5. El sistema genera reporte de cierre (PDF opcional). |
| **Postcondición**     | Caja cerrada. No se permiten más operaciones en esa caja.                                                                                                                                                                                                                      |
| **Reglas de Negocio** | • Se requiere arqueo previo.<br>• Se registra fecha/hora de cierre.<br>• Se bloquea edición de datos de caja cerrada.                                                                                                                                                          |

**Ruta:** `/cash-register/close`  
**Componente:** `App\Livewire\Reports\CashRegister\Close`

---

### CU-022: Historial de Cajas

| Campo               | Descripción                                                                                                                                                                                                                         |
| ------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**     | CU-022 - Consultar Historial de Cajas                                                                                                                                                                                               |
| **Propósito**       | Permite al Administrador revisar todas las cajas abiertas/cerradas del sistema.                                                                                                                                                     |
| **Actores**         | Administrador, Sistema                                                                                                                                                                                                              |
| **Precondición**    | Administrador autenticado.                                                                                                                                                                                                          |
| **Flujo Principal** | 1. El Administrador accede a "/cash-register/history".<br>2. El sistema muestra historial completo de cajas.<br>3. El Administrador puede filtrar por cajero, fecha, estado.<br>4. El Administrador puede ver detalle de cada caja. |
| **Postcondición**   | Historial visualizado.                                                                                                                                                                                                              |

**Ruta:** `/cash-register/history`  
**Componente:** `App\Livewire\Reports\CashRegister\History`

---

## 7. Módulo de Reportes y Análisis

### CU-023: Dashboard Analítico

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      |
| --------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-023 - Visualizar Dashboard Analítico y Métricas del Negocio                                                                                                                                                                                                                                                                                                                                                                                                                                                                   |
| **Propósito**         | Permite al Administrador visualizar KPIs, tendencias de ventas, productos top, stock crítico.                                                                                                                                                                                                                                                                                                                                                                                                                                    |
| **Actores**           | Administrador, Sistema                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
| **Precondición**      | Administrador autenticado. Datos históricos en sistema.                                                                                                                                                                                                                                                                                                                                                                                                                                                                          |
| **Flujo Principal**   | 1. El Administrador accede a "/dashboard".<br>2. El sistema carga filtro de fecha (7 días, 30 días, 12 meses).<br>3. El sistema calcula 4 KPIs: Ingresos Totales, Ticket Promedio, Stock Crítico, Egresos.<br>4. El sistema renderiza gráfico de tendencia de ventas (área con ApexCharts).<br>5. El sistema muestra Top 5 Productos Más Vendidos.<br>6. El sistema muestra Top 5 Productos Mejor Calificados.<br>7. El Administrador puede cambiar filtro de período.<br>8. El sistema actualiza todos los datos reactivamente. |
| **Postcondición**     | Información consolidada visualizada.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             |
| **Reglas de Negocio** | • Solo ventas con status="paid".<br>• Stock crítico = stock ≤ 10.<br>• Top calificados requiere mínimo 3 reseñas aprobadas.<br>• Agrupación: 7/30 días=diaria, 12 meses=mensual.                                                                                                                                                                                                                                                                                                                                                 |

**Ruta:** `/dashboard`  
**Componente:** `App\Livewire\Reports\Analytics`

---

### CU-024: Reportes Dinámicos

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                                                                                                                                                                 |
| --------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-024 - Generar Reportes Dinámicos Personalizados                                                                                                                                                                                                                                                                                                                                                                                                                          |
| **Propósito**         | Permite a usuarios generar reportes ad-hoc seleccionando tabla, campos y filtros.                                                                                                                                                                                                                                                                                                                                                                                           |
| **Actores**           | Administrador, Sistema                                                                                                                                                                                                                                                                                                                                                                                                                                                      |
| **Precondición**      | Administrador autenticado.                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
| **Flujo Principal**   | 1. El Administrador accede a "/reports/dynamic".<br>2. El Administrador selecciona tabla de base de datos.<br>3. El sistema carga campos disponibles de la tabla.<br>4. El Administrador selecciona campos a incluir.<br>5. El Administrador define filtros (campo, operador, valor).<br>6. El sistema ejecuta consulta y muestra resultados.<br>7. El Administrador puede exportar a PDF, Excel o HTML.<br>8. El Administrador puede guardar configuración como plantilla. |
| **Postcondición**     | Reporte generado y/o exportado. Plantilla guardada (opcional).                                                                                                                                                                                                                                                                                                                                                                                                              |
| **Reglas de Negocio** | • Se validan tipos de dato en filtros (fecha, number, string).<br>• Máximo 50 resultados por página.<br>• Se pueden guardar plantillas para reutilizar.                                                                                                                                                                                                                                                                                                                     |

**Rutas:** `/reports/dynamic`, `/reports/dynamic/generate`  
**Controlador:** `App\Http\Controllers\Reports\ReportController`  
**Modelo:** `App\Models\ReportTemplate`

---

## 8. Módulo de Entregas

### CU-025: Gestión de Entregas (Repartidor)

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                                                                                        |
| --------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-025 - Gestión de Entregas para Repartidores                                                                                                                                                                                                                                                                                                                                                     |
| **Propósito**         | Permite a repartidores ver pedidos asignados y marcarlos como entregados.                                                                                                                                                                                                                                                                                                                          |
| **Actores**           | Repartidor, Sistema                                                                                                                                                                                                                                                                                                                                                                                |
| **Precondición**      | Usuario con rol "Repartidor" autenticado.                                                                                                                                                                                                                                                                                                                                                          |
| **Flujo Principal**   | 1. El repartidor accede a "/deliveries".<br>2. El sistema muestra ventas asignadas con estado "pending_delivery".<br>3. El repartidor selecciona un pedido para ver detalle.<br>4. El repartidor revisa dirección, productos, monto.<br>5. El repartidor marca pedido como "entregado".<br>6. El sistema actualiza estado de venta a "delivered".<br>7. El sistema registra fecha/hora de entrega. |
| **Postcondición**     | Pedido marcado como entregado.                                                                                                                                                                                                                                                                                                                                                                     |
| **Reglas de Negocio** | • Solo se muestran ventas asignadas al repartidor (campo `delivered_by`).<br>• No se puede revertir entrega una vez marcada.                                                                                                                                                                                                                                                                       |

**Ruta:** `/deliveries`  
**Controlador:** `App\Http\Controllers\Deliveries\DeliveryController`

---

### CU-026: Mis Pedidos (Cliente)

| Campo                 | Descripción                                                                                                                                                                                                                                                                              |
| --------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-026 - Seguimiento de Pedidos del Cliente                                                                                                                                                                                                                                              |
| **Propósito**         | Permite a clientes ver historial de sus compras y estado de envío.                                                                                                                                                                                                                       |
| **Actores**           | Cliente, Sistema                                                                                                                                                                                                                                                                         |
| **Precondición**      | Cliente autenticado.                                                                                                                                                                                                                                                                     |
| **Flujo Principal**   | 1. El cliente accede a "/my-orders".<br>2. El sistema muestra pedidos del cliente ordenados por fecha.<br>3. El cliente puede ver detalle de cada pedido (productos, monto, estado).<br>4. El cliente puede cancelar pedidos pendientes.<br>5. El cliente puede ver tracking de entrega. |
| **Postcondición**     | Información de pedidos visualizada.                                                                                                                                                                                                                                                      |
| **Reglas de Negocio** | • Solo se pueden cancelar pedidos en estado "pending_payment" o "paid" (no enviados).<br>• Se muestra estado: pending, paid, in_transit, delivered, cancelled.                                                                                                                           |

**Ruta:** `/my-orders`  
**Controlador:** `App\Http\Controllers\Customer\CustomerOrderController`

---

## 9. Módulo de Reclamos

### CU-027: Registro de Reclamos

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                                                                               |
| --------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-027 - Registrar Reclamo de Producto                                                                                                                                                                                                                                                                                                                                                    |
| **Propósito**         | Permite a clientes reportar problemas con productos comprados.                                                                                                                                                                                                                                                                                                                            |
| **Actores**           | Cliente, Administrador, Sistema                                                                                                                                                                                                                                                                                                                                                           |
| **Precondición**      | Cliente autenticado. Producto comprado previamente.                                                                                                                                                                                                                                                                                                                                       |
| **Flujo Principal**   | 1. El cliente accede a "/mis-reclamos".<br>2. El cliente selecciona producto de compra previa.<br>3. El cliente completa formulario de reclamo (motivo, descripción, evidencias).<br>4. El sistema crea reclamo con estado "pending".<br>5. El Administrador revisa reclamo y actualiza estado (in_progress, resolved, rejected).<br>6. El sistema notifica al cliente cambios de estado. |
| **Postcondición**     | Reclamo registrado y en proceso de atención.                                                                                                                                                                                                                                                                                                                                              |
| **Reglas de Negocio** | • Solo productos comprados pueden reclamarse.<br>• Se pueden adjuntar imágenes como evidencia.<br>• Estados: pending, in_progress, resolved, rejected.                                                                                                                                                                                                                                    |

**Ruta:** `/mis-reclamos`, `/reclamos/*`  
**Controlador:** `App\Http\Controllers\Admin\ClaimController`  
**Modelo:** `App\Models\Claim`

---

## Resumen de Actores

| Actor               | Descripción                                                               | Accesos Principales                                                                                            |
| ------------------- | ------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------- |
| **Administrador**   | Usuario con máximos privilegios. Gestiona todo el sistema.                | Usuarios, Roles, Permisos, Auditoría, Dashboard, Reportes, Historial de Cajas, Moderación de Reseñas, Reclamos |
| **Empleado/Cajero** | Personal de ferretería. Realiza ventas presenciales, gestiona inventario. | Ventas, Compras, Inventario, Caja Registradora, Proveedores                                                    |
| **Cliente**         | Usuario registrado que compra en línea.                                   | Catálogo, Carrito, Checkout, Mis Pedidos, Reseñas, Reclamos                                                    |
| **Visitante**       | Usuario no autenticado. Navega catálogo.                                  | Catálogo Público, Detalle de Productos, Carrito (sin checkout)                                                 |
| **Repartidor**      | Personal encargado de entregas.                                           | Gestión de Entregas, Marcar como Entregado                                                                     |
| **Sistema**         | Actor automático que ejecuta cálculos, validaciones, notificaciones.      | Alertas de Stock, Auditoría, Cálculos de KPIs                                                                  |

---

## Resumen Cuantitativo

| Módulo               | Casos de Uso | Modelos Principales                       | Rutas         |
| -------------------- | ------------ | ----------------------------------------- | ------------- |
| Seguridad y Usuarios | 4            | User, Role, Permission, AuditLog          | 4             |
| Inventario           | 4            | Product, Category, ProductAlert, ExitNote | 4             |
| Compras              | 2            | Supplier, Entry, EntryDetail              | 2             |
| Ventas               | 2            | Sale, SaleDetail, Payment, Discount       | 2             |
| E-commerce           | 5            | Product, Review, SaleUnperson             | 8+            |
| Caja Registradora    | 5            | CashRegister, CashMovement, CashCount     | 6             |
| Reportes             | 2            | AuditLog, ReportTemplate                  | 8+            |
| Entregas             | 2            | Sale (campo delivered_by)                 | 4             |
| Reclamos             | 1            | Claim                                     | 5             |
| **TOTAL**            | **27 CU**    | **15+ Modelos**                           | **40+ Rutas** |

---

## Tecnologías y Patrones Implementados

### Backend

-   **Framework:** Laravel 10+
-   **Patrón MVC:** Modelos, Controladores, Vistas
-   **Livewire 3:** Componentes reactivos full-stack
-   **Eloquent ORM:** Relaciones, Observers, Scopes
-   **Middleware:** Autenticación, Autorización por roles
-   **Transactions:** Garantía de integridad en operaciones críticas
-   **Observers:** Auditoría automática (GenericObserver)

### Frontend

-   **Blade Templates:** Motor de plantillas
-   **Tailwind CSS:** Framework de estilos utility-first
-   **Alpine.js:** Interactividad ligera
-   **ApexCharts:** Visualización de datos
-   **Livewire Wire:** Reactividad bidireccional

### Base de Datos

-   **PostgreSQL:** Motor de base de datos relacional
-   **Migraciones:** Control de versiones de esquema
-   **Seeders:** Datos de prueba

### Integraciones

-   **PayPal SDK:** Pagos electrónicos
-   **Maatwebsite/Excel:** Exportación a Excel
-   **DomPDF:** Generación de PDFs

---

## Reglas de Negocio Generales

| ID         | Regla                                                                               |
| ---------- | ----------------------------------------------------------------------------------- |
| **RN-001** | Stock no puede ser negativo en ninguna operación.                                   |
| **RN-002** | Solo se cuentan ventas con `status = 'paid'` para métricas financieras.             |
| **RN-003** | Todas las acciones CRUD se registran en `audit_logs` con valores antiguos y nuevos. |
| **RN-004** | Un usuario solo puede tener una caja abierta simultáneamente.                       |
| **RN-005** | Los productos con `stock ≤ 10` generan alertas automáticas.                         |
| **RN-006** | Las reseñas requieren aprobación del Administrador antes de publicarse.             |
| **RN-007** | Los cupones de descuento tienen validez por fechas (`start_date`, `end_date`).      |
| **RN-008** | Las transacciones de venta, compra y pago usan DB transactions para consistencia.   |
| **RN-009** | Los números de factura son auto-incrementales y únicos (VEN-XXXXXX).                |
| **RN-010** | Solo clientes que compraron un producto pueden reseñarlo.                           |

---

**Documento generado:** Diciembre 2025  
**Proyecto:** SI1 - Sistema de Ferretería  
**Framework:** Laravel 10+ con Livewire 3
