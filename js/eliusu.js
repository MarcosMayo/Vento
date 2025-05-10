function eliminarUsuario(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará permanentemente al usuario.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const response = await fetch('../crud/eliminarusuario.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}`
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire('Eliminado', data.message, 'success');
                cargarUsuarios(currentPageUsuarios, searchInputUsuarios.value); // Recargar tabla
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        }
    });
}
