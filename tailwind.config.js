import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Space Grotesk', 'system-ui', ...defaultTheme.fontFamily.sans],
                display: ['Syne', 'system-ui', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                brand: {
                    black: '#050505',
                    white: '#FAFAFA',
                    offWhite: '#F0F0F0',
                    accent: '#FF3300',
                    silver: '#C0C0C0',
                },
            },
            borderRadius: {
                none: '0',
                xs: '1px',
                sm: '2px',
            },
            animation: {
                marquee: 'marquee 25s linear infinite',
                'spin-slow': 'spin 8s linear infinite',
            },
            keyframes: {
                marquee: {
                    '0%': { transform: 'translateX(0%)' },
                    '100%': { transform: 'translateX(-100%)' },
                },
            },
        },
    },

    plugins: [forms],
};
