<div class="card">
  <div class="card-body">
    <h5 class="card-title">Clientes con motocicletas</h5>
    <p class="text-muted">Relación entre clientes registrados y sus motocicletas.</p>

    <button class="btn btn-danger mb-3" onclick="exportarClientesMotosPDF()">Exportar a PDF</button>

    <div id="tablaClientesMotos"></div>
    <div id="paginacionClientesMotos" class="text-center mt-2"></div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => cargarClientesMotos(1));

function cargarClientesMotos(pagina = 1) {
  fetch('../reportes/clientes_motos.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ pagina })
  })
    .then(res => res.json())
    .then(data => {
      document.getElementById('tablaClientesMotos').innerHTML = data.tabla;
      document.getElementById('paginacionClientesMotos').innerHTML = data.paginacion;
    });
}

function exportarClientesMotosPDF() {
  window.open('../reportes/pdf_clientes_motos.php', '_blank');
}
</script>
