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

mix
    .setPublicPath('public/build')
    .setResourceRoot('/build/')
    .js('resources/js/app.js', 'js')
    .copy('node_modules/inputmask/dist/jquery.inputmask.bundle.js', 'public/build/js')
    .copy('node_modules/@ckeditor/ckeditor5-build-classic/build', 'public/build/js/ckeditor')
    .sass('resources/sass/app.scss', 'css')
    .version();
