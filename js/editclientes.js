
document.getElementById('btnConfirmarEdicion').addEventListener('click', async () => {
    const form = document.getElementById('formEditarCliente');
    const formData = new FormData(form);

    try {
        const response = await fetch('../crud/editarcliente.php', {
            method: 'POST',
            body: formData
        });

        const text = await response.text();

        if (response.ok && text.includes("exitosamente")) {
            // Mostrar alerta de Bootstrap
            const alerta = document.createElement('div');
            alerta.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
            alerta.style.zIndex = '1055';
            alerta.role = 'alert';
            alerta.innerHTML = `
                Cliente actualizado exitosamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            document.body.appendChild(alerta);

            // Cerrar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editarClienteModal'));
            modal.hide();

            // Redirigir después de 2 segundos
            setTimeout(() => {
                window.location.href = '../vistas/clientes.php'; // Cambia según tu vista
            }, 2000);
        } else {
            alert('Error: ' + text);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Ocurrió un error al actualizar el cliente.');
    }
});

