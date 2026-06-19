document.addEventListener("DOMContentLoaded", function () {

    const form = document.querySelector(".form-card");

    // ── MOSTRAR / OCULTAR CONTRASEÑA ──
    window.togglePwd = function (inputId, btn) {
        const input = document.getElementById(inputId);
        const esTexto = input.type === "text";
        input.type = esTexto ? "password" : "text";
        btn.textContent = esTexto ? "👁" : "🙈";
    };

    // ── VALIDACIÓN EN TIEMPO REAL ──
    const reglas = {
        nombre:              v => v.trim().length >= 2,
        apellido:            v => v.trim().length >= 2,
        email:               v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v),
        Contrasenia:         v => v.length >= 6,
        verificarcontrasenia:v => v === document.getElementById("Contrasenia").value,
        restaurante:         v => v.trim().length >= 2,
        usuario:             v => v !== "",
    };

    const mensajes = {
        nombre:              "Mínimo 2 caracteres",
        apellido:            "Mínimo 2 caracteres",
        email:               "Correo inválido",
        Contrasenia:         "Mínimo 6 caracteres",
        verificarcontrasenia:"Las contraseñas no coinciden",
        restaurante:         "Ingrese el nombre del restaurante",
        usuario:             "Seleccione un rol",
    };

    // Validar campo individual
    function validarCampo(campo) {
        const input = form.querySelector(`[name="${campo}"]`);
        if (!input) return true;
        const ok  = reglas[campo](input.value);
        const msg = input.closest(".campo")?.querySelector(".msg-error");
        if (msg) msg.classList.toggle("visible", !ok);
        input.classList.toggle("error", !ok);
        return ok;
    }

    // Escuchar cambios en cada campo
    Object.keys(reglas).forEach(campo => {
        const input = form.querySelector(`[name="${campo}"]`);
        if (input) {
            input.addEventListener("blur",  () => validarCampo(campo));
            input.addEventListener("input", () => validarCampo(campo));
        }
    });

    // ── SUBMIT ──
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const todosValidos = Object.keys(reglas).map(validarCampo).every(Boolean);

        if (!todosValidos) {
            Swal.fire({
                icon: "warning",
                title: "Campos incompletos",
                text: "Revisa los campos marcados en rojo.",
                confirmButtonColor: "#1a6b4a"
            });
            return;
        }

        // Si todo está bien, enviar el formulario al PHP
        Swal.fire({
            icon: "success",
            title: "Registrando...",
            text: "Un momento por favor.",
            timer: 1500,
            showConfirmButton: false,
            confirmButtonColor: "#1a6b4a"
        }).then(() => {
            form.submit();
        });
    });
});