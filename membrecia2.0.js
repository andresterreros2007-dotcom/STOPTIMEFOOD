
const PHP = "almacenista.php";

document.addEventListener("DOMContentLoaded", cargarTabla);

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

    if (!categoria || !producto) {
        Swal.fire("Error", "Completa la categoría y el producto", "warning"); return;
    }
    if (!diaIngreso || !mesIngreso || !anioIngreso) {
        Swal.fire("Error", "Completa la fecha de ingreso", "warning"); return;
    }
    if (!diaElab || !mesElab || !anioElab) {
        Swal.fire("Error", "Completa la fecha de elaboración", "warning"); return;
    }
    if (!diaVenci || !mesVenci || !anioVenci) {
        Swal.fire("Error", "Completa la fecha de vencimiento", "warning"); return;
    }

    // ===== VALIDACIÓN FECHAS INSERTAR =====
    const fechaIngreso = new Date(anioIngreso, mesIngreso - 1, diaIngreso);
    const fechaElab    = new Date(anioElab, mesElab - 1, diaElab);
    const fechaVenc    = new Date(anioVenci, mesVenci - 1, diaVenci);

    if (fechaIngreso.getDate() != diaIngreso || fechaIngreso.getMonth() != mesIngreso - 1 || fechaIngreso.getFullYear() != anioIngreso) {
        Swal.fire("Fecha inválida", "La fecha de ingreso no existe", "warning"); return;
    }
    if (fechaElab.getDate() != diaElab || fechaElab.getMonth() != mesElab - 1 || fechaElab.getFullYear() != anioElab) {
        Swal.fire("Fecha inválida", "La fecha de elaboración no existe", "warning"); return;
    }
    if (fechaVenc.getDate() != diaVenci || fechaVenc.getMonth() != mesVenci - 1 || fechaVenc.getFullYear() != anioVenci) {
        Swal.fire("Fecha inválida", "La fecha de vencimiento no existe", "warning"); return;
    }
    if (fechaElab > fechaIngreso) {
        Swal.fire("Error de fechas", "La fecha de elaboración no puede ser posterior a la fecha de ingreso.", "warning"); return;
    }
    if (fechaVenc <= fechaElab) {
        Swal.fire("Error de fechas", "La fecha de vencimiento debe ser posterior a la fecha de elaboración.", "warning"); return;
    }

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

        let estiloVenc = "";
        if (diasRestantes < 0)       estiloVenc = 'style="color:#c0392b;font-weight:600"'; // vencido
        else if (diasRestantes <= 7) estiloVenc = 'style="color:#e67e22;font-weight:600"'; // por vencer
        else                         estiloVenc = 'style="color:#1a6b4a"';                 // ok

        const fila = document.createElement("tr");
        fila.innerHTML = `
            <td style="color:#6b7a74;font-size:0.8rem">#${p.id}</td>
            <td><span class="pill-cat">${p.categoria}</span></td>
            <td style="font-weight:500">${p.producto}</td>
            <td style="color:#6b7a74">${p.fecha_ing}</td>
            <td style="color:#6b7a74">${p.fecha_elab}</td>
            <td ${estiloVenc}>${p.fecha_venc}</td>
            <td>
                <button class="btn-action btn-edit" onclick="abrirModal('${p.id}','${p.categoria.replace(/'/g, "\\'")}','${p.producto.replace(/'/g, "\\'")}','${p.fecha_ing}','${p.fecha_elab}','${p.fecha_venc}')">✏️</button>
                <button class="btn-action btn-delete" onclick="eliminarProducto(${p.id})">🗑️</button>
            </td>
        `;
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

// ===================== INTERFAZ MODAL (CUADRO SECUNDARIO) =====================
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

    // ===== VALIDACIÓN FECHAS EDICIÓN =====
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
        Swal.fire("Error de fechas", "La fecha de elaboración no puede ser posterior a la fecha de ingreso.", "warning"); return;
    }
    if (fechaVencEdit <= fechaElabEdit) {
        Swal.fire("Error de fechas", "La fecha de vencimiento debe ser posterior a la fecha de elaboración.", "warning"); return;
    }
   
    const datos = new FormData();
    datos.append("editar",      "1");