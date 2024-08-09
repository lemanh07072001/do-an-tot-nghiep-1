import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
        './app/**/*.php',
        './public/assets/**/*.js',
        'node_modules/preline/dist/*.js',
        "./src/**/*.{html,js,svelte,ts}",
        "./node_modules/flowbite-svelte/**/*.{html,js,svelte,ts}",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require('flowbite/plugin'),
        require('preline/plugin'),
    ],
};