export async function fetchClientes(query = '') {
    try {
        const response = await fetch(`buscarcliente.php?q=${query}`);
        const clientes = await response.json();
        mostrarClientes(clientes); // Mostrar los resultados de búsqueda
    } catch (error) {
        console.error('Error al obtener los clientes:', error);
    }
}
