/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme  : {
        extend: {
            fontFamily: {
                'inter': [
                    'InterVariable',
                    'system-ui'],
                sans   : [
                    'Roboto',
                    'sans-serif'],
                // serif: ['Merriweather', 'serif'],
            },
        },
    },
    plugins: [],
}

