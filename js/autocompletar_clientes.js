document.addEventListener('DOMContentLoaded', () => {
  const inputCliente = document.getElementById('clienteVenta');
  const contenedor = document.createElement('div');
  contenedor.className = 'sugerencias-clientes';
  contenedor.style.position = 'absolute';
  contenedor.style.backgroundColor = '#fff';
  contenedor.style.border = '1px solid #ccc';
  contenedor.style.zIndex = '1000';
  contenedor.style.width = '100%';
  inputCliente.parentNode.appendChild(contenedor);

  inputCliente.addEventListener('input', function () {
    const valor = inputCliente.value.trim();
    contenedor.innerHTML = '';
    if (valor.length < 2) return;

    fetch(`../logica/buscar_Clientesventas.php?term=${encodeURIComponent(valor)}`)
      .then(res => res.json())
      .then(data => {
        contenedor.innerHTML = '';
        data.forEach(cliente => {
          const div = document.createElement('div');
          div.textContent = cliente.nombre_completo;
          div.style.cursor = 'pointer';
          div.style.padding = '4px';
          div.addEventListener('click', () => {
  inputCliente.value = cliente.nombre_completo;
  document.getElementById('clienteVentaId').value = cliente.id_cliente; // 👈 este es el paso que faltaba
  contenedor.innerHTML = '';
});

          contenedor.appendChild(div);
        });
      });
  });

  document.addEventListener('click', (e) => {
    if (!contenedor.contains(e.target) && e.target !== inputCliente) {
      contenedor.innerHTML = '';
    }
  });
});
