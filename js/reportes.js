// =====================
// Reporte de Ventas
// =====================
function filtrarVentas() {
  const desde = document.getElementById('filtroDesdeVenta').value;
  const hasta = document.getElementById('filtroHastaVenta').value;
  const cliente = document.getElementById('filtroClienteVenta').value;

  fetch('../logica/ventas_filtradas.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ desde, hasta, cliente })
  })
    .then(res => res.text())
    .then(html => {
      document.getElementById('tablaVentas').innerHTML = html;
    });
}

// =====================
// Reporte de Servicios
// =====================
function filtrarServicios() {
  const desde = document.getElementById('filtroDesdeServicio').value;
  const hasta = document.getElementById('filtroHastaServicio').value;
  const empleado = document.getElementById('filtroEmpleadoServicio').value;

  fetch('../logica/reporte_servicios.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ desde, hasta, empleado })
  })
    .then(res => res.text())
    .then(html => {
      document.getElementById('tablaServicios').innerHTML = html;
    });
}

// =====================
// Reporte de Inventario
// =====================
function cargarInventario() {
  fetch('../logica/reporte_inventario.php')
    .then(res => res.text())
    .then(html => {
      document.getElementById('tablaInventario').innerHTML = html;
    });
}

// =====================
// Reporte de Órdenes de Trabajo
// =====================
function filtrarOrdenes() {
  const desde = document.getElementById('filtroDesdeOrden').value;
  const hasta = document.getElementById('filtroHastaOrden').value;
  const estatus = document.getElementById('filtroEstatusOrden').value;

  fetch('../logica/reporte_ordenes.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ desde, hasta, estatus })
  })
    .then(res => res.text())
    .then(html => {
      document.getElementById('tablaOrdenes').innerHTML = html;
    });
}

// =====================
// Reporte de Clientes Frecuentes
// =====================
function cargarClientesFrecuentes() {
  fetch('../logica/reporte_clientes.php')
    .then(res => res.text())
    .then(html => {
      document.getElementById('tablaClientesFrecuentes').innerHTML = html;
    });
}

function cargarVentas(pagina = 1) {
  const desde = document.getElementById('ventaDesde').value;
  const hasta = document.getElementById('ventaHasta').value;
  const busqueda = document.getElementById('ventaBusqueda').value;

  fetch(`../logica/ventas_paginado.php`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ pagina, desde, hasta, busqueda })
  })
    .then(res => res.json())
    .then(data => {
      document.getElementById('tablaVentas').innerHTML = data.tabla;
      document.getElementById('paginacionVentas').innerHTML = data.paginacion;
    });
}

function exportarVentasPDF() {
  const desde = document.getElementById('ventaDesde').value;
  const hasta = document.getElementById('ventaHasta').value;
  const busqueda = document.getElementById('ventaBusqueda').value;

  const params = new URLSearchParams({ desde, hasta, busqueda });
  window.open(`../logica/ventas_pdf.php?${params}`, '_blank');
}
