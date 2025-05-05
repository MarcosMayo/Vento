async function buscarCliente() {
  const busqueda = document.getElementById('modalClientes').value;

  // Verificar que no esté vacío
  if (busqueda.trim() === '') {
      document.getElementById('tablaResultadosClientes').innerHTML = '';
      return;
  }

  // Enviar la búsqueda al servidor
  const response = await fetch('../logica/buscarcliente.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `busqueda=${busqueda}`
  });

  const data = await response.json();

  // Mostrar los resultados
  if (data.success) {
      let resultadosHTML = '<table class="table table-striped">';
      resultadosHTML += '<thead><tr><th>Nombre</th><th>Acción</th></tr></thead><tbody>';

      data.clientes.forEach(cliente => {
          resultadosHTML += `
              <tr>
                  <td>${cliente.nombre}</td>
                  <td><button class="btn btn-primary" onclick="seleccionarCliente(${cliente.id_cliente}, '${cliente.nombre}')">Seleccionar</button></td>
              </tr>
          `;
      });

      resultadosHTML += '</tbody></table>';
      document.getElementById('tablaResultadosClientes').innerHTML = resultadosHTML;
  } else {
      document.getElementById('tablaResultadosClientes').innerHTML = 'No se encontraron clientes.';
  }
}

// Función para seleccionar un cliente
function seleccionarCliente(id_cliente, nombre) {
  // Establecer el ID del cliente en el formulario de agregar moto
  document.getElementById('id_cliente').value = id_cliente;
  // Establecer el nombre del cliente en el input del formulario
  document.getElementById('nombre_cliente').value = nombre;

  // Cerrar el modal de búsqueda de cliente
  $('#modalClientes').modal('hide');
}

