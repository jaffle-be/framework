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


/**
 * FILE WATCHERS
 */
gulp.task('admin::app-watcher', function () {
    gulp.watch(['resources/assets/js/admin/**/*.js'], ['admin::app']);
});

gulp.task('admin::core-watcher', function()
{
    gulp.watch(['resources/assets/js/core.js'], ['admin::core'])
});

gulp.task('less-watcher', function () {
    gulp.watch(['resources/assets/less/**/*.less', 'app/Users/resources/assets/less/**/*.less'], ['less']);
});

/**
 * WATCHER TASKS
 */

gulp.task('admin::app', function () {
    gulp.src('resources/assets/js/**/*.js')
        .pipe(cached('resources/assets/js/**/*.js'))
        //.pipe(uglify({
        //    mangle: false
        //}))
        .pipe(rename(function (path) {
            path.extname = '.min.js';
        }))
        .pipe(gulp.dest('public/js'));
});

gulp.task('admin::core', function () {

    gulp.src([
        'bower_components/metisMenu/dist/metisMenu.js',
        'bower_components/slimScroll/jquery.slimscroll.js',
        'bower_components/PACE/pace.js',
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

gulp.task('less', function () {
    gulp.src(['resources/assets/less/main.less'])
        .pipe(plumber())
        .pipe(less())
        .pipe(minify())
        .pipe(gulp.dest('public/css/admin'));
});

/**
 * COMPILER TASKS
 */
//all libraries
gulp.task('publisher', function () {

    gulp.src('bower_components/font-awesome/fonts/**')
        .pipe(copy('./public/fonts/admin', {
            prefix: 3
        }));
});


gulp.task('watch', ['less-watcher', 'admin::app-watcher', 'admin::core-watcher']);
gulp.task('compile', ['publisher']);

gulp.task('default', ['compile', 'watch']);
