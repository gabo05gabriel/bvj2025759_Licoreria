<?php
session_start();
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['user_id'])) {
    $usuario_id = $_SESSION['user_id'];

    // Consulta para obtener los recibos del usuario actual
    $sql = "SELECT r.id AS recibo_id, o.id AS orden_id, r.total, r.detalle, r.cambio, r.fecha_recibo
            FROM recibos r
            JOIN ordenes o ON r.orden_id = o.id
            WHERE o.usuario_id = ?
            ORDER BY r.fecha_recibo DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID de Recibo</th><th>ID de Orden</th><th>Total</th><th>Detalle</th><th>Cambio</th><th>Fecha de Recibo</th><th>Detalles</th></tr>";
        while($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $fila["recibo_id"] . "</td>";
            echo "<td>" . $fila["orden_id"] . "</td>";
            echo "<td>" . number_format($fila["total"], 2) . "</td>";
            echo "<td>" . htmlspecialchars($fila["detalle"]) . "</td>";
            echo "<td>" . number_format($fila["cambio"], 2) . "</td>";
            echo "<td>" . $fila["fecha_recibo"] . "</td>";
            echo "<td><a href='detalle_recibo.php?id=" . $fila["recibo_id"] . "' class='btn'>Ver Detalles</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No se encontraron recibos.</p>";
    }
} else {
    echo "<p>Debes iniciar sesión para ver tus recibos.</p>";
}

// Cerrar la conexión
$conn->close();
?>