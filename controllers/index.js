// Constante para la ruta del business que conecta a los metodos del SCRUD
const EMPLEADO_API = 'business/empleados.php';
// Constante para acceder al formulario de inicio de sesión.
const FORMULARIO_SESION = document.getElementById('formulario-sesion');
// Constante para acceder al formulario de registro para el primer empleado.
const FORMULARIO_EMPLEADO = document.getElementById('formulario-emp');
// Constante para acceder al formulario de registro para el primer usuario.
const FORMULARIO_USUARIO = document.getElementById('formulario-us');
// Constante para acceder al formulario de ingreso para el código de la verificacion en dos factores.
const FORMULARIO_SEGUNDOFACTOR = document.getElementById('formulario-codigo');
// Constante para acceder al formulario de recuperación de clave.
const FORMULARIO_RECUPERACION = document.getElementById('formulario-rc');
// Constante para acceder al formulario cambio de clave.
const FORMULARIO_CAMBIO_CLAVE = document.getElementById('formulario-psw');

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
    const JSON = await dataFetch(USUARIO_API, 'iniciarSesion', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se notifica al usuario que el ingreso al sistema ha sido exitoso y se redirige a la página principal.
        sweetAlert(1, JSON.message, true);
          document.getElementById('formulario-sesion').classList.add('hidden');
          document.getElementById('formulario-codigo').classList.remove('hidden');
    } else if (JSON.password) {
        sweetAlert(3, JSON.message, true);
        document.getElementById('ingresar-us').classList.add('hidden');
        //Aquí mandar a cambiar la contraseña
        document.getElementById('cambiar-clv').classList.remove('hidden');
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

FORMULARIO_SEGUNDOFACTOR.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(FORMULARIO_SEGUNDOFACTOR);
    // Petición para iniciar sesión.
    // Segundo factor de autenticación
    const JSON = await dataFetch(USUARIO_API, 'verificarCodigo', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se notifica al usuario que el ingreso al sistema ha sido exitoso y se redirige a la página principal.
        sweetAlert(1, JSON.message, true, 'dashboard.html');
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

FORMULARIO_CAMBIO_CLAVE.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(FORMULARIO_CAMBIO_CLAVE);
    // Petición para registrar el primer usuario.
    const JSON = await dataFetch(USUARIO_API, 'cambiarClaveDia', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se notifica que el primer usuario ha sido registrado exitosamente y se redirige al inicio de sesión
        sweetAlert(1, JSON.message, true, 'index.html');
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

function abrirRecuperacion() {
    // Se oculta el formulario para iniciar sesión.
    document.getElementById('ingresar-us').classList.add('hidden');
    // Se muestra el formulario para recuperar clave.
    document.getElementById('recuperacion-clave').classList.remove('hidden');
}

// Método manejador de eventos para cuando se envía el formulario de inicio de sesión.
FORMULARIO_RECUPERACION.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(FORMULARIO_RECUPERACION);
    if (!document.getElementById('nombre-recuperacion').disabled && !document.getElementById('pin-recuperacion').disabled) {
        // 
        const RC = await dataFetch(USUARIO_API, 'recuperacionCredenciales', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (!RC.status) {
            sweetAlert(2, RC.exception, false);
        } else {
            sweetAlert(1, RC.message, false);
            document.getElementById('nombre-recuperacion').disabled = true;
            document.getElementById('pin-recuperacion').disabled = true;
            document.getElementById('codigo-recuperacion').disabled = false;
        }
    } else if (!document.getElementById('codigo-recuperacion').disabled) {
        // 
        const VC = await dataFetch(USUARIO_API, 'recuperacionCodigo', FORM);
        if (!VC.status) {
            sweetAlert(2, VC.exception, false);
        } else {
            sweetAlert(1, VC.message, false);
            document.getElementById('codigo-recuperacion').disabled = true;
            document.getElementById('clave-recuperacion').disabled = false;
            document.getElementById('confirmar-recuperacion').disabled = false;
        }
    } else if (!document.getElementById('clave-recuperacion').disabled && !document.getElementById('confirmar-recuperacion').disabled) {
        const CC = await dataFetch(USUARIO_API, 'recuperacionClave', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (!CC.status) {
            sweetAlert(2, CC.exception, false);
        } else {
            sweetAlert(1, CC.message, true, 'index.html');
        }
    }
});