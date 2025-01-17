<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Validador de emails</h1>
    <form action="emailValidator.php" method="post">
        <label for="emailID">Introduzca el email a validar</label>
        <input type="text" name="email" id="emailID">
        <button type="submit">Enviar</button>
    </form>
    <br>
    <a href="menu.php">Volver</a>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"])) {
        $error = "";
        $email = $_POST["email"];
        try {
            if (strlen($email) == 0) {
                throw new Exception("Error: Introduzca un correo electronico. La cadena esta vacia.");
            } else {
                $array = explode("@", $email);
                if (count($array) != 2) {
                    throw new Exception("Error: Número de @ incorrecto.");
                } else {
                    if (comprobarUsuario($array[0]) && comprobarDominio($array[1])) {
                        echo "Correo válido";
                    }
                }
            }
        } catch (Error $e) {
            $error = "Error: **** poner el formato que debe tener el correo *** REVISAR";
        } catch (Exception $e2) {
            echo "<b>Error</b>, correo inválido: " . $e2->getMessage();
        }
    }

    function comprobarUsuario($user)
    {
        //Expresion regular de caracteres permitidos
        $regEx = "/^[a-zA-Z0-9_.-]+$/";

        if ($user[0] == "." || $user[strlen($user) - 1] == ".") {
            throw new Exception("Ni el primer ni el último carácter del usuario del email puede ser un punto");
        } elseif (!preg_match($regEx, $user)) {
            throw new Exception(" Se ha detectado un carácter inválido. Los caracteres validos son: Letras de a hasta z, numeros del 0 al 9 y los caracteres '-','_' y '.'");
        } elseif (preg_match("/\.\./", $user) || preg_match("/__/", $user) || preg_match("/--/", $user)) {
            throw new Exception(" No puede haber dos caractéres especiales juntos");
        } else {
            return true;
        }
    }

    function comprobarDominio($dominio)
    {
        $error = "";
        /*No puede empezar por guion, puede tener mayusculas minusculas numeros y guiones entre 1 y 63 caracteres
            no puede acabar en guion y cada parte del dominio despues del punto puede acabar en mayusculas y minusculas de 2 a 63 caracteres */
        $regEx = '/^(?!\-)([a-zA-Z0-9-]{1,63})(?<!\-)(\.[a-zA-Z]{2,63})+$/';

        //try{
        if (preg_match($regEx, $dominio)) {
            echo " Dominio válido<br>";
            return true;
        } else {
            throw new Exception(" El dominio no es valido");
        }
        /*}catch(Exception $e){
                $error = " Error en el dominio";
            }
            if($error){
                echo $error;
            }*/
    }
    ?>
</body>

</html>