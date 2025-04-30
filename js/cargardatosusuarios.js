let currentPage = 1;
let totalPages = 1;
const resultsPerPage = 5;

// Cargar datos de la tabla con paginación y búsqueda
function loadData(page = 1) {
    const search = document.getElementById("searchInput").value;
    const url = `backend.php?page=${page}&search=${search}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            totalPages = Math.ceil(data.totalResults / resultsPerPage);
            currentPage = page;

            renderTable(data.results);
            renderPagination();
        });
}
