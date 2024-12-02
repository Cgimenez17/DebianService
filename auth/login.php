<?php
$file = realpath("../config/database.php");

if (!$file || !file_exists($file)) {
    die("Error: No se pudo encontrar el archivo en la ruta $file");
}
//require_once "../config/database.php";
require_once $file;

// Obtener datos del formulario
$username = mysqli_real_escape_string($mysqli, stripslashes(strip_tags(htmlspecialchars(trim($_POST['username'])))));
$password = md5(mysqli_real_escape_string($mysqli, stripslashes(strip_tags(htmlspecialchars(trim($_POST['password']))))));

// Validar datos de entrada
$query = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE username='$username' AND password='$password' AND status='activo'") or die('error: ' . mysqli_error($mysqli));

$rows = mysqli_num_rows($query);

session_start(); 

if ($rows > 0) {
    $data = mysqli_fetch_assoc($query);

    
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['password'] = $data['password'];
    $_SESSION['name_user'] = $data['name_user'];
    $_SESSION['permisos_acceso'] = $data['permisos_acceso'];

    
    $_SESSION['message'] = "¡Inicio de sesión exitoso!";
    $_SESSION['message_type'] = "success";

    
    header("Location: ../index.php"); 
    exit();
} else {
    
    $_SESSION['message'] = "Usuario o contraseña incorrectos";
    $_SESSION['message_type'] = "error";
    
    header("Location: ../login.html");
    exit();
}
?>
