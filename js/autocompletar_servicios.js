
document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('servicio_nombre');
  const sugerencias = document.getElementById('sugerenciasServicios');
  const inputHidden = document.getElementById('servicio_id');
  const manoObraInput = document.getElementById('manoObraOrden');

  input.addEventListener('input', function () {
    const termino = input.value.trim();

    if (termino.length < 2) {
      sugerencias.innerHTML = '';
      sugerencias.style.display = 'none';
      return;
    }

    fetch('../logica/obtener_Servicios.php?term=' + encodeURIComponent(termino))
      .then(res => res.json())
      .then(data => {
        sugerencias.innerHTML = '';
        sugerencias.style.display = 'block';

        data.forEach(serv => {
          const div = document.createElement('div');
          div.textContent = `${serv.nombre_servicio} ($${serv.mano_obra})`;
          div.style.padding = '5px';
          div.style.cursor = 'pointer';
          div.addEventListener('click', () => {
            input.value = serv.nombre_servicio;
            inputHidden.value = serv.id_servicio;
            manoObraInput.value = parseFloat(serv.mano_obra).toFixed(2);

            sugerencias.innerHTML = '';
            sugerencias.style.display = 'none';

            cargarRefaccionesDelServicio(serv.id_servicio);
          });
          sugerencias.appendChild(div);
        });
      });
  });

  input.addEventListener('blur', function () {
    setTimeout(() => {
      sugerencias.innerHTML = '';
      sugerencias.style.display = 'none';
    }, 200);
  });
});
