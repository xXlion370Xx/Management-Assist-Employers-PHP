var mensaje = "¡Ya hay una nueva versión de la página! Da clic en ok para acceder:\n\n";
var enlace = "https://confeccioneslyz.onrender.com/";

if (confirm(mensaje + enlace)) {
    window.location.href = enlace;
}