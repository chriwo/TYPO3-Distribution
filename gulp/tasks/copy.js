var gulp = require('gulp');
var log = require('fancy-log');
var rename = require('gulp-rename');
var size = require('gulp-size');
var runSequence = require('run-sequence');

var gulpConf = require('../config');
var taskConf = gulpConf.copy;
var pathConf = gulpConf.pathConf;

gulp.task('copy', function (callback) {
  runSequence(
    ['copy:fonts'],
    ['copy:cookieconsent'],
    callback);
});

gulp.task('copy:fonts', function (callback) {
  var conf = taskConf.fonts;

  return gulp.src(conf.src)
    .pipe(gulp.dest(pathConf.dest.ext.fonts))
});

gulp.task('copy:cookieconsent', function (callback) {
  var conf = taskConf.cookieconsent;

  return gulp.src(conf.src)
    .pipe(gulp.dest(pathConf.dest.ext.js))
});
