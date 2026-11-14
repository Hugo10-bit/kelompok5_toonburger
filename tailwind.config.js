/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                bites: {
                    yellow: '#FFC72C',
                    'yellow-dark': '#E8A400',
                    orange: '#F9961F',
                    red: '#D92625',
                    'red-dark': '#A51B12',
                    dark: '#121212',
                    card: '#1E1E1E',
                    cream: '#FFFDF9',
                    bg: '#F8F6F0',
                },
                toon: {
                    granite: '#466967',
                    'granite-dark': '#344E4C',
                    wheat: '#F1D9B3',
                    rust: '#C1502D',
                    cream: '#FAF1E1',
                    dark: '#263A38',
                },
            },
            fontFamily: {
                poppins: ['Poppins', 'sans-serif'],
                luckiest: ['"BBH Hegarty"', '"Luckiest Guy"', 'cursive', 'sans-serif'],
                brand: ['"BBH Hegarty"', 'sans-serif'],
                hegarty: ['"BBH Hegarty"', 'sans-serif'],
            },
        },
    },

    plugins: [],
};
