document.getElementById('formAgregarCliente').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    try {
        const response = await fetch('../crud/guardarcliente.php', {
            method: 'POST',
            body: formData
        });

        const text = await response.text();

        if (response.ok && text.includes('Cliente guardado exitosamente')) {
            Swal.fire({
                icon: 'success',
                title: 'Cliente registrado',
                text: text,
                confirmButtonText: 'Aceptar'
            }).then(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('agregarClienteModal'));
                modal.hide();
                form.reset();
                location.reload(); // recarga tabla o lista actual
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: text,
                confirmButtonText: 'Cerrar'
            });
        }

    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error de red',
            text: 'No se pudo conectar con el servidor.',
            confirmButtonText: 'Cerrar'
        });
    }
});

