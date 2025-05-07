document.addEventListener('DOMContentLoaded', () => {
    const inputBusqueda = document.getElementById('busquedaCliente');
    const resultadosDiv = document.getElementById('tablaResultadosClientes');

    inputBusqueda.addEventListener('input', () => {
        const query = inputBusqueda.value.trim();

        if (query.length === 0) {
            resultadosDiv.innerHTML = '';
            return;
        }

        fetch(`../logica/buscarcliente.php?q=${encodeURIComponent(query)}`)
            .then(response => response.text())
            .then(html => {
                resultadosDiv.innerHTML = html;
            })
            .catch(error => {
                console.error('Error en la búsqueda:', error);
                resultadosDiv.innerHTML = '<p class="text-danger">Error al buscar clientes.</p>';
            });
    });
});

function seleccionarCliente(id, nombreCompleto) {
    document.getElementById('id_cliente').value = id;
    document.getElementById('nombre_cliente').value = nombreCompleto;

    const modal = bootstrap.Modal.getInstance(document.getElementById('modalClientes'));
    modal.hide();
}
