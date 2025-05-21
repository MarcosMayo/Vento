$(document).ready(function () {
  $('#cliente').select2({
    placeholder: 'Buscar cliente...',
    ajax: {
      url: '../logica/obtener_clientes.php',
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          term: params.term
        };
      },
      processResults: function (data) {
        return {
          results: data.map(cliente => ({
            id: cliente.id_cliente,
            text: cliente.nombre_completo
          }))
        };
      },
      cache: true
    }
  });

  // Cargar motos al seleccionar cliente
  $('#cliente').on('change', function () {
    const idCliente = $(this).val();

    const motoSelect = document.getElementById('motocicleta');
    motoSelect.innerHTML = '<option value="">Cargando motos...</option>';
    motoSelect.disabled = true;

    fetch(`../logica/obtener_motos_por_cliente.php?id_cliente=${idCliente}`)
      .then(res => res.json())
      .then(data => {
        motoSelect.innerHTML = '<option value="">Selecciona una moto</option>';
        data.forEach(moto => {
          const option = document.createElement('option');
          option.value = moto.id_motocicleta;
          option.textContent = `${moto.marca} - ${moto.modelo} (${moto.numero_serie})`;
          motoSelect.appendChild(option);
        });
        motoSelect.disabled = false;
      });
  });
});
