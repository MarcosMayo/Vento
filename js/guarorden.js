document.getElementById('formOrdenTrabajo').addEventListener('submit', function(e) {
    e.preventDefault();

    // Validación opcional aquí

    const formData = new FormData(this);

    fetch('guardar_orden_trabajo.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Orden guardada correctamente');
            location.reload();
        } else {
            alert('Error al guardar la orden');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error al enviar los datos.');
    });
});
