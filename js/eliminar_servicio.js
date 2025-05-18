
function eliminarServicio(id) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: 'Esta acción eliminará el servicio y sus refacciones asociadas.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append('id', id);

      fetch('../crud/eliminarservicio.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          Swal.fire('Eliminado', 'El servicio ha sido eliminado.', 'success');
          cargarServicios(); // Refrescar tabla
        } else {
          Swal.fire('Error', data.message || 'No se pudo eliminar el servicio.', 'error');
        }
      })
      .catch(err => {
        console.error(err);
        Swal.fire('Error', 'Error al intentar eliminar el servicio.', 'error');
      });
    }
  });
}
