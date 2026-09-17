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
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                display: ['Sora', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                clay: {
                    50: '#FAF6F5', 100: '#F2E9E8', 200: '#E6D4D1', 300: '#D4B5B0', 400: '#C0938B',
                    500: '#AE746A', 600: '#955B51', 700: '#774841', 800: '#593630', 900: '#3C2420',
                },
                dusk: {
                    50: '#F6F8F8', 100: '#EBEFEF', 200: '#D7DEDF', 300: '#BBC7C9', 400: '#9CAEB0',
                    500: '#809699', 600: '#667D80', 700: '#526466', 800: '#3D4B4D', 900: '#293233',
                },
                sand: { 50: '#FCF9F7', 100: '#F3EBE7', 200: '#E7D7D0', 300: '#D5BBAE' },
                peach: { 100: '#F5E9E6', 200: '#EBD4CC', 300: '#DCB4A8' },
                mist: { 100: '#ECEDEE', 200: '#DADBDD', 300: '#BFC1C4' },
                success: { 50: '#F1F5EF', 500: '#6F8F6B', 600: '#5B7857' },
                warning: { 50: '#FBF3E7', 500: '#C08A3E', 600: '#A5732E' },
                danger: { 50: '#FBEEEC', 500: '#B33F35', 600: '#98332A' },
            },
            boxShadow: {
                soft: '0 1px 2px rgba(41, 50, 51, 0.04), 0 8px 24px -12px rgba(41, 50, 51, 0.12)',
                lifted: '0 12px 32px -8px rgba(41, 50, 51, 0.22)',
            },
        },
    },

    plugins: [forms],
};