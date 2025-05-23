<div class="card">
  <div class="card-body">
    <h5 class="card-title">Servicios más solicitados</h5>
    <p class="text-muted">Listado de los servicios con mayor demanda en el taller.</p>

    <button class="btn btn-danger mb-3" onclick="exportarServiciosPDF()">Exportar a PDF</button>

    <div id="tablaServiciosSolicitados"></div>
    <div id="paginacionServiciosSolicitados" class="text-center mt-2"></div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => cargarServiciosSolicitados(1));

function cargarServiciosSolicitados(pagina = 1) {
  fetch('../reportes/servicios_mas_solicitados.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ pagina })
  })
    .then(res => res.json())
    .then(data => {
      document.getElementById('tablaServiciosSolicitados').innerHTML = data.tabla;
      document.getElementById('paginacionServiciosSolicitados').innerHTML = data.paginacion;
    });
}

function exportarServiciosPDF() {
  window.open('../reportes/pdf_servicios_solicitados.php', '_blank');
}
</script>
