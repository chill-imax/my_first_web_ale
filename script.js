// Seleccionamos el ícono del menú y los enlaces de navegación
const menuIcon = document.getElementById("menu-icon"); // Icono del menú (hamburguesa)
const navLinks = document.querySelector(".nav-links"); // Contenedor de los enlaces de navegación

// Evento de clic sobre el ícono del menú
menuIcon.addEventListener("click", () => {
    // Alterna la clase 'active' para abrir o cerrar el menú
    navLinks.classList.toggle("active");

    // Cambia el estado del ícono de menú para mostrar si está abierto o cerrado
    menuIcon.classList.toggle("active");
});

//////////////////////////////

// Función para mostrar un mensaje tipo "toast" (notificación emergente)
function mostrarToast(mensaje, tipo) {

    // Crear un nuevo elemento div para el toast
    const toast = document.createElement("div");

    // Asignamos las clases necesarias para el estilo y tipo del toast
    toast.className = `toast ${tipo}`; 

    // Asignamos el mensaje de texto al toast
    toast.textContent = mensaje;

    // Añadimos el toast al cuerpo del documento
    document.body.appendChild(toast);

    // Pequeño retraso para que se active la animación de aparición
    setTimeout(() => {
        toast.classList.add("show"); // Muestra el toast
        console.log("Toast es visible:).");
    }, 10);

    // Espera 3 segundos y luego oculta el toast
    setTimeout(() => {
        toast.classList.remove("show"); // Oculta el toast
        setTimeout(() => toast.remove(), 300); // Elimina el toast del DOM después de la animación
        console.log("Toast eliminado.");
    }, 3000); // El toast estará visible durante 3 segundos
}

////////////////////////////

// Al cargar el documento, agrega un evento al formulario de contacto
console.log("JavaScript cargado");

// Espera a que todo el contenido del documento esté completamente cargado
document.addEventListener("DOMContentLoaded", function () {
    // Añade un evento de envío al formulario de contacto
    document.getElementById("contactForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Evita que la página se recargue al enviar el formulario

        // Obtenemos los datos del formulario usando FormData
        const formData = new FormData(this);

        // Realiza una solicitud POST usando fetch para enviar los datos al servidor
        fetch("enviar.php", {
            method: "POST", // Método POST
            body: formData // Los datos del formulario
        })
        .then(response => response.text()) // Convierte la respuesta en texto
        .then(data => {
            console.log("Respuesta del servidor:", data); // Muestra la respuesta en la consola para depuración
            mostrarToast("¡Mensaje enviado correctamente!", "success"); // Muestra un toast de éxito
            this.reset(); // Limpia los campos del formulario después de enviarlo
        })
        .catch(error => {
            console.error("Error al enviar el formulario:", error); // Muestra el error en la consola si algo falla
            mostrarToast("Hubo un error al enviar el mensaje.", "error"); // Muestra un toast de error
        });
    });
});
