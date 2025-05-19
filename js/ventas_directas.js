
function activarAutocompletadoRefaccion(input) {
  input.addEventListener('input', function () {
    const termino = input.value;

    if (termino.length < 2) return;

    fetch(`../logica/buscar_refaccioneso.php?term=${encodeURIComponent(termino)}`)
      .then(res => res.json())
      .then(data => {
        if (data.length > 0) {
          const ref = data[0];
          const fila = input.closest('tr');
          fila.querySelector('.precio').value = parseFloat(ref.precio).toFixed(2);
          actualizarSubtotalFila(fila);
        }
      });
  });
}

function agregarFilaVentaDirecta() {
  const tbody = document.getElementById('tablaVentaDirecta');
  const fila = document.createElement('tr');

  fila.innerHTML = `
    <td><input type="text" class="form-control nombre-refaccion" placeholder="Refacción"></td>
    <td><input type="number" class="form-control cantidad" value="1" min="1"></td>
    <td><input type="number" class="form-control precio" value="0" min="0" step="0.01" readonly></td>
    <td class="subtotal">$0.00</td>
    <td><button class="btn btn-danger btn-sm" onclick="this.closest('tr').remove(); actualizarTotalDirecta();">X</button></td>
  `;

  tbody.appendChild(fila);

  const inputNombre = fila.querySelector('.nombre-refaccion');
  const inputCantidad = fila.querySelector('.cantidad');

  activarAutocompletadoRefaccion(inputNombre);

  inputCantidad.addEventListener('input', () => actualizarSubtotalFila(fila));
}

function actualizarSubtotalFila(fila) {
  const cantidad = parseFloat(fila.querySelector('.cantidad').value) || 0;
  const precio = parseFloat(fila.querySelector('.precio').value) || 0;
  const subtotal = cantidad * precio;
  fila.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;
  actualizarTotalDirecta();
}

function actualizarTotalDirecta() {
  let total = 0;
  document.querySelectorAll('#tablaVentaDirecta tr').forEach(fila => {
    const cantidad = parseFloat(fila.querySelector('.cantidad')?.value) || 0;
    const precio = parseFloat(fila.querySelector('.precio')?.value) || 0;
    total += cantidad * precio;
  });
  document.getElementById('totalVentaDirecta').textContent = total.toFixed(2);
}
