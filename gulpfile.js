var gulp = require('gulp'),
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
    glob = require('glob'),
    annotate = require('gulp-ng-annotate'),
    bytediff = require('gulp-bytediff'),
    notify = require('gulp-notify');

var modules = 'modules/*/resources/assets/';

var pkg = {
    admin: {
        js: {
            files: [
                'modules/System/resources/assets/js/admin/app.js',
                modules + 'js/admin/config.js',
                modules + 'js/admin/services/**/*.js',
                modules + 'js/admin/translations.js',
                modules + 'js/admin/directives/**/*.js',
                modules + 'js/admin/models.js',
                modules + 'js/admin/controllers/**/*.js'
            ],
            publish: "public/js/admin"
        },
        core: {
            watch: [
                'modules/system/resources/assets/js/admin/core.js',
            ],
            files: [
                'bower_components/jquery/dist/jquery.min.js',
                'bower_components/bootstrap/dist/js/bootstrap.min.js',
                'bower_components/pusher/dist/pusher.min.js',
                'bower_components/metisMenu/dist/metisMenu.js',
                'bower_components/slimScroll/jquery.slimscroll.js',
                'bower_components/PACE/pace.js',
                'bower_components/moment/min/moment-with-locales.min.js',
                'bower_components/dropzone/dist/min/dropzone.min.js',
                'bower_components/lodash/lodash.min.js',
                'bower_components/autosize/dist/autosize.min.js',
                'modules/system/resources/assets/js/admin/core.js',

                //angular plugins

                'bower_components/angular/angular.min.js',
                'bower_components/pusher-angular/lib/pusher-angular.min.js',
                'bower_components/angular-smart-table/dist/smart-table.min.js',
                'bower_components/ocLazyLoad/dist/ocLazyLoad.min.js',
                'bower_components/angular-translate/angular-translate.min.js',
                'bower_components/angular-ui-router/release/angular-ui-router.min.js',
                'bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js',
                'bower_components/ngstorage/ngStorage.min.js',
                'bower_components/ng-sortable/dist/ng-sortable.min.js',
                'bower_components/ng-idle/angular-idle.min.js',
                'bower_components/angular-resource/angular-resource.min.js',
                'bower_components/angular-cookies/angular-cookies.min.js',
                'bower_components/angularjs-toaster/toaster.min.js'
            ],
            publish: "public/js/admin"
        }
    },
};


//2 most basic commands
gulp.task('default', ['compile']);
gulp.task('watch', ['watch']);

//global commands
gulp.task('compile', ['plugins', 'js', 'less']);
gulp.task('watch', ['watch-js', 'watch-less']);
gulp.task('js', ['js-core', 'js-admin']);
gulp.task('less', ['less-admin']);
gulp.task('plugins', allPlugins);


//subcommands
gulp.task('js-admin', jsAdminCompiler);
gulp.task('js-core', jsCoreCompiler);

gulp.task('less-admin', lessCompiler);

gulp.task('watch-js', function () {
    jsAdminWatcher();
    jsCoreWatcher();
});

gulp.task('watch-less', function () {
    lessAdminWatcher();
});

/**
 *
 *          ADMIN SECTION
 *
 *
 */

function jsAdminCompiler() {
    return gulp.src(pkg.admin.js.files)
        .pipe(plumber())
        .pipe(maps.init())
        .pipe(concat('all.min.js'))
        // Annotate before uglify so the code get's min'd properly.
        .pipe(annotate({
            // true helps add where @ngInject is not used. It infers.
            // Doesn't work with resolve, so we must be explicit there
            add: true
        }))
        .pipe(bytediff.start())
        .pipe(uglify({mangle: true}))
        .pipe(bytediff.stop())
        .pipe(maps.write(pkg.admin.js.publish))
        .pipe(gulp.dest(pkg.admin.js.publish))
        .pipe(notify('admin built'));
}


function jsCoreCompiler() {
    return gulp.src(pkg.admin.core.files)
        .pipe(plumber())
        .pipe(maps.init())
        .pipe(concat('core.min.js'))
        .pipe(bytediff.start())
        .pipe(uglify({mangle: true}))
        .pipe(bytediff.stop())
        .pipe(maps.write(pkg.admin.core.publish))
        .pipe(gulp.dest(pkg.admin.core.publish))
        .pipe(notify('core built'));
}


function lessAdminWatcher() {
    watch(['modules/System/resources/assets/less/admin/**/*.less'], function () {
        gulp.start('less');
    });
}


function jsAdminWatcher() {
    watch(pkg.admin.js.files, function () {
        gulp.start('js-admin');
    });
}
function jsCoreWatcher() {
    watch(pkg.admin.core.watch, function () {
        gulp.start('js-core');
    });
}

function lessCompiler() {
    gulp.src(['modules/System/resources/assets/less/admin/main.less'])
        .pipe(plumber())
        .pipe(less())
        .pipe(gulp.dest('public/css/admin'))
        .pipe(minify())
        .pipe(rename(function (path) {
            path.extname = '.min.css';
        }))
        .pipe(gulp.dest('public/css/admin'))
        .pipe(notify('css done'))
}

function allPlugins() {
    gulp.src('bower_components/font-awesome/fonts/**')
        .pipe(copy('./public/fonts', {
            prefix: 3
        }));

    gulp.src('bower_components/bootstrap/dist/fonts/**')
        .pipe(copy('./public/fonts', {
            prefix: 4
        }));
}