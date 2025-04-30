
    const tablaBody = document.getElementById('tablaUsuarios');
    const paginacion = document.getElementById('paginacionUsuarios');
    const searchInput = document.getElementById('searchInput');

    let currentPage = 1;
    const limit = 10;

    async function cargarUsuarios(page = 1, search = '') {
        const response = await fetch(`../logica/usuarioslogica.php?page=${page}&limit=${limit}&search=${search}`);
        const data = await response.json();

        tablaBody.innerHTML = '';
        data.usuarios.forEach(usuario => {
            tablaBody.innerHTML += `
                <tr>
                    <td>${usuario.nombre}</td>
                    <td>${usuario.nombre_rol}</td>
                    <td>${usuario.contraseña}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal${usuario.id_usu}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <form action="../crud/eliminarusuario.php" method="POST" style="display:inline;" onsubmit="return confirmar();">
                            <input type="hidden" name="id" value="${usuario.id_usu}">
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            `;
        });

        // Renderizar paginación
        renderizarPaginacion(data.totalPages, page);
    }

    function renderizarPaginacion(totalPages, current) {
        paginacion.innerHTML = '';
        for (let i = 1; i <= totalPages; i++) {
            paginacion.innerHTML += `
                <li class="page-item ${i === current ? 'active' : ''}">
                    <a class="page-link" href="javascript:void(0);" onclick="cargarUsuarios(${i}, '${searchInput.value}')">${i}</a>
                </li>
            `;
        }
    }

    // Buscar mientras se escribe
    searchInput.addEventListener('input', () => {
        currentPage = 1;
        cargarUsuarios(currentPage, searchInput.value);
    });

    // Cargar al inicio
    cargarUsuarios();