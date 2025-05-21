
document.getElementById('formOrdenTrabajo').addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData();

  const id_motocicleta = document.getElementById('motocicleta').value;
  const id_servicio = document.getElementById('servicio_id').value;
  const id_empleado = document.getElementById('empleado').value;
  const fecha = document.getElementById('fecha').value;
  const estatus = document.getElementById('estatus').value;
  const mano_obra = parseFloat(document.getElementById('manoObraOrden').value) || 0;

  const refacciones = [];

  document.querySelectorAll('#tablaRefaccionesOrden tr').forEach(fila => {
    const id_refaccion = fila.querySelector('.refaccion-id')?.value || 0;
    const cantidad = parseFloat(fila.querySelector('.cantidad')?.value) || 0;
    const precio = parseFloat(fila.querySelector('.precio')?.value) || 0;

    if (id_refaccion > 0 && cantidad > 0 && precio >= 0) {
      refacciones.push({ id_refaccion, cantidad, precio });
    }
  });

  if (refacciones.length === 0) {
    Swal.fire('Atención', 'Debes incluir al menos una refacción válida.', 'warning');
    return;
  }

  formData.append('motocicleta', id_motocicleta);
  formData.append('servicio', id_servicio);
  formData.append('empleado', id_empleado);
  formData.append('fecha', fecha);
  formData.append('estatus', estatus);
  formData.append('mano_obra', mano_obra);
  formData.append('refacciones', JSON.stringify(refacciones));

  fetch('../crud/guardar_orden.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        Swal.fire('Éxito', 'Orden de trabajo guardada correctamente', 'success');
        form.reset();
        document.getElementById('tablaRefaccionesOrden').innerHTML = '';
        document.getElementById('subtotalRefOrden').value = '';
        document.getElementById('totalFinalOrden').value = '';
      } else {
        Swal.fire('Error', data.message || 'Error al guardar la orden', 'error');
      }
    })
    .catch(err => {
      console.error(err);
      Swal.fire('Error', 'No se pudo enviar la orden', 'error');
    });
});
