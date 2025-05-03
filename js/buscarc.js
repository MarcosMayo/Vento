function abrirModalClientes() {
    let modal = new bootstrap.Modal(document.getElementById('modalClientes'));
    modal.show();
  }
  
  function buscarCliente() {
    const query = document.getElementById('busquedaCliente').value;
  
    fetch('buscar_clientes.php?query=' + encodeURIComponent(query))
      .then(res => res.json())
      .then(clientes => {
        let html = '<table class="table table-bordered">';
        html += '<thead><tr><th>Nombre</th><th>Acción</th></tr></thead><tbody>';
        clientes.forEach(cliente => {
          html += `<tr>
                    <td>${cliente.nombre}</td>
                    <td><button class="btn btn-sm btn-success" onclick="seleccionarCliente(${cliente.id_cliente}, '${cliente.nombre}')">Seleccionar</button></td>
                  </tr>`;
        });
        html += '</tbody></table>';
        document.getElementById('tablaResultadosClientes').innerHTML = html;
      });
  }
  
  function seleccionarCliente(id, nombre) {
    document.getElementById('id_cliente').value = id;
    document.getElementById('nombre_cliente').value = nombre;
  
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalClientes'));
    modal.hide();
  }
  