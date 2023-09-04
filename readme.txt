URL del sitio:
http://localhost/import_cars/views/index.html

Comandos para ejecutar el archivo css
npx tailwindcss -i ./tailwind.css -o ./resources/css/tailwind.css --watch


Indicaciones sobre la estandarización del proyecto
Idioma: español


API

Nombres de archivos: camelCase; nombre de la tabla (Agregar la palabra Queries al final en el caso del DAO)
Nombres de clases: StudlyCaps
Nombres de funciones: camelCase
Nombres de propiedades: mismo nombre del campo en la tabla; tipoProducto -> tipoproducto
Nombres de objetos: minúsculas, una sola palabra referente a la tabla (Bussiness)
Nombres de los casos: camelCase (Businnes)
https://www.php-fig.org/psr/psr-1/

CONTROLLER

Nombre de archivos: camelCase
Nombre de constantes: SCREAMING_SNAKE_CASE; ejemplo: USUARIO_API
Funciones: camelCase
Variables: camelCase

<button class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
  <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
      Cyan to blue
  </span>
</button>