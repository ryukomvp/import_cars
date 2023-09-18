// Constante para la ruta del business que conecta a los metodos del SCRUD
const EMPLEADO_API = 'business/empleados.php';
// Constante para acceder al formulario de inicio de sesión.
const FORMULARIO_SESION = document.getElementById('formulario-sesion');
// Constante para acceder al formulario de registro para el primer empleado.
const FORMULARIO_EMPLEADO = document.getElementById('formulario-emp');
// Constante para acceder al formulario de registro para el primer usuario.
const FORMULARIO_USUARIO = document.getElementById('formulario-us');


// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para consultar los empleados registrados.
    const EMP = await dataFetch(EMPLEADO_API, 'leerEmpleados');
    // Petición para consultar los usuarios registrados.
    const JSON = await dataFetch(USUARIO_API, 'leerUsuarios');
    // Se comprueba si existe una sesión, de lo contrario se sigue con el flujo normal.
    if (JSON.session) {
        // Se direcciona a la página web de bienvenida.
        location.href = 'dashboard.html';
    } else if (JSON.status) {
        // Se muestra el formulario para iniciar sesión.
        document.getElementById('ingresar-us').classList.remove('hidden');
        sweetAlert(4, JSON.message, true);
    } else if (!EMP.status) {
        // Se notifica que debe registrar un usuario para utilizar el sistema.
        sweetAlert(4, JSON.exception, false);
        // Se muestra el formulario para registrar el primer empleado.
        document.getElementById('registrar-emp').classList.remove('hidden');
        // Se leen los generos registrados en la base de datos.
        fillSelect(USUARIO_API, 'leerGeneros', 'genero');
    }
    else {
        // Se notifica que debe registrar un usuario para utilizar el sistema.
        sweetAlert(4, JSON.exception, false);
        // Se muestra el formulario para registrar el primer usuario.
        document.getElementById('registrar-us').classList.remove('hidden');
        // Se leen los empleados registrados en la base de datos (ya que se esta registrando el primer usuario, por obviedad, solo existe un empleado el cual aun no posee usuario para acceder al sistema).
        fillSelect(USUARIO_API, 'leerEmpleados', 'empleado');
    }
});

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
        // Se notifica al usuario que el ingreso al sistema ha sido exitoso y se redirige a la página principal.
        sweetAlert(1, JSON.message, true, 'dashboard.html');
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

// Método manejador de eventos para cuando se envía el formulario de inicio de sesión.
FORMULARIO_EMPLEADO.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(FORMULARIO_EMPLEADO);
    // Petición para registrar el primer empleado.
    const JSON = await dataFetch(USUARIO_API, 'registrarPrimerEmpleado', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true);
        // Se oculta el formulario para registrar el primer empleado.
        document.getElementById('registrar-emp').classList.add('hidden');
        // Se notifica que debe registrar un usuario para utilizar el sistema.
        // sweetAlert(1, 'Debe registrar un usuario para inicializar el sistema', false);
        // Se muestra el formulario para registrar el primer usuario.
        document.getElementById('registrar-us').classList.remove('hidden');
        // Se leen los empleados registrados en la base de datos (ya que se esta registrando el primer usuario, por obviedad, solo existe un empleado el cual aun no posee usuario para acceder al sistema).
        fillSelect(USUARIO_API, 'leerEmpleados', 'empleado');
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

// Método manejador de eventos para cuando se envía el formulario de inicio de sesión.
FORMULARIO_USUARIO.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(FORMULARIO_USUARIO);
    // Petición para registrar el primer usuario.
    const JSON = await dataFetch(USUARIO_API, 'registrarPrimerUsuario', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se notifica que el primer usuario ha sido registrado exitosamente y se redirige al inicio de sesión
        sweetAlert(1, JSON.message, true, 'index.html');
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});