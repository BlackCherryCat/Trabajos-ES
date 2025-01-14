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
            $error = "";
            $email = $_POST["email"];
            try{
                if(strlen($email) == 0){
                    throw new Exception("Error: Introduzca un correo electronico. La cadena esta vacia.");
                }else{
                    $array = explode("@",$email);
                    if(count($array) != 2){
                        throw new Exception("Error: Número de @ incorrecto.");
                    }else{
                        comprobarUsuario($array[0]);
                        comprobarDominio($array[1]);
                    }
                }
            }catch(Error $e){
                $error = "Error: **** poner el formato que debe tener el correo *** REVISAR";
            }catch(Exception $e2){
                echo $e2->getMessage();
            }
        }

        function comprobarUsuario($user){
            echo $user;
            set_error_handler("errorPersonalizado");
            //Expresion regular de caracteres permitidos
            $regEx = "/^[a-zA-Z0-9_.-]+$/";

            if($user[0] == "." || $user[strlen($user) -1] == "."){
                trigger_error(" Ni el primer ni el último carácter del usuario del email puede ser un punto");
            }elseif(!preg_match($regEx, $user)){
                trigger_error(" Se ha detectado un carácter inválido. Los caracteres validos son: Letras de a hasta z, numeros del 0 al 9 y los caracteres '-','_' y '.'");
            }elseif(preg_match("/\.\./",$user) || preg_match("/__/",$user) || preg_match("/--/",$user)){
                trigger_error(" No puede haber dos caractéres especiales juntos");
            }else{
                echo " Usuario válido";
            }
        }

        function errorPersonalizado($numError, $msgError, $archivoError, $lineaError){
            throw new ErrorException($msgError, $numError, $lineaError, $archivoError);
        }

        function comprobarDominio($dominio){
            $error = "";
            echo "<br>" .$dominio;
            /*No puede empezar por guion, puede tener mayusculas minusculas numeros y guiones entre 1 y 63 caracteres
            no puede acabar en guion y cada parte del dominio despues del punto puede acabar en mayusculas y minusculas de 2 a 63 caracteres */
            $regEx = '/^(?!\-)([a-zA-Z0-9-]{1,63})(?<!\-)(\.[a-zA-Z]{2,63})+$/';

            try{
                if (preg_match($regEx, $dominio)) {
                    echo " Dominio válido.";
                } else {
                    throw new Exception(" El dominio no es valido");
                }
            }catch(Exception $e){
                $error = " Error en el dominio";
            }
            if($error){
                echo $error;
            }
        }
    ?>
</body>
</html>