/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        quicksand: ['Quicksand', 'sans-serif'],
      },
      keyframes: {
        'border-rgb': {
          '0%, 100%': { borderColor: '#ff0000' },
          '33%': { borderColor: '#00ff00' },
          '66%': { borderColor: '#0000ff' }
        }
      },
      animation: {
        'border-rgb': 'border-rgb 3s linear infinite'
      }
    }
  },
  plugins: [],
}
