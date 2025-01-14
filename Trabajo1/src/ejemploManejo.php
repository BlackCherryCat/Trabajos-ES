<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ejemploManejo.css">
    <title>Document</title>
</head>
<body>
    <form action="ejemploManejo.php" method="POST">
        <div class="header">
            <div>
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" alt="logoPHP">
            </div>
            <p class="nombre">Noemi</p>
        </div>


        <div class="bottom">
            
            <input type="text" name="msg" id="msgID">
            <button type="submit">Enviar</button>
        </div>
    </form>

    <?php
        if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["msg"])){
            
            //Creamos nuestro error handler personalizado. Esto es lo que se nos va a imprimir cuando salte el error
            function errorPersonalizado($numError, $msgError, $archivoError, $lineaError){
                echo "<p><b>Error Personalizado: </b>[$numError] , $msgError<br>";
                echo " Error en la linea $lineaError in $archivoError</p>";
            }

            //Configuramos nuestro función como controlador de errores personalizado
            set_error_handler("errorPersonalizado");

            //Obtenemos el mensaje
            $mensaje = $_POST["msg"];

            //Si es una cadena vacía, lanzamos el error
            if(strlen($mensaje) == 0){
                trigger_error("Debes escribir al menos un carácter. No se puede enviar un mensaje vacío");
            }else{
                //Si no, imprimimos el mensaje
                echo "<p class='mensaje'>$mensaje</p>";
            }

            //Es recomendable reiniciar la función a los valores por defecto para que no se aplique a todos los errores
            set_error_handler("");
        }
    ?>
</body>
</html>