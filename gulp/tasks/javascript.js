var gulp = require('gulp');
var jshint = require('gulp-jshint');
var jscs = require('gulp-jscs');
var runSequence = require('run-sequence');

var gulpConf = require('../config');
var taskConf = gulpConf.javascript;
var pathConf = gulpConf.pathConf;

gulp.task('js', function (callback) {
  runSequence(
    ['js:test'],
    ['clean:js'],
    ['copy:cookieconsent'],
    callback);
});

gulp.task('js:test', function (callback) {
  var conf = taskConf;

  return gulp.src([
    pathConf.src.js + '/**/*.js'
  ])
    .pipe(jscs())
    .pipe(jscs.reporter())
    .pipe(jscs.reporter('fail'))
    .on('error', handleError)
    .pipe(jshint())
    .pipe(jshint.reporter('jshint-stylish'))
    .pipe(jshint.reporter('fail'))
    .on('error', handleError);
});

// Handle the error
function handleError(error) {
  console.log(error.toString());
  this.emit('end');
}
