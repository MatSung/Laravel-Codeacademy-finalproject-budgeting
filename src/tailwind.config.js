/** @type {import('tailwindcss').Config} */

module.exports = {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        income: '#bbf7d0',
        expense: '#fecaca',
        positive: '#67f597',
        negative: '#F77A7A'
      },
    },

  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}
