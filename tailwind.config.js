const plugin = require('tailwindcss/plugin');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            textShadow: {
                sm: '0 1px 2px var(--tw-shadow-color)',
                DEFAULT: '0 2px 4px var(--tw-shadow-color)',
                lg: '0 8px 16px var(--tw-shadow-color)',
            },
            colors: {
                'stratos': {
                    '50': '#e4edff',
                    '100': '#cfdcff',
                    '200': '#a8beff',
                    '300': '#7492ff',
                    '400': '#3e52ff',
                    '500': '#1315ff',
                    '600': '#0400ff',
                    '700': '#0400ff',
                    '800': '#0400e4',
                    '900': '#0900b0',
                    '950': '#050040',
                },
            }
        },
    },
    plugins: [
        plugin(function({ matchUtilities, theme }) {
            matchUtilities(
                {
                    'text-shadow': (value) => ({
                        textShadow: value,
                    }),
                },
                { values: theme('textShadow') }
            )
        }),
    ],
}
