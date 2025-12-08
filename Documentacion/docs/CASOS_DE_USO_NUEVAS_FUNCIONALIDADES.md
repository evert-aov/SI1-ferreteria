# Casos de Uso - Nuevas Funcionalidades Propuestas

> **Proyecto:** SI1 - Sistema de Ferretería  
> **Documento:** Propuestas de Nuevas Funcionalidades  
> **Fecha:** Diciembre 2025

---

## 📋 Índice de Funcionalidades Propuestas

1. [Sistema de Fidelización (Puntos)](#cu-n01-sistema-de-fidelización)
2. [Cotizaciones y Presupuestos](#cu-n02-cotizaciones-y-presupuestos)
3. [Sistema de Reservas](#cu-n03-sistema-de-reservas)
4. [Gestión de Garantías](#cu-n04-gestión-de-garantías)
5. [Devoluciones y Reembolsos](#cu-n05-devoluciones-y-reembolsos)
6. [Dashboard de Vendedores](#cu-n06-dashboard-de-vendedores)
7. [Lista de Deseos](#cu-n07-lista-de-deseos)
8. [Sistema de Códigos QR](#cu-n08-sistema-de-códigos-qr)

---

## CU-N01: Sistema de Fidelización

### Acumular Puntos por Compra

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      |
| --------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-N01 - Programa de Fidelización de Clientes                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    |
| **Propósito**         | Recompensar clientes frecuentes con puntos canjeables por descuentos o productos.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
| **Actores**           | Cliente, Empleado, Administrador, Sistema                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        |
| **Precondición**      | Cliente registrado. Sistema de puntos configurado.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               |
| **Flujo Principal**   | 1. El sistema acumula puntos automáticamente por cada compra (1 punto = Bs. 10 gastados).<br>2. El sistema asigna nivel de membresía según puntos totales (Bronce: 0-99, Plata: 100-499, Oro: 500+).<br>3. El cliente puede consultar saldo de puntos en su perfil.<br>4. El cliente puede canjear puntos por descuentos o productos.<br>5. El sistema valida disponibilidad de puntos.<br>6. El sistema deduce puntos y aplica beneficio.<br>7. Los puntos tienen vencimiento (12 meses desde acumulación).<br>8. El sistema notifica puntos próximos a vencer. |
| **Postcondición**     | Puntos acumulados/canjeados. Nivel actualizado.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
| **Reglas de Negocio** | • 1 punto = Bs. 10 de compra.<br>• Puntos válidos por 12 meses.<br>• Niveles: Bronce (0-99), Plata (100-499), Oro (500+).<br>• Solo compras con status="paid" acumulan puntos.<br>• Mínimo 50 puntos para canjear.                                                                                                                                                                                                                                                                                                                                               |

**Modelos Nuevos:**

-   `LoyaltyAccount` (customer_id, total_points, available_points, level)
-   `LoyaltyTransaction` (account_id, type, points, description, expires_at)
-   `LoyaltyReward` (name, points_cost, discount_percentage, product_id)

**Rutas Propuestas:**

-   `GET /loyalty/dashboard` - Dashboard del cliente
-   `POST /loyalty/redeem` - Canjear puntos
-   `GET /admin/loyalty/config` - Configuración (Admin)

---

## CU-N02: Cotizaciones y Presupuestos

### Solicitar y Gestionar Cotizaciones

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      |
| --------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-N02 - Gestión de Cotizaciones                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 |
| **Propósito**         | Permitir a clientes solicitar cotizaciones sin compromiso de compra inmediata.                                                                                                                                                                                                                                                                                                                                                                                                                                                   |
| **Actores**           | Cliente, Empleado, Administrador, Sistema                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        |
| **Precondición**      | Usuario autenticado (clientes B2B).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              |
| **Flujo Principal**   | 1. El cliente selecciona productos y solicita cotización.<br>2. El cliente especifica cantidades y observaciones.<br>3. El sistema genera cotización con número único (COT-XXXXXX).<br>4. El empleado revisa y establece precios especiales (descuentos por volumen).<br>5. El sistema envía cotización por email al cliente.<br>6. El cliente puede aprobar cotización.<br>7. El sistema convierte cotización en venta.<br>8. Cotizaciones vencen después de 15 días.<br>9. El sistema notifica cotizaciones próximas a vencer. |
| **Postcondición**     | Cotización generada/aprobada/convertida a venta.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 |
| **Reglas de Negocio** | • Vigencia: 15 días desde creación.<br>• Estados: draft, sent, approved, rejected, expired, converted.<br>• Solo empleados/admin pueden establecer precios.<br>• Se bloquea stock al aprobar cotización (48 horas).                                                                                                                                                                                                                                                                                                              |

**Modelos Nuevos:**

-   `Quote` (number, customer_id, status, subtotal, discount, total, valid_until, approved_at)
-   `QuoteDetail` (quote_id, product_id, quantity, unit_price, discount, subtotal)

**Rutas Propuestas:**

-   `GET /quotes` - Listar cotizaciones
-   `POST /quotes/request` - Solicitar cotización
-   `POST /quotes/{id}/approve` - Aprobar cotización
-   `POST /quotes/{id}/convert` - Convertir a venta

---

## CU-N03: Sistema de Reservas

### Reservar Productos Temporalmente

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                                                                                                         |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-N03 - Reservas de Productos                                                                                                                                                                                                                                                                                                                                                                                      |
| **Propósito**         | Permitir a clientes reservar productos con stock limitado por tiempo definido.                                                                                                                                                                                                                                                                                                                                      |
| **Actores**           | Cliente, Sistema                                                                                                                                                                                                                                                                                                                                                                                                    |
| **Precondición**      | Cliente autenticado. Producto con stock disponible.                                                                                                                                                                                                                                                                                                                                                                 |
| **Flujo Principal**   | 1. El cliente reserva producto desde catálogo.<br>2. El sistema valida stock disponible.<br>3. El sistema bloquea temporalmente el stock (no vendible).<br>4. El cliente tiene 24 horas para completar compra.<br>5. El sistema envía recordatorios (a las 12h y 1h antes de vencer).<br>6. Si el cliente completa compra, reserva se convierte en venta.<br>7. Si expira, el sistema libera stock automáticamente. |
| **Postcondición**     | Stock reservado/liberado. Venta completada (si aplica).                                                                                                                                                                                                                                                                                                                                                             |
| **Reglas de Negocio** | • Tiempo de reserva: 24 horas.<br>• Stock reservado no está disponible para otros clientes.<br>• Máximo 5 reservas activas por cliente.<br>• Estados: active, completed, expired, cancelled.                                                                                                                                                                                                                        |

**Modelos Nuevos:**

-   `Reservation` (customer_id, product_id, quantity, reserved_until, status)

**Rutas Propuestas:**

-   `POST /products/{id}/reserve` - Reservar producto
-   `GET /my-reservations` - Mis reservas
-   `DELETE /reservations/{id}` - Cancelar reserva

---

## CU-N04: Gestión de Garantías

### Registro y Seguimiento de Garantías

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                                                                                                              |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| **Caso de uso**       | CU-N04 - Gestión de Garantías de Productos                                                                                                                                                                                                                                                                                                                                                                               |
| **Propósito**         | Gestionar garantías de productos vendidos para mejorar servicio postventa.                                                                                                                                                                                                                                                                                                                                               |
| **Actores**           | Cliente, Empleado, Administrador, Sistema                                                                                                                                                                                                                                                                                                                                                                                |
| **Precondición**      | Venta registrada. Producto con garantía configurada.                                                                                                                                                                                                                                                                                                                                                                     |
| **Flujo Principal**   | 1. Al completar venta, el sistema registra garantía automáticamente.<br>2. El sistema calcula fecha de vencimiento según tipo de producto.<br>3. El cliente puede consultar garantías activas en su perfil.<br>4. El cliente puede solicitar servicio de garantía.<br>5. El empleado valida vigencia y condiciones.<br>6. El sistema registra servicio prestado.<br>7. El sistema notifica 30 días antes de vencimiento. |
| **Postcondición**     | Garantía registrada/activada. Servicio documentado.                                                                                                                                                                                                                                                                                                                                                                      |
| **Reglas de Negocio** | • Duración según categoría (ej: herramientas eléctricas: 12 meses).<br>• Estados: active, claimed, expired, voided.<br>• Se requiere factura original.<br>• Productos en mal uso no aplican garantía.                                                                                                                                                                                                                    |

**Modelos Nuevos:**

-   `Warranty` (sale_detail_id, starts_at, expires_at, duration_months, status)
-   `WarrantyClaim` (warranty_id, claim_date, issue_description, resolution, resolved_at)

**Rutas Propuestas:**

-   `GET /my-warranties` - Mis garantías
-   `POST /warranties/{id}/claim` - Reclamar garantía
-   `GET /admin/warranties` - Gestión (Admin)

---

## CU-N05: Devoluciones y Reembolsos

### Proceso de Devolución de Productos

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| **Caso de uso**       | CU-N05 - Gestión de Devoluciones y Reembolsos                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
| **Propósito**         | Formalizar proceso de devolución de productos defectuosos o compras equivocadas.                                                                                                                                                                                                                                                                                                                                                                                                                                                                             |
| **Actores**           | Cliente, Empleado, Administrador, Sistema                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    |
| **Precondición**      | Venta existente. Dentro del período de devolución (7 días).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
| **Flujo Principal**   | 1. El cliente solicita devolución desde "Mis Pedidos".<br>2. El cliente especifica motivo y adjunta evidencias (fotos).<br>3. El sistema valida elegibilidad (tiempo, condiciones).<br>4. El empleado revisa solicitud.<br>5. El empleado aprueba/rechaza devolución.<br>6. Si se aprueba, cliente devuelve producto.<br>7. El empleado verifica estado del producto.<br>8. El sistema reingresa producto al inventario (si aplica).<br>9. El sistema procesa reembolso (efectivo, crédito en cuenta, cupón).<br>10. El sistema registra movimiento en caja. |
| **Postcondición**     | Producto devuelto. Stock actualizado. Reembolso procesado.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   |
| **Reglas de Negocio** | • Período de devolución: 7 días desde compra.<br>• Producto debe estar sin uso y con empaque original.<br>• Productos en oferta no aceptan devolución.<br>• Métodos de reembolso: efectivo, crédito, cupón.<br>• Se deduce costo de envío original.                                                                                                                                                                                                                                                                                                          |

**Modelos Nuevos:**

-   `Return` (sale_id, reason, status, refund_method, refund_amount, approved_by, approved_at)
-   `ReturnDetail` (return_id, sale_detail_id, quantity, condition, restock)

**Rutas Propuestas:**

-   `POST /sales/{id}/request-return` - Solicitar devolución
-   `GET /returns` - Mis devoluciones
-   `POST /admin/returns/{id}/approve` - Aprobar (Admin)
-   `POST /admin/returns/{id}/process-refund` - Procesar reembolso

---

## CU-N06: Dashboard de Vendedores

### Métricas Individuales por Vendedor

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                                                                                                                                                        |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| **Caso de uso**       | CU-N06 - Dashboard de Desempeño de Vendedores                                                                                                                                                                                                                                                                                                                                                                                                                      |
| **Propósito**         | Permitir a vendedores y administradores monitorear desempeño individual.                                                                                                                                                                                                                                                                                                                                                                                           |
| **Actores**           | Empleado (Vendedor), Administrador, Sistema                                                                                                                                                                                                                                                                                                                                                                                                                        |
| **Precondición**      | Vendedor autenticado. Ventas registradas con vendedor asignado.                                                                                                                                                                                                                                                                                                                                                                                                    |
| **Flujo Principal**   | 1. El vendedor accede a su dashboard personal.<br>2. El sistema muestra KPIs: ventas del día/mes, ticket promedio, comisiones.<br>3. El sistema muestra gráfico de tendencia de ventas.<br>4. El sistema muestra ranking entre vendedores.<br>5. El sistema muestra progreso hacia metas mensuales.<br>6. El Administrador puede ver dashboard consolidado de todos los vendedores.<br>7. El sistema calcula comisiones automáticamente según reglas configuradas. |
| **Postcondición**     | Métricas visualizadas. Comisiones calculadas.                                                                                                                                                                                                                                                                                                                                                                                                                      |
| **Reglas de Negocio** | • Comisiones: 2% sobre ventas >Bs. 1000.<br>• Meta mensual configurable por vendedor.<br>• Ranking actualizado diariamente.<br>• Solo ventas con status="paid" cuentan.                                                                                                                                                                                                                                                                                            |

**Modelos Nuevos:**

-   `SalesPerson` (user_id, monthly_goal, commission_rate)
-   `Commission` (salesperson_id, sale_id, amount, paid_at, status)

**Rutas Propuestas:**

-   `GET /salesperson/dashboard` - Dashboard personal
-   `GET /admin/salespeople/ranking` - Ranking (Admin)
-   `POST /admin/salespeople/{id}/set-goal` - Establecer meta

---

## CU-N07: Lista de Deseos

### Guardar Productos Favoritos

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                                                                                                                                 |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-N07 - Lista de Deseos de Clientes                                                                                                                                                                                                                                                                                                                                                                                                        |
| **Propósito**         | Permitir a clientes guardar productos de interés para compra futura.                                                                                                                                                                                                                                                                                                                                                                        |
| **Actores**           | Cliente, Sistema                                                                                                                                                                                                                                                                                                                                                                                                                            |
| **Precondición**      | Cliente autenticado.                                                                                                                                                                                                                                                                                                                                                                                                                        |
| **Flujo Principal**   | 1. El cliente agrega producto a lista de deseos desde catálogo.<br>2. El sistema guarda producto en lista personal.<br>3. El cliente puede ver todos sus productos guardados.<br>4. El sistema notifica cuando producto baje de precio (>10%).<br>5. El sistema notifica cuando stock sea limitado.<br>6. El cliente puede mover productos de lista a carrito.<br>7. El cliente puede compartir lista con otros usuarios (familia, amigos). |
| **Postcondición**     | Producto agregado/removido de lista. Notificaciones enviadas.                                                                                                                                                                                                                                                                                                                                                                               |
| **Reglas de Negocio** | • Sin límite de productos en lista.<br>• Se notifica reducción de precio >10%.<br>• Se notifica si stock <5 unidades.<br>• Listas pueden ser públicas o privadas.                                                                                                                                                                                                                                                                           |

**Modelos Nuevos:**

-   `Wishlist` (customer_id, name, is_public, shared_token)
-   `WishlistItem` (wishlist_id, product_id, added_price, current_price, notify_price_drop)

**Rutas Propuestas:**

-   `POST /wishlist/add/{product_id}` - Agregar producto
-   `GET /wishlist` - Mi lista
-   `POST /wishlist/move-to-cart` - Mover a carrito
-   `GET /wishlist/shared/{token}` - Ver lista compartida

---

## CU-N08: Sistema de Códigos QR

### Generación y Escaneo de QR

| Campo                 | Descripción                                                                                                                                                                                                                                                                                                                                                                                                       |
| --------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**       | CU-N08 - Sistema de Códigos QR para Productos                                                                                                                                                                                                                                                                                                                                                                     |
| **Propósito**         | Facilitar búsqueda de productos y validación mediante códigos QR.                                                                                                                                                                                                                                                                                                                                                 |
| **Actores**           | Cliente, Empleado, Sistema                                                                                                                                                                                                                                                                                                                                                                                        |
| **Precondición**      | Producto registrado en sistema.                                                                                                                                                                                                                                                                                                                                                                                   |
| **Flujo Principal**   | 1. El sistema genera QR único para cada producto.<br>2. El empleado imprime etiquetas con QR para estanterías.<br>3. El cliente escanea QR con su smartphone.<br>4. El sistema redirige a página de detalle del producto.<br>5. El cliente puede ver precio, stock, especificaciones.<br>6. El cliente puede agregar al carrito desde QR.<br>7. El empleado puede escanear QR para búsqueda rápida en inventario. |
| **Postcondición**     | QR generado/escaneado. Información visualizada.                                                                                                                                                                                                                                                                                                                                                                   |
| **Reglas de Negocio** | • QR único por producto (basado en SKU/ID).<br>• QR público (no requiere autenticación para ver producto).<br>• Se registra estadística de escaneos.                                                                                                                                                                                                                                                              |

**Modelos Nuevos:**

-   `QRCode` (product_id, qr_code, scan_count)
-   `QRScan` (qr_code_id, scanned_at, user_id, ip_address)

**Rutas Propuestas:**

-   `GET /qr/{code}` - Redirigir a producto
-   `GET /admin/products/{id}/generate-qr` - Generar QR (Admin)
-   `GET /admin/qr-analytics` - Estadísticas de escaneos

---

## Priorización de Funcionalidades

### Top 5 Recomendadas (Orden de Implementación)

| #   | Funcionalidad                   | Complejidad | Impacto | Prioridad     |
| --- | ------------------------------- | ----------- | ------- | ------------- |
| 1   | **Sistema de Fidelización**     | Media       | Alto    | 🔥 Alta       |
| 2   | **Devoluciones y Reembolsos**   | Media       | Alto    | 🔥 Alta       |
| 3   | **Cotizaciones y Presupuestos** | Media       | Alto    | ⚡ Media-Alta |
| 4   | **Dashboard de Vendedores**     | Baja        | Medio   | ⚡ Media      |
| 5   | **Lista de Deseos**             | Baja        | Medio   | ✅ Media      |
| 6   | **Gestión de Garantías**        | Media       | Medio   | ✅ Media      |
| 7   | **Sistema de Reservas**         | Media       | Bajo    | 💡 Baja       |
| 8   | **Sistema de Códigos QR**       | Baja        | Bajo    | 💡 Baja       |

---

## Estimación de Desarrollo

| Funcionalidad           | Modelos | Migraciones | Componentes | Rutas | Tiempo Estimado |
| ----------------------- | ------- | ----------- | ----------- | ----- | --------------- |
| Sistema de Fidelización | 3       | 3           | 5           | 6     | 16-20 horas     |
| Cotizaciones            | 2       | 2           | 4           | 5     | 12-16 horas     |
| Reservas                | 1       | 1           | 3           | 4     | 8-10 horas      |
| Garantías               | 2       | 2           | 4           | 4     | 10-12 horas     |
| Devoluciones            | 2       | 2           | 5           | 5     | 14-18 horas     |
| Dashboard Vendedores    | 2       | 2           | 3           | 4     | 10-12 horas     |
| Lista de Deseos         | 2       | 2           | 3           | 5     | 8-10 horas      |
| Códigos QR              | 2       | 2           | 2           | 4     | 6-8 horas       |

---

## Tecnologías Adicionales Requeridas

### Nuevas Dependencias

```bash
# Para generación de QR
composer require simplesoftwareio/simple-qrcode

# Para notificaciones avanzadas
composer require laravel/notifications

# Para emails mejorados
composer require mailable/laravel-mailable
```

### Integraciones Opcionales

-   **SMS:** Twilio para notificaciones de garantías/puntos
-   **WhatsApp:** WhatsApp Business API para actualizaciones de cotizaciones
-   **Push Notifications:** Firebase Cloud Messaging

---

**Documento generado:** Diciembre 2025  
**Nota:** Estos CU están propuestos para futuras implementaciones y no están actualmente en el sistema.
