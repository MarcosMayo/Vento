document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formAgregarUsuario");

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        try {
            const res = await fetch("../crud/guardarusuario.php", {
                method: "POST",
                body: formData
            });

            const data = await res.json();

            if (data.success) {
                Swal.fire({
                    icon: "success",
                    title: "Usuario agregado",
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                // Cierra el modal
                const modal = bootstrap.Modal.getInstance(document.getElementById("agregarUsuarioModal"));
                modal.hide();

                // Limpia el formulario
                form.reset();

                // Recarga los datos de la tabla
                cargarUsuarios();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.message
                });
            }
        } catch (error) {
            console.error("Error en la petición:", error);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Ocurrió un error al procesar la solicitud."
            });
        }
    });
});
