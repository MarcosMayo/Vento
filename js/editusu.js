document.addEventListener("DOMContentLoaded", () => {
    const formEditar = document.getElementById("formEditarUsuario");

    formEditar.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(formEditar);

        try {
            const response = await fetch("../crud/editarusuario.php", {
                method: "POST",
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Actualizado!',
                    text: result.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                // Cierra el modal
                const modal = bootstrap.Modal.getInstance(document.getElementById("editarUsuarioModal"));
                modal.hide();

                // Limpia y recarga la tabla
                formEditar.reset();
                cargarUsuarios(); // Esta función está definida en usuarios.js
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message
                });
            }

        } catch (error) {
            console.error("Error en la petición:", error);
            Swal.fire("Error", "No se pudo editar el usuario.", "error");
        }
    });
});
