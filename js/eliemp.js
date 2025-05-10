function eliminarEmpleado(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará permanentemente al empleado.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        console.log('Resultado del Swal:', result);

        if (result.isConfirmed) {
            const response = await fetch('../crud/eliminarempleado.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}`
            });

            const data = await response.json();
            console.log('Respuesta del servidor:', data);

            if (data.status === 'ok') {
                Swal.fire('Eliminado', 'Empleado eliminado correctamente.', 'success');
                cargarEmpleados(); // Asegúrate de tener esta función implementada
            } else {
                Swal.fire('Error', data.mensaje || 'No se pudo eliminar el empleado.', 'error');
            }
        } else {
            console.log('Eliminación cancelada');
        }
    });
}
