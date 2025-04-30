// Renderizar los resultados en la tabla
function renderTable(results) {
    const tableBody = document.getElementById("tableBody");
    tableBody.innerHTML = "";

    results.forEach(result => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${result.id_usu}</td>
            <td>${result.nombre}</td>
            <td>${result.nombre_rol}</td>
            <td><button class="btn btn-info">Editar</button></td>
        `;
        tableBody.appendChild(row);
    });
}