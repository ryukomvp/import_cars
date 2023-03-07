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
  },
  plugins: [
    require('flowbite/plugin'),
  ],
}