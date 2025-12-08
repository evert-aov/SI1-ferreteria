# CU16 – Compras Online

## Diagrama de Caso de Uso

```plantuml
@startuml cu16-compras-online
!theme plain

left to right direction

actor "Usuario" as User

rectangle "Sistema de Compras Online" {
    usecase "CU16: Método de pago" as CU16
    usecase "CU15" as CU15
    usecase "CU18" as CU18
}

User --> CU16

CU16 ..> CU15 : <<include>>
CU16 <.. CU18 : <<extends>>

@enduml
```

## Especificación del Caso de Uso

| **Campo**         | **Descripción**                                                                                                                                                                                                            |
| ----------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**   | CU16 – Compras Online                                                                                                                                                                                                      |
| **Propósito**     | • Permitir a cualquier usuario (autenticado) poder realizar su pago con diferentes métodos (QR, PayPal, Efectivo) y garantizar el control de las transacciones, mejorando la eficiencia en los pagos, para los usuarios.   |
| **Actores**       | • Usuario en general                                                                                                                                                                                                       |
| **Iniciador**     | • Usuario                                                                                                                                                                                                                  |
| **Precondición**  | • Requiere autenticación<br>• Los productos deben estar cargados y al igual que debe estar la información del usuario.                                                                                                     |
| **Flujo**         | **Vista de Pago**<br>• El usuario debe haber cargado sus productos al carrito.<br>• El usuario debe rellenar los datos de envío de su producto.<br>• El sistema validará su método de pago y si tiene el saldo suficiente. |
| **Postcondición** | • El método de pago quedará registrado en la bitácora.                                                                                                                                                                     |
| **Excepción**     | • No tenga productos en su carrito de compras.<br>• No haya brindado todos sus datos.<br>• No cuente con el monto de pago.                                                                                                 |
