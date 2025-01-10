## 2ª EVALUACIÓN: TAREA 1 - MANEJO DE ERRORES Y EXCEPCIONES EN PHP

09/01/2025

## Objetivos

● Investigar y preparar una exposición sobre el manejo de errores y excepciones en PHP.

● Desarrollar un ejemplo práctico que muestre cómo combinar ambos enfoques para manejar problemas que surjan en la ejecución del código.

### Parte 1: Explicación Teórica

Preparar una exposición en la que se explique::

1. ¿Qué son los errores en PHP?

○ Tipos de errores comunes (E_NOTICE, E_WARNING, E_ERROR, etc.).

○ Diferencias entre errores y excepciones.

2. ¿Cómo manejar errores?

○ Uso de funciones como set_error_handler y trigger_error.

○ Ejemplo breve de cómo capturar y personalizar errores.

3. ¿Qué son las excepciones en PHP?

○ Conceptos clave como try, catch y finally.

○ Cómo y por qué crear excepciones personalizadas.

○ Ventajas del uso de excepciones frente a los errores tradicionales.

Explicación clara, utilizando ejemplos básicos para ilustrar los conceptos.

## Parte 2: Ejemplo práctico

### Parte 3: Presentación y casos de prueba

## Criterios de Evaluación

● Trabajo individual: informe del responsable del grupo sobre el trabajo de los compañeros.

● Claridad de la explicación teórica.

● Calidad del ejemplo práctico.

● Capacidad de explicar el código.

● Interacción con los compañeros.

Fecha de entrega (aprox): 17/01/2025

## Ejemplo práctico. PROPUESTA 1: Carga de un archivo .txt

## Escribir un programa en PHP que haga lo siguiente:

1. Intente cargar un archivo de configuración llamado validacion.txt.

2. Maneje los siguientes casos:

○ Si el archivo no existe, genera un error utilizando trigger_error.

○ Si el archivo existe pero está vacío, lanza una excepción personalizada.

○ Si el archivo tiene contenido, muestra su contenido correctamente. Por ejemplo:

    usuario=usuario

    contraseña=12345

3. El código debe incluir:

○ Un manejador de errores personalizado mediante set_error_handler.

○ Una clase de excepción personalizada para manejar el caso del archivo vacío.

○ Un bloque try-catch-fnally para gestionar las excepciones.

○ Mensajes claros para cada caso, que informen al usuario sobre lo que ocurre.

## Ejemplo práctico. PROPUESTA 2: Calculadora Básica con Validación

## Escribir un programa en PHP que haga lo siguiente:

1. Solicita al usuario que ingrese dos números y el tipo de operación que desea realizar: suma, resta, multiplicación o división.

2. Valida la entrada del usuario:

○ Si el usuario ingresa un valor no numérico, genera un error con trigger_error.

○ Si intenta realizar una división por cero, lanza una excepción personalizada.

3. Realiza la operación solicitada y muestra el resultado al usuario.

4. El código debe incluir:

○ Una excepción personalizada llamada DivisionPorCeroException.

○ Uso de trigger_error para manejar errores en las entradas no válidas.

○ Un bloque try-catch-fnally para manejar los casos de error o excepción.



