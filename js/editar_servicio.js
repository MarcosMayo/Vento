function editarServicio(id) {
  fetch(`../logica/obtener_servicio.php?id=${id}`)
    .then(res => res.json())
    .then(data => {
      if (!data.success) {
        Swal.fire('Error', data.message || 'No se pudo obtener el servicio', 'error');
        return;
      }

      const servicio = data.servicio;
      document.getElementById('idServicioEditar').value = servicio.id_servicio;
      document.getElementById('nombreServicioEditar').value = servicio.nombre_servicio;
      document.getElementById('descripcionEditar').value = servicio.descripcion;
      document.getElementById('manoObraEditar').value = servicio.mano_obra;

      const tbody = document.getElementById('tablaRefaccionesEditar');
      tbody.innerHTML = '';

      let totalRef = 0;

      servicio.refacciones.forEach(ref => {
        const fila = document.createElement('tr');
        const subtotal = ref.precio * ref.cantidad;
        totalRef += subtotal;

        fila.innerHTML = `
          <td style="position: relative;">
            <input type="hidden" class="refaccion-id" value="${ref.id_refaccion}">
            <input type="text" class="form-control refaccion-nombre" value="${ref.nombre_refaccion}" required>
            <div class="sugerencias" style="position: absolute; z-index: 1000; background: white; width: 100%; border: 1px solid #ccc;"></div>
          </td>
          <td><input type="number" class="form-control cantidad" min="1" value="${ref.cantidad}"></td>
          <td><input type="number" class="form-control precio" min="0" step="0.01" value="${ref.precio}" readonly></td>
          <td class="subtotal">$${subtotal.toFixed(2)}</td>
          <td><button type="button" class="btn btn-danger btn-sm">X</button></td>
        `;

        fila.querySelector('.refaccion-nombre').addEventListener('input', function () {
          activarAutocompletado(this);
        });

        fila.querySelector('.cantidad').addEventListener('input', () => {
          actualizarSubtotalFilaEditar(fila);
          actualizarTotalesEditar();
        });

        fila.querySelector('.precio').addEventListener('input', () => {
          actualizarSubtotalFilaEditar(fila);
          actualizarTotalesEditar();
        });

        fila.querySelector('.btn-danger').addEventListener('click', () => {
          fila.remove();
          actualizarTotalesEditar();
        });

        tbody.appendChild(fila);
      });

      document.getElementById('totalRefaccionesEditar').textContent = totalRef.toFixed(2);
      const manoObra = parseFloat(servicio.mano_obra) || 0;
      document.getElementById('totalServicioEditar').textContent = (manoObra + totalRef).toFixed(2);

      const modal = new bootstrap.Modal(document.getElementById('editarServicioModal'));
      modal.show();
    })
    .catch(err => {
      console.error(err);
      Swal.fire('Error', 'Error al cargar datos del servicio', 'error');
    });
}

function actualizarSubtotalFilaEditar(fila) {
  const cantidad = parseFloat(fila.querySelector('.cantidad').value) || 0;
  const precio = parseFloat(fila.querySelector('.precio').value) || 0;
  const subtotal = cantidad * precio;
  fila.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;
}

function actualizarTotalesEditar() {
  let total = 0;
  document.querySelectorAll('#tablaRefaccionesEditar tr').forEach(fila => {
    const cantidad = parseFloat(fila.querySelector('.cantidad').value) || 0;
    const precio = parseFloat(fila.querySelector('.precio').value) || 0;
    const subtotal = cantidad * precio;
    fila.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;
    total += subtotal;
  });

  document.getElementById('totalRefaccionesEditar').textContent = total.toFixed(2);

  const manoObra = parseFloat(document.getElementById('manoObraEditar').value) || 0;
  document.getElementById('totalServicioEditar').textContent = (total + manoObra).toFixed(2);
}
