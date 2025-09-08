/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./*.php",
    "./templates/**/*.php",
    "./lib/**/*.php",
    "./src/**/*.{js,css}",
    "!./wp-admin/**/*",
    "!./wp-includes/**/*"
  ],
  safelist: [
    // Primary colors
    'bg-primary-50',
    'bg-primary-100',
    'bg-primary-200',
    'bg-primary-300',
    'bg-primary-400',
    'bg-primary-500',
    'bg-primary-600',
    'bg-primary-700',
    'bg-primary-800',
    'bg-primary-900',
    'text-primary-50',
    'text-primary-100',
    'text-primary-200',
    'text-primary-300',
    'text-primary-400',
    'text-primary-500',
    'text-primary-600',
    'text-primary-700',
    'text-primary-800',
    'text-primary-900',
    'border-primary-50',
    'border-primary-100',
    'border-primary-200',
    'border-primary-300',
    'border-primary-400',
    'border-primary-500',
    'border-primary-600',
    'border-primary-700',
    'border-primary-800',
    'border-primary-900',
    'hover:bg-primary-50',
    'hover:bg-primary-100',
    'hover:bg-primary-200',
    'hover:bg-primary-300',
    'hover:bg-primary-400',
    'hover:bg-primary-500',
    'hover:bg-primary-600',
    'hover:bg-primary-700',
    'hover:bg-primary-800',
    'hover:bg-primary-900',
    'hover:text-primary-50',
    'hover:text-primary-100',
    'hover:text-primary-200',
    'hover:text-primary-300',
    'hover:text-primary-400',
    'hover:text-primary-500',
    'hover:text-primary-600',
    'hover:text-primary-700',
    'hover:text-primary-800',
    'hover:text-primary-900',
    'focus:ring-primary-500',
    'focus:border-primary-500',
    // Secondary colors
    'bg-secondary-50',
    'bg-secondary-100',
    'bg-secondary-200',
    'bg-secondary-300',
    'bg-secondary-400',
    'bg-secondary-500',
    'bg-secondary-600',
    'bg-secondary-700',
    'bg-secondary-800',
    'bg-secondary-900',
    'text-secondary-50',
    'text-secondary-100',
    'text-secondary-200',
    'text-secondary-300',
    'text-secondary-400',
    'text-secondary-500',
    'text-secondary-600',
    'text-secondary-700',
    'text-secondary-800',
    'text-secondary-900',
    // Common utility classes
    'btn',
    'btn-primary',
    'btn-secondary',
    'card',
    'container-custom',
    'widget',
    'hero-section',
    'content-spacing',
    'section-spacing'
  ],
  corePlugins: {
    preflight: false, // Désactive le reset CSS de Tailwind pour éviter les conflits WordPress
  },
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#f0f9ff',
          100: '#e0f2fe',
          200: '#bae6fd',
          300: '#7dd3fc',
          400: '#38bdf8',
          500: '#0ea5e9',
          600: '#0284c7',
          700: '#0369a1',
          800: '#075985',
          900: '#0c4a6e'
        },
        secondary: {
          50: '#fefce8',
          100: '#fef9c3',
          200: '#fef08a',
          300: '#fde047',
          400: '#facc15',
          500: '#eab308',
          600: '#ca8a04',
          700: '#a16207',
          800: '#854d0e',
          900: '#713f12'
        }
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        serif: ['Merriweather', 'serif']
      },
      spacing: {
        '18': '4.5rem',
        '88': '22rem',
        '128': '32rem'
      }
    }
  },
  plugins: [
    require('@tailwindcss/typography')
  ]
}