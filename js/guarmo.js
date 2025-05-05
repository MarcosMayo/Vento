document.getElementById('formMoto').addEventListener('submit', async (event) => {
    event.preventDefault(); // Evita el envío normal del formulario

    const formData = new FormData(event.target);

    const response = await fetch('../crud/guardarmoto.php', {
        method: 'POST',
        body: formData
    });

    const data = await response.json();

    if (data.success) {
        Swal.fire('Éxito', data.message, 'success');
        $('#agregarMotoModal').modal('hide');
        cargarMotos(currentPageMotos, searchInputMotos.value); // Recargar la tabla de motos
    } else {
        Swal.fire('Error', data.message, 'error');
    }
});
