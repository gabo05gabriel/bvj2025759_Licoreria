<?php
require 'conexion.php'; // Archivo para la conexión a la base de datos

$error = ''; // Variable para almacenar mensajes de error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Comprobar si los campos están definidos
    if (isset($_POST['nombre_usuario']) && isset($_POST['email']) && isset($_POST['contrasena'])) {
        $nombre_usuario = $_POST['nombre_usuario'];
        $email = $_POST['email'];
        $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Encriptar contraseña

        // Consulta para insertar el nuevo usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, email, contrasena) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre_usuario, $email, $contrasena);

        if ($stmt->execute()) {
            header("Location: login.php"); // Redirigir a la página de inicio de sesión
            exit();
        } else {
            $error = "Error al registrar el usuario: " . $stmt->error;
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <form method="post" action="">
        <label for="nombre_usuario">Nombre de Usuario:</label>
        <input type="text" name="nombre_usuario" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        <br>
        <input type="submit" value="Registrarse">
    </form>
    <?php if ($error) echo "<p>$error</p>"; ?>
</body>
</html>