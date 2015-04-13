// FOUNDATION FOR APPS TEMPLATE GULPFILE
// -------------------------------------
// This file processes all of the assets in the "client" folder, combines them with the Foundation for Apps assets, and outputs the finished files in the "build" folder as a finished app.

// 1. LIBRARIES
// - - - - - - - - - - - - - - -

var gulp     = require('gulp'),
$        = require('gulp-load-plugins')(),
rimraf   = require('rimraf'),
sequence = require('run-sequence'),
package  = require('./package.json'),
//please copy the package.local.dist.json file to package.local.json and update its settings
local    = require('./package.local.json');

// 2. FILE PATHS
// - - - - - - - - - - - - - - -

// Output directory for this build. Can be output to anywhere in the file
//  system i.e. Wordpress themes directory

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
  headJS: [
    './bower_components/foundation/js/vendor/modernizr.js'
  ],
  // These files are for your theme's JavaScript
  // These scripts will be included by default on every page in your site
  appJS: [
    'bower_components/foundation/js/foundation.js',
    './src/javascripts/*.js',
    '!./src/javascripts/plugins/*',
  ],
  // These JS files will be uglified individually
  // The intention is that they are available to call as and when required
  pluginJS: [
    './src/javascripts/plugins/**/*.js'
  ]
}

// 3. TASKS
// - - - - - - - - - - - - - - -

// Cleans the build directory
gulp.task('clean', function(cb) {
  rimraf(local.buildDir, cb);
});

// Copies everything in the client folder except templates, Sass, and JS
gulp.task('copy', function() {
  return gulp.src(paths.assets, {
    base: './src/'
  })
  .pipe(gulp.dest(local.buildDir))
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
  .pipe($.replace('@@version', package.version))
  .pipe($.autoprefixer({
    browsers: ['last 2 versions', 'ie 10']
  }))
  .pipe(gulp.dest(local.buildDir));
});

gulp.task('lint', function() {
  return gulp.src('./src/javascripts/*.js')
  .pipe($.jshint())
  .pipe($.jshint.reporter('jshint-stylish'));
});

// Compiles and copies the Foundation & Modernizr JavaScripts
// Keep this small as these will be loaded in the head of your HTML document
gulp.task('uglify', ['lint'], function(cb) {
  // Foundation JavaScript
  gulp.src(paths.headJS)
  .pipe($.uglify())
  .pipe($.concat('head.js'))
  .pipe(gulp.dest(local.buildDir + '/js/'))
  ;

  // Your JavaScript
  // This will be loaded just below the end of the HTML document on every page in your theme
  // Script size is less of an issue than in the head, especially with good caching
  gulp.src(paths.appJS)
  .pipe($.plumber({ //hide errors as lint will deal with them in a much more friendly way
    errorHandler: function (err) {
      //console.log(err);
      this.emit('end');
    }
  }))
  .pipe($.uglify())
  .pipe($.concat('app.js'))
  .pipe(gulp.dest(local.buildDir + '/js/'))
  ;

  // These scripts will be minified one-by-one
  gulp.src(paths.pluginJS)
  .pipe($.plumber({ //hide errors as lint will deal with them in a much more friendly way
    errorHandler: function (err) {
      //console.log(err);
      this.emit('end');
    }
  }))
  .pipe($.uglify())
  .pipe(gulp.dest(local.buildDir + '/js/plugins/'))
  ;

  cb();
});

// Builds your entire app once
gulp.task('build', function(cb) {
  sequence('clean', ['copy', 'sass', 'uglify'], function() {
    console.log("Successfully built.");
    cb();
  });
});

// Default task: builds your app, and recompiles assets when they change
gulp.task('default', function () {
  // Build
  sequence('build');

  // Watch Sass
  gulp.watch(['./src/scss/**/*'], ['sass']);

  // Watch JavaScript
  gulp.watch(['./src/javascripts/**/*'], ['uglify']);

  // Watch static files
  gulp.watch(paths.assets, ['copy']);

});
