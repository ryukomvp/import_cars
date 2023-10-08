/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./views/*.html", "./controllers/*.js", "./node_modules/flowbite/**/*.js"],
  theme: {
    extend: {
      colors: {
        'oscuro': '#041562',
        'azul': '#11468F',
        'rojo': '#DA1212',
      },
    },
    container: {
      center: true,
    },
  },
  plugins: [
    require('flowbite/plugin'),
  ],
}