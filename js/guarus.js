document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formAgregarUsuario");

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const pass = form.pass.value.trim();
        const confirmar = form.confirmar.value.trim();

        if (pass !== confirmar) {
            Swal.fire("Error", "Las contraseñas no coinciden", "error");
            return;
        }

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

                // Cierra el modal y limpia
                const modal = bootstrap.Modal.getInstance(document.getElementById("agregarUsuarioModal"));
                modal.hide();
                form.reset();

                // Recarga tabla
                cargarUsuarios();
            } else {
                Swal.fire("Error", data.message, "error");
            }
        } catch (error) {
            console.error("Error:", error);
            Swal.fire("Error", "Ocurrió un error al procesar la solicitud.", "error");
        }
    });
});
