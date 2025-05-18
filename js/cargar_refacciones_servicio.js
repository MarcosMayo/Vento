
function cargarRefaccionesDelServicio(idServicio) {
  fetch(`../logica/refacciones_por_servicio.php?id_servicio=${idServicio}`)
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById('tablaRefaccionesOrden');
      tbody.innerHTML = '';
      let subtotalRef = 0;

      data.forEach(ref => {
        const fila = document.createElement('tr');
        const subtotal = ref.precio * ref.cantidad;
        subtotalRef += subtotal;

        fila.innerHTML = `
          <td style="position: relative;">
            <input type="hidden" class="refaccion-id" value="${ref.id_refaccion}">
            <input type="text" class="form-control" value="${ref.nombre_refaccion}" readonly>
          </td>
          <td><input type="number" class="form-control cantidad" value="${ref.cantidad}" min="1"></td>
          <td><input type="number" class="form-control precio" value="${ref.precio}" step="0.01" min="0"></td>
          <td class="subtotal">$${subtotal.toFixed(2)}</td>
          <td><button type="button" class="btn btn-danger btn-sm">X</button></td>
        `;

        fila.querySelector('.cantidad').addEventListener('input', () => {
          actualizarSubtotalFilaOrden(fila);
          actualizarTotalesOrden();
        });

        fila.querySelector('.precio').addEventListener('input', () => {
          actualizarSubtotalFilaOrden(fila);
          actualizarTotalesOrden();
        });

        fila.querySelector('.btn-danger').addEventListener('click', () => {
          fila.remove();
          actualizarTotalesOrden();
        });

        tbody.appendChild(fila);
      });

      document.getElementById('subtotalRefOrden').value = subtotalRef.toFixed(2);
      actualizarTotalesOrden();
    })
    .catch(err => {
      console.error('Error al cargar refacciones:', err);
    });
}

// Se asegura de actualizar total cuando cambia la mano de obra
document.addEventListener('DOMContentLoaded', () => {
  const manoObraInput = document.getElementById('manoObraOrden');
  if (manoObraInput) {
    manoObraInput.addEventListener('input', actualizarTotalesOrden);
  }
});

function actualizarSubtotalFilaOrden(fila) {
  const cantidad = parseFloat(fila.querySelector('.cantidad').value) || 0;
  const precio = parseFloat(fila.querySelector('.precio').value) || 0;
  const subtotal = cantidad * precio;
  fila.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;
}

function actualizarTotalesOrden() {
  let totalRef = 0;
  document.querySelectorAll('#tablaRefaccionesOrden tr').forEach(fila => {
    const cantidad = parseFloat(fila.querySelector('.cantidad').value) || 0;
    const precio = parseFloat(fila.querySelector('.precio').value) || 0;
    totalRef += cantidad * precio;
  });

  const manoObra = parseFloat(document.getElementById('manoObraOrden').value) || 0;
  const totalFinal = totalRef + manoObra;

  document.getElementById('subtotalRefOrden').value = totalRef.toFixed(2);
  document.getElementById('totalFinalOrden').value = totalFinal.toFixed(2);
}
