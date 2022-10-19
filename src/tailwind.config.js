const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#C7EDBA",
                "modal-rgba": "rgba(0,0,0,0.5)",
                "modal-window": "#FFF9F9",
            },
            inset: {
                "1/5": "20%",
            },
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
