// Cambiar el texto del eslogan cada 3.5 segundos (index.html)
const slogans = [
            "Más que solo comer: una experiencia salvaje",
            "Donde cada bocado tiene carácter",
            "No domamos la cocina, la perfeccionamos",
            "Sabor que despierta tus sentidos",
            "Atrévete a probar lo salvaje",
            "Tu próxima aventura gourmet"
        ];
        let idx = 0;
        setInterval(() => {
            idx = (idx + 1) % slogans.length;
            document.getElementById('slogan-text').textContent = slogans[idx];
        }, 3500);

/* ----- Todo lo de los Formularios (form) ----- */
// - Mostrar/Ocultar Contraseñas -
document.querySelectorAll('.toggle-password').forEach(btn => {
  btn.addEventListener('click', () => {
    const targetId = btn.getAttribute('data-target');
    const input = document.getElementById(targetId);
    const icon = btn.querySelector('i');

    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("bi-eye");
      icon.classList.add("bi-eye-slash");
    } else {
      input.type = "password";
      icon.classList.remove("bi-eye-slash");
      icon.classList.add("bi-eye");
    }
  });
});

// Validación de contraseñas antes de enviar el form
const formRegistro = document.querySelector('#pills-register form');
const pass1        = document.getElementById('clave');
const pass2        = document.getElementById('clave2');

function validarPasswords() {
  if (pass1.value && pass2.value && pass1.value !== pass2.value) {
    pass2.setCustomValidity("⚠️ Las contraseñas no coinciden");
  } else {
    pass2.setCustomValidity(""); // Limpia si coinciden o están vacías
  }
}

//--- Ejecutar al escribir en ambos campos ---
pass1.addEventListener('input', validarPasswords);
pass2.addEventListener('input', validarPasswords);

//--- Validar también al enviar ---
formRegistro.addEventListener('submit', e => {
  validarPasswords(); // Revisa otra vez antes de enviar
  if (!formRegistro.checkValidity()) {
    e.preventDefault();
    pass2.reportValidity(); // muestra la burbuja en el campo que falló
  }
});

// Aparición - Modal Términos y Condiciones
function abrirModal() {
  document.getElementById("modalTerminos").style.display = "block";
}

function cerrarModal() {
  document.getElementById("modalTerminos").style.display = "none";
}

// -- Cierra el modal si el usuario hace clic fuera del contenido --
window.onclick = function(event) {
  const modal = document.getElementById("modalTerminos");
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

//Visualización de Imagen Subida (Solo para, form_productos.html)
  const fileInput = document.getElementById('imagenProducto');
  const preview = document.getElementById('previewContainer');

  fileInput.addEventListener('change', () => {
    console.log("📂 Archivo seleccionado:", fileInput.files[0]);
    preview.innerHTML = '';
    const file = fileInput.files[0];
    if (!file) return;

    const img = document.createElement('img');
    img.src = URL.createObjectURL(file);
    img.onload = () => URL.revokeObjectURL(img.src);
    preview.appendChild(img);
  });