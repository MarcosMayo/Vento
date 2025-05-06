function abrirModalEditarMoto(id, cliente, marca, modelo, anio, numero_serie, fecha_ingreso) {
    document.getElementById('editarIdMoto').value = id;
    document.getElementById('editarClienteMoto').value = cliente;
    document.getElementById('editarMarcaMoto').value = marca;
    document.getElementById('editarModeloMoto').value = modelo;
    document.getElementById('editarAnioMoto').value = anio;
    document.getElementById('editarNumeroSerieMoto').value = numero_serie;
    document.getElementById('editarFechaIngresoMoto').value = fecha_ingreso;

    const modal = new bootstrap.Modal(document.getElementById('editarMotoModal'));
    modal.show();
}
async function buscarCliente() {
    const nombre = document.getElementById('busquedaCliente').value;
    const response = await fetch(`../logica/buscarcliente.php?nombre=${encodeURIComponent(nombre)}`);
    const data = await response.json();

    const contenedor = document.getElementById('tablaResultadosClientes');
    contenedor.innerHTML = `
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre completo</th>
                    <th>Teléfono</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                ${data.map(cliente => `
                    <tr>
                        <td>${cliente.nombre} ${cliente.apellido_paterno} ${cliente.apellido_materno}</td>
                        <td>${cliente.telefono}</td>
                        <td>
                            <button class="btn btn-success btn-sm" onclick="seleccionarCliente(${cliente.id}, '${cliente.nombre} ${cliente.apellido_paterno} ${cliente.apellido_materno}')">
                                Seleccionar
                            </button>
                        </td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
}
function seleccionarCliente(id, nombreCompleto) {
    document.getElementById('id_cliente').value = id;
    document.getElementById('nombre_cliente').value = nombreCompleto;

    // Cierra el modal de clientes
    const modalClientes = bootstrap.Modal.getInstance(document.getElementById('modalClientes'));
    modalClientes.hide();
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
                    <button class="btn btn-sm btn-warning" onclick="abrirModalEditarMoto(${moto.id_moto}, '${moto.cliente}', '${moto.marca}', '${moto.modelo}', '${moto.anio}', '${moto.numero_serie}', '${moto.fecha_ingreso}')">
                        <i class="bi bi-pencil-square"></i>
                    </button>

                    <form action="../crud/eliminarmoto.php" method="POST" style="display:inline;" onsubmit="return confirmar();">
                        <input type="hidden" name="id_moto" value="${moto.id_moto}">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
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
function abrirModalClientes() {
    const modal = new bootstrap.Modal(document.getElementById('modalClientes'));
    modal.show();
}


// Cargar al inicio
cargarMotos();
