document.addEventListener("DOMContentLoaded", () => {
    const formEditar = document.getElementById("formEditarMoto");

    formEditar.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(formEditar);

        const response = await fetch("../crud/editarmoto.php", {
            method: "POST",
            body: formData
        });

        const result = await response.json(); // Cambiamos a .json() para trabajar con la respuesta en formato JSON

        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Motocicleta actualizado!',
                text: result.message,  // Usamos el mensaje del JSON
                timer: 2000,
                showConfirmButton: false
            });

            // Cierra el modal
            const modal = bootstrap.Modal.getInstance(document.getElementById("editarMotoModal"));
            modal.hide();

            // Actualiza la tabla de clientes
            cargarClientes(); // <-- Función que ya usas para llenar la tabla dinámicamente
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: result.message  // Mostramos el mensaje de error si algo falla
            });
        }
    });
});
