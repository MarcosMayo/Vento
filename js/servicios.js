function agregarFila() {
  const tbody = document.querySelector('#tablaRefacciones tbody');
  const fila = document.createElement('tr');

  fila.innerHTML = `
    <td>
      <input type="text" class="form-control nombre-refaccion" placeholder="Refacción">
      <input type="hidden" class="id-refaccion" value="0">
    </td>
    <td><input type="number" class="form-control cantidad-refaccion" value="1" min="1"></td>
    <td><input type="number" class="form-control precio-refaccion" value="0" min="0" step="0.01"></td>
    <td><input type="text" class="form-control subtotal-refaccion" value="0.00" readonly></td>
    <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">X</button></td>
  `;

  tbody.appendChild(fila);

  fila.querySelector('.cantidad-refaccion').addEventListener('input', recalcularTotal);
  fila.querySelector('.precio-refaccion').addEventListener('input', recalcularTotal);
  recalcularTotal();
}

function eliminarFila(btn) {
  btn.closest('tr').remove();
  recalcularTotal();
}

function recalcularTotal() {
  let totalRefacciones = 0;
  const manoObra = parseFloat(document.querySelector('input[name="mano_obra"]').value) || 0;

  document.querySelectorAll('#tablaRefacciones tbody tr').forEach(fila => {
    const cantidad = parseFloat(fila.querySelector('.cantidad-refaccion')?.value) || 0;
    const precio = parseFloat(fila.querySelector('.precio-refaccion')?.value) || 0;
    const subtotal = cantidad * precio;

    fila.querySelector('.subtotal-refaccion').value = subtotal.toFixed(2);
    totalRefacciones += subtotal;
  });

  const totalServicio = manoObra + totalRefacciones;

  document.getElementById('totalRefacciones').textContent = totalRefacciones.toFixed(2);
  document.getElementById('totalServicio').textContent = totalServicio.toFixed(2);
}


document.querySelector('input[name="mano_obra"]').addEventListener('input', recalcularTotal);

const tablaBodyServicios = document.getElementById('tablaBodyServicios');
const paginacionServicios = document.getElementById('paginacionServicios');
const searchInputServicios = document.getElementById('searchInputServicios');

let currentPageServicios = 1;
const limitServicios = 5;

function renderizarPaginacionServicios(totalPages, current) {
    paginacionServicios.innerHTML = '';
    const maxVisible = 5;
    let start = Math.max(1, current - Math.floor(maxVisible / 2));
    let end = start + maxVisible - 1;

    if (end > totalPages) {
        end = totalPages;
        start = Math.max(1, end - maxVisible + 1);
    }

    paginacionServicios.innerHTML += `
        <li class="page-item ${current === 1 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="if(${current} > 1) cargarServicios(${current - 1}, '${searchInputServicios.value}')">←</a>
        </li>
    `;

    for (let i = start; i <= end; i++) {
        paginacionServicios.innerHTML += `
            <li class="page-item ${i === current ? 'active' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="cargarServicios(${i}, '${searchInputServicios.value}')">${i}</a>
            </li>
        `;
    }

    paginacionServicios.innerHTML += `
        <li class="page-item ${current === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="if(${current} < ${totalPages}) cargarServicios(${current + 1}, '${searchInputServicios.value}')">→</a>
        </li>
    `;
}

async function cargarServicios(page = 1, search = '') {
    const response = await fetch(`../logica/servicioslog.php?page=${page}&limit=${limitServicios}&search=${search}`);
    const data = await response.json();

    tablaBodyServicios.innerHTML = '';
    data.servicios.forEach(servicio => {
        tablaBodyServicios.innerHTML += `
            <tr>
                <td>${servicio.nombre_servicio}</td>
                <td>${servicio.descripcion}</td>
                <td>${servicio.refacciones}</td>
                <td>$${parseFloat(servicio.total).toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="abrirModalEditarServicio(${servicio.id_servicio})"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarServicio(${servicio.id})"><i class="bi bi-trash"></i></button>
                </td>
            </tr>
        `;
    });

    renderizarPaginacionServicios(data.totalPages, page);
}

searchInputServicios.addEventListener('input', () => {
    currentPageServicios = 1;
    cargarServicios(currentPageServicios, searchInputServicios.value);
});

cargarServicios(); // Cargar al inicio

function agregarFilaEditar() {
  const tbody = document.querySelector('#tablaRefaccionesEditar');
  const fila = document.createElement('tr');

  fila.innerHTML = `
    <td><input type="text" class="form-control input-refaccion" placeholder="Refacción"></td>
    <td><input type="number" class="form-control cantidad-refaccion" value="1" min="1"></td>
    <td><input type="number" class="form-control precio-refaccion" value="0" min="0" step="0.01"></td>
    <td><input type="text" class="form-control subtotal-refaccion" value="0.00" readonly></td>
    <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">X</button></td>
  `;

  tbody.appendChild(fila);

  fila.querySelector('.cantidad-refaccion').addEventListener('input', recalcularTotales);
  fila.querySelector('.precio-refaccion').addEventListener('input', recalcularTotales);
  recalcularTotales();
}


async function abrirModalEditarServicio(id) {
    try {
        const res = await fetch(`../logica/obtener_servicio.php?id=${id}`);

        if (!res.ok) {
            throw new Error(`Error HTTP: ${res.status}`);
        }

        const data = await res.json();
        console.log("Respuesta del servidor:", data);
        console.log("Mano de obra:", data.servicio.mano_obra);


        // Validar si recibimos el objeto servicio
        if (!data.servicio) {
            console.error('Servicio no encontrado o respuesta inválida:', data);
            alert('No se pudo cargar la información del servicio.');
            return;
        }

        // Rellenar los campos del modal
        document.getElementById('idServicioEditar').value = data.servicio.id_servicio || '';
        document.getElementById('nombreServicioEditar').value = data.servicio.nombre_servicio || '';
        document.getElementById('descripcionEditar').value = data.servicio.descripcion || '';
        document.getElementById('manoObraEditar').value = data.servicio.mano_obra || 0;

        // Obtener el tbody correctamente
        const tbody = document.getElementById('tablaRefaccionesEditar');
        if (!tbody) {
            console.error('No se encontró el cuerpo de la tabla con ID tablaRefaccionesEditar');
            alert('Error interno: no se encontró la tabla de refacciones.');
            return;
        }

        tbody.innerHTML = '';

        // Llenar la tabla con las refacciones si existen
        if (Array.isArray(data.refacciones)) {
            data.refacciones.forEach(ref => {
                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td><input type="text" class="form-control input-refaccion" value="${ref.nombre_refaccion || ''}" readonly></td>
                    <td><input type="number" class="form-control cantidad-refaccion" value="${ref.cantidad || 0}"></td>
                    <td><input type="text" class="form-control precio-refaccion" value="${ref.precio || 0}" readonly></td>
                    <td><input type="text" class="form-control subtotal-refaccion" value="${ref.subtotal || 0}" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">X</button></td>
                `;
                tbody.appendChild(fila);
            });
        } else {
            console.warn('No se recibieron refacciones válidas:', data.refacciones);
        }
        // Escuchar cambios en mano de obra
document.getElementById('manoObraEditar').addEventListener('input', recalcularTotales);

// Recalcular totales al finalizar
recalcularTotales();

        // Mostrar el modal
        const modal = new bootstrap.Modal(document.getElementById('editarServicioModal'));
        modal.show();

    } catch (error) {
        console.error('Error al abrir modal de edición:', error);
        alert('Ocurrió un error al obtener los datos del servicio.');
    }
}


