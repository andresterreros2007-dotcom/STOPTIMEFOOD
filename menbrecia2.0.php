<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>STOP TIMEFOOD</title>
  <link rel="stylesheet" href="membrecia2.0.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

  <header class="header-sistema">
    <!-- Logo -->
   <div class="logo">STOPTIME<span>FOOD</span></div>
    <div class="header-divider"></div>
    <h1>Sistema de Almacenista</h1>
    
  </header>

  <div class="contenedor">

    <p class="titulo-principal">Registrar producto</p>

    <div class="demo-box">
      <form id="form-producto">

        <div class="demo-item">
          <label for="categoria">Categoría</label>
          <select id="categoria" name="categoria">
            <option value="">Seleccione una categoría</option>
            <option value="enlatados">Enlatados</option>
            <option value="panaderia">Panadería</option>
            <option value="frutas">Frutas</option>
            <option value="bebidas">Bebidas</option>
            <option value="lacteos">Lácteos</option>
            <option value="carnicos">Cárnicos</option>
            <option value="condimentos">Condimentos</option>
            <option value="aceites">Aceites</option>
          </select>
        </div>

        <div class="demo-item">
          <label for="producto">Nombre del producto</label>
          <input type="text" id="producto" name="producto" placeholder="Ej: Atún en aceite 170g">
        </div>

        <div class="fila-fechas">
          <div class="demo-item">
            <label>Fecha de ingreso</label>
            <div class="input-group">
              <input type="number" id="diaIngreso"  name="diaingreso"  placeholder="DD"   min="1" max="31">
              <span>/</span>
              <input type="number" id="mesIngreso"  name="mesingreso"  placeholder="MM"   min="1" max="12">
              <span>/</span>
              <input type="number" id="anioIngreso" name="anioingreso" placeholder="AAAA" min="2026" max="2026">
            </div>
          </div>

          <div class="demo-item">
            <label>Fecha de elaboración</label>
            <div class="input-group">
              <input type="number" id="diaElab"  name="diaelab"  placeholder="DD"   min="1" max="31">
              <span>/</span>
              <input type="number" id="mesElab"  name="meselabo" placeholder="MM"   min="1" max="12">
              <span>/</span>
              <input type="number" id="anioElab" name="anioelab" placeholder="AAAA" min="2026" max="2026">
            </div>
          </div>

          <div class="demo-item">
            <label>Fecha de vencimiento</label>
            <div class="input-group">
              <input type="number" id="diaVencimiento"  name="diavenci"  placeholder="DD"   min="1" max="31">
              <span>/</span>
              <input type="number" id="mesVencimiento"  name="mesvenci"  placeholder="MM"   min="1" max="12">
              <span>/</span>
              <input type="number" id="anioVencimiento" name="aniovenci" placeholder="AAAA" min="2026" max="2030">
            </div>
          </div>
        </div>

        <button type="submit" class="btn-submit">Registrar producto</button>
      </form>
    </div>

    <p class="titulo-principal">Inventario</p>

    <table class="tabla-demo">
      <thead>
        <tr>
          <th>ID</th>
          <th>Categoría</th>
          <th>Producto</th>
          <th>Ingreso</th>
          <th>Elaboración</th>
          <th>Vencimiento</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="tabla-body"></tbody>
    </table>

  </div>

  <!-- Modal de edición -->
  <div id="modal-editar" class="modal">
    <div class="modal-content">
      <button id="cerrar-modal" class="close">&times;</button>
      <h2>Editar producto</h2>
      <form id="form-editar">
        <input type="hidden" id="edit-id">

        <div class="demo-item">
          <label>Categoría</label>
          <select id="edit-categoria">
            <option value="enlatados">Enlatados</option>
            <option value="panaderia">Panadería</option>
            <option value="frutas">Frutas</option>
            <option value="bebidas">Bebidas</option>
            <option value="lacteos">Lácteos</option>
            <option value="carnicos">Cárnicos</option>
            <option value="condimentos">Condimentos</option>
            <option value="aceites">Aceites</option>
          </select>
        </div>

        <div class="demo-item">
          <label>Nombre del producto</label>
          <input type="text" id="edit-producto">
        </div>

        <div class="fila-fechas">
          <div class="demo-item">
            <label>Fecha de ingreso</label>
            <div class="input-group">
              <input type="number" id="edit-diaing"  placeholder="DD"   min="1" max="31">
              <span>/</span>
              <input type="number" id="edit-mesing"  placeholder="MM"   min="1" max="12">
              <span>/</span>
              <input type="number" id="edit-anioing" placeholder="AAAA" min="1900" max="2100">
            </div>
          </div>
          <div class="demo-item">
            <label>Fecha de elaboración</label>
            <div class="input-group">
              <input type="number" id="edit-diaelab"  placeholder="DD"   min="1" max="31">
              <span>/</span>
              <input type="number" id="edit-meselab"  placeholder="MM"   min="1" max="12">
              <span>/</span>
              <input type="number" id="edit-anioelab" placeholder="AAAA" min="1900" max="2100">
            </div>
          </div>
          <div class="demo-item">
            <label>Fecha de vencimiento</label>
            <div class="input-group">
              <input type="number" id="edit-diaven"  placeholder="DD"   min="1" max="31">
              <span>/</span>
              <input type="number" id="edit-mesven"  placeholder="MM"   min="1" max="12">
              <span>/</span>
              <input type="number" id="edit-anioven" placeholder="AAAA" min="1900" max="2100">
            </div>
          </div>
        </div>

        <button type="button" id="btn-guardar-edicion" class="btn-submit">Guardar cambios</button>
      </form>
    </div>
  </div>

  <script src="membrecia2.0.js"></script>
</body>
</html>