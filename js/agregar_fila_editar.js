
function agregarFilaEditar() {
  const tbody = document.getElementById('tablaRefaccionesEditar');
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
  actualizarTotalesEditar();
}
