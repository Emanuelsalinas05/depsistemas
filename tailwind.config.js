import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'prussian-blue': '#0B3954',
                'metallic-seaweed': '#087E8B',
                'beau-blue': '#BFD7EA',
                'sizzling-red': '#FF5A5F',
                'lava': '#C81D25',
            },
        },
    },

    plugins: [forms],
};
