<?php
session_start();

// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se recibió el ID del producto
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verificar si el carrito existe en la sesión
    if (isset($_SESSION['carrito'][$id])) {
        unset($_SESSION['carrito'][$id]);
    }

    // Redireccionar al carrito de compras
    header("Location: carrito.php");
    exit();
}

// Cerrar la conexión
$conn->close();
?>
