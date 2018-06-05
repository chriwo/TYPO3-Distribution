var gulp = require('gulp');
var sass = require('gulp-sass');
var sassLint = require('gulp-sass-lint');
var rename = require('gulp-rename');
var size = require('gulp-size');
var minify = require('gulp-cssnano');
var cssimport = require('gulp-cssimport');
var postcss = require('gulp-postcss');
var imageInliner = require('postcss-image-inliner');
var runSequence = require('run-sequence');

var gulpConf = require('../config');
var taskConf = gulpConf.sass;
var pathConf = gulpConf.pathConf;

gulp.task('sass', function (callback) {
  runSequence(
    ['clean:css'],
    ['svg:svgmin'], /* Optimize SVGs before inlining them into CSS */
    ['sass:compile'],
    callback);
});

gulp.task('sass:lint', function (callback) {
  var conf = taskConf;

  return gulp.src([
    pathConf.src.sass + '/**/*.scss'
  ])
    .pipe(sassLint())
    .pipe(sassLint.format())
    .pipe(sassLint.failOnError())
    .on('error', handleError);
});

gulp.task('sass:compile', function (callback) {
  var conf = taskConf;

  var processors = [
    imageInliner(conf.imageInliner)
  ];

  var cssimportOptions = {
    matchPattern: '*.css',
    includePaths: ['./node_modules']
  };

  return gulp.src(conf.src)
    .pipe(
      sass({
        style: 'expanded',
        sourcemap: true,
        includePaths: ['./node_modules']
      }).on('error', sass.logError)
    )
    .pipe(postcss(processors))
    .pipe(cssimport(cssimportOptions))
    .pipe(size())
    .pipe(gulp.dest(pathConf.dest.ext.css))
    .pipe(minify())
    .pipe(rename({suffix: '.min'}))
    .pipe(size())
    .pipe(gulp.dest(pathConf.dest.ext.css));
});

// Handle the error
function handleError(error) {
  console.log(error.toString());
  this.emit('end');
}
