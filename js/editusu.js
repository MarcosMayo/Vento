document.addEventListener("DOMContentLoaded", () => {
    const formEditar = document.getElementById("formEditarUsuario");

    formEditar.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(formEditar);

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

            // Actualiza la tabla de usuarios
            cargarUsuarios(); // <-- función que ya usas para llenar la tabla dinámicamente
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: result.message
            });
        }
    });
});
