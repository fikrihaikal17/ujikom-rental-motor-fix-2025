/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: "#eff6ff",
                    100: "#dbeafe",
                    200: "#bfdbfe",
                    300: "#93c5fd",
                    400: "#60a5fa",
                    500: "#3b82f6",
                    600: "#2563eb", // Main primary color
                    700: "#1d4ed8",
                    800: "#1e40af",
                    900: "#1e3a8a",
                },
            },
            fontFamily: {
                sans: ["Inter", "ui-sans-serif", "system-ui"],
            },
            spacing: {
                18: "4.5rem",
                88: "22rem",
            },
            animation: {
                "fade-in": "fadeIn 0.3s ease-in-out",
                "slide-in": "slideIn 0.3s ease-out",
                "bounce-subtle": "bounceSubtle 0.6s ease-in-out",
            },
            keyframes: {
                fadeIn: {
                    "0%": { opacity: "0" },
                    "100%": { opacity: "1" },
                },
                slideIn: {
                    "0%": { transform: "translateY(-10px)", opacity: "0" },
                    "100%": { transform: "translateY(0)", opacity: "1" },
                },
                bounceSubtle: {
                    "0%, 100%": { transform: "translateY(0)" },
                    "50%": { transform: "translateY(-5px)" },
                },
            },
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        function ({ addComponents }) {
            addComponents({
                ".form-label": {
                    "@apply block text-sm font-medium text-gray-700 mb-1": {},
                },
                ".form-input": {
                    "@apply block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm":
                        {},
                },
                ".form-select": {
                    "@apply block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm":
                        {},
                },
                ".form-textarea": {
                    "@apply block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm":
                        {},
                },
                ".form-error": {
                    "@apply mt-1 text-sm text-red-600": {},
                },
                ".form-help": {
                    "@apply mt-1 text-sm text-gray-600": {},
                },
                ".form-spacing": {
                    "@apply space-y-1": {},
                },
            });
        },
    ],
};
