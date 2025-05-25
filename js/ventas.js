
document.addEventListener('DOMContentLoaded', () => {
  cargarOrdenesPendientes();
  document.getElementById('btnGuardarVentaOrden').addEventListener('click', guardarVentaDesdeOrden);
  document.getElementById('btnGuardarVentaDirecta').addEventListener('click', guardarVentaDirecta);
});

function cargarOrdenesPendientes() {
  fetch('../logica/ordenes_pendientes.php')
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById('ordenSeleccion');
      select.innerHTML = '<option value="">Seleccione una orden</option>';
      data.forEach(orden => {
        select.innerHTML += `<option value="${orden.id_orden}">#${orden.id_orden} - ${orden.cliente} (${orden.marca} ${orden.modelo})</option>`;
      });
    });

  document.getElementById('ordenSeleccion').addEventListener('change', e => {
    const id = e.target.value;
    if (id) cargarRefaccionesOrden(id);
  });
}


function cargarRefaccionesOrden(idOrden) {
  fetch(`../logica/refacciones_por_orden.php?id_orden=${idOrden}`)
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById('tablaOrdenRefacciones');
      tbody.innerHTML = '';
      let total = 0;

      // Agregar refacciones
      data.refacciones.forEach(ref => {
        const subtotal = ref.precio * ref.cantidad;
        total += subtotal;
        tbody.innerHTML += `
          <tr>
            <td>${ref.nombre}</td>
            <td>${ref.cantidad}</td>
            <td>$${parseFloat(ref.precio).toFixed(2)}</td>
            <td>$${subtotal.toFixed(2)}</td>
          </tr>`;
      });

      // Agregar mano de obra
      if (data.mano_obra > 0) {
        total += data.mano_obra;
        tbody.innerHTML += `
          <tr class="table-warning">
            <td colspan="2">Mano de obra</td>
            <td colspan="2">$${parseFloat(data.mano_obra).toFixed(2)}</td>
          </tr>`;
      }

      document.getElementById('totalOrden').textContent = total.toFixed(2);
    });
}

function agregarFilaVentaDirecta() {
  const tbody = document.getElementById('tablaVentaDirecta');
  const fila = document.createElement('tr');

  fila.innerHTML = `
    <td style="position: relative;">
      <input type="text" class="form-control nombre-refaccion" placeholder="Buscar refacción">
      <input type="hidden" class="id-refaccion">
      <div class="sugerencias" style="position: absolute; background: white; border: 1px solid #ccc; width: 100%; z-index: 1000;"></div>
    </td>
    <td><input type="number" class="form-control cantidad" value="1" min="1"></td>
    <td><input type="number" class="form-control precio" value="0.00" min="0" step="0.01" readonly></td>
    <td class="subtotal">$0.00</td>
    <td><button class="btn btn-danger btn-sm" onclick="this.closest('tr').remove(); actualizarTotalDirecta();">X</button></td>
  `;

  tbody.appendChild(fila);

  const inputNombre = fila.querySelector('.nombre-refaccion');
  const sugerencias = fila.querySelector('.sugerencias');

  inputNombre.addEventListener('input', () => {
    const termino = inputNombre.value;

    if (termino.length < 2) {
      sugerencias.innerHTML = '';
      return;
    }

    fetch(`../logica/buscar_refaccioneso.php?term=${encodeURIComponent(termino)}`)
      .then(res => res.json())
      .then(data => {
        sugerencias.innerHTML = '';
        data.forEach(ref => {
          const item = document.createElement('div');
          item.textContent = `${ref.nombre_refaccion} ($${ref.precio})`;
          item.style.padding = '4px';
          item.style.cursor = 'pointer';

          item.addEventListener('click', () => {
            inputNombre.value = ref.nombre_refaccion;
            fila.querySelector('.id-refaccion').value = ref.id_refaccion;
            fila.querySelector('.precio').value = parseFloat(ref.precio).toFixed(2);
            sugerencias.innerHTML = '';
            actualizarSubtotalFila(fila);
          });

          sugerencias.appendChild(item);
        });
      });
  });

  fila.querySelector('.cantidad').addEventListener('input', () => actualizarSubtotalFila(fila));
}


function actualizarSubtotalFila(fila) {
  const cantidad = parseFloat(fila.querySelector('.cantidad').value) || 0;
  const precio = parseFloat(fila.querySelector('.precio').value) || 0;
  const subtotal = cantidad * precio;
  fila.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;
  actualizarTotalDirecta();
}

function guardarVentaDesdeOrden() {
  const id_orden = document.getElementById('ordenSeleccion').value;
  if (!id_orden) {
    return Swal.fire('Atención', 'Selecciona una orden primero', 'warning');
  }

  const formData = new FormData();
  formData.append('tipo', 'orden');
  formData.append('id_orden', id_orden);

  fetch('../crud/guardar_venta.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json()) // ESTA LÍNEA ESCLAVE para convertir la respuesta a JSON
    .then(data => {
      if (data.success) {
        Swal.fire({
          icon: 'success',
          title: 'Venta registrada correctamente',
          text: 'Generando ticket...',
          timer: 1500,
          showConfirmButton: false
        }).then(() => {
      
        });
        setTimeout(() => {
  Swal.close(); // cerrar el modal
  window.open(`../vistas/ticket.php?id=${data.id_venta}`, '_blank');
}, 1500);



        cargarOrdenesPendientes();
        document.getElementById('tablaOrdenRefacciones').innerHTML = '';
        document.getElementById('totalOrden').textContent = '0.00';
      } else {
        Swal.fire('Error', data.message || 'No se pudo guardar la venta', 'error');
      }
    })
    .catch(err => {
      console.error('Error de red o fetch:', err);
      Swal.fire('Error', 'Hubo un problema al contactar al servidor', 'error');
    });
}


function guardarVentaDirecta() {
  const filas = document.querySelectorAll('#tablaVentaDirecta tr');
  const refacciones = [];

  filas.forEach(fila => {
    const id_refaccion = parseInt(fila.querySelector('.id-refaccion')?.value) || 0;
    const cantidad = parseFloat(fila.querySelector('.cantidad')?.value) || 0;
    const precio = parseFloat(fila.querySelector('.precio')?.value) || 0;

    if (id_refaccion && cantidad > 0) {
      refacciones.push({ id_refaccion, cantidad, precio });
    }
  });

  if (refacciones.length === 0) {
    return Swal.fire('Atención', 'Agrega al menos una refacción válida', 'warning');
  }

  const cliente_id = document.getElementById('clienteVentaId')?.value || 38;

  const formData = new FormData();
  formData.append('tipo', 'directa');
  formData.append('cliente_id', cliente_id);
  formData.append('refacciones', JSON.stringify(refacciones));

  fetch('../crud/guardar_venta.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
.then(data => {
  if (data.success) {
    Swal.fire({
      icon: 'success',
      title: 'Venta registrada correctamente',
      text: 'Generando ticket...',
      timer: 1500,
      showConfirmButton: false
    }).then(() => {
     
    });

    setTimeout(() => {
  Swal.close(); // cerrar el modal
  window.open(`../vistas/ticket.php?id=${data.id_venta}`, '_blank');
}, 1500);


    document.getElementById('tablaVentaDirecta').innerHTML = '';
    document.getElementById('totalVentaDirecta').textContent = '0.00';
    document.getElementById('clienteVenta').value = '';
    document.getElementById('clienteVentaId').value = '38';
  } else {
    Swal.fire('Error', data.message || 'No se pudo guardar la venta', 'error');
  }
})

.catch(err => {
  console.error('Error en respuesta JSON:', err);
  Swal.fire('Error', 'Respuesta no válida del servidor', 'error');
})
    .catch(err => {
      console.error('Error de red o fetch:', err);
      Swal.fire('Error', 'Hubo un problema al contactar al servidor', 'error');
    });
}

function actualizarTotalDirecta() {
  let total = 0;

  document.querySelectorAll('#tablaVentaDirecta tr').forEach(fila => {
    const cantidadInput = fila.querySelector('.cantidad');
    const precioInput = fila.querySelector('.precio');
    const subtotalCell = fila.querySelector('.subtotal');

    const cantidad = parseFloat(cantidadInput?.value) || 0;
    const precio = parseFloat(precioInput?.value) || 0;
    const subtotal = cantidad * precio;

    console.log(`Fila: cantidad=${cantidad}, precio=${precio}, subtotal=${subtotal}`);

    if (subtotalCell) {
      subtotalCell.textContent = `$${subtotal.toFixed(2)}`;
    }

    total += subtotal;
  });

  console.log(`TOTAL: ${total}`);

  const totalElement = document.getElementById('totalVentaDirecta');
  if (totalElement) {
    totalElement.textContent = `$${total.toFixed(2)}`;
  }
}
