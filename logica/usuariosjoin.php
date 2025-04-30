<?php

function obtenerDatosConJoin($conn, $selectFields, $fromJoinClause, $camposBusqueda, $orderBy = '', $perPage = 5) {
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $offset = ($page - 1) * $perPage;

    $params = [];
    $sqlBase = "FROM $fromJoinClause WHERE 1";

    if ($search && !empty($camposBusqueda)) {
        $likeParts = [];
        foreach ($camposBusqueda as $campo) {
            $likeParts[] = "$campo LIKE :search";
        }
        $sqlBase .= " AND (" . implode(" OR ", $likeParts) . ")";
        $params[':search'] = "%$search%";
    }

    // Total de registros
    $stmt = $conn->prepare("SELECT COUNT(*) $sqlBase");
    $stmt->execute($params);
    $total = $stmt->fetchColumn();

    // Registros paginados
    $orderClause = $orderBy ? "ORDER BY $orderBy" : "";
    $stmt = $conn->prepare("SELECT $selectFields $sqlBase $orderClause LIMIT $offset, $perPage");
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
        "records" => $rows,
        "totalPages" => ceil($total / $perPage)
    ];
}