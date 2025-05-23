<div class="card mb-4">
  <div class="card-body">
    <h5 class="card-title">Ventas del día</h5>
    <button class="btn btn-danger mb-3" onclick="exportarVentasHoyPDF()">Exportar a PDF</button>
    <div id="tablaVentasHoy"></div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Ventas por rango de fecha</h5>
    <div class="row mb-3">
      <div class="col-md-5">
        <label>Desde:</label>
        <input type="date" id="ventaDesde" class="form-control">
      </div>
      <div class="col-md-5">
        <label>Hasta:</label>
        <input type="date" id="ventaHasta" class="form-control">
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-primary w-100" onclick="cargarVentasPorFecha()">Buscar</button>
      </div>
    </div>

    <button class="btn btn-danger mb-3" onclick="exportarVentasFechaPDF()">Exportar a PDF</button>
    <div id="tablaVentasFecha"></div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => cargarVentasHoy());

function cargarVentasHoy(pagina = 1) {
  fetch('../reportes/reportes_ventas_hoy.php')
    .then(res => res.text())
    .then(html => {
      document.getElementById('tablaVentasHoy').innerHTML = html;
    });
}

function cargarVentasPorFecha(pagina = 1) {
  const desde = document.getElementById('ventaDesde').value;
  const hasta = document.getElementById('ventaHasta').value;

  fetch('../reportes/ventas_fecha.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ desde, hasta, pagina })
  })
    .then(res => res.text())
    .then(html => {
      document.getElementById('tablaVentasFecha').innerHTML = html;
    });
}


function exportarVentasHoyPDF() {
  window.open('../reportes/pdf_ventas_hoy.php', '_blank');
}

function exportarVentasFechaPDF() {
  const desde = document.getElementById('ventaDesde').value;
  const hasta = document.getElementById('ventaHasta').value;
  const params = new URLSearchParams({ desde, hasta });
  window.open('../reportes/pdf_ventas_fecha.php?' + params.toString(), '_blank');
}
</script>
