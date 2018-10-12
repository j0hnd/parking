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

mix.js('resources/assets/js/app.js', 'public/assets/js')
    // daterangepicker
    .copy('node_modules/daterangepicker/daterangepicker.css', 'public/assets/vendors/css/daterangepicker.css')
    .copy('node_modules/daterangepicker/daterangepicker.js', 'public/assets/vendors/js/daterangepicker.js')

    // bootstrap3-wysihtml5
    .copy('node_modules/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.js', 'public/assets/vendors/js/bootstrap3-wysihtml5.min.js')   
    .copy('node_modules/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css', 'public/assets/vendors/css/bootstrap3-wysihtml5.min.css')

    // bootstrap timepicker
    // .less('bower_components/bootstrap-timepicker/less/timepicker.less', 'public/assets/vendors/css')

    // othr vendors js
    .copy('resources/assets/js/affix.js', 'public/assets/vendors/js/affix.js')
    .copy('resources/assets/js/jquery.steps.min.js', 'public/assets/vendors/js/jquery.steps.min.js')
    .copy('resources/assets/js/slick.min.js', 'public/assets/vendors/js/slick.min.js')

    // other vendors css
    .copy('resources/assets/css/font-face.css', 'public/assets/vendors/css/font-face.css')
    .copy('resources/assets/css/jquery.steps.css', 'public/assets/vendors/css/jquery.steps.css')
    .copy('resources/assets/css/slick.css', 'public/assets/vendors/css/slick.css')
    .copy('resources/assets/css/slick-theme.css', 'public/assets/vendors/css/slick-theme.css')

    .sass('resources/assets/sass/app.scss', 'public/assets/css');
