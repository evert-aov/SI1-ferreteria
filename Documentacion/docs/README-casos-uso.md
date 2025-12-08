# Índice de Casos de Uso - Sistema de Ferretería

## Sistema de Compras Online

-   [CU16 - Compras Online](./CU16-compras-online.md)

## Sistema de Lealtad

### Casos de Uso para Clientes

-   [CU-L01 - Dashboard de Lealtad y Consulta de Historial](./CU-L01-dashboard-lealtad.md)
-   [CU-L02 - Ganar Puntos por Compra](#cu-l02) (Automático - Sistema)
-   [CU-L03 - Gestión de Recompensas (Catálogo y Canje)](./CU-L03-gestion-recompensas.md)
-   [CU-L05 - Aplicar Cupón en Checkout](./CU-L05-aplicar-cupon.md)

### Casos de Uso para Administradores

-   [CU-L08 - Configurar Sistema de Lealtad](#cu-l08)
-   [CU-L09 - Gestionar Recompensas CRUD](./CU-L09-crud-recompensas.md)
-   [CU-L10 - Ver Reportes de Lealtad](#cu-l10)

### Casos de Uso de Configuración

-   [CU-C01 - Gestión de Niveles de Lealtad (CRUD)](./CU-C01-gestion-niveles.md)
-   [CU-C05 - Configurar Parámetros del Sistema](./CU-C05-configurar-sistema.md)

## Sistema de Importación de Productos

-   [CU-P01 - Importar Productos desde Excel](./CU-P01-importar-productos.md)
-   [CU-P02 - Validar Formato de Archivo](#cu-p02) (Include de CU-P01)
-   [CU-P03 - Procesar Datos del Archivo](#cu-p03) (Include de CU-P01)
-   [CU-P04 - Crear/Actualizar Productos](#cu-p04) (Include de CU-P03)
-   [CU-P05 - Ver Resultado de Importación](#cu-p05) (Include de CU-P01)

## Diagramas de Secuencia

### Sistema de Lealtad

-   [Secuencia: Dashboard de Lealtad](./secuencia-dashboard-lealtad.puml)
-   [Secuencia: Gestión de Recompensas](./secuencia-gestion-recompensas.puml)
-   [Secuencia: Aplicar Cupón](./secuencia-aplicar-cupon.puml)
-   [Secuencia: Ganar Puntos](./secuencia-ganar-puntos.puml)
-   [Secuencia: CRUD Recompensas](./secuencia-crud-recompensas.puml)

### Sistema de Configuración

-   [Secuencia: Gestión de Niveles (CRUD)](./secuencia-gestion-niveles.puml)
-   [Secuencia: Configurar Sistema](./secuencia-configurar-sistema.puml)

### Sistema de Importación

-   [Secuencia: Importar Productos](./secuencia-importar-productos.puml)

## Diagramas de Casos de Uso

-   [Diagrama: Sistema de Lealtad](./caso-uso-lealtad.puml)
-   [Diagrama: Sistema de Configuración](./caso-uso-configuracion.puml)
-   [Diagrama: Importación de Productos](./caso-uso-importacion.puml)

---

## Resumen de Casos de Uso

**Total de Casos de Uso: 17**

-   **Sistema de Compras**: 1 CU
-   **Sistema de Lealtad**: 10 CU (7 para clientes, 3 para administradores)
-   **Sistema de Configuración**: 2 CU (gestión de niveles CRUD y parámetros)
-   **Importación de Productos**: 5 CU (1 principal, 4 includes)
