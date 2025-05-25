// Esperar a que el DOM esté cargado
// y verificar que los elementos existen antes de operar

document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('servicio')) {
    cargarMotocicletas();
    cargarServicios();
    cargarEmpleados();
    cargarFechaHoraActual();

    document.getElementById('servicio').addEventListener('change', cargarRefaccionesDelServicio);
  }

  const input = document.getElementById('motocicleta_nombre');
  const sugerencias = document.getElementById('sugerenciasMotos');
  const inputHidden = document.getElementById('motocicleta_id');

  if (input && sugerencias && inputHidden) {
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
  }
});

function cargarMotocicletas() {
  fetch('../logica/obtener_motocicletas.php')
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById('motocicleta');
      if (select) {
        select.innerHTML = '<option value="">Selecciona una motocicleta</option>';
        data.forEach(moto => {
          select.innerHTML += `<option value="${moto.id_motocicleta}">${moto.marca} ${moto.modelo} (${moto.anio})</option>`;
        });
      }
    });
}

function cargarServicios() {
  fetch('../logica/obtener_Servicios.php')
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById('servicio');
      if (select) {
        select.innerHTML = '<option value="">Selecciona un servicio</option>';
        data.forEach(serv => {
          select.innerHTML += `<option value="${serv.id_servicio}" data-mano-obra="${serv.mano_obra}">${serv.nombre_servicio}</option>`;
        });
      }
    });
}

function cargarEmpleados() {
  fetch('../logica/obtener_Empleados.php')
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById('empleado');
      if (select) {
        select.innerHTML = '<option value="">Selecciona un empleado</option>';
        data.forEach(emp => {
          select.innerHTML += `<option value="${emp.id_empleado}">${emp.nombre} ${emp.apellido_paterno}</option>`;
        });
      }
    });
}

function cargarFechaHoraActual() {
  const fecha = new Date();
  const fechaInput = document.getElementById('fecha');
  const horaInput = document.getElementById('hora');

  if (fechaInput) fechaInput.value = fecha.toISOString().slice(0, 10);
  if (horaInput) horaInput.value = fecha.toTimeString().slice(0, 5);
}

function cargarRefaccionesDelServicio() {
  // Aquí puedes añadir validaciones o lógica si es necesario
}
