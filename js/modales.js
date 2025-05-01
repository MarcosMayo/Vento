function abrirModalEditar(id, nombre, rol, contraseña) {
    document.getElementById('editarId').value = id;
    document.getElementById('editarNombre').value = nombre;
    document.getElementById('editarRol').value = rol;
    document.getElementById('editarContraseña').value = contraseña;

    const modal = new bootstrap.Modal(document.getElementById('editarUsuarioModal'));
    modal.show();
}
    
    
    const tablaBody = document.getElementById('tablaUsuarios');
    const paginacion = document.getElementById('paginacionUsuarios');
    const searchInput = document.getElementById('searchInput');

    let currentPage = 1;
    const limit = 5;
    function renderizarPaginacion(totalPages, current) {
        paginacion.innerHTML = '';
        const maxVisible = 5;
        let start = Math.max(1, current - Math.floor(maxVisible / 2));
        let end = start + maxVisible - 1;
    
        if (end > totalPages) {
            end = totalPages;
            start = Math.max(1, end - maxVisible + 1);
        }
    
        // Botón anterior (←)
        paginacion.innerHTML += `
            <li class="page-item ${current === 1 ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="if(${current} > 1) cargarUsuarios(${current - 1}, '${searchInput.value}')">←</a>
            </li>
        `;
    
        // Botones numéricos centrados
        for (let i = start; i <= end; i++) {
            paginacion.innerHTML += `
                <li class="page-item ${i === current ? 'active' : ''}">
                    <a class="page-link" href="javascript:void(0);" onclick="cargarUsuarios(${i}, '${searchInput.value}')">${i}</a>
                </li>
            `;
        }
    
        // Botón siguiente (→)
        paginacion.innerHTML += `
            <li class="page-item ${current === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="if(${current} < ${totalPages}) cargarUsuarios(${current + 1}, '${searchInput.value}')">→</a>
            </li>
        `;
    }
    
    
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
                        <button class="btn btn-sm btn-warning" onclick="abrirModalEditar(${usuario.id_usu}, '${usuario.nombre}', '${usuario.nombre_rol}', '${usuario.contraseña}')">
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

   
    
    

    // Buscar mientras se escribe
    searchInput.addEventListener('input', () => {
        currentPage = 1;
        cargarUsuarios(currentPage, searchInput.value);
    });

    // Cargar al inicio
    cargarUsuarios();