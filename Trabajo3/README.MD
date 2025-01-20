## 2ª EVALUACIÓN: TAREA 3 - Programación Orientada a Objetos en PHP

## 20/01/2025 

## Objetivos 

●​ Investigar y preparar una exposición sobre los principios de la Programación Orientada a Objetos (POO) en PHP. 

●​ Desarrollar un ejemplo práctico que muestre cómo aplicar la programación orientada a objetos en PHP utilizando todos los conceptos vistos en la parte teórica. 

## Parte 1: Explicación Teórica 

Preparar una exposición en la que se explique:: 

 ●​ Definición y Principios de la POO: 

○​ ¿Qué es la Programación Orientada a Objetos (POO)? 

○​ Los cuatro pilares de la POO: Abstracción, Encapsulamiento, Herencia y Polimorfismo. 

 ●​ Estructura Básica en PHP: 

○​ Cómo definir y trabajar con clases y objetos en PHP. 

○​ Declaración de atributos (variables) y métodos (funciones) dentro de una clase.

○​ Diferencia entre propiedades estáticas y no estáticas.

○​ Uso de modificadores de acceso: public, private y protected. 

 ●​ Características Avanzadas de POO en PHP: 

○​ Constructores ( construct) y destructores ( destruct).

○​ Métodos mágicos ( get, set, toString, call, etc).

○​ Uso de interfaces y clases abstractas.

○​ Sobrecarga de métodos (polimorfismo básico). 

Explicación clara, utilizando ejemplos básicos para ilustrar los conceptos.

## Parte 2: Ejemplo práctico

## Parte 3: Presentación y casos de prueba 

### Criterios de Evaluación

●​ Trabajo individual: informe del responsable del grupo sobre el trabajo de los compañeros. 

●​ Claridad de la explicación teórica.

●​ Calidad del ejemplo práctico.

●​ Capacidad de explicar el código.

●​ Interacción con los compañeros.

Fecha de entrega (aprox): 31/01/2025 

## Ejemplo práctico. PROPUESTA 1: Gestión de una librería utilizando POO en PHP. 

### 1.​ Requisitos Funcionales: 

○​Define una clase base llamada Libro con los atributos:

 ​titulo (cadena de texto).

 ​autor (cadena de texto). 

precio (número decimal).

○​Implementa un constructor que permita inicializar los valores de estos atributos al crear un objeto. 

○​Agrega un método llamado mostrarDetalles() que devuelva una cadena con la información completa del libro. 

### 2.​ Ampliación mediante Herencia: 

○​Crea una clase llamada LibroDigital que extienda la clase Libro.

○​Añade un nuevo atributo llamado pesoArchivo (en MB) y un método llamado descargar() que simule la descarga del libro mostrando un mensaje en pantalla. 

### 3.​ Encapsulamiento: 

○​Asegúrate de que todos los atributos sean privados y utiliza métodos getter y setter para acceder y modificar los valores de los atributos. 

### 4.​ Polimorfismo:

○​Sobrescribe el método mostrarDetalles() en la clase LibroDigital para incluir la información adicional del peso del archivo. 

### 5.​ Interacción: 

○​Crea un archivo PHP en el que se instancien y utilicen objetos de las clases Libro y LibroDigital. 

○​Muestra los detalles de los libros y utiliza el método descargar() en los libros digitales.

 Ejemplo práctico. PROPUESTA 2: Gestión de empleados en una empresa utilizando POO en PHP 

### Requisitos Funcionales: 

### 1.​ Clase Base: Empleado

○​ Define los siguientes atributos privados:

 ​ nombre (cadena de texto).

 ​ edad (entero).

 ​ salario (número decimal).

○​ Implementa un constructor que permita inicializar estos atributos al crear un objeto. 

○​ Agrega un método mostrarDetalles() que devuelva una cadena con la información completa del empleado. 

### 2.​ Ampliación mediante Herencia:

○​ Crea una clase llamada EmpleadoRemoto que extienda la clase Empleado.

○​ Añade un atributo adicional llamado horasConexion (entero), que indica las horas que el empleado trabaja conectado de forma remota. 

○​ Agrega un método llamado trabajar() que simule una sesión de trabajo remoto mostrando un mensaje como:​

"El empleado remoto [nombre] está trabajando durante [horasConexion] horas." 

### 3.​ Encapsulamiento:

○​ Asegúrate de que todos los atributos sean privados y utiliza métodos getter y setter para acceder y modificar sus valores. 

### 4.​ Polimorfismo: 

○​ Sobrescribe el método mostrarDetalles() en la clase EmpleadoRemoto para incluir información sobre las horas de conexión. 

### 5.​ Interacción:

○​ Crea un archivo PHP donde se instancien objetos de las clases Empleado y EmpleadoRemoto. 

○​ Muestra los detalles de los empleados utilizando el método mostrarDetalles() y simula una sesión de trabajo remoto utilizando el método trabajar(). 



