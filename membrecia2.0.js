const PHP = "almacenista.php";

document.addEventListener("DOMContentLoaded", cargarTabla);

// ===================== FUNCIÓN AUXILIAR: VALIDACIÓN DE FECHAS =====================
function validarFechas(dia, mes, anio, tipoNombre) {
    const fecha = new Date(anio, mes - 1, dia);
    if (fecha.getDate() != dia || fecha.getMonth() != mes - 1 || fecha.getFullYear() != anio) {
        Swal.fire("Fecha inválida", `La fecha de ${tipoNombre} no existe`, "warning");
        return null;
    }
    return fecha;
}

function verificarLogicaFechas(fIngreso, fElab, fVenc) {
    if (fElab > fIngreso) {
        Swal.fire("Error de fechas", "La fecha de elaboración no puede ser posterior a la fecha de ingreso.", "warning"); 
        return false;
    }
    if (fVenc <= fElab) {
        Swal.fire("Error de fechas", "La fecha de vencimiento debe ser posterior a la fecha de elaboración.", "warning"); 
        return false;
    }
    return true;
}

// ===================== INSERTAR PRODUCTO =====================
document.getElementById("form-producto").addEventListener("submit", async function (e) {
    e.preventDefault();

    const categoria  = document.getElementById("categoria").value;
    const producto   = document.getElementById("producto").value;
    const diaIngreso = document.getElementById("diaIngreso").value;
    const mesIngreso = document.getElementById("mesIngreso").value;
    const anioIngreso= document.getElementById("anioIngreso").value;
    const diaElab    = document.getElementById("diaElab").value;
    const mesElab    = document.getElementById("mesElab").value;
    const anioElab   = document.getElementById("anioElab").value;
    const diaVenci   = document.getElementById("diaVencimiento").value;
    const mesVenci   = document.getElementById("mesVencimiento").value;
    const anioVenci  = document.getElementById("anioVencimiento").value;

    if (!categoria || !producto || !diaIngreso || !mesIngreso || !anioIngreso || !diaElab || !mesElab || !anioElab || !diaVenci || !mesVenci || !anioVenci) {
        Swal.fire("Error", "Completa todos los campos obligatorios", "warning"); return;
    }

    // Validar existencias de fechas individuales
    const fIngreso = validarFechas(diaIngreso, mesIngreso, anioIngreso, "ingreso");
    if (!fIngreso) return;
    const fElab = validarFechas(diaElab, mesElab, anioElab, "elaboración");
    if (!fElab) return;
    const fVenc = validarFechas(diaVenci, mesVenci, anioVenci, "vencimiento");
    if (!fVenc) return;

    // Validar coherencia lógica entre ellas
    if (!verificarLogicaFechas(fIngreso, fElab, fVenc)) return;

    const datos = new FormData();
    datos.append("insertar",    "1");
    datos.append("categoria",   categoria);
    datos.append("producto",    producto);
    datos.append("diaingreso",  diaIngreso);
    datos.append("mesingreso",  mesIngreso);
    datos.append("anioingreso", anioIngreso);
    datos.append("diaelab",     diaElab);
    datos.append("meselabo",    mesElab);
    datos.append("anioelab",    anioElab);
    datos.append("diavenci",    diaVenci);
    datos.append("mesvenci",    mesVenci);
    datos.append("aniovenci",   anioVenci);

    try {
        const res  = await fetch(PHP, { method: "POST", body: datos });
        const json = await res.json();
        if (json.status === "ok") {
            Swal.fire("Guardado", json.mensaje, "success");
            document.getElementById("form-producto").reset();
            cargarTabla();
        } else {
            Swal.fire("Error en BD", json.mensaje, "error");
        }
    } catch (err) {
        Swal.fire("Error", "No se pudo conectar con el servidor", "error");
    }
});

// ===================== CARGAR TABLA =====================
async function cargarTabla() {
    try {
        const res       = await fetch(`${PHP}?obtener=1`);
        const productos = await res.json();
        renderizarTabla(productos);
    } catch (err) {
        console.error("Error al cargar productos:", err);
    }
}

// ===================== RENDERIZAR TABLA =====================
function renderizarTabla(productos) {
    const tbody = document.getElementById("tabla-body");
    if (!tbody) return;
    tbody.innerHTML = "";

    if (productos.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7" class="vacio">No hay productos registrados</td></tr>`;
        return;
    }

    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0);

    productos.forEach(p => {

        const fechaVencDate = new Date(p.fecha_venc_raw);
        const diasRestantes = Math.ceil((fechaVencDate - hoy) / (1000 * 60 * 60 * 24));

        // ===================== GENERAR ALERTAS =====================
        if (diasRestantes < 0) {

            dispararNotificacion(
                p.id,
                "Producto vencido",
                `El producto "${p.producto}" venció el ${p.fecha_venc}.`
            );

        } else if (diasRestantes <= 7) {

            dispararNotificacion(
                p.id,
                "Próximo a vencer",
                `El producto "${p.producto}" vence el ${p.fecha_venc}.`
            );

        }
        // ==========================================================

        let estiloVenc = "";

        if (diasRestantes < 0)
            estiloVenc = 'style="color:#c0392b;font-weight:600"';
        else if (diasRestantes <= 7)
            estiloVenc = 'style="color:#e67e22;font-weight:600"';
        else
            estiloVenc = 'style="color:#1a6b4a"';

        const fila = document.createElement("tr");

        fila.innerHTML = `
            <td style="color:#6b7a74;font-size:0.8rem">#${p.id}</td>
            <td><span class="pill-cat">${p.categoria}</span></td>
            <td style="font-weight:500" class="prod-nombre"></td>
            <td style="color:#6b7a74">${p.fecha_ing}</td>
            <td style="color:#6b7a74">${p.fecha_elab}</td>
            <td ${estiloVenc}>${p.fecha_venc}</td>
            <td>
                <button class="btn-action btn-edit">✏️</button>
                <button class="btn-action btn-delete">🗑️</button>
            </td>
        `;

        fila.querySelector(".prod-nombre").textContent = p.producto;

        fila.querySelector(".btn-edit").addEventListener("click", () => {
            abrirModal(
                p.id,
                p.categoria,
                p.producto,
                p.fecha_ing,
                p.fecha_elab,
                p.fecha_venc
            );
        });

        fila.querySelector(".btn-delete").addEventListener("click", () => {
            eliminarProducto(p.id);
        });

        tbody.appendChild(fila);

    });
}
// ===================== ELIMINAR PRODUCTO =====================
async function eliminarProducto(id) {
    const conf = await Swal.fire({
        title: "¿Eliminar producto?",
        text: "Esta acción no se puede deshacer",
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
        const res  = await fetch(PHP, { method: "POST", body: datos });
        const json = await res.json();
        if (json.status === "ok") {
            Swal.fire("Eliminado", "El producto fue eliminado", "success");
            cargarTabla();
        } else {
            Swal.fire("Error", json.mensaje, "error");
        }
    } catch (err) {
        Swal.fire("Error", "No se pudo conectar con el servidor", "error");
    }
}

// ===================== INTERFAZ MODAL =====================
function abrirModal(id, cat, prod, fechaIng, fechaElab, fechaVenc) {
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

document.getElementById("cerrar-modal").addEventListener("click", () => {
    document.getElementById("modal-editar").style.display = "none";
});

window.addEventListener("click", (e) => {
    if (e.target === document.getElementById("modal-editar"))
        document.getElementById("modal-editar").style.display = "none";
});

// ===================== GUARDAR EDICIÓN =====================
document.getElementById("btn-guardar-edicion").addEventListener("click", async () => {
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

    // Validar existencias de fechas individuales (Reutilizando la función)
    const fIngresoEdit = validarFechas(diaing, mesing, anioing, "ingreso");
    if (!fIngresoEdit) return;
    const fElabEdit = validarFechas(diaelab, meselab, anioelab, "elaboración");
    if (!fElabEdit) return;
    const fVencEdit = validarFechas(diaven, mesven, anioven, "vencimiento");
    if (!fVencEdit) return;

    // Validar coherencia lógica
    if (!verificarLogicaFechas(fIngresoEdit, fElabEdit, fVencEdit)) return;

    const datos = new FormData();
    datos.append("editar",      "1");
    datos.append("id",          id);
    datos.append("categoria",   cat);
    datos.append("producto",    prod);
    datos.append("diaingreso",  diaing);
    datos.append("mesingreso",  mesing);
    datos.append("anioingreso", anioing);
    datos.append("diaelab",     diaelab);
    datos.append("meselabo",    meselab); // Mantiene coincidencia con el name original 'meselabo'
    datos.append("anioelab",    anioelab);
    datos.append("diavenci",    diaven);
    datos.append("mesvenci",    mesven);
    datos.append("aniovenci",   anioven);

    try {
        const res  = await fetch(PHP, { method: "POST", body: datos });
        const json = await res.json();
        if (json.status === "ok") {
            Swal.fire("Actualizado", "Producto modificado correctamente", "success");
            document.getElementById("modal-editar").style.display = "none";
            cargarTabla();
        } else {
            Swal.fire("Error", json.mensaje, "error");
        }
    } catch (err) {
        Swal.fire("Error", "No se pudo conectar con el servidor", "error");
    }
});
// =========================================================================
// =================== SISTEMA NATIVO DE NOTIFICACIONES ====================
// =========================================================================

// 1. Registrar el Service Worker al iniciar (Requisito para capturar clics en segundo plano)
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('sw.js')
    .then(reg => console.log('Service Worker registrado correctamente.', reg))
    .catch(err => console.error('Error al registrar el Service Worker:', err));
}
// 2. Pide permiso para mostrar notificaciones
document.addEventListener("DOMContentLoaded", () => {
    cargarTabla();

    if (Notification.permission !== "granted" &&
        Notification.permission !== "denied") {
        Notification.requestPermission();
    }
});

/**
 * 3. Función global para enviar una notificación a la Base de Datos
 * y dispararla inmediatamente a la bandeja de Windows.
 * @param {string} tipo - Ej: 'Producto vencido', 'Próximo a vencer'
 * @param {string} mensajeDetalle - Texto descriptivo de la notificación
 */
/**
 * Envía la notificación a la BD y luego la muestra en Windows.
 */
async function dispararNotificacion(idProducto, tipo, mensajeDetalle) {

    const datos = new FormData();
    datos.append("accion", "crear_notificacion");
    datos.append("id_producto", idProducto);
    datos.append("tipo", tipo);
    datos.append("mensaje", mensajeDetalle);

    try {

        const res = await fetch(PHP, {
            method: "POST",
            body: datos
        });

        const json = await res.json();

        if (json.status !== "ok") {
            console.error("Error al crear la notificación:", json.mensaje);
            return;
        }

        // Si ya existe una pendiente no vuelve a mostrarla
        if (json.duplicada) {
            return;
        }

        if (!("Notification" in window)) {
            return;
        }

        if (Notification.permission !== "granted") {
            return;
        }

        const reg = await navigator.serviceWorker.ready;

        await reg.showNotification(
            `STOP TIMEFOOD - ${tipo.toUpperCase()}`,
            {
                body: mensajeDetalle,
                icon: "logo.png",
                badge: "logo.png",
                requireInteraction: true,
                vibrate: [200,100,200],
                actions: [
                    {
                        action: "aceptar",
                        title: "Aceptar"
                    }
                ],
                data: {
                    id: json.id_notificacion
                }
            }
        );

    } catch (err) {
        console.error("Error al procesar la notificación:", err);
    }
}