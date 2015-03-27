// FOUNDATION FOR APPS TEMPLATE GULPFILE
// -------------------------------------
// This file processes all of the assets in the "client" folder, combines them with the Foundation for Apps assets, and outputs the finished files in the "build" folder as a finished app.

// 1. LIBRARIES
// - - - - - - - - - - - - - - -

var gulp     = require('gulp'),
    $        = require('gulp-load-plugins')(),
    rimraf   = require('rimraf'),
    sequence = require('run-sequence');

// 2. FILE PATHS
// - - - - - - - - - - - - - - -

// Output directory for this build. Can be output to anywhere in the file
//  system i.e. Wordpress themes directory
var buildDir = './build';

var paths = {
  assets: [
    './src/**/*.*',
    '!./src/{scss,javascripts}/**/*.*'
  ],
  // Sass will check these folders for files when you use @import.
  sass: [
    'src/scss',
    'bower_components/foundation/scss/'
  ],
  vendorJS: [
    'bower_components/foundation/js/vender/modernizr.js',
    'bower_components/foundation/js/foundation.js'
  ],
  // These files are for your app's JavaScript
  appJS: [
    'src/javascripts/**/*.js'
  ]
}

// 3. TASKS
// - - - - - - - - - - - - - - -

// Cleans the build directory
gulp.task('clean', function(cb) {
  rimraf(buildDir, cb);
});

// Copies everything in the client folder except templates, Sass, and JS
gulp.task('copy', function() {
  return gulp.src(paths.assets, {
    base: './src/'
  })
    .pipe(gulp.dest(buildDir))
  ;
});

// Compile SASS
gulp.task('sass', function() {
  return gulp.src('./src/scss/style.scss')
    .pipe($.sass({
      includePaths: paths.sass,
      style: 'nested',
      errLogToConsole: true
    }))
    .pipe($.autoprefixer({
      browsers: ['last 2 versions', 'ie 10']
    }))
    .pipe(gulp.dest(buildDir + '/css/'));
});

// Compiles and copies the Foundation for Apps JavaScript, as well as your app's custom JS
gulp.task('uglify', function(cb) {
  // Foundation JavaScript
  gulp.src(paths.vendorJS)
    .pipe($.uglify()
      .on('error', function (e) {
        console.log(e);
      }))
    .pipe($.concat('foundation.js'))
    .pipe(gulp.dest(buildDir + '/js/'))
  ;

  // App JavaScript
  gulp.src(paths.appJS)
    .pipe($.uglify()
      .on('error', function(e) {
        console.log(e);
      }))
    .pipe($.concat('app.js'))
    .pipe(gulp.dest(buildDir + '/js/'))
  ;

  cb();
});

// Builds your entire app once, without starting a server
gulp.task('build', function(cb) {
  sequence('clean', ['copy', 'sass', 'uglify'], function() {
    console.log("Successfully built.");
    cb();
  });
});

// Default task: builds your app, starts a server, and recompiles assets when they change
gulp.task('default', function () {
  // Run the server after the build
  sequence('build', 'server');

  // Watch Sass
  gulp.watch(['./client/assets/scss/**/*', './scss/**/*'], ['sass']);

  // Watch JavaScript
  gulp.watch(['./client/assets/js/**/*', './js/**/*'], ['uglify']);

  // Watch static files
  gulp.watch(['./client/**/*.*', '!./client/templates/**/*.*', '!./client/assets/{scss,js}/**/*.*'], ['copy']);

  // Watch app templates
  gulp.watch(['./client/templates/**/*.html'], ['copy:templates']);
});
