/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./views/*.html", "./node_modules/flowbite/**/*.js"],
  theme: {
    extend: {
      colors: {
        'btn': '#11468F',
        'btn-hover': '#030E41',
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