document.addEventListener("DOMContentLoaded", () => {
    const formEditar = document.getElementById("formEditarEmpleado");

    formEditar.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(formEditar);

        try {
            const response = await fetch("../crud/editarempleado.php", {
                method: "POST",
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Empleado actualizado!',
                    text: result.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                const modal = bootstrap.Modal.getInstance(document.getElementById("editarEmpleadoModal"));
                modal.hide();

                // Recargar empleados
                cargarEmpleados(); // Asegúrate de que esta función exista
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error de red',
                text: 'No se pudo conectar con el servidor.'
            });
        }
    });
});