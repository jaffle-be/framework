var gulp = require('gulp'),
    SubTask = require('gulp-subtask')(gulp),
    debug = require('gulp-debug'),
    tap = require('gulp-tap'),
    less = require('gulp-less'),
    minify = require('gulp-minify-css'),
    copy = require('gulp-copy'),
    concat = require('gulp-concat'),
    plumber = require('gulp-plumber'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    watch = require('gulp-watch'),
    cached = require('gulp-cached'),
    maps = require('gulp-sourcemaps'),
    fs = require('fs'),
    glob = require('glob');


//default task to run
gulp.task('default', ['admin-compile', 'front-compile']);

//file is divided into 2 global parts:
// - front part
// - admin part

//each part has its own compiler function
//and a watcher function

//the compiler should be used when deploying
//the watcher should be used only when developing


/**
 *
 *          FRONT SECTION
 *
 *
 */
gulp.task('front-compile', ['front-less']);

gulp.task('front-less', function()
{
    gulp.src(['app/System/resources/assets/less/front/main.less'])
        .pipe(plumber())
        .pipe(less())
        .pipe(minify())
        .pipe(gulp.dest('public/css/front'))
        .pipe(minify())
        .pipe(rename(function(path){
            path.extname = '.min.css';
        }))
        .pipe(gulp.dest('public/css/front'))
});


/**
 *
 *          ADMIN SECTION
 *
 *
 */

gulp.task('admin-compile', ['admin-plugins', 'admin-scripts', 'admin-less']);

gulp.task('admin-less', function()
{
    gulp.src(['app/system/resources/assets/less/admin/main.less'])
        .pipe(plumber())
        .pipe(less())
        .pipe(gulp.dest('public/css/admin'))
        .pipe(minify())
        .pipe(rename(function(path){
            path.extname = '.min.css';
        }))
        .pipe(gulp.dest('public/css/admin'))
});

gulp.task('admin-scripts', function () {
    /**
     * there are 4 types of components.
     * - module components that exist out of 1 file with a name of 'component'.js
     * - module components that can have multiple files, which are all found in a subdirectory called 'component'
     * - app.js component
     * - core.js component
     */

    var fileComponents = ['translations', 'config', 'models'];

    for (var i in fileComponents)
    {
        var file = fileComponents[i];

        gulp.src('app/*/resources/assets/js/admin/' + file + '.js')
            .pipe(concat(file + '.js'))
            .pipe(gulp.dest('public/js/admin'))
            .pipe(rename(function (file) {
                file.extname = '.min.js';
            }))
            .pipe(gulp.dest('public/js/admin'));
    }

    var folderComponents = ['controllers', 'services', 'directives'];

    for (var i in folderComponents)
    {
        var folder = folderComponents[i];

        gulp.src('app/*/resources/assets/js/admin/' + folder + '/*.js')
            .pipe(concat(folder + '.js'))
            .pipe(gulp.dest('public/js/admin'))
            .pipe(rename(function (file) {
                file.extname = '.min.js';
            }))
            .pipe(gulp.dest('public/js/admin'));
    }

    gulp.src('app/system/resources/assets/js/admin/app.js')
        .pipe(plumber())
        .pipe(gulp.dest('public/js/admin'))
        .pipe(rename(function (path) {
            path.extname = '.min.js';
        }))
        .pipe(gulp.dest('public/js/admin'));


    gulp.src([
        'bower_components/metisMenu/dist/metisMenu.js',
        'bower_components/slimScroll/jquery.slimscroll.js',
        'bower_components/PACE/pace.js',
        'bower_components/moment/min/moment-with-locales.min.js',
        'bower_components/dropzone/dist/min/dropzone.min.js',
        'bower_components/lodash/lodash.min.js',
        'bower_components/summernote/dist/summernote.min.js',
        'app/system/resources/assets/js/admin/core.js',
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

gulp.task('admin-plugins', function () {
    gulp.src('bower_components/font-awesome/fonts/**')
        .pipe(copy('./public/fonts', {
            prefix: 3
        }));

    gulp.src('bower_components/angular/angular.min.js')
        .pipe(copy('./public/js/admin/angular/', {
            prefix: 2
        }));

    gulp.src('bower_components/jquery/dist/jquery.min.js')
        .pipe(copy('./public/js/admin/jquery/', {
            prefix: 3
        }));

    gulp.src('bower_components/bootstrap/dist/js/bootstrap.min.js')
        .pipe(copy('./public/js/admin/bootstrap/', {
            prefix: 4
        }));

    gulp.src('bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js')
        .pipe(copy('./public/js/admin/bootstrap/', {
            prefix: 2
        }));

    //angular admin plugins
    gulp.src('bower_components/angular-smart-table/dist/smart-table.min.js')
        .pipe(copy('./public/js/admin/angular-smart-table/', {
            prefix: 3
        }));

    gulp.src('bower_components/angular-translate/angular-translate.min.js')
        .pipe(copy('./public/js/admin/angular-translate/', {
            prefix: 2
        }));

    gulp.src('bower_components/ocLazyLoad/dist/ocLazyLoad.min.js')
        .pipe(copy('./public/js/admin/ocLazyLoad', {
            prefix: 3
        }));

    gulp.src('bower_components/angular-ui-router/release/angular-ui-router.min.js')
        .pipe(copy('./public/js/admin/angular-ui-router/', {
            prefix: 3
        }));

    gulp.src('bower_components/ng-idle/angular-idle.min.js')
        .pipe(copy('./public/js/admin/angular-idle/', {
            prefix: 2
        }));

    gulp.src('bower_components/angular-resource/angular-resource.min.js')
        .pipe(copy('./public/js/admin/angular-resource/', {
            prefix: 3
        }));

    gulp.src('bower_components/ngStorage/ngStorage.min.js')
        .pipe(copy('./public/js/admin/ngStorage/', {
            prefix: 2
        }));

    gulp.src('bower_components/ng-sortable/dist/ng-sortable.min.js')
        .pipe(copy('./public/js/admin/ng-sortable/', {
            prefix: 3
        }));

    gulp.src('bower_components/angular-cookies/angular-cookies.min.js')
        .pipe(copy('./public/js/admin/angular-cookies/', {
            prefix: 2
        }));

    gulp.src('bower_components/angular-summernote/dist/angular-summernote.min.js')
        .pipe(copy('./public/js/admin/angular-summernote/', {
            prefix: 3
        }));

    gulp.src('bower_components/angularjs-toaster/toaster.min.js')
        .pipe(copy('./public/js/admin/angularjs-toaster/', {
            prefix: 2
        }));
});