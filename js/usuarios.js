// js/usuarios.js
let currentPageUsuarios = 1;
const limit = 5;
const tablaBody = document.getElementById('tablaUsuarios');
const paginacion = document.getElementById('paginacionUsuarios');
const searchInputUsuarios = document.getElementById('searchInput');

function abrirModalEditar(id, nombre, idRol) {
    document.getElementById('editarId').value = id;
    document.getElementById('editarNombre').value = nombre;
    document.getElementById('editarRol').value = idRol;

    const modal = new bootstrap.Modal(document.getElementById('editarUsuarioModal'));
    modal.show();
}

function renderizarPaginacion(totalPages, current) {
    paginacion.innerHTML = '';
    const maxVisible = 5;
    let start = Math.max(1, current - Math.floor(maxVisible / 2));
    let end = start + maxVisible - 1;

    if (end > totalPages) {
        end = totalPages;
        start = Math.max(1, end - maxVisible + 1);
    }

    paginacion.innerHTML += `
        <li class="page-item ${current === 1 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="cargarUsuarios(${current - 1})">←</a>
        </li>
    `;

    for (let i = start; i <= end; i++) {
        paginacion.innerHTML += `
            <li class="page-item ${i === current ? 'active' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="cargarUsuarios(${i})">${i}</a>
            </li>
        `;
    }

    paginacion.innerHTML += `
        <li class="page-item ${current === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="cargarUsuarios(${current + 1})">→</a>
        </li>
    `;
}

async function cargarUsuarios(page = 1, search = '') {
    currentPageUsuarios = page;

    const res = await fetch(`../logica/usuarioslogica.php?page=${page}&limit=${limit}&search=${encodeURIComponent(search)}`);
    const data = await res.json();

    tablaBody.innerHTML = '';

const idActual = idUsuarioActual;


    data.usuarios.forEach(usuario => {
        const esAdmin = usuario.id_rol == 1;
        const soyYo = usuario.id_usu == idActual;
        const puedeEliminar = !esAdmin && !soyYo;

        tablaBody.innerHTML += `
            <tr>
                <td>${usuario.nombre}</td>
                <td>${usuario.nombre_rol}</td>
                <td>${usuario.contraseña}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-warning" onclick="abrirModalEditar(${usuario.id_usu}, '${usuario.nombre}', ${usuario.id_rol})">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    ${puedeEliminar ? `
                    <button class="btn btn-sm btn-danger" onclick="eliminarUsuario(${usuario.id_usu})">
                        <i class="bi bi-trash"></i>
                    </button>` : ''}
                </td>
            </tr>
        `;
    });

    renderizarPaginacion(data.totalPages, page);
}


// Buscar mientras se escribe
searchInputUsuarios.addEventListener('input', () => {
    cargarUsuarios(1, searchInputUsuarios.value);
});

// Cargar usuarios al inicio
document.addEventListener('DOMContentLoaded', () => {
    cargarUsuarios();
});
