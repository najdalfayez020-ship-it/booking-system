const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
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
        },
    },
    theme: {
        extend: {
            colors: {
                beautyPink: '#ec4899',
                beautyRose: '#FCE4EC',
                beautyGold: '#C9A24D',
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
