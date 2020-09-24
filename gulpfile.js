var gulp  = require('gulp');
var cleanCSS = require('gulp-clean-css');
var rename = require("gulp-rename");
var uglify = require('gulp-uglify');
var less = require('gulp-less');
var path = require('path');
var util = require("gulp-util");
var elixir = require('laravel-elixir');
var concat = require('gulp-concat');

gulp.task('copy',function() {

    util.log('copy -> start');
    var res = null;

    // FONTS

    res = 
    gulp.src('resources/assets/fonts/*')
      .pipe(gulp.dest('public/fonts/'));

    // IMG

    res = gulp.src('resources/assets/img/*').pipe(gulp.dest('public/img/'));
    res = gulp.src('resources/assets/img/bootstrap-colorpicker/*').pipe(gulp.dest('public/img/bootstrap-colorpicker/'));
    res = gulp.src('resources/assets/img/icons/*').pipe(gulp.dest('public/img/icons/'));
    res = gulp.src('resources/assets/img/industries/*').pipe(gulp.dest('public/img/industries/'));
    res = gulp.src('resources/assets/img/intlTelInput/*').pipe(gulp.dest('public/img/intlTelInput/'));
    res = gulp.src('resources/assets/img/jumbo/*').pipe(gulp.dest('public/img/jumbo/'));
    res = gulp.src('resources/assets/img/medical/*').pipe(gulp.dest('public/img/medical/'));
    res = gulp.src('resources/assets/img/payment/logos/*').pipe(gulp.dest('public/img/payment/logos/'));
    res = gulp.src('resources/assets/img/wizard/*').pipe(gulp.dest('public/img/wizard/'));

    res = 
    gulp.src('./bower_components/adminlte/plugins/iCheck/square/*.png')
      .pipe(gulp.dest('public/css/iCheck/'));
    
    res = 
    gulp.src('./bower_components/select2/dist/js/i18n/*.min.js')
      .pipe(gulp.dest('public/js/select2/i18n'));

    res = 
    gulp.src('./bower_components/mjolnic-bootstrap-colorpicker/dist/img/')
      .pipe(gulp.dest('public/img/'));
/*
    res = 
    gulp.src('./')
      .pipe(gulp.dest('public/medical/css/'));
*/
    res = 
    gulp.src('./bower_components/Ionicons/css/ionicons.min.css')
      .pipe(gulp.dest('public/css/'));

    res = 
    gulp.src('resources/assets/css/intlTelInput/intlTelInput.css')
      .pipe(gulp.dest('public/css/intlTelInput/'));

    // React Front
    // res = 
    //   gulp.src('resources/medcal-front/dist/index.html')
    //     .pipe(gulp.dest('resources/views/React/index.blade.php'));
    res = 
      gulp.src('resources/medcal-front/dist/react-front-images/*')
          .pipe(gulp.dest('public/react-front-images/'));
    res = 
      gulp.src('resources/medcal-front/dist/main.js')
          .pipe(gulp.dest('public/react-front/'));
    
    return res;
});


gulp.task('styles',function() {

    util.log('styles -> start');
    var res = null;
    
    // Main
    res = 
    gulp.src( [
        // './bower_components/bootstrap/dist/css/bootstrap.min.css',
        // './bower_components/bootstrap/less/bootstrap.less',
        './bower_components/adminlte/dist/css/AdminLTE.css',
        //'./bower_components/adminlte/dist/css/skins/skin-blue.css',
        //'./bower_components/adminlte/dist/css/skins/skin-purple.min.css',
        './bower_components/adminlte/dist/css/skins/skin-purple-light.min.css',
        './bower_components/adminlte/plugins/iCheck/square/purple.css',
        './node_modules/chart.js/dist/Chart.min.css',
        './resources/assets/less/app.less',
        ])
        .pipe(less({
          paths: [ path.join(__dirname, 'less', 'includes') ]
        }))        
        .pipe(cleanCSS())
        .pipe(concat('app.min.css'))
        .pipe(gulp.dest('public/css/'));

    // iCheck plugin
    res = 
    gulp.src('./bower_components/adminlte/plugins/iCheck/square/purple.css')
        .pipe(cleanCSS())
        .pipe(concat('icheck.min.css'))
        .pipe(gulp.dest('public/css/iCheck/'));
    
    res = 
    gulp.src( [
        // './bower_components/bootstrap/dist/css/bootstrap.min.css',
        './bower_components/tooltipster/css/themes/tooltipster-light.css',
        './bower_components/tooltipster/css/tooltipster.css',
        './bower_components/animate.css/animate.min.css',
        ])
        .pipe(cleanCSS())
        .pipe(concat('styles.css'))
        .pipe(gulp.dest('public/css/'));
            
    // bootstrap-select
    res = 
    gulp.src( [
        './bower_components/select2/dist/css/select2.min.css',
        './bower_components/select2-bootstrap-theme/dist/select2-bootstrap.min.css',
        './bower_components/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css',
        './bower_components/jquery.steps/demo/css/jquery.steps.css',
        './bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css'
        ])
        .pipe(cleanCSS())
        .pipe(concat('forms.css'))
        .pipe(gulp.dest('public/css/'));

    res = 
    gulp.src('./bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css')
        .pipe(cleanCSS())
        .pipe(concat('tour.min.css'))
        .pipe(gulp.dest('public/css/'));

    res = 
    gulp.src('./bower_components/jquery-highlighttextarea/jquery.highlighttextarea.min.css')
        .pipe(cleanCSS())
        .pipe(concat('highlight.css'))
        .pipe(gulp.dest('public/css/'));

    res = 
    gulp.src( [
            // './bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
            './bower_components/air-datepicker/dist/css/datepicker.min.css',
            //'./bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            './bower_components/bootstrap-timepicker/css/timepicker.less',
            './bower_components/fullcalendar/dist/fullcalendar.min.css',
        ])
        .pipe(less())
        .pipe(cleanCSS())
        .pipe(concat('datetime.css'))
        .pipe(gulp.dest('public/css/'));
            
    return res;
});

gulp.task('script', function(){

    util.log('script -> start');
    var res = null;

    // FORM
    res =
    gulp.src( [
        './bower_components/select2/dist/js/select2.full.min.js',
        './bower_components/bootstrap-validator/dist/validator.min.js',
        './bower_components/speakingurl/speakingurl.min.js',
        './bower_components/jquery-slugify/dist/slugify.min.js',
        './bower_components/bootstrap-list-filter/bootstrap-list-filter.min.js',
        './bower_components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
        './bower_components/jquery.steps/build/jquery.steps.min.js',
        './bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js',
        ])
        .pipe(uglify())
        .pipe(concat('forms.js'))
        .pipe(gulp.dest('public/js/'));

    // APP REQUIRE
    res =
    gulp.src( [
        './bower_components/jquery/dist/jquery.min.js',
        './bower_components/moment/min/moment-with-locales.min.js',
        './bower_components/moment/min/locales.min.js',
        './bower_components/moment-timezone/builds/moment-timezone.min.js',
        './bower_components/adminlte/plugins/iCheck/icheck.min.js',
        './bower_components/bootstrap/dist/js/bootstrap.min.js',
        './bower_components/adminlte/dist/js/adminlte.min.js',
        './bower_components/tooltipster/js/jquery.tooltipster.min.js',
        './node_modules/chart.js/dist/Chart.min.js',
        ])
        .pipe(uglify())
        .pipe(concat('app.min.js'))
        .pipe(gulp.dest('public/js/'));
    
    // iCheck plugin
    res =
    gulp.src( [
        './bower_components/adminlte/plugins/iCheck/icheck.min.js',
        ])
        .pipe(uglify())
        .pipe(concat('icheck.min.js'))
        .pipe(gulp.dest('public/js/iCheck/'));
    
    // bootstrap-select
    res =
    gulp.src( [
        './bower_components/bootstrap-select/dist/js/i18n/*',
        ])
        .pipe(uglify())
        .pipe(gulp.dest('public/js/bootstrap-select/i18n/'));

    // gender
    res =
    gulp.src( [
        'resources/assets/js/gender/*',
        ])
        .pipe(uglify())
        .pipe(concat('gender.min.js'))
        .pipe(gulp.dest('public/js/gender/'));

    //clipboard
    res =
    gulp.src( [
        './bower_components/clipboard/dist/clipboard.min.js',
        ])
        .pipe(uglify())
        .pipe(concat('clipboard.min.js'))
        .pipe(gulp.dest('public/js/clipboard/'));


    // News Helpers
    res =
    gulp.src( [
        './bower_components/jquery-bootstrap-newsbox/dist/jquery.bootstrap.newsbox.min.js',
        ])
        .pipe(uglify())
        .pipe(concat('newsbox.js'))
        .pipe(gulp.dest('public/js/'));
    
    // Tour Helpers

    res =
    gulp.src( [
        './bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js',
        ])
        .pipe(uglify())
        .pipe(concat('tour.min.js'))
        .pipe(gulp.dest('public/js/'));

    // Highlight

    res =
    gulp.src( [
        './bower_components/jquery-highlighttextarea/jquery.highlighttextarea.min.js',
        ])
        .pipe(uglify())
        .pipe(concat('highlight.js'))
        .pipe(gulp.dest('public/js/'));

    // Date & Time Helpers
    res =
    gulp.src( [
        './bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
        './bower_components/air-datepicker/dist/js/datepicker.min.js',
        './bower_components/air-datepicker/dist/js/i18n/datepicker.es.js',
        './bower_components/air-datepicker/dist/js/i18n/datepicker.en.js',
        './bower_components/air-datepicker/dist/js/i18n/datepicker.pl.js',
        //'./bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
        './bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js',
        './bower_components/fullcalendar/dist/fullcalendar.min.js',
        './bower_components/fullcalendar/dist/locale-all.js',
        ])
        .pipe(uglify())
        .pipe(concat('datetime.js'))
        .pipe(gulp.dest('public/js/'));

    // intlTelInput
    res =
    gulp.src( [
        'resources/assets/js/intlTelInput/*',
        ])
        .pipe(uglify())
        .pipe(concat('intlTelInput.min.js'))
        .pipe(gulp.dest('public/js/intlTelInput/'));

    // Lib
    res =
    gulp.src( [
        'resources/assets/js/lib/*',
        ])
        .pipe(uglify())
        .pipe(concat('utils.js'))
        .pipe(gulp.dest('public/js/lib/'));
        
    // calendar
    res =
    gulp.src( [
        'resources/assets/js/calendar/*',
        ])
        .pipe(uglify())
        .pipe(concat('calendar.js'))
        .pipe(rename({
          suffix: '.min'
        }))    
        .pipe(gulp.dest('public/js/calendar/'));

    // statistics
    res =
    gulp.src( [
        'resources/assets/js/statistics/*',
        ])
        .pipe(uglify())
        .pipe(concat('statistics.min.js'))
        .pipe(gulp.dest('public/js/statistics/'));

        // cookie
      res =
      gulp.src( [
        'resources/assets/js/cookie/*',
        ])
        .pipe(uglify())
        .pipe(concat('cookie.js'))
        .pipe(rename({
          suffix: '.min'
        }))    
        .pipe(gulp.dest('public/js/cookie/'));
    
        // alert
        res =
        gulp.src( [
          'resources/assets/js/alert/*',
          ])
          .pipe(uglify())
          .pipe(concat('alert.js'))
          .pipe(rename({
            suffix: '.min'
          }))    
          .pipe(gulp.dest('public/js/alert/'));

        // confirm
        res =
        gulp.src( [
          'resources/assets/js/confirm/*',
          ])
          .pipe(uglify())
          .pipe(concat('confirm.js'))
          .pipe(rename({
            suffix: '.min'
          }))    
          .pipe(gulp.dest('public/js/confirm/'));

          // appointment
        res =
        gulp.src( [
          'resources/assets/js/appointment/*',
          ])
          .pipe(uglify())
          .pipe(concat('appointment.min.js'))
          .pipe(gulp.dest('public/js/appointment/'));

          // med doc
        res =
        gulp.src( [
          'resources/assets/js/medical/*',
          ])
          .pipe(uglify())
          .pipe(concat('doc.min.js'))
          .pipe(gulp.dest('public/js/medical/'));
        
        // Rollbar
        res =
        gulp.src( [
            './bower_components/rollbar/dist/rollbar.js',
            'resources/assets/js/rollbar/*',
            ])
            .pipe(uglify())
            .pipe(concat('rollbar.min.js'))
            .pipe(gulp.dest('public/js/'));
    
        return res;
});


// Compile LESS
// gulp.task('less', function () {
//   util.log('less -> start');
//   return gulp.src('./resources/assets/less/app.less')
//     .pipe(less({
//       paths: [ path.join(__dirname, 'less', 'includes') ]
//     }))
//     .pipe(gulp.dest('./resources/assets/css'));
// });
/*
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
});
 
// Dev task
gulp.task('dev', function() {
  util.log('Dev start');
  gulp.watch('./resources/assets/js/*.js', gulp.parallel('js:minify'));
  gulp.watch('./resources/assets/less/*.less', gulp.series( 'less','css:minify' ));
});

*/