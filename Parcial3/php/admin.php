<?php
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Bienvenido, Administrador</h1>
    <p>Aquí puedes gestionar los registros.</p>
</body>
</html>