const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .js("resources/js/display-booklist.js", "public/js")
    .js("resources/js/add-book.js", "public/js")
    .js("resources/js/search-book.js", "public/js")
    .babel(
        [
            "public/js/display-booklist.js",
            "public/js/add-book.js",
            "public/js/search-book.js",
        ],
        "public/js/top.js"
    )
    .postCss("resources/css/app.css", "public/css", [
        require("tailwindcss"),
        require("autoprefixer"),
    ]);
