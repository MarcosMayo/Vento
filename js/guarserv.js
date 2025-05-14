document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formServicio');
  const totalServicio = document.getElementById('totalServicio');

  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    const nombre = form.nombre_servicio.value.trim();
    const descripcion = form.descripcion.value.trim();
    const mano_obra = parseFloat(form.mano_obra.value) || 0;

    const refacciones = [];

    document.querySelectorAll('#tablaRefacciones tbody tr').forEach(fila => {
      const id_refaccion = fila.querySelector('.id-refaccion')?.value || 0;
      const cantidad = parseInt(fila.querySelector('.cantidad-refaccion')?.value) || 0;
      const precio = parseFloat(fila.querySelector('.precio-refaccion')?.value) || 0;

      if (cantidad > 0 && precio >= 0 && id_refaccion > 0) {
        refacciones.push({ id_refaccion, cantidad, precio });
      }
    });

    const datos = {
      nombre_servicio: nombre,
      descripcion: descripcion,
      mano_obra: mano_obra,
      refacciones: JSON.stringify(refacciones)
    };

    try {
      const res = await fetch('../crud/guardarservicios.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(datos)
      });

      const resultado = await res.json();

      if (resultado.status === 'ok') {
        Swal.fire('Éxito', 'Servicio guardado correctamente', 'success').then(() => {
          location.reload();
        });
      } else {
        Swal.fire('Error', resultado.mensaje || 'Hubo un error al guardar', 'error');
      }
    } catch (err) {
      console.error(err);
      Swal.fire('Error', 'Error en la comunicación con el servidor', 'error');
    }
  });
});
