const FORMULARIO_SESION = document.getElementById('login-form');
const EJECUTAR_FORMULARIO = document.getElementById('ejecutarFormulario');
const RECUPERAR_CLAVE = new Modal(document.getElementById('RecuperarClave'));



// // Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para consultar los usuarios registrados.
    const JSON = await dataFetch(USUARIO_API, 'leerUsuarios');
    // Se comprueba si existe una sesión, de lo contrario se sigue con el flujo normal.
    if (JSON.session) {
        // Se direcciona a la página web de bienvenida.
        location.href = 'dashboard.html';
    } else if (JSON.status) {
        // Se muestra el formulario para iniciar sesión.
        // document.getElementById('login-form').classList.remove('d-none');
        sweetAlert(4, JSON.message, true);
    }
    //  else {
    //     // Se muestra el formulario para registrar el primer usuario.
    //     document.getElementById('signup-container').classList.remove('d-none');
    //     sweetAlert(4, JSON.exception, true);
    // }
});

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

EJECUTAR_FORMULARIO.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.setElementById('correoemp').value = JSON.dataget.correoemp);
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(EJECUTAR_FORMULARIO);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(USUARIOS_API,'verificarContrasenia', FORM);
    console.log(JSON);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se cierra la caja de diálogo.
        RECUPERAR_CLAVE.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    }
    else {
        sweetAlert(2, JSON.exception, false);
    }
});


EJECUTAR_FORMULARIO.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(EJECUTAR_FORMULARIO);
    // Petición para iniciar sesión.
    const JSON = await dataFetch(USUARIO_API, 'verificarRecu', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        const JSON = await dataFetch(USUARIO_API, 'verificarContrasenia', FORM);
        if (JSON.status) {
            document.getElementById('clave').value = JSON.dataset.contrasenia;
            document.getElementById('confirmar').value = JSON.dataset.contrasenia;
        } else {
            sweetAlert(2, JSON.exception, false, 'usuario.html');
        }

    } else {
        sweetAlert(2, JSON.exception, false, 'dashboard.html');
    }

});

// function Recuperacion() {
//     const FORM = new FormData();
//     // Se abre la caja de diálogo que contiene el formulario.
//     EJECUTAR_FORMULARIO.reset();
//     // Verificar si el correo y usuario son validos
//     const JSON = dataFetch(USUARIO_API, 'verificarRecu', FORM);
//     // Revisa el resultado si fue true o false y dependiendo de eso pasa a el siguiente paso o tira error
//     if (JSON.status) {
//         // Mostrar el segundo modal para ingresar el pin y contrasenia
//         VERIFICAR_PIN.show();
//         // Verificar que el pin ingresado sea igual que el de la base
//         const JSON = dataFetch(USUARIO_API, 'verificarPin', FORM);
//         if (JSON.status) {
//             document.getElementById('clave').value = JSON.dataset.contrasenia;
//             document.getElementById('confirmar').value = document.getElementById('clave').value;
//         }
//     } else {
//         sweetAlert(2, JSON.exception, false);
//     }
// }

// async function actualizarClave(id) {
//     // Se define una constante tipo objeto con los datos del registro seleccionado.
//     const FORM = new FormData();
//     FORM.append('id', id);
//     // Petición para obtener los datos del registro solicitado.
//     const JSON = await dataFetch(USUARIO_API, 'leerUnRegistro', FORM);
//     // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
//     if (JSON.status) {
//             ACTUALIZAR_CLAVE.show();
//             EJECUTAR_FORMULARIO3.reset();
//             document.getElementById('clave').value = JSON.dataset.contrasenia;
//             document.getElementById('confirmar').value = JSON.dataset.contrasenia;
//     } else {
//         sweetAlert(2, JSON.exception, false);
//     }
// }

