<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num1 = $_POST["num1"];
    $num2 = $_POST["num2"];
    $res = 0;
    if (is_numeric($num1) || is_numeric($num2)) {
        if ($_POST["op"] == "+") {
            $res = (float)$num1 + (float)$num2;
        }
        if ($_POST["op"] == "-") {
            $res = (float)$num1 - (float)$num2;
        }
        if ($_POST["op"] == "*") {
            $res = (float)$num1 * (float)$num2;
        }
        if ($_POST["op"] == "/") {
            try {
                $res = (float)$num1 / (float)$num2;
            } catch (Error $e) {
                $res = "No se puede dividir entre 0";
            }
        }
    } else {
        $res = "Solo admite numeros";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>Calculadora</h2>
    <form action="./calculadora.php" method="post">
        <input type="text" name="num1" id="num1">
        <select name="op" id="op">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select>
        <input type="text" name="num2" id="num2">
        =
        <input type="text" value="<?php echo $res; ?>" size="30"> <br> <br>
        <input type="submit" value="Calcular">
    </form>
</body>

</html>