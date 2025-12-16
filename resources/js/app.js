import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
window.tailwind = {
    theme: {
        extend: {
            fontFamily: {
                sans: ['Space Grotesk', 'sans-serif'],
                display: ['Syne', 'sans-serif'],
                mono: ['JetBrains Mono', 'monospace'],
            },
            colors: {
                brand: {
                    black: '#050505',
                    white: '#FAFAFA',
                    offWhite: '#F0F0F0',
                    accent: '#FF3300',
                    silver: '#C0C0C0',
                }
            },
        }
    }
};
