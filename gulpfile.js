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
    maps = require('gulp-sourcemaps');


gulp.task('front', function()
{
    //we use the same theme in the front for now so styles are common
    gulp.watch(['resources/assets/less/front/**/*.less'], ['less-front']);
});

gulp.task('admin', function()
{
    gulp.watch(['resources/assets/less/admin/**/*.less'], ['less-admin']);

    gulp.watch(['resources/assets/js/core.js'], ['admin-core']);


    //angular compiles in 2 steps. First it compiles all module specific files
    //secondly it compiles all those module files into app specific files
    watch('app/*/resources/assets/js/admin/**/*.js', function(watcher)
    {
        var parsed = parseWatcher(watcher),
        //if there is a section, the filename should be built from that. else the filename is the actual remaining path
            type = parsed.section ? parsed.section + '.js' : parsed.path;

        var sectionTask = ModuleSectionTask(parsed.module, parsed.section, parsed.path);
        var globalTask = GlobalTask(type);

        sectionTask.on('end', function()
        {
            globalTask.run();
        });

        sectionTask.run();
    });


    watch('resources/assets/js/admin/**/*.js', function(watcher)
    {
        var parsed = parseWatcher(watcher);
        //if there is a section, the filename should be built from that. else the filename is the actual remaining path
            type = parsed.section ? parsed.section + '.js' : parsed.path;

        var sectionTask = ModuleSectionTask(parsed.module, parsed.section, parsed.path);
        var globalTask = GlobalTask(type);

        sectionTask.on('end', function()
        {
            globalTask.run();
        });

        sectionTask.run();
    });

});

function parseWatcher(watcher)
{
    //here we parse the watched file path to see which module it belongs to and what section we're compiling.
    //types can be controllers, services or directives
    //if there is no section, we simply copy to dist.
    var path = watcher.path;
    path = path.replace(this.process.env.INIT_CWD + '/app/', '');
    path = path.replace(this.process.env.INIT_CWD + '/', '');

    var module = path.substring(0, path.indexOf('/'));

    if(module != 'resources')
    {
        path = path.replace(module + '/resources/assets/js/admin/', '');
    }
    else{
        module = '';
        path = path.replace('resources/assets/js/admin/', '');
    }

    var section = path.substring(0, path.indexOf('/'));

    return {
        module: module,
        section: section,
        path: path
    }
}

function GlobalTask(type)
{
    return new SubTask()
        .src(['resources/assets/js/admin/' + type, 'app/*/resources/assets/js/dist/admin/' + type])
        .pipe(plumber)
        .pipe(debug, {title: 'global build'})
        .pipe(concat, type)
        .pipe(rename, function(path){
            path.extname = '.min.js';
        })
        //.pipe(uglify, {mangle: false})
        .pipe(gulp.dest, 'public/js/admin');
}

function ModuleSectionTask(module, section, file)
{
    var base = 'app/' + module + '/resources/assets/js/admin/';
    var dist = './app/' + module + '/resources/assets/js/dist/admin';

    var task = new SubTask();

    if(section)
    {
        task.src([base + section + '/*.js'])
            .pipe(plumber)
            .pipe(debug, {title: 'module build compiled: '})
            .pipe(concat, section + '.js')
            .pipe(gulp.dest, dist);
    }
    else if(file){
        //this is the filename of the changed file, if there is no section, we're dealing with a
        //small file that should simply be copied.
        task.src(base + file)
            .pipe(plumber)
            .pipe(debug, {title: 'module build non-compiled: '})
            .pipe(gulp.dest, dist);
    }

    return task;
}

/**
 * WATCHER TASKS
 */

gulp.task('admin-angular', function () {

    gulp.src([
        'resources/assets/js/admin/app.js',
        'resources/assets/js/admin/config.js',
        'resources/assets/js/admin/services.js',
        'resources/assets/js/admin/directives.js',
        'resources/assets/js/admin/translations.js',
        'resources/assets/js/admin/controllers.js',
    ])
        .pipe(concat('admin.js'))
        .pipe(gulp.dest('public/js/admin'));
});

gulp.task('admin-core', function () {

    gulp.src([
        'bower_components/metisMenu/dist/metisMenu.js',
        'bower_components/slimScroll/jquery.slimscroll.js',
        'bower_components/PACE/pace.js',
        'bower_components/moment/min/moment-with-locales.min.js',
        'bower_components/dropzone/dist/min/dropzone.min.js',
        'bower_components/lodash/lodash.min.js',
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
        }));

    gulp.src('bower_components/angular-cookies/angular-cookies.min.js')
        .pipe(copy('./public/js/admin/plugins/angular-cookies/', {
            prefix: 2
        }));

});


gulp.task('watch', ['front', 'admin']);

gulp.task('compile', ['publisher']);
gulp.task('default', ['compile', 'watch']);