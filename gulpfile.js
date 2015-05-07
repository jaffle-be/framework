var gulp = require('gulp'),
    less = require('gulp-less'),
    minify = require('gulp-minify-css'),
    copy = require('gulp-copy');


gulp.task('watch', ['less-watcher', 'publisher'])

gulp.task('less-watcher', function()
{
 gulp.watch(['resources/assets/less/**/*.less', 'app/Users/resources/assets/less/**/*.less'], ['less']);
});

//all libraries
gulp.task('publisher', function()
{
 gulp.src('node_modules/bootstrap/dist/**')
     .pipe(copy('./public/', {
      prefix: 3
     }));

 gulp.src('node_modules/font-awesome/fonts/**')
     .pipe(copy('./public/', {
      prefix: 2
     }));

 gulp.src('node_modules/jquery/dist/*')
     .pipe(copy('./public/js/', {
      prefix: 3
     }));
});

gulp.task('less', function(){
 gulp.src(['resources/assets/less/main.less'])
     .pipe(less())
     .pipe(minify())
     .pipe(gulp.dest('public/css'));
});

gulp.task('default', ['watch']);