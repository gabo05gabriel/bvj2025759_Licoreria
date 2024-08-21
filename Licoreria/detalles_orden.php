<?php
session_start();
// Incluir el archivo de conexión
include 'conexion.php';

// Obtener el ID de la orden desde la URL
$orden_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['user_id'])) {
    $usuario_id = $_SESSION['user_id'];

    // Consultar los detalles de la orden
    $sql_orden = "SELECT o.id AS orden_id, o.total, o.fecha_orden
                  FROM ordenes o
                  WHERE o.id = ? AND o.usuario_id = ?";
    $stmt_orden = $conn->prepare($sql_orden);
    $stmt_orden->bind_param("ii", $orden_id, $usuario_id);
    $stmt_orden->execute();
    $resultado_orden = $stmt_orden->get_result();

    if ($resultado_orden->num_rows > 0) {
        $orden = $resultado_orden->fetch_assoc();
        echo "<h2>Orden #" . $orden["orden_id"] . "</h2>";
        echo "<p><strong>Total:</strong> " . number_format($orden["total"], 2) . "</p>";
        echo "<p><strong>Fecha de Orden:</strong> " . $orden["fecha_orden"] . "</p>";

        // Consultar los detalles de los productos en la orden
        $sql_detalles = "SELECT p.nombre, d.cantidad, d.precio_unitario
                         FROM detalles_orden d
                         JOIN productos p ON d.producto_id = p.id
                         WHERE d.orden_id = ?";
        $stmt_detalles = $conn->prepare($sql_detalles);
        $stmt_detalles->bind_param("i", $orden_id);
        $stmt_detalles->execute();
        $resultado_detalles = $stmt_detalles->get_result();

        if ($resultado_detalles->num_rows > 0) {
            echo "<h3>Detalles de Productos</h3>";
            echo "<table>";
            echo "<tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th></tr>";
            while ($detalle = $resultado_detalles->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($detalle["nombre"]) . "</td>";
                echo "<td>" . $detalle["cantidad"] . "</td>";
                echo "<td>" . number_format($detalle["precio_unitario"], 2) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No se encontraron detalles para esta orden.</p>";
        }
    } else {
        echo "<p>No se encontró la orden con el ID proporcionado o no tienes acceso a ella.</p>";
    }
} else {
    echo "<p>Debes iniciar sesión para ver los detalles de la orden.</p>";
}

// Cerrar la conexión
$conn->close();
?>