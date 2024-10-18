<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: crud.php');
    exit();
}

// Conexión a la base de datos
$host = 'localhost';
$db = 'BDParcial3';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejar la autenticación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Verificar las credenciales
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE nombre = ? AND contrasena = ?");
    $stmt->bind_param("ss", $usuario, $contrasena);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        $_SESSION['username'] = $usuario['nombre']; // Guardar el nombre del usuario en sesión
        $_SESSION['role'] = $usuario['email'] === 'admin' ? 'admin' : 'usuario'; // Establecer rol
        header('Location: crud.php'); // Redirigir al CRUD
        exit();
    } else {
        echo "Credenciales inválidas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<form action="login.php" method="POST">
    <label for="usuario">Usuario:</label>
    <input type="text" id="usuario" name="usuario" required>

    <label for="contrasena">Contraseña:</label>
    <input type="password" id="contrasena" name="contrasena" required>

    <button type="submit">Iniciar Sesión</button>
</form>
</body>
</html>