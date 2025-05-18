
document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('motocicleta_nombre');
  const sugerencias = document.getElementById('sugerenciasMotos');
  const inputHidden = document.getElementById('motocicleta_id');

  input.addEventListener('input', function () {
    const termino = input.value.trim();

    if (termino.length < 2) {
      sugerencias.innerHTML = '';
      sugerencias.style.display = 'none';
      return;
    }

    fetch('../logica/obtener_motocicletas.php?term=' + encodeURIComponent(termino))
      .then(res => res.json())
      .then(data => {
        sugerencias.innerHTML = '';
        sugerencias.style.display = 'block';

        data.forEach(moto => {
          const div = document.createElement('div');
          div.textContent = `${moto.marca} ${moto.modelo} (${moto.anio})`;
          div.style.padding = '5px';
          div.style.cursor = 'pointer';
          div.addEventListener('click', () => {
            input.value = `${moto.marca} ${moto.modelo} (${moto.anio})`;
            inputHidden.value = moto.id_motocicleta;
            sugerencias.innerHTML = '';
            sugerencias.style.display = 'none';
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
