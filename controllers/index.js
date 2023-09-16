
const USUARIO_API = 'business/usuarios.php';
const FORMULARIO_SESION = document.getElementById('login-form');
const EJECUTAR_FORMULARIO1 = document.getElementById('ejecutarFormulario1');
const EJECUTAR_FORMULARIO2 = document.getElementById('ejecutarFormulario2');
const EJECUTAR_FORMULARIO3 = document.getElementById('ejecutarFormulario3');
const ABRIR_MODAL1 = new Modal(document.getElementById('RecuperarModal1'));
const ABRIR_MODAL2 = new Modal(document.getElementById('RecuperarModal2'));
const ABRIR_MODAL3 = new Modal(document.getElementById('RecuperarModal3'));


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

// EJECUTAR_FORMULARIO.addEventListener('submit', async (event) => {
//     // Se evita recargar la página web después de enviar el formulario.
//     event.preventDefault();
//     // Se verifica la acción a realizar.
//     (document.getElementById('id').value) ? action = 'actualizarRegistro' : action = 'crearRegistro';
//     // Constante tipo objeto con los datos del formulario.
//     const FORM = new FormData(EJECUTAR_FORMULARIO);
//     // Petición para guardar los datos del formulario.
//     const JSON = await dataFetch(USUARIO_API, action, FORM);
//     // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
//     if (JSON.status) {
//         // Se carga nuevamente la tabla para visualizar los cambios.
//         registrosTabla();
//         // Se cierra la caja de diálogo.
//         ABRIR_MODAL.hide();
//         // Se muestra un mensaje de éxito.
//         sweetAlert(1, JSON.message, true);
//     } else {
//         sweetAlert(2, JSON.exception, false);
//     }
// });

function abrirRecuperacion() {
    const FORM = new FormData();
    // Se abre la caja de diálogo que contiene el formulario.
    EJECUTAR_FORMULARIO.reset();
    // Verificar si el correo y usuario son validos
    const JSON = dataFetch(USUARIO_API, 'verificarRecu', FORM);
    // Revisa el resultado si fue true o false y dependiendo de eso pasa a el siguiente paso o tira error 
    if(JSON.status){
        // Mostrar el segundo modal para ingresar el pin y contrasenia
        ABRIR_MODAL2.show();
        // Verificar que el pin ingresado sea igual que el de la base 
        const JSON = dataFetch(USUARIO_API, 'verificarPin', FORM);
        if(JSON.status){
            document.getElementById('clave').value = JSON.dataset.contrasenia;
            document.getElementById('confirmar').value = document.getElementById('clave').value; 
        }
    }else{
        sweetAlert(2, JSON.exception, false);
    }
}

function verificarCredenciales (){
    const FORM = new FormData();
    // Se abre la caja de diálogo que contiene el formulario.
    EJECUTAR_FORMULARIO1.reset();
    // Verificar si el correo y usuario son validos
    const JSON = dataFetch(USUARIO_API, 'verificarRecu', FORM);
    // Revisa el resultado si fue true o false y dependiendo de eso pasa a el siguiente paso o tira error 
    if(JSON.status){
        sweetAlert(1, JSON.exception, true);
    }else{
        sweetAlert(2, JSON.exception, false, 'index.html');
    }
}

function verificarPin (){
    const FORM = new FormData();
    // Se abre la caja de diálogo que contiene el formulario.
    EJECUTAR_FORMULARIO2.reset();
    // Verificar si el correo y usuario son validos
    const JSON = dataFetch(USUARIO_API, 'verificarPin', FORM);
    // Revisa el resultado si fue true o false y dependiendo de eso pasa a el siguiente paso o tira error 
    if(JSON.status){
        sweetAlert(1, JSON.exception, true);
    }else{
        sweetAlert(2, JSON.exception, false);
    }
}

async function actualizarClave(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(USUARIO_API, 'leerUnRegistro', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
            ABRIR_MODAL3.show();
            EJECUTAR_FORMULARIO3.reset();
            document.getElementById('clave').value = JSON.dataset.contrasenia;
            document.getElementById('confirmar').value = JSON.dataset.contrasenia;  
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

EJECUTAR_FORMULARIO1.addEventListener('submit', async (event) => {
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(EJECUTAR_FORMULARIO1);
    // Petición para iniciar sesión.
    const JSON = await dataFetch(USUARIO_API, 'verificarRecu', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false, 'index.html');
    }
});

EJECUTAR_FORMULARIO2.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(EJECUTAR_FORMULARIO2);
    // Petición para iniciar sesión.
    const JSON = await dataFetch(USUARIO_API, 'verificarPin', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false,'index.html');
    }
});

