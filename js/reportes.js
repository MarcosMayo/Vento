function filtrarVentas() {
  const desde = document.getElementById('filtroDesde').value;
  const hasta = document.getElementById('filtroHasta').value;
  const cliente = document.getElementById('filtroCliente').value;

  const formData = new FormData();
  formData.append('desde', desde);
  formData.append('hasta', hasta);
  formData.append('cliente', cliente);

  fetch('../logica/ventas_filtradas.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(html => {
    document.getElementById('tablaVentas').innerHTML = html;
  })
  .catch(err => {
    console.error('Error al cargar ventas:', err);
    document.getElementById('tablaVentas').innerHTML = '<div class="alert alert-danger">No se pudo cargar el reporte.</div>';
  });
} 
