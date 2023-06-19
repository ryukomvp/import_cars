// Constante para la ruta del business que conecta a los metodos del SCRUD
const PAIS_ORIGEN_API = 'business/paisesOrigen.php';
// Constante para el input de busqueda
const BUSCAR_FORMULARIO = document.getElementById('buscarFormulario');
// Constante para el formulario del modal, sirve para añadir y editar
const EJECUTAR_FORMULARIO = document.getElementById('ejecutarFormulario');
// Constante para rellenar la tabla de los datos registrados en la base
const REGISTROS_TABLA = document.getElementById('registrosTabla');
// Constante para nombrar el modal dependiendo de la acción que se haga
const TITULO = document.getElementById('titulo');
// Constante para el texto del boton
const BTN_ACCION = document.getElementById('accion');
// Constante para abrir o cerrar el modal
const ABRIR_MODAL = new Modal(document.getElementById('abrirModal'));