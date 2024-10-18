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

// Manejar el registro de usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $nacionalidad_id = $_POST['nacionalidad_id'];

    // Insertar usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuario (nombre, apellido, email, contrasena, nacionalidad_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nombre, $apellido, $email, $contrasena, $nacionalidad_id);

    if ($stmt->execute()) {
        echo "Registro exitoso";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Registro de Usuario</h1>
    <form action="registro.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>

        <label for="nacionalidad_id">Nacionalidad:</label>
        <select id="nacionalidad_id" name="nacionalidad_id" required>
            <option value="">Seleccione</option>
            <?php
            $nacionalidades = $conn->query("SELECT * FROM nacionalidad");
            while ($nacionalidad = $nacionalidades->fetch_assoc()) {
                echo "<option value='{$nacionalidad['nacionalidad_id']}'>{$nacionalidad['valor']}</option>";
            }
            ?>
        </select>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>
