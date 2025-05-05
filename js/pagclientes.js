function abrirModalEditarCliente(id, nombre, apellido_p, apellido_m, telefono, email, direccion) {
    document.getElementById('editarIdCliente').value = id;
    document.getElementById('editarNombreCliente').value = nombre;
    document.getElementById('editarApellidoPCliente').value = apellido_p;
    document.getElementById('editarApellidoMCliente').value = apellido_m;
    document.getElementById('editarTelefonoCliente').value = telefono;
    document.getElementById('editarEmailCliente').value = email;
    document.getElementById('editarDireccionCliente').value = direccion;

    const modal = new bootstrap.Modal(document.getElementById('editarClienteModal'));
    modal.show();
}



const tablaBodyClientes = document.getElementById('tablaClientes');
const paginacionClientes = document.getElementById('paginacionClientes');
const searchInputClientes = document.getElementById('searchInputClientes');

let currentPageClientes = 1;
const limitClientes = 5;

function renderizarPaginacionClientes(totalPages, current) {
    paginacionClientes.innerHTML = '';
    const maxVisible = 5;
    let start = Math.max(1, current - Math.floor(maxVisible / 2));
    let end = start + maxVisible - 1;

    if (end > totalPages) {
        end = totalPages;
        start = Math.max(1, end - maxVisible + 1);
    }

    // Botón anterior (←)
    paginacionClientes.innerHTML += `
        <li class="page-item ${current === 1 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="if(${current} > 1) cargarClientes(${current - 1}, '${searchInputClientes.value}')">←</a>
        </li>
    `;

    // Botones numéricos centrados
    for (let i = start; i <= end; i++) {
        paginacionClientes.innerHTML += `
            <li class="page-item ${i === current ? 'active' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="cargarClientes(${i}, '${searchInputClientes.value}')">${i}</a>
            </li>
        `;
    }

    // Botón siguiente (→)
    paginacionClientes.innerHTML += `
        <li class="page-item ${current === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="if(${current} < ${totalPages}) cargarClientes(${current + 1}, '${searchInputClientes.value}')">→</a>
        </li>
    `;
}


async function cargarClientes(page = 1, search = '') {
    const response = await fetch(`../logica/clientelog.php?page=${page}&limit=${limitClientes}&search=${search}`);
    const data = await response.json();

    tablaBodyClientes.innerHTML = '';
    data.clientes.forEach(cliente => {
        tablaBodyClientes.innerHTML += `
            <tr>
                <td>${cliente.folio}</td>
                <td>${cliente.nombre}</td>
                <td>${cliente.apellido_p}</td>
                <td>${cliente.apellido_m}</td>
                <td>${cliente.telefono}</td>
                <td>${cliente.email}</td>
                <td>${cliente.direccion}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-warning" onclick="abrirModalEditarCliente(${cliente.id_cliente}, '${cliente.nombre}', '${cliente.apellido_p}', '${cliente.apellido_m}', '${cliente.telefono}', '${cliente.email}', '${cliente.direccion}')">
                        <i class="bi bi-pencil-square"></i>
                    </button>

                    <button class="btn btn-sm btn-danger" onclick="eliminarCliente(${cliente.id_cliente})">
                   <i class="bi bi-trash"></i>
                   </button>

                </td>
            </tr>
        `;
    });

    // Renderizar paginación
    renderizarPaginacionClientes(data.totalPages, page);
}

// Buscar mientras se escribe
searchInputClientes.addEventListener('input', () => {
    currentPageClientes = 1;
    cargarClientes(currentPageClientes, searchInputClientes.value);
});

// Cargar al inicio
cargarClientes();

