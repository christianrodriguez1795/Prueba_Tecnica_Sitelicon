# Prueba Técnica: Integración de una API de Pagos en Laravel

## Descripción del Proyecto

Este proyecto es un módulo de Laravel diseñado para simular una parte del sistema de checkout para un ecommerce. Permite a los usuarios autenticados realizar un pago simulado utilizando la API de Stripe.

## Requisitos Técnicos

-   PHP >= 8.2
-   Composer
-   Laravel >= 11.x

## Configuración del Entorno de Desarrollo

### Clonar el Repositorio

Clona este repositorio en tu máquina local:

    git clone https://github.com/christianrodriguez1795/Prueba_Tecnica_Sitelicon.git
    cd Prueba_Tecnica_Sitelicon

### Instalar las Dependencias

Ejecuta el siguiente comando dentro del directorio del proyecto para instalar todas las dependencias:

    composer install

### Configuración de la Base de Datos

Configura la conexión a la base de datos en el archivo `.env`. La base de datos debe crearse previamente, ya sea en PostgreSQL o MySQL. Puedes usar un gestor de bases de datos como pgAdmin4 o un contenedor Docker con una base de datos desplegada.

Una vez configurada la conexión a la base de datos, ejecuta las migraciones:

    php artisan migrate

### Iniciar el Servidor

Ejecuta el siguiente comando para iniciar el servidor de la API en `localhost:8000`:

    php artisan serve

## Pruebas de Funcionamiento

Para probar la funcionalidad de la API, puedes usar herramientas como Thunder Client en VSCode o Postman.

### Registrar un Usuario

Realiza una petición POST a la siguiente URL para registrar un usuario:

    POST http://localhost:8000/register

Con los siguientes parámetros:

    name=user
    email=user@gmail.com
    password=password
    password_confirmation=password

Esta solicitud te devolverá un token que deberás utilizar en las siguientes peticiones.

Ejemplo de peticion usando curl:

    curl  -X POST \
      'http://localhost:8000/register?name=user&email=user@gmail.com&password=password&password_confirmation=password' \
      --header 'Accept: application/json' \
      --header 'Accept-Encoding: application/json'

### Realizar un Pago

Una vez registrado el usuario, realiza una petición POST a la siguiente URL para simular un pago:

    POST http://localhost:8000/checkout

Incluye el token en el encabezado de la petición como Bearer Token y añade el parámetro `total_amount`:

    total_amount=200

Ejemplo de peticion usando curl:

    curl  -X POST \

'http://localhost:8000/checkout?total_amount=200' \
 --header 'Accept: application/json' \
 --header 'Accept-Encoding: application/json' \
 --header 'Authorization: Bearer token devuelto por la api'

Las respuestas posibles son:

-   Si `total_amount` es negativo, recibirás un mensaje indicando que debe ser al menos cero.
-   Si `total_amount` es cero, recibirás un mensaje de fallo.
-   Si `total_amount` es mayor a cero, recibirás un mensaje de éxito ("pagado").

Para comprobarlo se puede cambiar el valor de total_amount en cada peticion para obtener cada respuesta.
