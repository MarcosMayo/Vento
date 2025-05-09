async function eliminarMoto(idMoto) {
    // Confirmación antes de eliminar
    const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '¡Sí, eliminar!',
        cancelButtonText: 'Cancelar'
    });

    if (result.isConfirmed) {
        // Enviar la solicitud de eliminación
        const response = await fetch('../crud/eliminarmoto.php', {
            method: 'POST',
            body: new URLSearchParams({ 'id_moto': idMoto })
        });

        const resultJson = await response.json();

        if (resultJson.success) {
            Swal.fire(
                '¡Eliminado!',
                resultJson.message,
                'success'
            );
            cargarMotos(currentPageMotos, searchInputMotos.value); // Actualiza la tabla
        } else {
            Swal.fire(
                'Error',
                resultJson.message,
                'error'
            );
        }
    }
}
