
document.addEventListener('DOMContentLoaded', () => {
  cargarMotocicletas();
  cargarServicios();
  cargarEmpleados();
  cargarFechaHoraActual();

  // Eventos
  document.getElementById('servicio').addEventListener('change', cargarRefaccionesDelServicio);
});

// Cargar motocicletas
function cargarMotocicletas() {
  fetch('../logica/obtener_motocicletas.php')
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById('motocicleta');
      select.innerHTML = '<option value="">Selecciona una motocicleta</option>';
      data.forEach(moto => {
        select.innerHTML += `<option value="${moto.id_motocicleta}">${moto.marca} ${moto.modelo} (${moto.anio})</option>`;
      });
    });
}

// Cargar servicios
function cargarServicios() {
  fetch('../logica/obtener_Servicios.php')
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById('servicio');
      select.innerHTML = '<option value="">Selecciona un servicio</option>';
      data.forEach(serv => {
        select.innerHTML += `<option value="${serv.id_servicio}" data-mano-obra="${serv.mano_obra}">${serv.nombre_servicio}</option>`;
      });
    });
}

// Cargar empleados
function cargarEmpleados() {
  fetch('../logica/obtener_Empleados.php')
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById('empleado');
      select.innerHTML = '<option value="">Selecciona un empleado</option>';
      data.forEach(emp => {
        select.innerHTML += `<option value="${emp.id_empleado}">${emp.nombre} ${emp.apellido_paterno}</option>`;
      });
    });
}

// Cargar fecha y hora actual
function cargarFechaHoraActual() {
  const fecha = new Date();
  document.getElementById('fecha').value = fecha.toISOString().slice(0, 10);
  document.getElementById('hora').value = fecha.toTimeString().slice(0, 5);
}
