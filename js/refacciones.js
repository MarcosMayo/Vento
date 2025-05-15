const tablaBodyRefacciones = document.getElementById('tablaRefacciones');
const paginacionRefacciones = document.getElementById('paginacionRefacciones');
const searchInputRefacciones = document.getElementById('searchInputRefacciones');

let currentPageRefacciones = 1;
const limitRefacciones = 5;

// Modal abrir
function abrirModalEditarRefaccion(id, nombre, precio, stock) {
    document.getElementById('editarIdRefaccion').value = id;
    document.getElementById('editarNombreRefaccion').value = nombre;
    document.getElementById('editarPrecioRefaccion').value = precio;
    document.getElementById('editarStockRefaccion').value = stock;

    const modal = new bootstrap.Modal(document.getElementById('editarRefaccionModal'));
    modal.show();
}

// Renderizar paginación
function renderizarPaginacionRefacciones(totalPages, current) {
    paginacionRefacciones.innerHTML = '';
    const maxVisible = 5;
    let start = Math.max(1, current - Math.floor(maxVisible / 2));
    let end = start + maxVisible - 1;

    if (end > totalPages) {
        end = totalPages;
        start = Math.max(1, end - maxVisible + 1);
    }

    paginacionRefacciones.innerHTML += `
        <li class="page-item ${current === 1 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="if(${current} > 1) cargarRefacciones(${current - 1}, '${searchInputRefacciones.value}')">←</a>
        </li>
    `;

    for (let i = start; i <= end; i++) {
        paginacionRefacciones.innerHTML += `
            <li class="page-item ${i === current ? 'active' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="cargarRefacciones(${i}, '${searchInputRefacciones.value}')">${i}</a>
            </li>
        `;
    }

    paginacionRefacciones.innerHTML += `
        <li class="page-item ${current === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="if(${current} < ${totalPages}) cargarRefacciones(${current + 1}, '${searchInputRefacciones.value}')">→</a>
        </li>
    `;
}

// Cargar refacciones
async function cargarRefacciones(page = 1, search = '') {
    const response = await fetch(`../logica/refaccionlog.php?page=${page}&limit=${limitRefacciones}&search=${search}`);
    const data = await response.json();

    tablaBodyRefacciones.innerHTML = '';
    data.refacciones.forEach(ref => {
        tablaBodyRefacciones.innerHTML += `
            <tr>
                <td>${ref.id_refaccion}</td>
                <td>${ref.nombre_refaccion}</td>
                <td>$${parseFloat(ref.precio).toFixed(2)}</td>
                <td>${ref.stock}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-warning" onclick="abrirModalEditarRefaccion(${ref.id_refaccion}, '${ref.nombre_refaccion}', ${ref.precio}, ${ref.stock})">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarRefaccion(${ref.id_refaccion})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });

    renderizarPaginacionRefacciones(data.totalPages, page);
}

// Buscar en vivo
searchInputRefacciones.addEventListener('input', () => {
    currentPageRefacciones = 1;
    cargarRefacciones(currentPageRefacciones, searchInputRefacciones.value);
});

// Al cargar la página
cargarRefacciones();
