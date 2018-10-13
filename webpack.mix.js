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
    // daterangepicker
    .copy('node_modules/daterangepicker/daterangepicker.css', 'public/assets/vendors/css/daterangepicker.css')
    .copy('node_modules/daterangepicker/daterangepicker.js', 'public/assets/vendors/js/daterangepicker.js')

    // bootstrap3-wysihtml5
    .copy('node_modules/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.js', 'public/assets/vendors/js/bootstrap3-wysihtml5.js')   
    .copy('node_modules/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.css', 'public/assets/vendors/css/bootstrap3-wysihtml5.css')

    // bootstrap timepicker
    // .less('bower_components/bootstrap-timepicker/less/timepicker.less', 'public/assets/vendors/css/timepicker.css')

    // othr vendors js
    .copy('resources/assets/js/affix.js', 'public/assets/vendors/js/affix.js')
    .copy('resources/assets/js/jquery.steps.min.js', 'public/assets/vendors/js/jquery.steps.min.js')
    .copy('resources/assets/js/slick.min.js', 'public/assets/vendors/js/slick.min.js')

    // other vendors css
    .copy('resources/assets/css/font-face.css', 'public/assets/vendors/css/font-face.css')
    .copy('resources/assets/css/jquery.steps.css', 'public/assets/vendors/css/jquery.steps.css')
    .copy('resources/assets/css/slick.css', 'public/assets/vendors/css/slick.css')
    .copy('resources/assets/css/slick-theme.css', 'public/assets/vendors/css/slick-theme.css')

    // admin assets
    .styles([
        'public/assets/vendors/css/AdminLTE.css',
        'public/assets/vendors/css/autocomplete.css',
        'public/assets/vendors/css/bootstrap.css',
        'public/assets/vendors/css/bootstrap3-wysihtml5.css',
        'public/assets/vendors/css/bootstrap-datepicker3.css',
        'public/assets/vendors/css/daterangepicker.css',
        'public/assets/vendors/css/font-awesome.css',
        'public/assets/vendors/css/ionicons.css',
        'public/assets/vendors/css/jquery-ui.css',
        'public/assets/vendors/css/sweetalert2.css',
        'public/assets/vendors/css/skins/skin-red.css',
        'public/assets/vendors/css/timepicker.css'
    ], 'public/css/admin-vendor.css')

    .styles([
        'resources/assets/css/spacing.css'
    ], 'public/css/admin.css')

    .scripts([
        'public/assets/vendors/js/jquery-ui.js',
        'public/assets/vendors/js/adminlte.js',
        'public/assets/vendors/js/bootstrap.js',
        'public/assets/vendors/js/bootstrap-datepicker.js',
        'public/assets/vendors/js/bootstrap-timepicker.js',
        'public/assets/vendors/js/bootstrap3-wysihtml5.all.js',
        'public/assets/vendors/js/daterangepicker.js',
    ], 'public/js/admin-vendor.js')

    .scripts([
        'resources/assets/js/common.js',
        'resources/assets/js/reports.js'
    ], 'public/js/admin.js')

    .sass('resources/assets/sass/app.scss', 'public/css');
