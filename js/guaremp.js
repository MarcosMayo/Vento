document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formAgregarEmpleado');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        try {
            const response = await fetch('../crud/guarempleado.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (response.ok && data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Empleado guardado!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                // Cerrar el modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('agregarEmpleadoModal'));
                modal.hide();

                // Limpiar el formulario
                form.reset();

                // Recargar tabla de empleados
                cargarEmpleados(); // Asegúrate de tener esta función definida
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error al guardar',
                    text: data.message || 'Ocurrió un error desconocido'
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
