const tablaBodyMotos = document.getElementById('tablaBodyMotos');
const paginacionMotos = document.getElementById('paginacionMotos');
const searchInputMotos = document.getElementById('searchInputMotos');

let currentPageMotos = 1;
const limitMotos = 5;

function renderizarPaginacionMotos(totalPages, current) {
    paginacionMotos.innerHTML = '';
    const maxVisible = 5;
    let start = Math.max(1, current - Math.floor(maxVisible / 2));
    let end = start + maxVisible - 1;

    if (end > totalPages) {
        end = totalPages;
        start = Math.max(1, end - maxVisible + 1);
    }

    paginacionMotos.innerHTML += `
        <li class="page-item ${current === 1 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="if(${current} > 1) cargarMotos(${current - 1}, '${searchInputMotos.value}')">←</a>
        </li>
    `;

    for (let i = start; i <= end; i++) {
        paginacionMotos.innerHTML += `
            <li class="page-item ${i === current ? 'active' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="cargarMotos(${i}, '${searchInputMotos.value}')">${i}</a>
            </li>
        `;
    }

    paginacionMotos.innerHTML += `
        <li class="page-item ${current === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="if(${current} < ${totalPages}) cargarMotos(${current + 1}, '${searchInputMotos.value}')">→</a>
        </li>
    `;
}

async function cargarMotos(page = 1, search = '') {
    const response = await fetch(`../logica/motoslog.php?page=${page}&limit=${limitMotos}&search=${search}`);
    const data = await response.json();

    tablaBodyMotos.innerHTML = '';

    data.motocicletas.forEach(motocicleta => {
        tablaBodyMotos.innerHTML += `
            <tr>
                <td>${motocicleta.id_cliente}</td>
                <td>${motocicleta.marca}</td>
                <td>${motocicleta.modelo}</td>
                <td>${motocicleta.anio}</td>
                <td>${motocicleta.numero_serie}</td>
                <td>${motocicleta.fecha_registro}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-warning" onclick="editarMoto(${motocicleta.id_motocicleta})">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <form action="../crud/eliminarmoto.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar esta moto?');">
                        <input type="hidden" name="id_moto" value="${motocicleta.id_motocicleta}">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        `;
    });

    renderizarPaginacionMotos(data.totalPages, page);
}


searchInputMotos.addEventListener('input', () => {
    currentPageMotos = 1;
    cargarMotos(currentPageMotos, searchInputMotos.value);
});

// Carga inicial
cargarMotos();
