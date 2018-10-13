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
        '!public/assets/images',
        '!public/assets/images/.gitignore',
        '!public/assets/fonts',
        '!public/assets/fonts/.gitignore'
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
    mix.copy(vendors + 'jquery/dist/jquery.min.js', destinationAssets + 'vendors/js/jquery.min.js');

    // admin-lte
    mix.copy(vendors + 'admin-lte/dist/js/adminlte.min.js', destinationAssets + 'vendors/js/adminlte.min.js');
    mix.copy(vendors + 'admin-lte/dist/css/AdminLTE.min.css', destinationAssets + 'vendors/css/AdminLTE.min.css');
    mix.copy(vendors + 'admin-lte/dist/css/skins', destinationAssets + 'vendors/css/skins');

    // moment
    mix.copy(vendors + 'moment/min/moment.min.js', destinationAssets + 'vendors/js/moment.min.js');
    mix.copy(vendors + 'moment/min/locales.min.js', destinationAssets + 'vendors/js/locales.min.js');
``
    // bootstrap
    mix.copy(vendors + 'bootstrap/dist/js/bootstrap.min.js', destinationAssets + 'vendors/js/bootstrap.min.js');
    mix.copy(vendors + 'bootstrap/dist/fonts', destinationAssets + 'vendors/fonts');
    mix.copy(vendors + 'bootstrap/dist/css/bootstrap.min.css', destinationAssets + 'vendors/css/bootstrap.min.css');
    mix.copy(vendors + 'bootstrap/fonts', public + 'fonts');

    // bootstrap3-wysihtml5-bower
    mix.copy(vendors + 'bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.min.js', destinationAssets + 'vendors/js/bootstrap3-wysihtml5.all.min.js');
    mix.copy(vendors + 'bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css', destinationAssets + 'vendors/css/bootstrap3-wysihtml5.min.css');

    // bootstrap datepicker
    mix.copy(vendors + 'bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', destinationAssets + 'vendors/js/bootstrap-datepicker.min.js');
    mix.copy(vendors + 'bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css', destinationAssets + 'vendors/css/bootstrap-datepicker3.min.css');

    // bootstrap daterangepicker
    mix.copy(vendors + 'bootstrap-daterangepicker/daterangepicker.js', destinationAssets + 'vendors/js/daterangepicker.js');
    mix.copy(vendors + 'bootstrap-daterangepicker/daterangepicker.js', destinationAssets + 'vendors/css/daterangepicker.js');

    // bootstrap timepicker
    mix.copy(vendors + 'bootstrap-timepicker/js/bootstrap-timepicker.js', destinationAssets + 'vendors/js/bootstrap-timepicker.js')

    // easy autocomplete
    mix.copy(vendors + 'EasyAutoComplete/dist/jquery.easy-autocomplete.min.js', destinationAssets + 'vendors/js/jquery.easy-autocomplete.min.js');

    // font-awesome
    mix.copy(vendors + 'font-awesome/css/font-awesome.min.css', destinationAssets + 'vendors/css/font-awesome.min.css');
    mix.copy(vendors + 'font-awesome/fonts', public + 'fonts');

    // ionicons
    mix.copy(vendors + 'Ionicons/fonts', public + 'fonts');
    mix.copy(vendors + 'Ionicons/css/ionicons.css', destinationAssets + 'vendors/css/ionicons.css');

    // jquery-ui
    mix.copy(vendors + 'jquery-ui/jquery-ui.min.js', destinationAssets + 'vendors/js/jquery-ui.min.js');
    mix.copy(vendors + 'jquery-ui/themes/base/jquery-ui.min.css', destinationAssets + 'vendors/css/jquey-ui.min.css');
    mix.copy(vendors + 'jquery-ui/themes/base/autocomplete.css', destinationAssets + 'vendors/css/autocomplete.css');
});