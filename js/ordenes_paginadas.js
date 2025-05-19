
const tablaBodyOrdenes = document.getElementById('tablaBodyOrdenes');
const paginacionOrdenes = document.getElementById('paginacionOrdenes');
const searchInput = document.getElementById('buscarOrdenes');
const filtroEstatus = document.getElementById('filtroEstatus');
const fechaDesde = document.getElementById('fechaDesde');
const fechaHasta = document.getElementById('fechaHasta');

let currentPage = 1;
const limit = 5;

function renderizarPaginacion(totalPages, current) {
  paginacionOrdenes.innerHTML = '';
  const maxVisible = 5;
  let start = Math.max(1, current - Math.floor(maxVisible / 2));
  let end = start + maxVisible - 1;
  if (end > totalPages) {
    end = totalPages;
    start = Math.max(1, end - maxVisible + 1);
  }

  if (totalPages > 1) {
    paginacionOrdenes.innerHTML += `
      <li class="page-item ${current === 1 ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="if(${current} > 1) cargarOrdenes(${current - 1})">←</a>
      </li>`;

    for (let i = start; i <= end; i++) {
      paginacionOrdenes.innerHTML += `
        <li class="page-item ${i === current ? 'active' : ''}">
          <a class="page-link" href="#" onclick="cargarOrdenes(${i})">${i}</a>
        </li>`;
    }

    paginacionOrdenes.innerHTML += `
      <li class="page-item ${current === totalPages ? 'disabled' : ''}">
        <a class="page-link" href="#" onclick="if(${current} < ${totalPages}) cargarOrdenes(${current + 1})">→</a>
      </li>`;
  }
}

function cargarOrdenes(page = 1) {
  const search = searchInput.value.trim();
  const estatus = filtroEstatus.value;
  const desde = fechaDesde.value;
  const hasta = fechaHasta.value;

  const params = new URLSearchParams({
    page,
    limit,
    search,
    estatus,
    desde,
    hasta
  });

  fetch(`../logica/ordenes_paginadas.php?${params.toString()}`)
    .then(res => res.json())
    .then(data => {
      tablaBodyOrdenes.innerHTML = '';

      data.ordenes.forEach(orden => {
        const cliente = `${orden.nombre} ${orden.apellido_paterno}`;
        const moto = `${orden.marca} ${orden.modelo}`;
        const servicio = orden.nombre_servicio;
        const fecha = orden.fecha_servicio;
        const total = `$${parseFloat(orden.costo_total).toFixed(2)}`;
        const estatus = orden.estatus;

        const boton = orden.estatus !== 'Terminado' ? `
  <button class="btn btn-sm btn-outline-primary" onclick="cambiarEstatus(${orden.id_orden})">
    Cambiar estatus
  </button>` : '<span class="text-muted">Finalizado</span>';

tablaBodyOrdenes.innerHTML += `
  <tr>
    <td>${cliente}</td>
    <td>${moto}</td>
    <td>${servicio}</td>
    <td>${fecha}</td>
    <td>${total}</td>
    <td>${estatus}</td>
    <td class="text-center">${boton}</td>
  </tr>`;

      });

      renderizarPaginacion(data.totalPages, page);
      currentPage = page;
    });
}

// Recarga al buscar o filtrar
[searchInput, filtroEstatus, fechaDesde, fechaHasta].forEach(el => {
  el.addEventListener('input', () => cargarOrdenes(1));
});

// Inicial
document.addEventListener('DOMContentLoaded', () => {
  cargarOrdenes();
});
function cambiarEstatus(id) {
  Swal.fire({
    title: 'Cambiar estatus',
    input: 'select',
    inputOptions: {
      1: 'Pendiente',
      2: 'Cancelado',
      3: 'Terminado'
    },
    inputPlaceholder: 'Selecciona un nuevo estatus',
    showCancelButton: true,
    confirmButtonText: 'Actualizar',
    cancelButtonText: 'Cancelar'
  }).then(result => {
    if (result.isConfirmed && result.value) {
      fetch('../crud/actualizar_estatus_orden.php', {
        method: 'POST',
        body: new URLSearchParams({
          id_orden: id,
          nuevo_estatus: result.value
        })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          Swal.fire('Éxito', 'Estatus actualizado', 'success');
          cargarOrdenes(currentPage);
        } else {
          Swal.fire('Error', data.message || 'No se pudo actualizar', 'error');
        }
      })
      .catch(err => {
        console.error(err);
        Swal.fire('Error', 'No se pudo contactar con el servidor', 'error');
      });
    }
  });
}