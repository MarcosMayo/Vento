
function abrirModalEditarMoto(id, cliente, marca, modelo, anio, numero_serie, fecha_registro) {
    document.getElementById('editar-id-motocicleta').value = id;
    document.getElementById('editar-cliente').value = cliente;
    document.getElementById('editar-marca').value = marca;
    document.getElementById('editar-modelo').value = modelo;
    document.getElementById('editar-anio').value = anio;
    document.getElementById('editar-numero-serie').value = numero_serie;
    document.getElementById('editar-fecha-registro').value = fecha_registro;

    const modal = new bootstrap.Modal(document.getElementById('editarMotoModal'));
    modal.show();
}


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

    // Botón anterior (←)
    paginacionMotos.innerHTML += `
        <li class="page-item ${current === 1 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="if(${current} > 1) cargarMotos(${current - 1}, '${searchInputMotos.value}')">←</a>
        </li>
    `;

    // Botones numéricos centrados
    for (let i = start; i <= end; i++) {
        paginacionMotos.innerHTML += `
            <li class="page-item ${i === current ? 'active' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="cargarMotos(${i}, '${searchInputMotos.value}')">${i}</a>
            </li>
        `;
    }

    // Botón siguiente (→)
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
    data.motos.forEach(moto => {
        tablaBodyMotos.innerHTML += `
            <tr>
                <td>${moto.cliente}</td>
                <td>${moto.marca}</td>
                <td>${moto.modelo}</td>
                <td>${moto.anio}</td>
                <td>${moto.numero_serie}</td>
                <td>${moto.fecha_registro}</td>
                <td class="text-center">
                    <button 
  class="btn btn-sm btn-warning btn-editar-moto"
  data-id="${moto.id_motocicleta}"
  data-cliente="${moto.cliente}"
  data-marca="${moto.marca}"
  data-modelo="${moto.modelo}"
  data-anio="${moto.anio}"
  data-numero_serie="${moto.numero_serie}"
  data-fecha_registro="${moto.fecha_registro}">
    <i class="bi bi-pencil-square"></i>
</button>


                    <button class="btn btn-sm btn-danger" onclick="eliminarMoto(${moto.id_motocicleta})">
    <i class="bi bi-trash"></i>
</button>

                </td>
            </tr>
        `;
    });

    // Renderizar paginación
    renderizarPaginacionMotos(data.totalPages, page);   
}

// Buscar mientras se escribe
searchInputMotos.addEventListener('input', () => {
    currentPageMotos = 1;
    cargarMotos(currentPageMotos, searchInputMotos.value);
});



// Cargar al inicio
cargarMotos();

// ESCUCHA DE EVENTO PARA BOTÓN DE EDITAR
document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-editar-moto')) {
        const btn = e.target.closest('.btn-editar-moto');

        document.getElementById('editar-id-motocicleta').value = btn.dataset.id;
        document.getElementById('editar-cliente').value = btn.dataset.cliente;
        document.getElementById('editar-marca').value = btn.dataset.marca;
        document.getElementById('editar-modelo').value = btn.dataset.modelo;
        document.getElementById('editar-anio').value = btn.dataset.anio;
        document.getElementById('editar-numero-serie').value = btn.dataset.numero_serie;
        document.getElementById('editar-fecha-registro').value = btn.dataset.fecha_registro;

        const modal = new bootstrap.Modal(document.getElementById('editarMotoModal'));
        modal.show();
    }
});
