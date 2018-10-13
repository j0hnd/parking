var gulp = require("gulp");
var bower = require("gulp-bower");
var elixir = require("laravel-elixir");
var del = require("del");
var htmlmin = require("gulp-htmlmin");

gulp.task('bower', function () {
    return bower();
});

gulp.task('compress', function () {
    var opts = {
        collapseWhitspace: true,
        removeAttributeQuotes: true,
        remeoveComments: true,
        minifyCSS: true,
        minifyJS: false
    }

    return gulp.src('./storage/framework/views/*')
            .pipe(htmlmin(opts))
            .pipe(gulp.dest('./storage/framework/views/'));
});

gulp.task('delete', function () {
    del.sync([
        'public/assets/**/*',
        '!public/assets',
        '!public/assets/css',
        '!public/assets/css/.gitignore',
        '!public/assets/js',
        '!public/assets/js/.gitignore',
        '!public/assets/vendors/'
        // '!public/assets/images',
        // '!public/assets/images/.gitignore',
        // '!public/assets/fonts',
        // '!public/assets/fonts/.gitignore'
    ]);
});

elixir.config.publicPath = 'public/assets';

var vendors = 'bower_components/';
var resourcesAssets = 'resources/assets/';
var destinationAssets = 'public/assets/';
var public = 'public/';

elixir(function (mix) {
    mix.task('delete');

    // jquery
    mix.copy(vendors + 'jquery/dist/jquery.js', destinationAssets + 'vendors/js/jquery.js');

    // admin-lte
    mix.copy(vendors + 'admin-lte/dist/js/adminlte.min.js', destinationAssets + 'vendors/js/adminlte.js');
    mix.copy(vendors + 'admin-lte/dist/css/AdminLTE.min.css', destinationAssets + 'vendors/css/AdminLTE.css');
    mix.copy(vendors + 'admin-lte/dist/css/skins', destinationAssets + 'vendors/css/skins');
    mix.copy(vendors + 'admin-lte/plugins/iCheck/icheck.js', destinationAssets + 'vendors/js/icheck.js');
    mix.copy(vendors + 'admin-lte/plugins/iCheck/square/blue.css', destinationAssets + 'vendors/css/icheck-square-blue.css');

    // moment
    mix.copy(vendors + 'moment/src/moment.js', destinationAssets + 'vendors/js/moment.js');
    mix.copy(vendors + 'moment/min/locales.js', destinationAssets + 'vendors/js/locales.js');

    // bootstrap
    mix.copy(vendors + 'bootstrap/dist/js/bootstrap.js', destinationAssets + 'vendors/js/bootstrap.js');
    mix.copy(vendors + 'bootstrap/dist/css/bootstrap.css', destinationAssets + 'vendors/css/bootstrap.css');
    mix.copy(vendors + 'bootstrap/fonts', public + 'fonts');

    // bootstrap3-wysihtml5-bower
    mix.copy(vendors + 'bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.js', destinationAssets + 'vendors/js/bootstrap3-wysihtml5.all.js');
    mix.copy(vendors + 'bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.css', destinationAssets + 'vendors/css/bootstrap3-wysihtml5.css');

    // bootstrap datepicker
    mix.copy(vendors + 'bootstrap-datepicker/dist/js/bootstrap-datepicker.js', destinationAssets + 'vendors/js/bootstrap-datepicker.js');
    mix.copy(vendors + 'bootstrap-datepicker/dist/css/bootstrap-datepicker3.css', destinationAssets + 'vendors/css/bootstrap-datepicker3.css');

    // bootstrap daterangepicker
    mix.copy(vendors + 'bootstrap-daterangepicker/daterangepicker.js', destinationAssets + 'vendors/js/daterangepicker.js');
    mix.copy(vendors + 'bootstrap-daterangepicker/daterangepicker.js', destinationAssets + 'vendors/css/daterangepicker.js');

    // bootstrap timepicker
    mix.copy(vendors + 'bootstrap-timepicker/js/bootstrap-timepicker.js', destinationAssets + 'vendors/js/bootstrap-timepicker.js');
    mix.copy(vendors + 'admin-lte/plugins/timepicker/bootstrap-timepicker.css', destinationAssets + 'vendors/css/timepicker.css');
    // mix.copy(vendors + 'bootstrap-timepicker/css/timepicker.css', destinationAssets + 'vendors/css/timepicker.css');

    // easy autocomplete
    mix.copy(vendors + 'EasyAutoComplete/dist/jquery.easy-autocomplete.js', destinationAssets + 'vendors/js/jquery.easy-autocomplete.js');

    // font-awesome
    mix.copy(vendors + 'font-awesome/css/font-awesome.css', destinationAssets + 'vendors/css/font-awesome.css');
    mix.copy(vendors + 'font-awesome/fonts', public + 'fonts');

    // ionicons
    mix.copy(vendors + 'Ionicons/fonts', public + 'fonts');
    mix.copy(vendors + 'Ionicons/css/ionicons.css', destinationAssets + 'vendors/css/ionicons.css');

    // jquery-ui
    mix.copy(vendors + 'jquery-ui/jquery-ui.js', destinationAssets + 'vendors/js/jquery-ui.js');
    mix.copy(vendors + 'jquery-ui/themes/base/jquery-ui.css', destinationAssets + 'vendors/css/jquey-ui.css');
    mix.copy(vendors + 'jquery-ui/themes/base/autocomplete.css', destinationAssets + 'vendors/css/autocomplete.css');

    // media
    mix.copy(resourcesAssets + 'img', public + 'img');
    mix.copy(resourcesAssets + 'video', public + 'video');
    mix.copy(vendors + 'admin-lte/plugins/iCheck/square/blue.png', public + 'css');
    mix.copy(vendors + 'admin-lte/plugins/iCheck/square/blue@2x.png', public + 'css');
});