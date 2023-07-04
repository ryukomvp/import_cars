// Constante para completar la ruta de la API.
const USUARIO_API = 'business/usuarios.php';

// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');
const FOOTER = document.querySelector('footer');

document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const JSON = await dataFetch(USUARIO_API, 'capturarUsuario');
    if (JSON.session) {
        if (JSON.status) {
            // Inserción de header
            HEADER.innerHTML = `
                        <nav class="sticky top-0 z-10 bg-azul">
                            <!-- nombre del sistema -->
                            <div class="logo">
                                <i class="bx bx-menu menu-icon text-white"></i>
                                <span class="logo-name text-white">Import Cars</span>
                            </div>
                            <!-- nombre del sistema -->
                            <div class="sidebar bg-white">
                                <div class="logo">
                                    <i class="bx bx-menu menu-icon text-black"></i>
                                    <span class="logo-name text-black">IMPORT CARS</span>
                                </div>
                                <div class="sidebar-content">
                                    <hr>
                                    <ul class="lists">
                                        <!-- boton para dashboard -->
                                        <li class="list">
                                            <a href="dashboard.html" class="nav-link text-gray-600 hover:bg-azul hover:text-white">
                                                <i class="bx bx-home-alt icon"></i>
                                                <span class="link">Dashboard</span>
                                            </a>
                                        </li>
                                        <!-- boton para dropdown de productos -->
                                        <li class="list">
                                            <a href="#" id="dropdownHoverButton" data-dropdown-toggle="productos-detalles"
                                                class="nav-link text-gray-600 hover:bg-azul hover:text-white">
                                                <button
                                                    class="font-medium rounded-lg text-sm text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                    type="button">
                                                    <i class='bx bx-chevron-down icon'></i>
                                                    <span class="link">Productos
                                                    </span></button>
                                            </a>
                                            <!-- Dropdown menu -->
                                            <div id="productos-detalles"
                                                class="z-10 hidden bg-white border border-black divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
                                                    <!-- boton para productos -->
                                                    <li>
                                                        <a href="productos.html"
                                                            class="block px-4 py-2 hover:bg-azul hover:text-white dark:hover:bg-gray-600 dark:hover:text-white">Productos</a>
                                                    </li>
                                                    <!-- boton para bodega -->
                                                    <li>
                                                        <a href="bodegas.html"
                                                            class="block px-4 py-2 hover:bg-azul hover:text-white dark:hover:bg-gray-600 dark:hover:text-white">Bodega</a>
                                                    </li>
                                                    <!-- boton para entradas -->
                                                    <li>
                                                        <a href="entradas.html"
                                                            class="block px-4 py-2 hover:bg-azul hover:text-white dark:hover:bg-gray-600 dark:hover:text-white">Entradas</a>
                                                    </li>
                                                    <!-- boton para proveedores -->
                                                    <li>
                                                        <a href="proveedores.html"
                                                            class="block px-4 py-2 hover:bg-azul hover:text-white dark:hover:bg-gray-600 dark:hover:text-white">Proveedores<a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <!-- boton para dropdown de detalles de productos -->
                                        <li class="list">
                                            <a href="#" id="dropdownHoverButton" data-dropdown-toggle="productos"
                                                class="nav-link text-gray-600 hover:bg-azul hover:text-white">
                                                <button
                                                    class="font-medium rounded-lg text-sm text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                    type="button">
                                                    <i class='bx bx-chevron-down icon'></i>
                                                    <span class="link">Detalles de productos
                                                    </span></button>
                                            </a>
                                            <!-- Dropdown menu -->
                                            <div id="productos"
                                                class="z-10 hidden bg-white border border-black divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
                                                    <!-- boton para categorias -->
                                                    <li>
                                                        <a href="categorias.html"
                                                            class="block px-4 py-2 hover:bg-azul hover:text-white dark:hover:bg-gray-600 dark:hover:text-white">Categorias</a>
                                                    </li>
                                                    <!-- boton para familias -->
                                                    <li>
                                                        <a href="familias.html"
                                                            class="block px-4 py-2 hover:bg-azul hover:text-white dark:hover:bg-gray-600 dark:hover:text-white">Familias</a>
                                                    </li>
                                                    <!-- boton para marcas -->
                                                    <li>
                                                        <a href="marcas.html"
                                                            class="block px-4 py-2 hover:bg-azul hover:text-white dark:hover:bg-gray-600 dark:hover:text-white">Marcas</a>
                                                    </li>
                                                    <!-- boton para modelos -->
                                                    <li>
                                                        <a href="modelos.html"
                                                            class="block px-4 py-2 hover:bg-azul hover:text-white dark:hover:bg-gray-600 dark:hover:text-white">Modelos</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <!-- boton para dropdown de facturacion -->
                                        <li class="list">
                                            <a href="#" id="dropdownHoverButton" data-dropdown-toggle="facturacion"
                                                class="nav-link text-gray-600 hover:bg-azul hover:text-white">
                                                <button
                                                    class="font-medium rounded-lg text-sm text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                    type="button">
                                                    <i class='bx bx-chevron-down icon'></i>
                                                    <span class="link">Facturación
                                                    </span></button>
                                            </a>
                                            <!-- Dropdown menu -->
                                            <div id="facturacion"
                                                class="z-10 hidden bg-white border border-black divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
                                                    <!-- boton para facturas -->
                                                    <li>
                                                        <a href="facturas.html"
                                                            class="block px-4 py-2 hover:bg-azul hover:text-white dark:hover:bg-gray-600 dark:hover:text-white">Facturas</a>
                                                    </li>
                                                    <!-- boton para detalles de facturas -->
                                                    <li>
                                                        <a href="detallesfacturas.html"
                                                            class="block px-4 py-2 hover:bg-azul hover:text-white dark:hover:bg-gray-600 dark:hover:text-white">Detalles
                                                            de facturas</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <!-- boton para dropdown de entidades -->
                                        <li class="list">
                                            <a href="#" id="dropdownHoverButton" data-dropdown-toggle="entidades"
                                                class="nav-link text-gray-600 hover:bg-azul hover:text-white">
                                                <button
                                                    class="font-medium rounded-lg text-sm text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                    type="button">
                                                    <i class='bx bx-chevron-down icon'></i>
                                                    <span class="link">Entidades
                                                    </span></button>
                                            </a>
                                            <!-- Dropdown menu -->
                                            <div id="entidades"
                                                class="z-10 hidden bg-white border border-black divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
                                                    <!-- boton para empleados -->
                                                    <li>
                                                        <a href="empleados.html"
                                                            class="block px-4 py-2 hover:bg-azul hover:text-white dark:hover:bg-gray-600 dark:hover:text-white">Empleados</a>
                                                    </li>
                                                    <!-- boton para usuarios -->
                                                    <li>
                                                        <a href="usuarios.html"
                                                            class="block px-4 py-2 hover:bg-azul hover:text-white dark:hover:bg-gray-600 dark:hover:text-white">Usuarios</a>
                                                    </li>
                                                    <!-- boton para surcusales -->
                                                    <li>
                                                        <a href="sucursales.html"
                                                            class="block px-4 py-2 hover:bg-azul hover:text-white dark:hover:bg-gray-600 dark:hover:text-white">Sucursales</a>
                                                    </li>
                                                    <!-- boton para paises -->
                                                    <li>
                                                        <a href="paisOrigen.html"
                                                            class="block px-4 py-2 hover:bg-azul hover:text-white dark:hover:bg-gray-600 dark:hover:text-white">Paises de origen</a>
                                                    </li>
                                                    <!-- boton para monedas -->
                                                    <li>
                                                        <a href="monedas.html"
                                                            class="block px-4 py-2 hover:bg-azul hover:text-white dark:hover:bg-gray-600 dark:hover:text-white">Tipos de monedas</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <!-- boton para consulta -->
                                        <li class="list">
                                            <a href="#" class="nav-link text-gray-600 hover:bg-azul hover:text-white">
                                                <i class='bx bx-bar-chart-alt icon'></i>
                                                <span class="link">Procesos</span>
                                            </a>
                                        </li>
                                        <!-- boton para reportes -->
                                        <li class="list">
                                            <a href="#" class="nav-link text-gray-600 hover:bg-azul hover:text-white">
                                                <i class='bx bxs-report icon'></i>
                                                <span class="link">Reportes</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <hr>
                                    <div class="bottom-cotent">
                                        <li class="list">
                                            <a href="#" class="nav-link">
                                                <i class="bx bx-cog icon"></i>
                                                <span class="link">Configuracion</span>
                                            </a>
                                        </li>
                                        <li class="list">
                                            <a onclick="cerrarSesion()" href="#" class="nav-link text-gray-600 hover:bg-azul hover:text-white">
                                            <button
                                                    class="font-medium rounded-lg text-sm text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                    type="button">
                                                    <i class="bx bx-log-out icon"></i>
                                                    <span class="link">Cerrar sesion</span></button> 
                                            </a>
                                        </li>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute inset-y-0 right-0 p-3">
                                <img class=" w-10 h-10 p-1 rounded-full ring-2 ring-gray-300" src="../resources/img/logo.jpg" alt="">
                            </div>
                        </nav>

                        <section class='overlay'></section>
                    `;
                        // Inserción de footer
            FOOTER.innerHTML = `
                        <div class="2xl:sticky bottom-0 left-0 right-0 p-4 bg-azul shadow md:flex md:items-center md:justify-between md:p-6 dark:bg-gray-800">
                            <!-- nombre del sistema -->
                            <span class="text-white text-2xl">Import Cars</span>
                            <!-- lista de enlaces -->
                            <ul class="flex flex-wrap items-center mt-3 text-sm text-white dark:text-gray-400 sm:mt-0">
                                <li>
                                    <a href="https://www.instagram.com/dnlhernandez_/" class="mr-4 hover:underline md:mr-6 "
                                        target="_blank">About</a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/dnlhernandez_/" class="mr-4 hover:underline md:mr-6"
                                        target="_blank">Privacy Policy</a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/dnlhernandez_/" class="mr-4 hover:underline md:mr-6"
                                        target="_blank">Licensing</a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/dnlhernandez_/" class="hover:underline" target="_blank">Contact</a>
                                </li>
                            </ul>
                        </div>
                    `;
                        
        } else {
            sweetAlert(3, JSON.exception, false, 'index.html');
        }
    } else {
        if (location.pathname == '/import_cars/views/index.html') {
            HEADER.innerHTML = ``;
            FOOTER.innerHTML = ``;
        } else {
            location.href = 'index.html'
        }
    };
        // Configuración para menú
        const   navBar = document.querySelector("nav"),
                menuBtns = document.querySelectorAll(".menu-icon"),
                overlay = document.querySelector(".overlay");

        menuBtns.forEach((menuBtn) => {
            menuBtn.addEventListener("click", () => {
                navBar.classList.toggle("open");
            });
        });
        overlay.addEventListener("click", () => {
            navBar.classList.remove("open");
        });
})