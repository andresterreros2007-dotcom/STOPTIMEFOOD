// ======================
// SERVICE WORKER
// STOP TIMEFOOD
// ======================

// Instalar
self.addEventListener("install", (event) => {
    self.skipWaiting();
});

// Activar
self.addEventListener("activate", (event) => {
    event.waitUntil(self.clients.claim());
});

// Clic en la notificación
self.addEventListener("notificationclick", (event) => {

    // Cerrar la notificación
    event.notification.close();

    const id = event.notification.data?.id;

    // Si el navegador soporta botones, se procesa el botón "Aceptar".
    // Si no los soporta, un clic sobre la notificación también la acepta.
    if (event.action === "aceptar" || event.action === "") {

        event.waitUntil((async () => {

            try {

                if (id) {

                    const datos = new FormData();
                    datos.append("accion", "aceptar_notificacion");
                    datos.append("id", id);

                    await fetch("almacenista.php", {
                        method: "POST",
                        body: datos
                    });

                }

            } catch (error) {

                console.error("Error en notificationclick:", error);

            }

        })());

    }

});