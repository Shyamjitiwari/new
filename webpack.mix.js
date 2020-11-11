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

mix.js('resources/admin/js/app.js', 'public/admin/js').sass('resources/admin/sass/app.scss', 'public/admin/css');

mix.js('resources/frontend/js/app.js', 'public/js').sass('resources/frontend/sass/app.scss', 'public/css');
