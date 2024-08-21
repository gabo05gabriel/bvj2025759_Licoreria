<?php
session_start();

if (!isset($_SESSION['nombre_usuario'])) {
    // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    header('Location: login.php');
    exit();
}

// Incluir el archivo de conexión
include 'conexion.php';

// Validar y procesar los datos del formulario
if (isset($_POST['id']) && isset($_POST['quantity'])) {
    $id = intval($_POST['id']);
    $quantity = intval($_POST['quantity']);

    // Aquí deberías agregar la lógica para agregar el producto al carrito
    // Ejemplo: insertar el producto y la cantidad en la tabla de carrito

    // Redirigir al usuario al carrito o a otra página después de agregar el producto
    header('Location: carrito.php');
    exit();
} else {
    // Manejar el caso en el que los datos del formulario no estén presentes
    header('Location: productos.php');
    exit();
}
?>
