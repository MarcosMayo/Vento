function eliminarCliente(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará permanentemente al cliente.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        console.log('Resultado del Swal:', result);  // Para verificar el resultado de la confirmación

        if (result.isConfirmed) {
            const response = await fetch('../crud/eliminarcliente.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id_cliente=${id}`
            });

            const data = await response.json();
            console.log('Respuesta del servidor:', data);  // Verifica lo que responde el servidor

            if (data.success) {
                Swal.fire('Eliminado', data.message, 'success');
                cargarClientes(currentPageClientes, searchInputClientes.value); // Recargar tabla
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        } else {
            console.log('Eliminación cancelada');  // Para verificar si se canceló
        }
    });
}

