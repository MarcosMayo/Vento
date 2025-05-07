document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("input-cliente");
    const contenedorSugerencias = document.getElementById("contenedor-sugerencias");
    const inputId = document.getElementById("input-id-cliente");
  
    input.addEventListener("input", async () => {
      const texto = input.value.trim();
      contenedorSugerencias.innerHTML = "";
  
      if (texto.length === 0) return;
  
      try {
        const response = await fetch(`../logica/autocom.php?term=${encodeURIComponent(texto)}`);
        const sugerencias = await response.json();
  
        sugerencias.forEach(rep => {
          const div = document.createElement("div");
          div.textContent = rep.nombre_completo;
          div.classList.add("suggestion-item");
          div.addEventListener("click", () => {
            input.value = rep.nombre_completo;
            inputId.value = rep.id_cliente;
            contenedorSugerencias.innerHTML = "";
          });
          contenedorSugerencias.appendChild(div);
        });
      } catch (error) {
        console.error("Error al buscar representantes:", error);
      }
    });
  
    document.addEventListener("click", (e) => {
      if (!contenedorSugerencias.contains(e.target) && e.target !== input) {
        contenedorSugerencias.innerHTML = "";
      }
    });
  });
  