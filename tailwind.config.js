import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    darkMode: "class",
    theme: {
   
        extend: {
            gridTemplateColumns: {
        16: 'repeat(16, minmax(0, 1fr))',
      },
            fontFamily: {
                sans: [
                    '"Vazirmatn"', // فارسی
                    '"Noto Sans Arabic"', // عربی
                    '"Inter"', // انگلیسی
                    "system-ui",
                    "-apple-system",
                    "sans-serif",
                ],
            },
            animation: {
                "fade-in": "fadeIn 0.3s ease-out",
                "scale-in": "scaleIn 0.3s ease-out",
            },
            keyframes: {
                fadeIn: {
                    "0%": { opacity: "0" },
                    "100%": { opacity: "1" },
                },
                scaleIn: {
                    "0%": { transform: "scale(0.95)" },
                    "100%": { transform: "scale(1)" },
                },
            },
        },
    },

    plugins: [forms, typography],
};
