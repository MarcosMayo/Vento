function renderPagination() {
    const paginationNav = document.getElementById("paginationNav");
    const paginationList = document.createElement("ul");
    paginationList.classList.add("pagination");

    for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement("li");
        li.classList.add("page-item");
        li.innerHTML = `<a class="page-link" href="javascript:void(0);" onclick="loadData(${i})">${i}</a>`;
        paginationList.appendChild(li);
    }

    paginationNav.innerHTML = "";
    paginationNav.appendChild(paginationList);
}