let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .copy('node_modules/daterangepicker/daterangepicker.js', 'public/js/vendors/daterangepicker.js')
   .copy('node_modules/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.js', 'public/js/vendors/bootstrap3-wysihtml5.min.js')
   .copy('node_modules/daterangepicker/daterangepicker.css', 'public/css/vendors/daterangepicker.css')
   .copy('node_modules/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css', 'public/css/vendors/bootstrap3-wysihtml5.min.css')
   .sass('resources/assets/sass/app.scss', 'public/css');
