
function agregarFilaRefaccion() {
  const tbody = document.getElementById('tablaRefaccionesOrden');
  const fila = document.createElement('tr');

  fila.innerHTML = `
    <td style="position: relative;">
      <input type="hidden" class="refaccion-id">
      <input type="text" class="form-control refaccion-nombre" placeholder="Buscar refacción..." autocomplete="off">
      <div class="sugerencias-refacciones position-absolute bg-white border w-100" style="z-index: 1000;"></div>
    </td>
    <td><input type="number" class="form-control cantidad" min="1" value="1"></td>
    <td><input type="number" class="form-control precio" min="0" step="0.01" value="0" readonly></td>
    <td class="subtotal">$0.00</td>
    <td><button type="button" class="btn btn-danger btn-sm">X</button></td>
  `;

  const inputNombre = fila.querySelector('.refaccion-nombre');
  const cantidadInput = fila.querySelector('.cantidad');
  const precioInput = fila.querySelector('.precio');
  const sugerencias = fila.querySelector('.sugerencias-refacciones');
  const idInput = fila.querySelector('.refaccion-id');

  inputNombre.addEventListener('input', () => {
    const term = inputNombre.value.trim();
    if (term.length < 2) {
      sugerencias.innerHTML = '';
      sugerencias.style.display = 'none';
      return;
    }

    fetch('../logica/buscar_refacciones.php?term=' + encodeURIComponent(term))
      .then(res => res.json())
      .then(data => {
        sugerencias.innerHTML = '';
        sugerencias.style.display = 'block';
        data.forEach(ref => {
          const div = document.createElement('div');
          div.textContent = `${ref.nombre_refaccion} ($${ref.precio})`;
          div.style.padding = '5px';
          div.style.cursor = 'pointer';
          div.addEventListener('click', () => {
            inputNombre.value = ref.nombre_refaccion;
            precioInput.value = parseFloat(ref.precio).toFixed(2);
            idInput.value = ref.id_refaccion;
            sugerencias.innerHTML = '';
            sugerencias.style.display = 'none';
            cantidadInput.dispatchEvent(new Event('input'));
          });
          sugerencias.appendChild(div);
        });
      });
  });

  inputNombre.addEventListener('blur', () => {
    setTimeout(() => {
      sugerencias.innerHTML = '';
      sugerencias.style.display = 'none';
    }, 200);
  });

  cantidadInput.addEventListener('input', () => {
    actualizarSubtotalFilaOrden(fila);
    actualizarTotalesOrden();
  });

  precioInput.addEventListener('input', () => {
    actualizarSubtotalFilaOrden(fila);
    actualizarTotalesOrden();
  });

  fila.querySelector('.btn-danger').addEventListener('click', () => {
    fila.remove();
    actualizarTotalesOrden();
  });

  tbody.appendChild(fila);
}
