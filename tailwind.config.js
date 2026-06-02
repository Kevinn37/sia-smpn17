/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./public/js/**/*.js",
    ],

    theme: {
        extend: {
            colors: {
                kuning: "#ffe845",
                biru: "#2c46c4",
                fuchsia: "#d234b0",
                hijau: "#03d930",
                hitam: "#111111",
            },

            fontFamily: {
                heading: ["Archivo", "sans-serif"],
                body: ["Inter", "sans-serif"],
            },

            boxShadow: {
                neo: "4px 4px 0px #111111",
                "neo-lg": "6px 6px 0px #111111",
                "neo-sm": "2px 2px 0px #111111",
            },

            borderRadius: {
                neo: "4px",
            },
        },
    },

    plugins: [],
};
