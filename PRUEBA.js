document.addEventListener("DOMContentLoaded", function () {
   
    const formulario = document.querySelector(".contact-form");

    if (formulario) {
        formulario.addEventListener("submit", function (e) {
            e.preventDefault();

          
            const nombre = document.getElementById("nombre").value.trim();
            const apellido = document.getElementById("apellido").value.trim();
            const email = document.getElementById("email").value.trim();
            const ciudad = document.getElementById("ciudad").value.trim(); 

            
            if (!nombre || !apellido || !email || !ciudad) {
                Swal.fire({
                    title: "Ops..",
                    text: "Por favor, rellena todos los campos.",
                    icon: "error",
                    confirmButtonColor: "#1a1a1a"
                });
                return; 
            }

            
            Swal.fire({
                title: "¡Información enviada!",
                text: "Nos pondremos en contacto contigo pronto.",
                icon: "success",
                confirmButtonColor: "#1a1a1a"
            });

            formulario.reset(); 
        });
    }
});