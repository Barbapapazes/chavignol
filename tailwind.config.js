import { getIconCollections, iconsPlugin } from '@egoist/tailwindcss-icons'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
import defaultTheme from 'tailwindcss/defaultTheme'

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },
  },

  plugins: [
    forms,
    typography,
    iconsPlugin({
      collections: getIconCollections(['ph']),
    }),
    function ({ addUtilities }) {
      addUtilities({
        '.transform-custom': {
          transform: 'var(--transform)',
        },
        '.left-unset': {
          left: 'unset',
        },
      })
    },
  ],
}
