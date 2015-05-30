var gulp = require('gulp'),
    less = require('gulp-less'),
    minify = require('gulp-minify-css'),
    copy = require('gulp-copy'),
    concat = require('gulp-concat'),
    plumber = require('gulp-plumber'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    watch = require('gulp-watch'),
    cached = require('gulp-cached'),
    maps = require('gulp-sourcemaps');


gulp.task('front', function()
{
    //we use the same theme in the front for now so styles are common
    gulp.watch(['resources/assets/less/front/**/*.less'], ['less-front']);
});


gulp.task('admin', function()
{
    //we use the same theme in the back for now styles are common
    gulp.watch(['resources/assets/less/admin/**/*.less'], ['less-admin']);

    //both stores and app use same core
    gulp.watch(['resources/assets/js/core.js'], ['admin-core']);
});

//all tasks relating to the app only should go here
gulp.task('app', function()
{
    gulp.watch(['resources/assets/js/app/admin/**/*.js'], ['app-angular']);
});

//all tasks relating to the stores only should go here
gulp.task('stores', function()
{
    gulp.watch(['resources/assets/js/stores/admin/**/*.js'], ['stores-angular']);
});

/**
 * WATCHER TASKS
 */

gulp.task('app-angular', function () {
    gulp.src('resources/assets/js/app/admin/**/*.js')
        .pipe(cached('resources/assets/js/**/*.js'))
        //.pipe(uglify({
        //    mangle: false
        //}))
        .pipe(rename(function (path) {
            path.extname = '.min.js';
        }))
        .pipe(gulp.dest('public/js/app/admin'));
});

gulp.task('stores-angular', function () {
    gulp.src('resources/assets/js/stores/admin/**/*.js')
        .pipe(cached('resources/assets/js/**/*.js'))
        //.pipe(uglify({
        //    mangle: false
        //}))
        .pipe(rename(function (path) {
            path.extname = '.min.js';
        }))
        .pipe(gulp.dest('public/js/stores/admin'));
});

gulp.task('admin-core', function () {

    gulp.src([
        'bower_components/metisMenu/dist/metisMenu.js',
        'bower_components/slimScroll/jquery.slimscroll.js',
        'bower_components/PACE/pace.js',
        'bower_components/moment/min/moment-with-locales.min.js',
        'resources/assets/js/core.js',
    ])
        .pipe(maps.init())
        .pipe(concat('core.js'))
        .pipe(uglify())
        .pipe(rename(function(path){
            path.extname = '.min.js';
        }))
        .pipe(maps.write())
        .pipe(gulp.dest('public/js/admin'))
});

gulp.task('less-admin', function () {
    gulp.src(['resources/assets/less/admin/main.less'])
        .pipe(plumber())
        .pipe(less())
        .pipe(minify())
        .pipe(gulp.dest('public/css/admin'))
});

gulp.task('less-front', function () {
    gulp.src(['resources/assets/less/front/main.less'])
        .pipe(plumber())
        .pipe(less())
        .pipe(minify())
        .pipe(gulp.dest('public/css/front'))
});

/**
* COMPILER TASKS
*/
//all libraries
gulp.task('publisher', function () {

    gulp.src('bower_components/font-awesome/fonts/**')
        .pipe(copy('./public/fonts', {
            prefix: 3
        }));


    //angular admin plugins
    gulp.src('bower_components/angular-smart-table/dist/smart-table.min.js')
        .pipe(copy('./public/js/admin/plugins/angular-smart-table/', {
            prefix: 3
        }));

    gulp.src('bower_components/angular-resource/angular-resource.min.js')
        .pipe(copy('./public/js/admin/plugins/angular-resource/', {
            prefix: 3
        }));

    gulp.src('bower_components/ngStorage/ngStorage.min.js')
        .pipe(copy('./public/js/admin/plugins/ngStorage/', {
            prefix: 2
        }))
});


gulp.task('watch', ['app', 'stores', 'front', 'admin']);

gulp.task('compile', ['publisher']);
gulp.task('default', ['compile', 'watch']);