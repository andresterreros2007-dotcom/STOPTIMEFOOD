<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro — STOP TIMEFOOD</title>
  <link rel="stylesheet" href="Registros.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

  

  <div class="main-container">
    <form action="MiConexion.php" method="post" class="form-card">

      <!-- DATOS PERSONALES -->
      <p class="form-section">Datos personales</p>

      <div class="fila-2">
        
      <div class="campo">
        <label for="id">Numero de identificacion</label>
        <input type="text" id="ide" name="ide" placeholder="Ej:1001">
        </div>

        <div class="campo">
          <label for="nombre">Nombre</label>
          <input type="text" id="nombre" name="nombre" placeholder="Ej: Andrés">
          <span class="msg-error">Mínimo 2 caracteres</span>
        </div>
        <div class="campo">
          <label for="apellido">Apellido</label>
          <input type="text" id="apellido" name="apellido" placeholder="Ej: Torres">
          <span class="msg-error">Mínimo 2 caracteres</span>
        </div>
      </div>

      <div class="campo">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" placeholder="correo@ejemplo.com">
        <span class="msg-error">Correo inválido</span>
      </div>

      <!-- RESTAURANTE -->
      <p class="form-section">Restaurante y rol</p>

      <div class="campo">
        <label for="restaurante">Nombre del restaurante</label>
        <input type="text" id="restaurante" name="restaurante" placeholder="Ej: La Fogata">
        <span class="msg-error">Ingrese el nombre del restaurante</span>
      </div>

      <div class="campo">
        <label for="usuario">¿Cuál es su labor?</label>
        <select id="usuario" name="usuario">
          <option value="">Seleccione una opción...</option>
          <option value="Admin">Administrador</option>
          <option value="Alman">Almacenista</option>
        </select>
        <span class="msg-error">Seleccione un rol</span>
      </div>

      <!-- CONTRASEÑA -->
      <p class="form-section">Contraseña</p>

      <div class="campo">
        <label for="Contrasenia">Contraseña</label>
        <div class="pwd-wrapper">
          <input type="password" id="Contrasenia" name="Contrasenia" placeholder="Mínimo 6 caracteres">
          <button type="button" class="toggle-pwd" onclick="togglePwd('Contrasenia', this)">👁</button>
        </div>
        <span class="msg-error">Mínimo 6 caracteres</span>
      </div>

      <div class="campo">
        <label for="verificarcontrasenia">Verificar contraseña</label>
        <div class="pwd-wrapper">
          <input type="password" id="verificarcontrasenia" name="verificarcontrasenia" placeholder="Repite la contraseña">
          <button type="button" class="toggle-pwd" onclick="togglePwd('verificarcontrasenia', this)">👁</button>
        </div>
        <span class="msg-error">Las contraseñas no coinciden</span>
      </div>

      <input type="submit" name="register" value="Crear cuenta" class="btn-submit">

      <div class="form-footer">
        ¿Ya tienes cuenta? <a href="inicio de sesion.php">Inicia sesión aquí</a>
      </div>

    </form>
  </div>

  <script src="Registros.js"></script>
</body>
</html>