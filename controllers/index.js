// Constante para establecer el formulario de registro del primer usuario.
// const SIGNUP_FORM = document.getElementById('signup-form');
// Constante para establecer el formulario de inicio de sesión.
const FORMULARIO_SESION = document.getElementById('login-form');

// // Método manejador de eventos para cuando el documento ha cargado.
// document.addEventListener('DOMContentLoaded', async () => {
//     // Petición para consultar los usuarios registrados.
//     const JSON = await dataFetch(USUARIO_API, 'leerUsuarios');
//     // Se comprueba si existe una sesión, de lo contrario se sigue con el flujo normal.
//     if (JSON.session) {
//         // Se direcciona a la página web de bienvenida.
//         location.href = 'dashboard.html';
//     } else if (JSON.status) {
//         // Se muestra el formulario para iniciar sesión.
//         document.getElementById('login-container').classList.remove('hide');
//         sweetAlert(4, JSON.message, true);
//     } else {
//         // Se muestra el formulario para registrar el primer usuario.
//         document.getElementById('signup-container').classList.remove('hide');
//         sweetAlert(4, JSON.exception, true);
//     }
// });

// Método manejador de eventos para cuando se envía el formulario de registro del primer usuario.
// SIGNUP_FORM.addEventListener('submit', async (event) => {
//     // Se evita recargar la página web después de enviar el formulario.
//     event.preventDefault();
//     // Constante tipo objeto con los datos del formulario.
//     const FORM = new FormData(SIGNUP_FORM);
//     // Petición para registrar el primer usuario del sitio privado.
//     const JSON = await dataFetch(USER_API, 'signup', FORM);
//     // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
//     if (JSON.status) {
//         sweetAlert(1, JSON.message, true, 'index.html');
//     } else {
//         sweetAlert(2, JSON.exception, false);
//     }
// });

// Método manejador de eventos para cuando se envía el formulario de inicio de sesión.
FORMULARIO_SESION.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(FORMULARIO_SESION);
    // Petición para iniciar sesión.
    const JSON = await dataFetch(USUARIO_API, 'iniciarSesion', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'dashboard.html');
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});