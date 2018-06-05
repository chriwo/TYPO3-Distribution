var gulp = require('gulp');
var runSequence = require('run-sequence').use(gulp);

var gulpConf = require('../config');
var taskConf = gulpConf.build;
var pathConf = gulpConf.pathConf;

gulp.task('build', function (callback) {
  runSequence(
    ['clean'],
    ['svg'],
    // ['sass', 'js', 'images'],
    ['sass'],
    ['images'],
    ['copy'],
    callback);
});

gulp.task('build:optimize', function (callback) {
  runSequence(
    ['build'],
    //['critical'],
    callback);
});
