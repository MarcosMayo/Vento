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
  const response = await fetch(`../logica/servicioslog.php?page=${page}&limit=${limitServicios}&search=${encodeURIComponent(search)}`);
  const data = await response.json();

  tablaBodyServicios.innerHTML = '';
  data.servicios.forEach(servicio => {
    tablaBodyServicios.innerHTML += `
      <tr>
        
        <td>${servicio.nombre_servicio}</td>
        <td>${servicio.descripcion}</td>
        <td>${servicio.total}</td>
        <td class="text-center">
          <button class="btn btn-sm btn-warning" onclick="editarServicio(${servicio.id_servicio})">
            <i class="bi bi-pencil-square"></i>
          </button>
          <button class="btn btn-sm btn-danger" onclick="eliminarServicio(${servicio.id_servicio})">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      </tr>
    `;
  });

  renderizarPaginacionServicios(data.totalPages, page);
}

// Buscar mientras escribe
searchInputServicios.addEventListener('input', () => {
  currentPageServicios = 1;
  cargarServicios(currentPageServicios, searchInputServicios.value);
});

// Inicial
cargarServicios();
