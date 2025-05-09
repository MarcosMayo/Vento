const tablaBodyEmpleados = document.getElementById('tablaEmpleados');
const paginacionEmpleados = document.getElementById('paginacionEmpleados');
const searchInputEmpleados = document.getElementById('searchInputEmpleados');

let currentPageEmpleados = 1;
const limitEmpleados = 5;

function renderizarPaginacionEmpleados(totalPages, current) {
    paginacionEmpleados.innerHTML = '';
    const maxVisible = 5;
    let start = Math.max(1, current - Math.floor(maxVisible / 2));
    let end = start + maxVisible - 1;
    if (end > totalPages) {
        end = totalPages;
        start = Math.max(1, end - maxVisible + 1);
    }

    paginacionEmpleados.innerHTML += `
        <li class="page-item ${current === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="if(${current} > 1) cargarEmpleados(${current - 1}, searchInputEmpleados.value)">←</a>
        </li>`;

    for (let i = start; i <= end; i++) {
        paginacionEmpleados.innerHTML += `
            <li class="page-item ${i === current ? 'active' : ''}">
                <a class="page-link" href="#" onclick="cargarEmpleados(${i}, searchInputEmpleados.value)">${i}</a>
            </li>`;
    }

    paginacionEmpleados.innerHTML += `
        <li class="page-item ${current === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="if(${current} < ${totalPages}) cargarEmpleados(${current + 1}, searchInputEmpleados.value)">→</a>
        </li>`;
}

async function cargarEmpleados(page = 1, search = '') {
    const response = await fetch(`../logica/empleadolog.php?page=${page}&limit=${limitEmpleados}&search=${search}`);
    const data = await response.json();

    tablaBodyEmpleados.innerHTML = '';
    data.empleados.forEach(emp => {
        tablaBodyEmpleados.innerHTML += `
            <tr>
                <td>${emp.nombre}</td>
                <td>${emp.apellido_p}</td>
                <td>${emp.apellido_m}</td>
                <td>${emp.telefono}</td>
                <td>${emp.email}</td>
                <td>${emp.direccion}</td>
                <td>${emp.puesto}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-warning" onclick="abrirModalEditarEmpleado(${emp.id_empleado}, '${emp.nombre}', '${emp.apellido_p}', '${emp.apellido_m}', '${emp.telefono}', '${emp.email}', '${emp.direccion}', ${emp.id_puesto})">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarEmpleado(${emp.id_empleado})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>`;
    });

    renderizarPaginacionEmpleados(data.totalPages, page);
}

// Abrir el modal de edición con los datos del empleado
function abrirModalEditarEmpleado(id, nombre, apellidoP, apellidoM, telefono, correo, direccion, idPuesto) {
    document.getElementById('editar_id_empleado').value = id;
    document.getElementById('editar_nombre').value = nombre;
    document.getElementById('editar_apellido_paterno').value = apellidoP;
    document.getElementById('editar_apellido_materno').value = apellidoM;
    document.getElementById('editar_telefono').value = telefono;
    document.getElementById('editar_correo').value = correo;
    document.getElementById('editar_direccion').value = direccion;
    document.getElementById('editar_id_puesto').value = idPuesto;

    const modal = new bootstrap.Modal(document.getElementById('editarEmpleadoModal'));
    modal.show();
}

// Enviar datos modificados del formulario de edición
document.getElementById('formEditarEmpleado').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const response = await fetch('../logica/editar_empleado.php', {
        method: 'POST',
        body: formData
    });

    const resultado = await response.json();

    if (resultado.success) {
        bootstrap.Modal.getInstance(document.getElementById('editarEmpleadoModal')).hide();
        cargarEmpleados(currentPageEmpleados, searchInputEmpleados.value);
    } else {
        alert('Error al actualizar el empleado');
    }
});

// Buscar mientras se escribe
searchInputEmpleados.addEventListener('input', () => {
    currentPageEmpleados = 1;
    cargarEmpleados(currentPageEmpleados, searchInputEmpleados.value);
});

// Cargar empleados al iniciar
cargarEmpleados();
