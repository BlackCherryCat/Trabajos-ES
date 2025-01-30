<?php
session_start();

if (isset($_SESSION["cliente"])) {
    $cliente = $_SESSION["cliente"];
    
    $carrito = $cliente->getCarrito();
    
    if (empty($carrito)) {
        echo "<p>Tu carrito está vacío.</p>";
    } else {
        echo "<h2>Carrito de compras</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>";
        
        foreach ($carrito as $producto) {
            $totalProducto = $producto->getPrecio() * 1; 

            echo "<tr>
                    <td>" . htmlspecialchars($producto->getNombre()) . "</td>
                    <td>" . htmlspecialchars($producto->getPrecio()) . "</td>
                    <td>1</td> <!-- Puedes cambiar la cantidad si lo tienes implementado -->
                    <td>" . htmlspecialchars($totalProducto) . "</td>
                </tr>";
        }

        $totalCarrito = 0;
        foreach ($carrito as $producto) {
            $totalCarrito += $producto->getPrecio() * 1;
        }

        echo "</table>";
        echo "<p><b>Total del carrito: $" . $totalCarrito . "</b></p>";
    }
} else {
    echo "<p>No has iniciado sesión. Por favor, inicia sesión para ver tu carrito.</p>";
}
?>