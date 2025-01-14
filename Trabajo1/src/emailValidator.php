<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="emailValidator.php" method="post">
        <label for="emailID">Introduzca el email a validar</label>
        <input type="text" name="email" id="emailID">
        <button type="submit">Enviar</button>
    </form>
    <?php 
        if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"])){
            $email = $_POST["email"];

            if(strlen($email) == 0){
                //Lanzar error de cadena vacia
            }else{
                $array = explode("@",$email);

                if(count($array) != 2){
                    //Error de muchas @ o ninguna @
                }else{
                    comprobarUsuario($array[0]);
                }
            }
        }

        function comprobarUsuario($user){
            echo $user;
            set_error_handler("errorPersonalizado");
            //Expresion regular de caracteres permitidos
            $regEx = "/^[a-zA-Z0-9_.-]+$/";

            if($user[0] == "." || $user[strlen($user) -1] == "."){
                trigger_error("Ni el primer ni el último carácter del usuario del email puede ser un punto");
            }elseif(!preg_match($regEx, $user)){
                trigger_error("Se ha detectado un carácter inválido. Los caracteres validos son: Letras de a hasta z, numeros del 0 al 9 y los caracteres '-','_' y '.'");
            }elseif(preg_match("/\.\./",$user) || preg_match("/__/",$user) || preg_match("/--/",$user)){
                trigger_error("No puede haber dos caractéres especiales juntos");
            }else{
                echo "Usuario válido";
            }
        }

        function errorPersonalizado($numError, $msgError, $archivoError, $lineaError){
            throw new ErrorException($msgError, $numError, $lineaError, $archivoError);
        }
    ?>
</body>
</html>