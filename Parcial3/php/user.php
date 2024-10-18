<?php
session_start();

// Verificar si el usuario es usuario normal
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'usuario') {
    header('Location: index.php');
    exit();
}

$nombre = "Daniel Mateo Gutierrez De la O";
$numero_carnet = "1708002023";
$edad = 22;
$foto = "../img/me.jpg";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuario</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Bienvenido, <?php echo $nombre; ?></h1>
    <div class="usuario-info">
        <img src="<?php echo $foto; ?>" alt="Foto de <?php echo $nombre; ?>" class="foto-usuario">
        <p><strong>Número de Carnet:</strong> <?php echo $numero_carnet; ?></p>
        <p><strong>Edad:</strong> <?php echo $edad; ?></p>
    </div>
</body>
</html>