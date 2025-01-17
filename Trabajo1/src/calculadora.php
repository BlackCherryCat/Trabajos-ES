<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <h2>Calculadora</h2>
        <form action="./prueba.php" method="post">
            <input type="text" name="num1" id="num1">
            <select name="op" id="op">
                <option value="+">+</option>
                <option value="-">-</option>
                <option value="*">*</option>
                <option value="/">/</option>
            </select>
            <input type="text" name="num2" id="num2">
            <input type="submit" value="Calcular">
        </form>
        <br>
        <a href="menu.php">Volver</a>

        <?php
        $num1;
        $num2;
        $res = 0.0;
        $error = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $num1 = $_POST["num1"];
            $num2 = $_POST["num2"];
            try {
                if ($_POST["op"] == "+") {
                    $res = $num1 + $num2;
                }
                if ($_POST["op"] == "-") {
                    $res = $num1 - $num2;
                }
                if ($_POST["op"] == "*") {
                    $res = $num1 * $num2;
                }
                if ($_POST["op"] == "/") {
                    try {
                        $res = $num1 / $num2;
                    } catch (Error $e) {
                        $error = "No se puede dividir entre 0";
                    }
                }
            } catch (Error $e) {
                $error = "Solo admite numeros";
            }
        }
        ?>
        <p>
            <!-- Mostrar resultado o error -->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (!$error) {
                    echo $num1 . " " . $_POST["op"] . " " . $num2 . " = " . $res;
                } else {
                    echo $error;
                }
            }
            ?>
        </p>
    </body>
</html>