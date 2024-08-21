<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Liquoreria</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        nav ul li {
            display: inline;
            margin: 0 10px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
        }
        .container {
            padding: 20px;
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }
        .cart-table, .cart-table th, .cart-table td {
            border: 1px solid #ddd;
        }
        .cart-table th, .cart-table td {
            padding: 8px;
            text-align: left;
        }
        .cart-table th {
            background-color: #f4f4f4;
        }
        .remove-item {
            color: red;
            text-decoration: none;
        }
        .remove-item:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Carrito de Compras</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="ordenes.php">Órdenes</a></li>
                <li><a href="recibos.php">Recibos</a></li>
                <?php
                session_start();
                if (isset($_SESSION['nombre_usuario'])) {
                    echo "<li style='float: right;'><a href='logout.php'>Cerrar Sesión</a></li>";
                    echo "<li style='float: right; margin-right: 10px;'>Hola, " . $_SESSION['nombre_usuario'] . "</li>";
                } else {
                    echo "<li style='float: right;'><a href='login.php'>Iniciar Sesión</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Contenido del Carrito</h2>
        <?php
        if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
            echo "<table class='cart-table'>";
            echo "<tr><th>Nombre</th><th>Precio</th><th>Cantidad</th><th>Total</th><th>Acción</th></tr>";

            $total_carrito = 0;

            foreach ($_SESSION['carrito'] as $id => $producto) {
                $nombre = htmlspecialchars($producto['nombre']);
                $precio = number_format($producto['precio'], 2);
                $cantidad = $producto['cantidad'];
                $total = number_format($precio * $cantidad, 2);
                $total_carrito += $precio * $cantidad;

                echo "<tr>";
                echo "<td>$nombre</td>";
                echo "<td>$$precio</td>";
                echo "<td>$cantidad</td>";
                echo "<td>$$total</td>";
                echo "<td><a href='remove_from_cart.php?id=$id' class='remove-item'>Eliminar</a></td>";
                echo "</tr>";
            }

            echo "<tr><td colspan='3'><strong>Total</strong></td><td>$$total_carrito</td><td></td></tr>";
            echo "</table>";
        } else {
            echo "<p>El carrito está vacío.</p>";
        }
        ?>
        <a href="productos.php" class="btn">Volver a Productos</a>
    </div>
</body>
</html>
