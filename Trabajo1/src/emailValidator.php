<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="emailValidator.php" method="post">
        <label for="emailID">Introduzca el email a validad</label>
        <input type="text" name="email" id="emailID">
    </form>
    <?php 
        if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"])){
            $email = $_POST["email"];

            if(strlen($email) == 0){
                //Lanzar error de cadena vacia
            }else{
                $array = explode("@",$email);

                if(count($array) != 2){
                    //Error de muchos arrobas o ningun arroba
                }
            }
            

        
        }
    ?>
</body>
</html>