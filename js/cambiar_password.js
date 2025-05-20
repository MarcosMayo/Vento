document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("formCambiarPassword");

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(form);

    const res = await fetch("../crud/cambiar_password.php", {
      method: "POST",
      body: formData
    });

    const data = await res.json();

    if (data.success) {
      Swal.fire("Éxito", data.message, "success");
      const modal = bootstrap.Modal.getInstance(document.getElementById("modalCambiarPassword"));
      modal.hide();
      form.reset();
    } else {
      Swal.fire("Error", data.message, "error");
    }
  });
});
