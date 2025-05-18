
document.getElementById('formEditarServicio').addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);
  const refacciones = [];

  document.querySelectorAll('#tablaRefaccionesEditar tr').forEach(fila => {
    const id_refaccion = fila.querySelector('.refaccion-id').value;
    const cantidad = fila.querySelector('.cantidad').value;
    const precio = fila.querySelector('.precio').value;

    if (id_refaccion && cantidad && precio) {
      refacciones.push({ id_refaccion, cantidad, precio });
    }
  });

  formData.append('refacciones', JSON.stringify(refacciones));

  fetch('../crud/editar_servicio.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        Swal.fire('Éxito', 'Servicio actualizado correctamente', 'success');
        const modal = bootstrap.Modal.getInstance(document.getElementById('editarServicioModal'));
        modal.hide();
        form.reset();
        document.getElementById('tablaRefaccionesEditar').innerHTML = '';
        cargarServicios(); // Refrescar tabla
      } else {
        Swal.fire('Error', data.message || 'No se pudo actualizar', 'error');
      }
    })
    .catch(err => {
      console.error(err);
      Swal.fire('Error', 'Error al enviar los datos', 'error');
    });
});
