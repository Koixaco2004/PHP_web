/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  darkMode: 'class', // Enable class-based dark mode
  theme: {
    extend: {
      fontFamily: {
        sans: ['"Be Vietnam Pro"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      colors: {
        primary: {
          // Usage guidelines:
          // 50-100: Light backgrounds, subtle borders
          // 200-300: Medium backgrounds, hover states
          // 400-500: Main accents, links, icons
          // 600-700: Buttons, active states, important text
          // 800-900: Headers, strong emphasis
          50: '#f0fdf4',
          100: '#dcfce7',
          200: '#bbf7d0',
          300: '#86efac',
          400: '#4ade80',
          500: '#22c55e',
          600: '#16a34a',
          700: '#15803d',
          800: '#166534',
          900: '#14532d',
          // Dark mode variants
          '50-dark': '#14532d',
          '100-dark': '#166534',
          '200-dark': '#15803d',
          '300-dark': '#16a34a',
          '400-dark': '#22c55e',
          '500-dark': '#4ade80',
          '600-dark': '#86efac',
          '700-dark': '#bbf7d0',
          '800-dark': '#dcfce7',
          '900-dark': '#f0fdf4',
        },
        accent: {
          50: '#fafafa',
          100: '#f4f4f5',
          200: '#e4e4e7',
          300: '#d4d4d8',
          400: '#a1a1aa',
          500: '#71717a',
          600: '#52525b',
          700: '#3f3f46',
          800: '#27272a',
          900: '#18181b',
          // Dark mode variants
          '50-dark': '#18181b',
          '100-dark': '#27272a',
          '200-dark': '#3f3f46',
          '300-dark': '#52525b',
          '400-dark': '#71717a',
          '500-dark': '#a1a1aa',
          '600-dark': '#d4d4d8',
          '700-dark': '#e4e4e7',
          '800-dark': '#f4f4f5',
          '900-dark': '#fafafa',
        },
        brand: {
          50: '#eff6ff',
          100: '#dbeafe',
          200: '#bfdbfe',
          300: '#93c5fd',
          400: '#60a5fa',
          500: '#3b82f6',
          600: '#2563eb',
          700: '#1d4ed8',
          800: '#1e40af',
          900: '#1e3a8a',
          // Dark mode variants
          '50-dark': '#1e3a8a',
          '100-dark': '#1e40af',
          '200-dark': '#1d4ed8',
          '300-dark': '#2563eb',
          '400-dark': '#3b82f6',
          '500-dark': '#60a5fa',
          '600-dark': '#93c5fd',
          '700-dark': '#bfdbfe',
          '800-dark': '#dbeafe',
          '900-dark': '#eff6ff',
        },
        // Additional dark mode specific colors
        dark: {
          50: '#1a1a1a',
          100: '#2d2d2d',
          200: '#404040',
          300: '#525252',
          400: '#737373',
          500: '#a3a3a3',
          600: '#d4d4d4',
          700: '#e5e5e5',
          800: '#f5f5f5',
          900: '#ffffff',
        }
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-in-out',
        'slide-up': 'slideUp 0.3s ease-out',
        'bounce-subtle': 'bounceSubtle 2s infinite',
        'marquee': 'marquee 25s linear infinite',
        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { transform: 'translateY(10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        bounceSubtle: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-5px)' },
        },
        marquee: {
          '0%': { transform: 'translateX(100%)' },
          '100%': { transform: 'translateX(-100%)' },
        },
      },
    },
  },
  plugins: [],
}
