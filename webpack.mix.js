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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/axios.js', 'public/js')
    .copy('node_modules/inputmask/dist/jquery.inputmask.bundle.js', 'public/js')
    .copy('node_modules/jquery/dist/jquery.js', 'public/js')
    .copy('node_modules/@ckeditor/ckeditor5-build-classic/build', 'public/js/ckeditor')
    .sass('resources/sass/app.scss', 'public/css');