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

elixir(function (mix) {
    mix.task('delete');

    // jquery
    mix.copy(vendors + 'jquery/dist/jquery.min.js', destinationAssets + 'vendors/js/jquery.min.js');

    // moment
    mix.copy(vendors + 'moment/min/moment.min.js', destinationAssets + 'vendors/js/moment.min.js');
    mix.copy(vendors + 'moment/min/locales.min.js', destinationAssets + 'vendors/js/locales.min.js');
``
    // bootstrap
    mix.copy(vendors + 'bootstrap/dist/js/bootstrap.min.js', destinationAssets + 'vendors/js/bootstrap.min.js');
    mix.copy(vendors + 'bootstrap/dist/fonts', destinationAssets + 'vendors/fonts');
    mix.copy(vendors + 'bootstrap/dist/css/bootstrap.min.css', destinationAssets + 'vendors/css/bootstrap.min.css');

    // bootstrap3-wysihtml5-bower
    mix.copy(vendors + 'bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.min.js', destinationAssets + 'vendors/js/bootstrap3-wysihtml5.all.min.js');
    mix.copy(vendors + 'bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css', destinationAssets + 'vendors/js/bootstrap3-wysihtml5.min.css');

    // font-awesome
    mix.copy(vendors + 'font-awesome/css', destinationAssets + 'vendors/css');
    mix.copy(vendors + 'font-awesome/fonts', destinationAssets + 'vendors/fonts');

    // ionicons
    // mix.copy(vendors + 'ionicons/fonts', destinationAssets + 'vendors/fonts');
    // mix.copy(vendors + 'ionicons/css/ionicons.min.css', destinationAssets + 'vendors/css/ionicons.min.css');

    // jquery-ui
    mix.copy(vendors + 'jquery-ui/jquery-ui.min.js', destinationAssets + 'vendors/js/jquery-ui.min.js');
    mix.copy(vendors + 'jquery-ui/themes/base/jquery-ui.min.css', destinationAssets + 'vendors/css/jquey-ui.min.css');
    mix.copy(vendors + 'jquery-ui/themes/base/autocomplete.css', destinationAssets + 'vendors/css/autocomplete.css');
});