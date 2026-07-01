<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión — STOP TIMEFOOD</title>
    <link rel="stylesheet" href="inicio de sesion.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="inicio de sesion.js" defer></script>
</head>
<body>

    <form action="autenticacion.php" method="post" class="form-card">
        <div class="login-container">
            <h2>Iniciar Sesión</h2>

            <div class="input-group">
                <input type="email" id="usuario" name="email" placeholder="Usuario@gmail.com" required>
            </div>

            <div class="input-group">
                <input type="password" id="clave" name="Contrasenia" placeholder="Contraseña" required>
                <span class="toggle-password" onclick="togglePassword()">👁</span>
            </div>

            <button type="submit">Inicie sesión</button>

            <div class="form-footer">
                ¿No tienes una cuenta? <a href="Registros.php">Regístrate aquí</a>
            </div>
        </div>
    </form>

</body>
</html>