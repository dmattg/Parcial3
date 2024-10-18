<?php
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: index.php');
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

// Funciones CRUD para la tabla usuario
function crearUsuario($nombre, $apellido, $email, $contrasena, $nacionalidad_id) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO usuario (nombre, apellido, email, contrasena, nacionalidad_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nombre, $apellido, $email, $contrasena, $nacionalidad_id);
    return $stmt->execute();
}

function leerUsuarios() {
    global $conn;
    $result = $conn->query("SELECT * FROM usuario");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function actualizarUsuario($usuario_id, $nombre, $apellido, $email, $contrasena, $nacionalidad_id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE usuario SET nombre = ?, apellido = ?, email = ?, contrasena = ?, nacionalidad_id = ? WHERE usuario_id = ?");
    $stmt->bind_param("ssssii", $nombre, $apellido, $email, $contrasena, $nacionalidad_id, $usuario_id);
    return $stmt->execute();
}

function eliminarUsuario($usuario_id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM usuario WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    return $stmt->execute();
}

// Manejo de solicitudes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'crear':
                crearUsuario($_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['contrasena'], $_POST['nacionalidad_id']);
                break;
            case 'actualizar':
                actualizarUsuario($_POST['usuario_id'], $_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['contrasena'], $_POST['nacionalidad_id']);
                break;
            case 'eliminar':
                eliminarUsuario($_POST['usuario_id']);
                break;
        }
    }
}

$usuarios = leerUsuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Usuarios</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Gestión de Usuarios</h1>

    <!-- Formulario para crear usuario -->
    <form action="crud.php" method="POST">
        <input type="hidden" name="action" value="crear">
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
            <!-- Aquí debes cargar las nacionalidades de la base de datos -->
            <?php
            $nacionalidades = $conn->query("SELECT * FROM nacionalidad");
            while ($nacionalidad = $nacionalidades->fetch_assoc()) {
                echo "<option value='{$nacionalidad['nacionalidad_id']}'>{$nacionalidad['valor']}</option>";
            }
            ?>
        </select>

        <button type="submit">Agregar Usuario</button>
    </form>

    <h2>Lista de Usuarios</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Nacionalidad</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?php echo $usuario['usuario_id']; ?></td>
            <td><?php echo $usuario['nombre']; ?></td>
            <td><?php echo $usuario['apellido']; ?></td>
            <td><?php echo $usuario['email']; ?></td>
            <td>
                <?php
                // Cargar la nacionalidad correspondiente
                $nacionalidad_result = $conn->query("SELECT valor FROM nacionalidad WHERE nacionalidad_id = " . $usuario['nacionalidad_id']);
                $nacionalidad = $nacionalidad_result->fetch_assoc();
                echo $nacionalidad['valor'];
                ?>
            </td>
            <td>
                <form action="crud.php" method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="eliminar">
                    <input type="hidden" name="usuario_id" value="<?php echo $usuario['usuario_id']; ?>">
                    <button type="submit">Eliminar</button>
                </form>
                <button onclick="editarUsuario(<?php echo $usuario['usuario_id']; ?>, '<?php echo $usuario['nombre']; ?>', '<?php echo $usuario['apellido']; ?>', '<?php echo $usuario['email']; ?>', '<?php echo $usuario['nacionalidad_id']; ?>')">Editar</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <script src="../js/script.js"></script>
</body>
</html>
