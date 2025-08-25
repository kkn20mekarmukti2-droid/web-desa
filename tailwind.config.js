/** @type {import('tailwindcss').Config} */

export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/**/*.blade.php",
        "./resources/**/**/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: '#3d5a80',
                hov: '#638ca6',
            },
            aspectRatio: {
                '9/16': '9 / 16',
              },
        },
    },
    plugins: [require('@tailwindcss/typography'),],
}
