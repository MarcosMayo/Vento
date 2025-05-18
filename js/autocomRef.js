
function activarAutocompletado(input) {
  input.addEventListener('input', function () {
    const termino = input.value;
    const fila = input.closest('tr');
    const sugerencias = fila.querySelector('.sugerencias');

    if (termino.length < 2) {
      sugerencias.innerHTML = '';
      sugerencias.style.display = 'none';
      return;
    }

    fetch('../logica/buscar_refacciones.php?term=' + encodeURIComponent(termino))
      .then(res => res.json())
      .then(data => {
        sugerencias.innerHTML = '';
        sugerencias.style.display = 'block';

        data.forEach(ref => {
          const div = document.createElement('div');
          div.textContent = `${ref.nombre_refaccion} ($${ref.precio})`;
          div.style.cursor = 'pointer';
          div.style.padding = '5px';
          div.addEventListener('click', () => {
            fila.querySelector('.refaccion-id').value = ref.id_refaccion;
            input.value = ref.nombre_refaccion;

            const precioInput = fila.querySelector('.precio');
            const cantidadInput = fila.querySelector('.cantidad');

            precioInput.value = ref.precio;

            // Forzar actualización del subtotal y total
            precioInput.dispatchEvent(new Event('input'));
            cantidadInput.dispatchEvent(new Event('input'));

            sugerencias.innerHTML = '';
            sugerencias.style.display = 'none';
          });
          sugerencias.appendChild(div);
        });
      });
  });

  input.addEventListener('blur', function () {
    setTimeout(() => {
      const fila = input.closest('tr');
      const sugerencias = fila.querySelector('.sugerencias');
      sugerencias.innerHTML = '';
      sugerencias.style.display = 'none';
    }, 200); // Espera breve para permitir el clic en la sugerencia
  });
}

