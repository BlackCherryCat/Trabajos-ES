<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        //La clase admin hereda de Usuario e implementa la interfaz base de datos
        class Admin extends Usuario{
            //Atributos de la clase admin
            private $credenciales;
        }

    ?>
</body>
</html>