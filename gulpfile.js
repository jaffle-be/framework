var gulp = require('gulp'),
    less = require('gulp-less'),
    minify = require('gulp-minify-css'),
    copy = require('gulp-copy'),
    concat = require('gulp-concat'),
    plumber = require('gulp-plumber'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    watch = require('gulp-watch'),
    cached = require('gulp-cached');


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
        'bower_components/jquery/dist/jquery.min.js',
        'bower_components/jquery-ui/jquery-ui.min.js',
        'bower_components/bootstrap/dist/js/bootstrap.min.js',
        'metisMenu/dist/metisMenu.min.js',
        'bower_components/slimScroll/jquery.slimscroll.min.js',
        'bower_components/PACE/pace.min.js',
        'resources/assets/js/core.js',
        'bower_components/angular/angular.min.js',
        'bower_components/ocLazyLoad/dist/ocLazyLoad.min.js',
        'bower_components/angular-translate/angular-translate.min.js', ,
        'bower_components/angular-ui-router/release/angular-ui-router.min.js',
        'bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js',
        'bower_components/ng-idle/angular-idle.min.js'
    ])
        .pipe(concat('core.js'))
        //.pipe(uglify({
        //    mangle: false
        //}))
        .pipe(gulp.dest('public/js/admin'))
});

gulp.task('less', function () {
    gulp.src(['resources/assets/less/main.less'])
        .pipe(plumber())
        .pipe(less())
        .pipe(minify())
        .pipe(gulp.dest('public/css'));
});


/**
 * COMPILER TASKS
 */
//all libraries
gulp.task('publisher', function () {
    gulp.src('bower_components/bootstrap/dist/**')
        .pipe(copy('./public/', {
            prefix: 3
        }));

    gulp.src('bower_components/font-awesome/fonts/**')
        .pipe(copy('./public/', {
            prefix: 2
        }));

    gulp.src('bower_components/jquery/dist/*')
        .pipe(copy('./public/js/', {
            prefix: 3
        }));

    gulp.src(['bower_components/angular/angular.min.js', 'bower_components/angular/angular.min.map'])
        .pipe(copy('./public/js/', {
            prefix: 3
        }));

    gulp.src(['bower_components/angular-bootstrap/angular.min.js', 'bower_components/angular/angular.min.map'])
        .pipe(copy('./public/js/', {
            prefix: 3
        }));
});


gulp.task('watch', ['less-watcher', 'admin::app-watcher', 'admin::core-watcher']);
gulp.task('compile', ['publisher']);

gulp.task('default', ['compile', 'watch']);
