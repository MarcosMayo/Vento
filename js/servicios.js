
document.addEventListener('DOMContentLoaded', () => {
  const formAgregar = document.getElementById('formAgregarServicio');
  const tablaRef = document.getElementById('tbodyRefaccionesAgregar');
  const totalRefaccionesSpan = document.getElementById('totalRefaccionesAgregar');
  const totalServicioSpan = document.getElementById('totalServicioAgregar');
  const manoObraInput = document.getElementById('manoObra');

  manoObraInput.addEventListener('input', actualizarTotales);

  formAgregar.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(formAgregar);
    const refacciones = [];

    tablaRef.querySelectorAll('tr').forEach(fila => {
      const id_refaccion = fila.querySelector('.refaccion-id').value;
      const cantidad = fila.querySelector('.cantidad').value;
      const precio = fila.querySelector('.precio').value;

      if (id_refaccion && cantidad && precio) {
        refacciones.push({ id_refaccion, cantidad, precio });
      }
    });

    formData.append('refacciones', JSON.stringify(refacciones));

    fetch('../crud/guardarservicios.php', {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          Swal.fire('Éxito', 'Servicio guardado correctamente', 'success');
          formAgregar.reset();
          tablaRef.innerHTML = '';
          actualizarTotales();
           cargarServicios(); // ← Esto refresca la tabla después de guardar
        } else {
          Swal.fire('Error', data.message || 'Ocurrió un error', 'error');
        }
      })
      .catch(err => {
        console.error(err);
        Swal.fire('Error', 'Ocurrió un error inesperado', 'error');
      });
  });

  window.agregarFilaAgregar = function () {
    const fila = document.createElement('tr');
    fila.innerHTML = `
      <td style="position: relative;">
        <input type="hidden" class="refaccion-id">
        <input type="text" class="form-control refaccion-nombre" placeholder="Buscar..." autocomplete="off" required>
        <div class="sugerencias" style="position: absolute; z-index: 1000; background: white; width: 100%; border: 1px solid #ccc;"></div>
      </td>
      <td><input type="number" class="form-control cantidad" min="1" value="1"></td>
      <td><input type="number" class="form-control precio" min="0" step="0.01" value="0" readonly></td>
      <td class="subtotal">$0.00</td>
      <td><button type="button" class="btn btn-danger btn-sm">X</button></td>
    `;
    fila.querySelector('.refaccion-nombre').addEventListener('input', function () {
      activarAutocompletado(this);
    });

    fila.querySelector('.cantidad').addEventListener('input', () => {
      actualizarSubtotalFila(fila);
      actualizarTotales();
    });

    fila.querySelector('.precio').addEventListener('input', () => {
      actualizarSubtotalFila(fila);
      actualizarTotales();
    });

    fila.querySelector('.btn-danger').addEventListener('click', () => {
      fila.remove();
      actualizarTotales();
    });

    tablaRef.appendChild(fila);
    actualizarTotales();
  };

  function actualizarSubtotalFila(fila) {
    const cantidad = parseFloat(fila.querySelector('.cantidad').value) || 0;
    const precio = parseFloat(fila.querySelector('.precio').value) || 0;
    const subtotal = cantidad * precio;
    fila.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;
  }

  function actualizarTotales() {
    let totalRefacciones = 0;
    tablaRef.querySelectorAll('tr').forEach(fila => {
      const cantidad = parseFloat(fila.querySelector('.cantidad').value) || 0;
      const precio = parseFloat(fila.querySelector('.precio').value) || 0;
      const subtotal = cantidad * precio;
      fila.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;
      totalRefacciones += subtotal;
    });

    totalRefaccionesSpan.textContent = totalRefacciones.toFixed(2);

    const manoObra = parseFloat(manoObraInput.value) || 0;
    const totalServicio = totalRefacciones + manoObra;
    totalServicioSpan.textContent = totalServicio.toFixed(2);
  }
});
