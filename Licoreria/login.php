<?php
session_start();
require 'conexion.php'; // Archivo para la conexión a la base de datos

$error = ''; // Variable para almacenar mensajes de error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Comprobar si los campos están definidos
    if (isset($_POST['nombre_usuario']) && isset($_POST['contrasena'])) {
        $nombre_usuario = $_POST['nombre_usuario'];
        $contrasena = $_POST['contrasena'];

        // Consulta para obtener el usuario
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ?");
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();
            // Verificar la contraseña
            if (password_verify($contrasena, $usuario['contrasena'])) {
                // Guardar información del usuario en la sesión
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
                header("Location: index.php"); // Redirigir a la página de inicio
                exit();
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado.";
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
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form method="post" action="">
        <label for="nombre_usuario">Nombre de Usuario:</label>
        <input type="text" name="nombre_usuario" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        <br>
        <input type="submit" value="Iniciar Sesión">
    </form>
    <?php if ($error) echo "<p>$error</p>"; ?>
</body>
</html>