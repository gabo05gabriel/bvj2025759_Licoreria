<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Liquoreria</title>
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
        .product-list {
            list-style: none;
            padding: 0;
        }
        .product-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .product-item h3 {
            margin: 0;
        }
        .product-item p {
            margin: 5px 0;
        }
        .product-item .add-to-cart {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .product-item .add-to-cart:hover {
            background-color: #0056b3;
        }
        .cart-link {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 20px;
            color: #fff;
            background-color: #28a745;
            text-decoration: none;
            border-radius: 5px;
        }
        .cart-link:hover {
            background-color: #218838;
        }
        .quantity-input {
            width: 60px;
            text-align: center;
            margin-right: 10px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <header>
        <h1>Productos de Liquoreria</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="ordenes.php">Órdenes</a></li>
                <li><a href="recibos.php">Recibos</a></li>
                <li><a href="carrito.php" class="cart-link">Ver Carrito</a></li>
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
        <h2>Listado de Productos</h2>
        <?php
        // Incluir el archivo de conexión
        include 'conexion.php';

        // Consulta para obtener todos los productos
        $sql = "SELECT * FROM productos";
        $resultado = $conn->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            echo "<ul class='product-list'>";
            while($fila = $resultado->fetch_assoc()) {
                echo "<li class='product-item'>";
                echo "<div>";
                echo "<h3>" . htmlspecialchars($fila["nombre"]) . "</h3>";
                echo "<p>Descripción: " . htmlspecialchars($fila["descripcion"]) . "</p>";
                echo "<p>Precio: $" . number_format($fila["precio"], 2) . "</p>";
                echo "<p>Stock: " . $fila["stock"] . "</p>";
                echo "</div>";
                if (isset($_SESSION['nombre_usuario'])) {
                    echo "<form action='add_to_cart.php' method='post' style='display: flex; align-items: center;'>";
                    echo "<input type='hidden' name='id' value='" . $fila["id"] . "'>";
                    echo "<input type='number' name='quantity' value='1' min='1' max='" . $fila["stock"] . "' class='quantity-input'>";
                    echo "<button type='submit' class='add-to-cart'>Agregar al Carrito</button>";
                    echo "</form>";
                } else {
                    echo "<p><a href='login.php' class='add-to-cart'>Inicia sesión para agregar al carrito</a></p>";
                }
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No se encontraron productos.</p>";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </div>
</body>
</html>
