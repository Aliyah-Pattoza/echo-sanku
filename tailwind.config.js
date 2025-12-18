import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'sanku-primary': '#4A7C59',
        'sanku-secondary': '#8B6F47',
        'sanku-accent': '#7FB069',
        'sanku-dark': '#2D3E2E',
        'sanku-light': '#F5F3E7',
        'sanku-cream': '#E8DCC4',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}