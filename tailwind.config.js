/** @type {import('tailwindcss').Config} */
import colors from 'tailwindcss/colors'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/filament/**/*.blade.php",
    ],
    theme: {
        theme: {
            extend: {
                colors: {
                    danger: colors.rose,
                    primary: colors.blue,
                    success: colors.green,
                    warning: colors.yellow,
                },
            },
        },
    },
    plugins: [
        forms,
        typography,
    ],
};
