<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si no ha iniciado sesión o su columna 'usuario' no es 'Admin', lo saca al login
if (!isset($_SESSION['usuario']) || trim($_SESSION['usuario']) !== 'Admin') {
    header("Location: inicio de sesion.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración — STOP TIMEFOOD</title>
    <link rel="stylesheet" href="membrecia2.0.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        .badge-admin {
            background: rgba(225, 29, 72, 0.15) !important;
            color: #e11d48 !important;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            letter-spacing: 0.03em;
            text-transform: capitalize;
        }
        .badge-alman {
            background: rgba(26, 107, 74, 0.15) !important;
            color: #1a6b4a !important;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            letter-spacing: 0.03em;
            text-transform: capitalize;
        }
        .header-admin {
            background: #101010; /* Mantiene tu color --verde oscuro corporativo */
        }
    </style>
</head>
<body>

    <header class="header-sistema header-admin">
        <div class="logo">STOPTIME<span>FOOD</span></div>
        <div class="header-divider"></div>
        <h1>Panel Principal del Administrador</h1>
        <span class="badge-version" style="background: #e11d48; color: #fff; opacity: 1;">ROOT</span>
    </header>

    <div class="contenedor">

        <p class="titulo-principal">Control de accesos y auditoría</p>

        <div class="demo-box">
            <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 6px;">Historial de Sesiones Activas</h2>
            <p style="color: var(--gris-texto); font-size: 0.82rem; margin-bottom: 20px;">
                Monitoreo en tiempo real de los usuarios que se han autenticado en el sistema.
            </p>

            <table class="tabla-demo" style="box-shadow: none; border-radius: 8px;">
                <thead>
                    <tr>
                        <th>Nombre del Empleado</th>
                        <th>Correo Electrónico</th>
                        <th>Tipo de Usuario</th>
                        <th>Fecha y Hora de Entrada</th>
                    </tr>
                </thead>
                <tbody id="tabla-sesiones-body">
                    <tr>
                        <td colspan="4" class="vacio">Cargando registro de ingresos...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <button onclick="window.location.href='index.php?rol_real=Admin'" class="btn-submit" style="background: #222; margin-top: 10px;">
            Volver a la página principal
        </button>

    </div>

    <script>
       // Al cargar completamente la estructura del DOM, ejecutamos la consulta automáticamente
document.addEventListener("DOMContentLoaded", cargarHistorialSesiones);

async function cargarHistorialSesiones() {
    try {
        const respuesta = await fetch("obtener_sesiones.php");
        
        if (!respuesta.ok) {
            throw new Error(`Error en el servidor: ${respuesta.status}`);
        }

        const datos = await respuesta.json();
        const tbody = document.getElementById("tabla-sesiones-body");
        
        tbody.innerHTML = ""; 

        if (datos.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" class="vacio">No hay registros de ingresos recientes.</td></tr>`;
            return;
        }

        datos.forEach(item => {
            const fila = document.createElement("tr");
            
            const tipoUsuario = (item.usuario || '').trim().toLowerCase();
            
            let badgeHTML = '';
            if (tipoUsuario === 'admin') {
                badgeHTML = `<span class="badge-admin">Administrador</span>`;
            } else {
                badgeHTML = `<span class="badge-alman">Almacenista</span>`;
            }

            // Cambiado a item.fecha_ing para que pinte el valor real
            fila.innerHTML = `
                <td style="font-weight: 500; color: var(--negro);">${item.nombre || 'Sin nombre'}</td>
                <td style="color: var(--gris-texto);">${item.email || 'Sin correo'}</td>
                <td>${badgeHTML}</td>
                <td style="color: var(--gris-texto); font-variant-numeric: tabular-nums;">${item.fecha_ing || 'Sin fecha'}</td>
            `;
            
            tbody.appendChild(fila);
        });

    } catch (error) {
        console.error("Detalle del fallo en JavaScript:", error);
        const tbody = document.getElementById("tabla-sesiones-body");
        tbody.innerHTML = `<tr><td colspan="4" class="vacio" style="color: #c0392b;">Error al procesar o renderizar los datos de auditoría.</td></tr>`;
    }
}
    </script>
</body>
</html>