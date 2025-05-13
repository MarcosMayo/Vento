// Cuando el formulario se envía
document.getElementById('formServicio').addEventListener('submit', function (event) {
    event.preventDefault(); // Evita que el formulario se envíe de manera tradicional

    // Recoger los datos del servicio
    const nombreServicio = document.querySelector('input[name="nombre_servicio"]').value;
    const manoObra = parseFloat(document.querySelector('input[name="mano_obra"]').value) || 0;
    const descripcion = document.querySelector('textarea[name="descripcion"]').value;

    // Recoger los datos de las refacciones
    const refacciones = [];
    document.querySelectorAll('#tablaRefacciones tbody tr').forEach(fila => {
        const idRefaccion = fila.querySelector('.id-refaccion').value;
        const cantidad = parseFloat(fila.querySelector('.cantidad-refaccion').value) || 0;
        const precio = parseFloat(fila.querySelector('.precio-refaccion').value) || 0;
        const subtotal = parseFloat(fila.querySelector('.subtotal-refaccion').value) || 0;

        // Solo agregar refacciones que tienen id
        if (idRefaccion) {
            refacciones.push({
                id_refaccion: idRefaccion,
                cantidad: cantidad,
                precio: precio,
                subtotal: subtotal
            });
        }
    });

    // Enviar los datos al backend
    const formData = new FormData();
    formData.append('nombre_servicio', nombreServicio);
    formData.append('mano_obra', manoObra);
    formData.append('descripcion', descripcion);
    formData.append('refacciones', JSON.stringify(refacciones)); // Convertimos el array de refacciones a JSON
    

    // Usar fetch para enviar los datos
    fetch('../crud/guardarservicios.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
       if (data.status === 'ok') {
            Swal.fire('Éxito', 'Servicio guardado correctamente', 'success');
            // Aquí puedes hacer alguna acción después de guardar, como limpiar el formulario o recargar la tabla de servicios
        } else {
            Swal.fire('Error', 'Hubo un problema al guardar el servicio', 'error');
        }
    })
    .catch(error => {
        console.error('Error al guardar el servicio:', error);
        Swal.fire('Error', 'Hubo un problema al guardar el servicio', 'error');
    });
});



