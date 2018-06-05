var gulp = require('gulp');
var runSequence = require('run-sequence');

var gulpConf = require('../config');
var taskConf = gulpConf.test;
var pathConf = gulpConf.pathConf;

gulp.task('test', function (callback) {
  runSequence(
    ['js:test'],
    ['sass:lint'],
    callback);
});
