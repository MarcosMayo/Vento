let currentPage = 1;
let searchTerm = "";
let equiposData = [];

// 1. Fetch de usuarios
function fetchData(page = 1, search = "") {
  fetch('../logica/usuarioslogica.php?page=${page}&search=${encodeURIComponent(search)}')
    .then(res => res.json())
    .then(data => {
      renderTable(data.records);
      renderPagination(data.totalPages, page);
    });
}

// 2. Render de tabla
function renderTable(rows) {
  const tbody = document.querySelector("#tablaUsuarios tbody");
  tbody.innerHTML = "";

  const fragment = document.createDocumentFragment();

  rows.forEach(row => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${row.nombre_equipo}</td>
      <td>${row.nombre}</td>
      <td>${row.apellidos}</td>
      <td>${row.fecha_nacimiento}</td>
      <td>
        <button 
          class="btn-edit"
          data-id-jugador="${row.id_jugador}" 
          data-nombre="${row.nombre}" 
          data-apellidos="${row.apellidos}"
          data-fecha-nacimiento="${row.fecha_nacimiento}"
          data-id-equipo="${row.id_equipo}" 
          data-bs-toggle="modal" 
          data-bs-target="#updatePlayerModal">✏</button>
        <button class="btn-delete" data-id="${row.id_jugador}">🗑</button>
      </td>`;
    fragment.appendChild(tr);
  });

  tbody.appendChild(fragment);
}
// en data-id-rol="${row.id_rol}" utiliza el rol de la tabla usuarios



// 3. Paginación
function renderPagination(totalPages, current) {
  const pagination = document.getElementById("pagination");
  pagination.innerHTML = "";

  const createBtn = (text, page, isActive = false) => {
    const btn = document.createElement("button");
    btn.textContent = text;
    if (isActive) btn.classList.add("active");
    btn.addEventListener("click", () => {
      currentPage = page;
      fetchData(currentPage, searchTerm);
    });
    return btn;
  };

  // Botón "<" (anterior)
  if (current > 1) {
    pagination.appendChild(createBtn("<", current - 1));
  }

  // Botones de páginas
  for (let i = 1; i <= totalPages; i++) {
    pagination.appendChild(createBtn(i, i, i === current));
  }

  // Botón ">" (siguiente)
  if (current < totalPages) {
    pagination.appendChild(createBtn(">", current + 1));
  }
}

document.getElementById("searchInput").addEventListener("input", (e) => {
  searchTerm = e.target.value;
  currentPage = 1;
  fetchData(currentPage, searchTerm);
});



import { loadSelect } from './obtener-datos.js';

loadSelect({
  url: "./php/equipos.php", 
  selectId: "setEquipos", // ID del select que usas en tu formulario/modal
  placeholder: "Selecciona un equipo"
}).then((equipos) => {
  equiposData = equipos; // Almacena los equipos en variable global
  fetchData(); // Luego de cargar los equipos, carga la tabla de jugadores
});


// 7. Abrir modal y llenar datos
document.addEventListener("click", async function (e) {
  if (e.target.classList.contains("btn-edit")) {
    const btn = e.target;

    // Setear los valores en los inputs del modal de jugadores
    document.getElementById("inputNombreJugador").value = btn.dataset.nombre;
    document.getElementById("inputApellidos").value = btn.dataset.apellidos;
    document.getElementById("inputFechaNacimiento").value = btn.dataset.fechaNacimiento;
    document.getElementById("inputJugadorId").value = btn.dataset.idJugador;


    const idEquipo = btn.dataset.idEquipo;

    const selectEquipo = document.getElementById("selectEquipo");
    selectEquipo.innerHTML = '<option disabled>Equipo</option>';

    console.log("Equipos cargados:", equiposData);
    console.log("ID del equipo del jugador:", idEquipo);

    equiposData.forEach(equipo => {
      const option = document.createElement("option");
      option.value = equipo.id_equipo;
      option.textContent = equipo.nombre;
      if (equipo.id_equipo == idEquipo) {
        option.selected = true;
      }
      selectEquipo.appendChild(option);
    });
  }
});

document.addEventListener("DOMContentLoaded", () => {
  // fetchRoles(); // Ya no es necesario, porque los roles se cargan con loadSelect
  fetchData(); // Cargar los usuarios
});