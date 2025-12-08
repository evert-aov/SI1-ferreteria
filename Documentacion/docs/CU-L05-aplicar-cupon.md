# CU-L05 – Aplicar Cupón en Checkout

## Diagrama de Caso de Uso

```plantuml
@startuml cu-l05-aplicar-cupon
!theme plain

left to right direction

actor "Cliente" as Cliente
actor "Sistema PayPal" as Sistema

rectangle "Sistema de Lealtad" {
    usecase "CU-L02: Ganar Puntos\npor Compra" as CU2
    usecase "CU-L04: Canjear Recompensa\npor Cupón" as CU4
    usecase "CU-L05: Aplicar Cupón\nen Checkout" as CU5
}

Cliente --> CU5

CU5 ..> CU4 : <<extends>>
CU5 ..> CU2 : <<include>>
Sistema ..> CU2 : <<include>>

@enduml
```

## Especificación del Caso de Uso

| **Campo**         | **Descripción**                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      |
| ----------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Caso de uso**   | CU-L05 – Aplicar Cupón en Checkout                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   |
| **Propósito**     | • Permitir al cliente aplicar un cupón de descuento (generado por lealtad u otro) en el proceso de checkout, validando su vigencia y ajustando el descuento para cumplir con los requisitos de PayPal.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               |
| **Actores**       | • Cliente autenticado                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
| **Iniciador**     | • Cliente                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            |
| **Precondición**  | • El usuario debe estar autenticado<br>• El carrito debe tener productos<br>• El cupón debe existir y estar activo<br>• El cupón no debe haber alcanzado su límite de usos                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
| **Flujo**         | **Vista de Checkout**<br>1. El cliente ingresa el código del cupón en el campo correspondiente<br>2. El cliente hace clic en "Aplicar Cupón"<br>3. El sistema busca el cupón en la base de datos<br>4. El sistema valida que el cupón esté activo y no expirado<br>5. El sistema verifica que el cupón no haya alcanzado su límite de usos<br>6. El sistema calcula el total del carrito<br>7. El sistema calcula el descuento según el tipo de cupón<br>8. Si el total después del descuento es menor a $1:<br>&nbsp;&nbsp;&nbsp;• El sistema ajusta el descuento para dejar mínimo $1<br>9. El sistema guarda el descuento en la sesión<br>10. El sistema muestra el descuento aplicado al cliente |
| **Postcondición** | • El descuento se aplica al total del carrito<br>• El descuento se guarda en la sesión<br>• El total final es al menos $1 USD para PayPal                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            |
| **Excepción**     | • El cupón no existe<br>• El cupón está expirado o inactivo<br>• El cupón alcanzó su límite de usos<br>• El monto mínimo no se cumple<br>• Error al calcular el descuento                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            |
