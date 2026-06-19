<?php
// 1. Iniciar la sesión de forma segura
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Incluir la conexión limpia
include("conexion.php"); 

// 3. Recibir y limpiar los datos del formulario de login
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$contrasenia = isset($_POST['Contrasenia']) ? $_POST['Contrasenia'] : '';

if (empty($email) || empty($contrasenia)) {
    die("Por favor, rellene todos los campos del formulario.");
}

//consulta SQL para buscar al usuario
// incluir 'nombre' en el SELECT para guardarlo en el historial
$sql = "SELECT id_usuario, nombre, email, Contrasenia, usuario FROM usuarios WHERE email = ?";
$stmt = mysqli_prepare($Laconexion, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($fila = mysqli_fetch_assoc($resultado)) {

        // Comparación de contraseña en texto plano
        if ($contrasenia === $fila['Contrasenia']) {
            
            // Guardamos los datos en la sesión global
            $_SESSION['id_usuario'] = $fila['id_usuario'];
            $_SESSION['email'] = $fila['email'];
            
            $rol_base_datos = trim($fila['usuario']); // Captura 'Admin' o 'Alman'
            $_SESSION['usuario'] = $rol_base_datos; 

           
            // Guardar el rastro en la tabla historial_sesiones

            $id_user    = $fila['id_usuario'];
            $nom_user   = $fila['nombre']; 
            $email_user = $fila['email'];
            
            
            $sql_log = "INSERT INTO historial_sesiones (id_usuario, nombre, email, usuario, fecha_ing) VALUES (?, ?, ?, ?,  NOW())";
            $stmt_log = mysqli_prepare($Laconexion, $sql_log);
            
            if ($stmt_log) {
                mysqli_stmt_bind_param($stmt_log, "isss", $id_user, $nom_user, $email_user, $rol_base_datos);
                mysqli_stmt_execute($stmt_log);
                mysqli_stmt_close($stmt_log);
            }
            

            // Redireccionar a la pantalla de roles pasando el usuario real por la URL
            header("Location: SELECCION DE ROLES.php?rol_real=" . urlencode($rol_base_datos));
            exit();

        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Correo no registrado.";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Error en la consulta: " . mysqli_error($Laconexion);
}
mysqli_close($Laconexion);
?>