
const tablaBodyServicios = document.getElementById('tablaBodyServicios');
const paginacionServicios = document.getElementById('paginacionServicios');
const searchInputServicios = document.getElementById('searchInputServicios');

let currentPage = 1;
const limit = 5;

searchInputServicios.addEventListener('input', () => {
    cargarServicios(1, searchInputServicios.value.trim());
});

function cargarServicios(page = 1, search = '') {
    currentPage = page;
    fetch(`../logica/servicioslog.php?page=${page}&search=${encodeURIComponent(search)}`)
        .then(res => res.json())
        .then(data => {
            tablaBodyServicios.innerHTML = '';
            data.servicios.forEach(servicio => {
                tablaBodyServicios.innerHTML += `
                    <tr>
                        <td>${servicio.nombre_servicio}</td>
                        <td>${servicio.descripcion}</td>
                        <td>${servicio.refacciones}</td>
                        <td>$${parseFloat(servicio.precio).toFixed(2)}</td>
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
            renderizarPaginacion(data.totalPages, page);
        })
        .catch(err => {
            console.error('Error al cargar servicios:', err);
        });
}

function renderizarPaginacion(totalPages, current) {
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
            <a class="page-link" href="#" onclick="if(${current} > 1) cargarServicios(${current - 1}, searchInputServicios.value)">←</a>
        </li>`;

    for (let i = start; i <= end; i++) {
        paginacionServicios.innerHTML += `
            <li class="page-item ${i === current ? 'active' : ''}">
                <a class="page-link" href="#" onclick="cargarServicios(${i}, searchInputServicios.value)">${i}</a>
            </li>`;
    }

    paginacionServicios.innerHTML += `
        <li class="page-item ${current === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="if(${current} < ${totalPages}) cargarServicios(${current + 1}, searchInputServicios.value)">→</a>
        </li>`;
}

// Inicializar carga
document.addEventListener('DOMContentLoaded', () => {
    cargarServicios();
});



function eliminarServicio(id) {
    Swal.fire('Eliminar', 'Aquí irá la lógica para eliminar el servicio ID: ' + id, 'warning');
}
