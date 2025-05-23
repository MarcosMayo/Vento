<div class="card mb-4">
  <div class="card-body">
    <h5 class="card-title">Órdenes por Rango de Fecha</h5>
    <div class="row mb-3">
      <div class="col-md-5">
        <label>Desde:</label>
        <input type="date" id="ordenDesde" class="form-control">
      </div>
      <div class="col-md-5">
        <label>Hasta:</label>
        <input type="date" id="ordenHasta" class="form-control">
      </div>
      <div class="col-md-2">
    <label>Estatus:</label>
    <select id="ordenEstatus" class="form-control">
      <option value="">Todos</option>
      <option value="1">Pendiente</option>
      <option value="2">Cancelada</option>
      <option value="3">Completada</option>
    </select>
  </div>
      <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-primary w-100" onclick="cargarOrdenesPorFecha()">Buscar</button>
      </div>
    </div>

    <button class="btn btn-danger mb-3" onclick="exportarOrdenesPDF()">Exportar a PDF</button>
    <div id="tablaOrdenesFecha"></div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Órdenes Pendientes de Hoy</h5>
    <button class="btn btn-danger mb-3" onclick="exportarOrdenesHoyPDF()">Exportar a PDF</button>
    <div id="tablaOrdenesHoy"></div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  cargarOrdenesHoy();
});

function cargarOrdenesPorFecha() {
  const desde = document.getElementById('ordenDesde').value;
  const hasta = document.getElementById('ordenHasta').value;
  const estatus = document.getElementById('ordenEstatus').value;

  fetch('../reportes/ordenes_rango.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ desde, hasta, estatus })
  })
    .then(res => res.text())
    .then(html => {
      document.getElementById('tablaOrdenesFecha').innerHTML = html;
    });
}


function cargarOrdenesHoy() {
  fetch('../reportes/ordenes_pendientes_hoy.php')
    .then(res => res.text())
    .then(html => {
      document.getElementById('tablaOrdenesHoy').innerHTML = html;
    });
}

function exportarOrdenesPDF() {
  const desde = document.getElementById('ordenDesde').value;
  const hasta = document.getElementById('ordenHasta').value;
  const estatus = document.getElementById('ordenEstatus').value;

  const params = new URLSearchParams({ desde, hasta, estatus });
  window.open('../reportes/pdf_ordenes_rango.php?' + params.toString(), '_blank');
}


function exportarOrdenesHoyPDF() {
  window.open('../reportes/pdf_ordenes_hoy.php', '_blank');
}
</script>
