
<?php
error_reporting(0);
ini_set('display_errors', 0);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || trim($_SESSION['usuario']) !== 'Admin') {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(["error" => "No autorizado"]);
    exit();
}

include("conexion.php");


$sql = "SELECT nombre, email, usuario, fecha_ing FROM historial_sesiones ORDER BY fecha_ing DESC LIMIT 20";
$resultado = mysqli_query($Laconexion, $sql);

$sesiones = [];

if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        // Formateamos la fecha leída desde fecha_ing
      $fecha_formateada = date("d/m/Y g:i A", strtotime($fila['fecha_ing']));
        $sesiones[] = [
            "nombre"    => $fila['nombre'],
            "email"     => $fila['email'],
            "usuario"   => $fila['usuario'],
            "fecha_ing" => $fecha_formateada // Clave idéntica para JS
        ];
    }
    mysqli_free_result($resultado);
}

header('Content-Type: application/json');
echo json_encode($sesiones);
mysqli_close($Laconexion);
?>