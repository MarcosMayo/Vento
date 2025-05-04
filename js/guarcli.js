document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formAgregarCliente');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        try {
            const response = await fetch('../crud/guardarcliente.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (response.ok && data.status === 'ok') {
                Swal.fire({
                    icon: 'success',
                    title: '¡Cliente guardado!',
                    text: `${data.mensaje} (Folio: ${data.folio})`,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Cerrar modal, limpiar formulario y recargar tabla
                    bootstrap.Modal.getInstance(document.getElementById('agregarClienteModal')).hide();
                    form.reset();
                    cargarClientes(); // Asegúrate que esta función exista
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error al guardar',
                    text: data.mensaje || 'Ocurrió un error desconocido'
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
