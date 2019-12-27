var gulp  = require('gulp');
var cleanCSS = require('gulp-clean-css');
var rename = require("gulp-rename");
var uglify = require('gulp-uglify');
//var pkg = require('./package.json');
//var browserSync = require('browser-sync').create();
var less = require('gulp-less');
var path = require('path');
var util = require("gulp-util");
//var watch = require('gulp-watch');

// Copy third party libraries from /node_modules into /vendor
gulp.task('vendor', function() {

  // Bootstrap
  gulp.src([
      './node_modules/bootstrap/dist/**/*',
      '!./node_modules/bootstrap/dist/css/bootstrap-grid*',
      '!./node_modules/bootstrap/dist/css/bootstrap-reboot*'
    ])
    .pipe(gulp.dest('./assets/vendor/bootstrap'))

  // Font Awesome
  gulp.src([
      './node_modules/font-awesome/**/*',
      '!./node_modules/font-awesome/{less,less/*}',
      '!./node_modules/font-awesome/{scss,scss/*}',
      '!./node_modules/font-awesome/.*',
      '!./node_modules/font-awesome/*.{txt,json,md}'
    ])
    .pipe(gulp.dest('./assets/vendor/font-awesome'))

  // jQuery
  gulp.src([
      './node_modules/jquery/dist/*',
      '!./node_modules/jquery/dist/core.js'
    ])
    .pipe(gulp.dest('./assets/vendor/jquery'))

  // jQuery Easing
  gulp.src([
      './node_modules/jquery.easing/*.js'
    ])
    .pipe(gulp.dest('./assets/vendor/jquery-easing'))

  // Simple Line Icons
  gulp.src([
      './node_modules/simple-line-icons/fonts/**',
    ])
    .pipe(gulp.dest('./assets/vendor/simple-line-icons/fonts'))

  gulp.src([
      './node_modules/simple-line-icons/css/**',
    ])
    .pipe(gulp.dest('./assets/vendor/simple-line-icons/css'))

});

// Compile LESS
gulp.task('less', function () {
  util.log('less -> start');
  return gulp.src('./resources/assets/less/app.less')
    .pipe(less({
      paths: [ path.join(__dirname, 'less', 'includes') ]
    }))
    .pipe(gulp.dest('./resources/assets/css'));
});

// Minify CSS
gulp.task('css:minify', function() {
  util.log('css minify -> start');
  return gulp.src([
      './resources/assets/css/*.css',
      '!./resources/assets/css/*.min.css'
    ])
    .pipe(cleanCSS())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest('./public/css'));
});

// CSS
//gulp.task('css', ['less:compile', 'css:minify']);

// Minify JavaScript
gulp.task('js:minify', function() {
  util.log('js minify -> start');
  return gulp.src([
      './resources/assets/js/*.js',
      '!./resources/assets/js/*.min.js'
    ])
    .pipe(uglify())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest('./public/assets/js'));
    //.pipe(browserSync.stream());
});
 
// Dev task
gulp.task('dev', function() {
  util.log('Dev start');
  gulp.watch('./resources/assets/js/*.js', gulp.parallel('js:minify'));
  gulp.watch('./resources/assets/less/*.less', gulp.series( 'less','css:minify' ));
  //gulp.watch('./*.html', browserSync.reload);
});
