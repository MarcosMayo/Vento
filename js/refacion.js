document.getElementById('formAgregarRefaccion').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    try {
        const response = await fetch('../crud/guardar_refaccion.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: result.message,
                timer: 2000,
                showConfirmButton: false
            });

            form.reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('agregarRefaccionModal'));
            modal.hide();

            cargarRefacciones(); // Llama a tu función para recargar la tabla
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
            title: 'Error inesperado',
            text: 'Ocurrió un error al intentar guardar la refacción.'
        });
        console.error(error);
    }
});



document.getElementById('formEditarRefaccion').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    try {
        const response = await fetch('../crud/editar_refaccion.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });

            form.reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('editarRefaccionModal'));
            modal.hide();

            // Recargar tabla o lista de refacciones (supón que tienes esta función)
            cargarRefacciones();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error de red',
            text: 'No se pudo conectar con el servidor'
        });
        console.error(error);
    }
});
function eliminarRefaccion(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../crud/eliminar_refaccion.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id_refaccion=${encodeURIComponent(id)}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('¡Eliminado!', data.message, 'success');
                    cargarRefacciones(); // Recarga la lista después de eliminar
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(() => Swal.fire('Error', 'Error en la conexión', 'error'));
        }
    });
}
