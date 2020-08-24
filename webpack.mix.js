const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js([
        'resources/js/app.js',
        'resources/js/ajaxLogOut.js',
        'resources/front-end/plugins/OwlCarousel2-2.2.1/owl.carousel.js',
        'resources/front-end/plugins/easing/easing.js',
        'resources/front-end/js/custom.js',
    ], 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

// back-end js & css
mix.js([
        'resources/js/layouts_back-end.js',
        'resources/js/ajaxLogOut.js'
    ], 'public/js/app_back-end.js')
    .sass('resources/sass/layouts_back-end.scss', 'public/css/app_back-end.css');
