<?php
// Capturamos el rol real que viene desde la base de datos
$rol_real = isset($_GET['rol_real']) ? trim($_GET['rol_real']) : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="SELECCION DE ROLES.css">
    <title>Selección de Rol — STOPTIMEFOOD</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <header class="main-header">
        <div class="logo">STOPTIME<span>FOOD</span></div>
    </header>

    <main class="container">
        <h1>Seleccione una cuenta</h1>
        
        <div class="profiles-grid">
            
            <div class="role-card" onclick="verificarAcceso('Admin')">
                <div class="avatar-circle">
                    <ion-icon name="person-outline" style="font-size: 2.5rem; color: #555;"></ion-icon>
                </div>
                <h3>Administrador</h3>
                <p>Gestión total del sistema</p>
            </div>

            <div class="role-card" onclick="verificarAcceso('Alman')">
                <div class="avatar-circle">
                    <ion-icon name="add-circle-outline" style="font-size: 2.5rem; color: #555;"></ion-icon>
                </div>
                <h3>Almacenista</h3>
                <p>Registrar productos</p>
            </div>

        </div>
    </main>

    <script>
// Captura el rol de la URL
const rolVerdadero = "<?php echo addslashes($rol_real); ?>".trim().toLowerCase(); 

//LÍNEA DE DIAGNÓSTICO: Te dirá qué llegó en una alerta apenas cargue la página
alert("DEBUG: El rol que llegó de la Base de Datos es: '" + rolVerdadero + "'");

function verificarAcceso(rolSeleccionado) {
    const seleccion = rolSeleccionado.trim().toLowerCase();
    
    if (rolVerdadero === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sesión no identificada',
            text: 'No se detectó un rol asignado.',
            confirmButtonColor: '#e11d48'
        });
        return;
    }

    // Comparamos de forma directa e idéntica
    if (seleccion !== rolVerdadero) {
        let laborNombre = (rolVerdadero === 'admin') ? 'Administrador' : 'Almacenista';

        Swal.fire({
            icon: 'error',
            title: 'Acceso Denegado',
            text: `Esa no es tu labor. Tu cuenta está registrada como ${laborNombre}. (Detectado en BD: '${rolVerdadero}')`,
            confirmButtonColor: '#e11d48'
        });
    } else {
        if (seleccion === 'admin') {
            window.location.href = 'vistaadmin.php'; 
        } else if (seleccion === 'alman') {
            window.location.href = 'menbrecia2.0.php'; 
        }
    }
}
</script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>