<?php
// MiConexion.php - Ahora es el procesador del registro

// 1. Incluimos solo la conexión limpia
include("conexion.php");

// Recibir datos
$id = $_POST["ide"];
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$email = $_POST["email"];
$Contrasenia = $_POST["Contrasenia"];
$verificarcontrasenia = $_POST["verificarcontrasenia"];
$restaurante = $_POST["restaurante"];
$usuario = $_POST["usuario"];

// Validar campos vacíos
if (empty($id) || empty($nombre) || empty($apellido) || empty($email) || empty($Contrasenia) || empty($verificarcontrasenia) || empty($usuario)) {
    die("Campos obligatorios vacíos");
}

// Validar contraseñas
if ($Contrasenia !== $verificarcontrasenia) {
    die("Las contraseñas no coinciden");
}

// SQL
$sql = "INSERT INTO usuarios(id_usuario, nombre, apellido, email, Contrasenia, verificarcontrasenia, restaurante, usuario)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($Laconexion, $sql);

// 8 variables (corregido el comentario anterior, eran 8 's')
mysqli_stmt_bind_param($stmt, "ssssssss",
    $id,
    $nombre,
    $apellido,
    $email,
    $Contrasenia,
    $verificarcontrasenia,
    $restaurante,
    $usuario
);

// Ejecutar
if (mysqli_stmt_execute($stmt)) {
    echo "Datos insertados correctamente";
} else {
    echo "Error: " . mysqli_error($Laconexion);
}
?>