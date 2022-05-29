## Introducción

El objetivo de esta prueba consiste en diseñar e implementar un carrito de la compra que podría encajar en el contexto de la web de Drinks&Co.

Este carrito de la compra nos tiene que permitir añadir y eliminar productos, y calcular el total del importe del carrito.

**La entrega del ejercicio se hará mediante un repositorio privado de Bitbucket o GitHub** donde estará todo el código a ser evaluado. Este repositorio debe tener
permisos de lectura para los siguientes usuarios:

- En caso de escoger Bitbucket: javieroman_uvinum
- En caso de escoger Github: p0lemic

## Algoritmos

Se adjuntan una serie de ficheros donde hay que completar una línea o dos de código utilizando funciones nativas de php.

## Programación orientada de objetos

**La forma de validar el funcionamiento de las piezas se deberá hacer mediante tests**, por lo que no es necesario desarrollar el frontend.

## Carrito de la compra

Pasamos a detallar las funcionalidades a diseñar e implementar del carrito de la compra.

### Añadir producto

Se le deberá indicar el producto y el número de unidades a añadir.

**Restricciones**

- Se pueden añadir un máximo de 10 productos diferentes
- Se pueden añadir un máximo de 50 unidades por producto

### Eliminar producto

Esta acción deberá contemplar la posibilidad de que el producto que se solicita eliminar del carrito no exista en él.

### Calcular importe total del carrito

El importe total del carrito será la suma de los importes totales de los productos. En la sección relativa a Productos se detalla cómo calcular el importe total de
cada uno de ellos.

Como resultado de esta acción se deberá mostrar el importe total con y sin ofertas.

### Productos

- Importe unitario estándar
- Importe en oferta
- Número de unidades mínimas a partir de las cuales se aplica el importe en oferta y no el importe unitario estándar

### Ejemplo lógica importe en oferta 

Tenemos el siguiente producto:

- Importe unitario estándar: 10€ 
- Importe en oferta: 9€ 
- Número de unidades mínimas para oferta: 3 

Cálculo importe total:

- Si el usuario solicita 1 unidad de este producto, el importe total será 10€ (a 10€ la unidad)
- Si el usuario solicita 2 unidades de este producto, el importe total será 20€ (a 10€ la unidad)
- Si el usuario solicita 3 unidades de este producto, el importe total será 27€ (a 9€ la unidad)
- Si el usuario solicita 4 unidades de este producto, el importe total será 36€ (a 9€ la unidad)
