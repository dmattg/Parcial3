<?php
session_start();

// Definir usuarios y contraseñas
$valid_users = [
    'admin' => 'parcial2024',
    'usuario' => 'usuario2024'
];

// Obtener los datos del formulario
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validar credenciales
if (array_key_exists($username, $valid_users) && $valid_users[$username] === $password) {
    $_SESSION['username'] = $username;
    
    // Redirigir según el usuario
    if ($username === 'admin') {
        header('Location: admin.php');
        exit();
    } else {
        header('Location: user.php');
        exit();
    }
} else {
    echo 'Credenciales incorrectas. Intenta de nuevo.';
}
?>