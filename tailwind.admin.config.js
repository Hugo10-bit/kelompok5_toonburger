/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './resources/views/layouts/admin.blade.php',
        './resources/views/admin/**/*.blade.php',
        './resources/js/admin.js',
        './resources/js/admin/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                toon: {
                    granite: '#385A56',
                    'granite-dark': '#2D4B47',
                    'granite-light': '#4E7571',
                    wheat: '#F1D9B3',
                    'wheat-light': '#FDF8F0',
                    rust: '#C93B2B',
                    'rust-dark': '#B33224',
                    cream: '#FAF1E1',
                    dark: '#1F2937',
                    slate: '#4B5563',
                },
            },
            fontFamily: {
                sans: ['Roboto', 'sans-serif'],
            },
        },
    },

    plugins: [],
};
