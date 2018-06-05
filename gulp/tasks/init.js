var gulp = require('gulp');
var runSequence = require('run-sequence');

var gulpConf = require('../config');
var taskConf = gulpConf.init;
var pathConf = gulpConf.pathConf;

gulp.task('init', function (callback) {
  runSequence(
    ['default'],
    callback);
});
