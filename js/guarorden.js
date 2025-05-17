document.getElementById('formOrdenTrabajo').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    // === ARMA REFACCIONES Y TOTAL ===
    let listaRefacciones = [];
    let filas = document.querySelectorAll('#tbodyRefacciones tr');

    filas.forEach(fila => {
        const nombreRefaccion = fila.querySelector('input[name="refaccion[]"]')?.value || '';
        const cantidad = fila.querySelector('input[name="cantidad[]"]')?.value || '';
        const precioUnitario = fila.querySelector('input[name="precio[]"]')?.value || '';

        if (nombreRefaccion && cantidad && precioUnitario) {
            listaRefacciones.push({
                nombre_refaccion: nombreRefaccion,
                cantidad: parseFloat(cantidad),
                precio_unitario: parseFloat(precioUnitario)
            });
        }
    });

    // === TOTAL FINAL ===
    const totalFinalTexto = document.getElementById('totalFinal')?.textContent.replace('$', '').trim();
    const totalFinal = parseFloat(totalFinalTexto) || 0;

    formData.append('refacciones', JSON.stringify(listaRefacciones));
    formData.append('totalFinal', totalFinal);
    console.log("Refacciones a enviar:", listaRefacciones);
console.log("Total Final:", totalFinal);


    // === ENVÍA AL PHP ===
    fetch('../crud/guardar_orden_trabajo.php', {
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
