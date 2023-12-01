import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                mont: "'Montserrat', sans-serif",
                pop: "'poppins', Poppins",
            },
            colors: {
                hover_bg: "#5F9BFF",
            },
            backgroundImage: {
              'chcc_bg': "url('/img/chcc_bg.png')",
            }
        },
    },

    plugins: [forms],
};
