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
            background: #101010;
        }
        
        /* Contenedor de botones de pestañas */
        .tabs-container {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            border-bottom: 2px solid #222;
            padding-bottom: 10px;
        }
        .tab-btn {
            background: #151515;
            color: #888;
            border: 1px solid #252525;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        .tab-btn:hover {
            color: #fff;
            background: #202020;
        }
        .tab-btn.active {
            background: #e11d48;
            color: #fff;
            border-color: #e11d48;
        }

        /* Control de visibilidad de las pestañas */
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }

        /* Estilos de las tarjetas de notificación */
        .notif-card {
            background: #141414;
            border-left: 4px solid #fff;
            padding: 12px 16px;
            margin-bottom: 10px;
            border-radius: 0 6px 6px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .notif-critica { border-left-color: #c0392b; }
        .notif-advertencia { border-left-color: #e67e22; }

        /* ===================== ESTILOS DEL CUADRO SECUNDARIO (MODAL) ===================== */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            display: none; /* Cambia a flex mediante JavaScript */
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .modal-content {
            background: #151515;
            border: 1px solid #252525;
            padding: 25px;
            border-radius: 12px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            position: relative;
            animation: aparecerModal 0.3s ease;
        }
        @keyframes aparecerModal {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 1.5rem;
            color: #6b7a74;
            cursor: pointer;
            transition: color 0.2s;
        }
        .close:hover { color: #e11d48; }
        .modal-content h2 { font-size: 1.2rem; margin-bottom: 15px; color: #fff; font-weight: 600; }
        .modal-content label { display: block; font-size: 0.85rem; color: #888; margin-top: 10px; margin-bottom: 4px; }
        .modal-content input[type="text"] {
            width: 100%; padding: 8px 12px; background: #202020; border: 1px solid #303030; color: #fff; border-radius: 6px; box-sizing: border-box;
        }
        .modal-content fieldset { border: 1px solid #252525; border-radius: 6px; padding: 10px 12px; margin-top: 12px; }
        .modal-content legend { font-size: 0.75rem; color: #e11d48; padding: 0 5px; font-weight: 600; }
        .modal-content fieldset input[type="number"] {
            background: #202020; border: 1px solid #303030; color: #fff; border-radius: 4px; text-align: center; padding: 6px;
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
        
        <div class="tabs-container">
            <button class="tab-btn active" onclick="cambiarPestaña('pestaña-sesiones')">🕒 Historial de Sesiones</button>
            <button class="tab-btn" onclick="cambiarPestaña('pestaña-inventario')">📦 Gestión de Inventario</button>
            <button class="tab-btn" onclick="cambiarPestaña('pestaña-notificaciones')">🔔 Historial de Alertas</button>
        </div>

        <div id="pestaña-sesiones" class="tab-content active">
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
        </div>

        <div id="pestaña-inventario" class="tab-content">
            <p class="titulo-principal">Control Maestro de Productos</p>
            <div class="demo-box">
                <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 6px;">Inventario Global (Almacén)</h2>
                <p style="color: var(--gris-texto); font-size: 0.82rem; margin-bottom: 20px;">
                    Panel de control total sobre los productos, alertas de vencimiento y modificaciones directas.
                </p>
                <table class="tabla-demo" style="box-shadow: none; border-radius: 8px;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Categoría</th>
                            <th>Producto</th>
                            <th>F. Ingreso</th>
                            <th>F. Elaboración</th>
                            <th>F. Vencimiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-inventario-body">
                        <tr>
                            <td colspan="7" class="vacio">Cargando productos del almacén...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="pestaña-notificaciones" class="tab-content">
            <p class="titulo-principal">Alertas Críticas del Sistema</p>
            <div class="demo-box">
                <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 6px;">Log de Alertas de Vencimiento</h2>
                <p style="color: var(--gris-texto); font-size: 0.82rem; margin-bottom: 20px;">
                    Notificaciones automáticas de alimentos que expiran en un plazo menor a 3 días o que ya se encuentran vencidos.
                </p>
                <div id="contenedor-notificaciones">
                    <p class="vacio">No hay notificaciones recientes.</p>
                </div>
            </div>
        </div>

        <button onclick="window.location.href='index.php?rol_real=Admin'" class="btn-submit" style="background: #222; margin-top: 10px;">
            Volver a la página principal
        </button>

    </div>

    <div id="modal-editar" class="modal">
        <div class="modal-content">
            <span id="cerrar-modal" class="close">&times;</span>
            <h2>Editar Producto (Admin)</h2>
            
            <input type="hidden" id="edit-id">
            
            <label>Categoría:</label>
            <input type="text" id="edit-categoria">
            
            <label>Producto:</label>
            <input type="text" id="edit-producto">
            
            <fieldset style="display: flex; gap: 8px; justify-content: space-between;">
                <legend>Fecha de Ingreso</legend>
                <input type="number" id="edit-diaing" placeholder="DD" style="width: 30%;">
                <input type="number" id="edit-mesing" placeholder="MM" style="width: 30%;">
                <input type="number" id="edit-anioing" placeholder="AAAA" style="width: 35%;">
            </fieldset>

            <fieldset style="display: flex; gap: 8px; justify-content: space-between;">
                <legend>Fecha de Elaboración</legend>
                <input type="number" id="edit-diaelab" placeholder="DD" style="width: 30%;">
                <input type="number" id="edit-meselab" placeholder="MM" style="width: 30%;">
                <input type="number" id="edit-anioelab" placeholder="AAAA" style="width: 35%;">
            </fieldset>

            <fieldset style="display: flex; gap: 8px; justify-content: space-between;">
                <legend>Fecha de Vencimiento</legend>
                <input type="number" id="edit-diaven" placeholder="DD" style="width: 30%;">
                <input type="number" id="edit-mesven" placeholder="MM" style="width: 30%;">
                <input type="number" id="edit-anioven" placeholder="AAAA" style="width: 35%;">
            </fieldset>

            <button id="btn-guardar-edicion" class="btn-submit" style="margin-top: 15px; width: 100%;">Guardar Cambios</button>
        </div>
    </div>

    <script>
        const PHP_ALMACEN = "almacenista.php"; 

        document.addEventListener("DOMContentLoaded", () => {
            // Cargas paralelas iniciales
            cargarHistorialSesiones();
            cargarTablaInventario();

            // Disparadores de cierre del cuadro secundario
            const cerrarBtn = document.getElementById("cerrar-modal");
            if (cerrarBtn) cerrarBtn.addEventListener("click", () => document.getElementById("modal-editar").style.display = "none");
            
            window.addEventListener("click", (e) => {
                if (e.target === document.getElementById("modal-editar")) document.getElementById("modal-editar").style.display = "none";
            });

            const guardarBtn = document.getElementById("btn-guardar-edicion");
            if (guardarBtn) guardarBtn.addEventListener("click", guardarEdicionAdmin);
        });

        // Cambio visual e interactivo de las 3 pestañas
        function cambiarPestaña(idPestaña) {
            document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(tb => tb.classList.remove('active'));
            document.getElementById(idPestaña).classList.add('active');
            const botonActivo = Array.from(document.querySelectorAll('.tab-btn')).find(btn => btn.getAttribute('onclick').includes(idPestaña));
            if (botonActivo) botonActivo.classList.add('active');
        }

        // Obtener historial de sesiones
        async function cargarHistorialSesiones() {
            try {
                const respuesta = await fetch("obtener_sesiones.php");
                if (!respuesta.ok) throw new Error(Error: ${respuesta.status});
                const datos = await respuesta.json();
                const tbody = document.getElementById("tabla-sesiones-body");
                tbody.innerHTML = ""; 

                if (datos.length === 0) {
                    tbody.innerHTML = <tr><td colspan="4" class="vacio">No hay registros de ingresos recientes.</td></tr>;
                    return;
                }

                datos.forEach(item => {
                    const fila = document.createElement("tr");
                    const tipoUsuario = (item.usuario || '').trim().toLowerCase();
                    let badgeHTML = tipoUsuario === 'admin' ? <span class="badge-admin">Administrador</span> : <span class="badge-alman">Almacenista</span>;

                    fila.innerHTML = `
                        <td style="font-weight: 500; color: var(--negro);">${item.nombre || 'Sin nombre'}</td>
                        <td style="color: var(--gris-texto);">${item.email || 'Sin correo'}</td>
                        <td>${badgeHTML}</td>
                        <td style="color: var(--gris-texto); font-variant-numeric: tabular-nums;">${item.fecha_ing || 'Sin fecha'}</td>
                    `;
                    tbody.appendChild(fila);
                });
            } catch (error) {
                console.error(error);
                document.getElementById("tabla-sesiones-body").innerHTML = <tr><td colspan="4" class="vacio" style="color: #c0392b;">Error de renderizado de auditoría.</td></tr>;
            }
        }

        // Obtener inventario general del almacén
        async function cargarTablaInventario() {
            try {
                const res = await fetch(${PHP_ALMACEN}?obtener=1);
                if (!res.ok) throw new Error(Error: ${res.status});
                const productos = await res.json();
                renderizarTablaInventario(productos);
                generarHistorialNotificaciones(productos);
            } catch (err) {
                console.error(err);
                document.getElementById("tabla-inventario-body").innerHTML = <tr><td colspan="7" class="vacio" style="color: #c0392b;">Error al conectar con el servicio de inventario.</td></tr>;
            }
        }

        // Renderizado dinámico de productos en la tabla con semaforización
        function renderizarTablaInventario(productos) {
            const tbody = document.getElementById("tabla-inventario-body");
            if (!tbody) return;
            tbody.innerHTML = "";

            if (productos.length === 0) {
                tbody.innerHTML = <tr><td colspan="7" class="vacio">No hay productos registrados en el almacén.</td></tr>;
                return;
            }

            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);

            productos.forEach(p => {
                const fechaVencDate = new Date(p.fecha_venc_raw);
                const diasRestantes = Math.ceil((fechaVencDate - hoy) / (1000 * 60 * 60 * 24));

                let estiloVenc = "";
                if (diasRestantes < 0) estiloVenc = 'style="color:#c0392b;font-weight:600"';
                else if (diasRestantes <= 7) estiloVenc = 'style="color:#e67e22;font-weight:600"';
                else estiloVenc = 'style="color:#1a6b4a"';

                const fila = document.createElement("tr");
                fila.innerHTML = `
                    <td style="color:#6b7a74;font-size:0.8rem">#${p.id}</td>
                    <td><span class="pill-cat">${p.categoria}</span></td>
                    <td style="font-weight:500">${p.producto}</td>
                    <td style="color:#6b7a74">${p.fecha_ing}</td>
                    <td style="color:#6b7a74">${p.fecha_elab}</td>
                    <td ${estiloVenc}>${p.fecha_venc}</td>
                    <td>
                        <button class="btn-action btn-edit" onclick="abrirModalAdmin('${p.id}', '${p.categoria.replace(/'/g, "\\'")}', '${p.producto.replace(/'/g, "\\'")}', '${p.fecha_ing}', '${p.fecha_elab}', '${p.fecha_venc}')">✏️</button>
                        <button class="btn-action btn-delete" onclick="eliminarProductoAdmin(${p.id})">🗑️</button>
                    </td>
                `;
                tbody.appendChild(fila);
            });
        }

        // Levantar cuadro secundario e inyectar valores correspondientes
        function abrirModalAdmin(id, cat, prod, fechaIng, fechaElab, fechaVenc) {
            const [diaI, mesI, anioI] = fechaIng.split("/");
            const [diaE, mesE, anioE] = fechaElab.split("/");
            const [diaV, mesV, anioV] = fechaVenc.split("/");

            document.getElementById("edit-id").value        = id;
            document.getElementById("edit-categoria").value = cat;
            document.getElementById("edit-producto").value  = prod;
            document.getElementById("edit-diaing").value    = diaI;
            document.getElementById("edit-mesing").value    = mesI;
            document.getElementById("edit-anioing").value   = anioI;
            document.getElementById("edit-diaelab").value   = diaE;
            document.getElementById("edit-meselab").value   = mesE;
            document.getElementById("edit-anioelab").value  = anioE;
            document.getElementById("edit-diaven").value    = diaV;
            document.getElementById("edit-mesven").value    = mesV;
            document.getElementById("edit-anioven").value   = anioV;

            document.getElementById("modal-editar").style.display = "flex";
        }

        // Eliminar producto por medio del archivo compartido
        async function eliminarProductoAdmin(id) {
            const conf = await Swal.fire({
                title: "¿Eliminar producto del sistema?",
                text: "Como Administrador, esta acción borrará permanentemente el registro.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            });
            if (!conf.isConfirmed) return;

            const datos = new FormData();
            datos.append("eliminar", "1");
            datos.append("id", id);

            try {
                const res = await fetch(PHP_ALMACEN, { method: "POST", body: datos });
                const json = await res.json();
                if (json.status === "ok") {
                    Swal.fire("Eliminado", "El producto fue removido con éxito.", "success");
                    cargarTablaInventario();
                } else {
                    Swal.fire("Error", json.mensaje, "error");
                }
            } catch (err) {
                Swal.fire("Error", "No se pudo procesar la solicitud en el servidor", "error");
            }
        }

        // Validar cronología de fechas y procesar persistencia de la edición
        async function guardarEdicionAdmin() {
            const id      = document.getElementById("edit-id").value;
            const cat     = document.getElementById("edit-categoria").value;
            const prod    = document.getElementById("edit-producto").value;
            const diaing  = document.getElementById("edit-diaing").value;
            const mesing  = document.getElementById("edit-mesing").value;
            const anioing = document.getElementById("edit-anioing").value;
            const diaelab = document.getElementById("edit-diaelab").value;
            const meselab = document.getElementById("edit-meselab").value;
            const anioelab= document.getElementById("edit-anioelab").value;
            const diaven  = document.getElementById("edit-diaven").value;
            const mesven  = document.getElementById("edit-mesven").value;
            const anioven = document.getElementById("edit-anioven").value;

            if (!cat || !prod || !diaing || !mesing || !anioing || !diaelab || !meselab || !anioelab || !diaven || !mesven || !anioven) {
                Swal.fire("Error", "Completa todos los campos", "warning"); return;
            }

            const fechaIngresoEdit = new Date(anioing, mesing - 1, diaing);
            const fechaElabEdit    = new Date(anioelab, meselab - 1, diaelab);
            const fechaVencEdit    = new Date(anioven, mesven - 1, diaven);

            if (fechaIngresoEdit.getDate() != diaing || fechaIngresoEdit.getMonth() != mesing - 1 || fechaIngresoEdit.getFullYear() != anioing) {
                Swal.fire("Fecha inválida", "La fecha de ingreso no existe.", "warning"); return;
            }
            if (fechaElabEdit.getDate() != diaelab || fechaElabEdit.getMonth() != meselab - 1 || fechaElabEdit.getFullYear() != anioelab) {
                Swal.fire("Fecha inválida", "La fecha de elaboración no existe.", "warning"); return;
            }
            if (fechaVencEdit.getDate() != diaven || fechaVencEdit.getMonth() != mesven - 1 || fechaVencEdit.getFullYear() != anioven) {
                Swal.fire("Fecha inválida", "La fecha de vencimiento no existe.", "warning"); return;
            }
            if (fechaElabEdit > fechaIngresoEdit) {
                Swal.fire("Error de fechas", "La fecha de elaboración no puede ser posterior a la de ingreso.", "warning"); return;
            }
            if (fechaVencEdit <= fechaElabEdit) {
                Swal.fire("Error de fechas", "La fecha de vencimiento debe ser posterior a la de elaboración.", "warning"); return;
            }
               
            const datos = new FormData();
            datos.append("editar",      "1");
            datos.append("id",          id);
            datos.append("categoria",   cat);
            datos.append("producto",    prod);
            datos.append("diaingreso",  diaing);
            datos.append("mesingreso",  mesing);
            datos.append("anioingreso", anioing);
            datos.append("diaelab",     diaelab);
            datos.append("meselabo",    meselab);
            datos.append("anioelab",    anioelab);
            datos.append("diavenci",    diaven);
            datos.append("mesvenci",    mesven);
            datos.append("aniovenci",   anioven);

            try {
                const res  = await fetch(PHP_ALMACEN, { method: "POST", body: datos });
                const json = await res.json();
                if (json.status === "ok") {
                    Swal.fire("Actualizado", "Registro modificado correctamente.", "success");
                    document.getElementById("modal-editar").style.display = "none";
                    cargarTablaInventario();
                } else {
                    Swal.fire("Error", json.mensaje, "error");
                }
            } catch (err) {
                Swal.fire("Error", "No se pudo conectar con el servidor", "error");
            }
        }

        // Pestaña 3: Generador automático de Alertas de Vencimiento
        function generarHistorialNotificaciones(productos) {
            const contenedor = document.getElementById("contenedor-notificaciones");
            if (!contenedor) return;
            contenedor.innerHTML = "";

            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);
            let alertasEmitidas = 0;

            productos.forEach(p => {
                const fechaVencDate = new Date(p.fecha_venc_raw);
                const diasRestantes = Math.ceil((fechaVencDate - hoy) / (1000 * 60 * 60 * 24));
                let cardHTML = "";

                if (diasRestantes < 0) {
                    alertasEmitidas++;
                    cardHTML = `
                        <div class="notif-card notif-critica">
                            <div>
                                <strong style="color: #c0392b;">🚨 CRÍTICO: Producto Vencido</strong>
                                <p style="margin: 4px 0 0 0; font-size:0.88rem; color:#eee;">El artículo <strong>${p.producto}</strong> (#${p.id}) de la categoría <em>${p.categoria}</em> expiró el ${p.fecha_venc}.</p>
                            </div>
                            <span style="font-size: 0.8rem; color:#888;">Hace ${Math.abs(diasRestantes)} días</span>
                        </div>`;
                } else if (diasRestantes <= 3) {
                    alertasEmitidas++;
                    cardHTML = `
                        <div class="notif-card notif-advertencia">
                            <div>
                                <strong style="color: #e67e22;">⚠️ ADVERTENCIA: Próximo a vencer</strong>
                                <p style="margin: 4px 0 0 0; font-size:0.88rem; color:#eee;">El artículo <strong>${p.producto}</strong> (#${p.id}) está a punto de caducar. Vence el ${p.fecha_venc}.</p>
                            </div>
                            <span style="font-size: 0.8rem; color:#e67e22; font-weight:600;">Quedan ${diasRestantes} días</span>
                        </div>`;
                }

                if (cardHTML !== "") {
                    contenedor.insertAdjacentHTML("beforeend", cardHTML);
                }
            });

            if (alertasEmitidas === 0) {
                contenedor.innerHTML = <p class="vacio" style="color: #1a6b4a;">✔️ No hay alertas de vencimiento críticas activas en este momento.</p>;
            }
        }
    </script>
</body>
</html>