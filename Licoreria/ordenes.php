<?php
session_start();
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['user_id'])) {
    $usuario_id = $_SESSION['user_id'];

    // Consulta para obtener las órdenes del usuario actual
    $sql = "SELECT o.id AS orden_id, o.total, o.fecha_orden
            FROM ordenes o
            WHERE o.usuario_id = ?
            ORDER BY o.fecha_orden DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID de Orden</th><th>Total</th><th>Fecha de Orden</th><th>Detalles</th></tr>";
        while($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $fila["orden_id"] . "</td>";
            echo "<td>" . number_format($fila["total"], 2) . "</td>";
            echo "<td>" . $fila["fecha_orden"] . "</td>";
            echo "<td><a href='detalles_orden.php?id=" . $fila["orden_id"] . "' class='btn'>Ver Detalles</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No se encontraron órdenes.</p>";
    }
} else {
    echo "<p>Debes iniciar sesión para ver tus órdenes.</p>";
}

// Cerrar la conexión
$conn->close();
?>