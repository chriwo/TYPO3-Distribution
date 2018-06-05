var gulp = require('gulp');
var imagemin = require('gulp-imagemin');
var size = require('gulp-size');
var runSequence = require('run-sequence');

var gulpConf = require('../config');
var taskConf = gulpConf.imagemin;
var pathConf = gulpConf.pathConf;

gulp.task('images', [
  'imagemin:images'
], function (callback) {

  callback(console.log('Images have been optimized.'));
});

gulp.task('imagemin:images', function (callback) {
  var conf = taskConf;

  return gulp.src([
    pathConf.src.images + '/**/*.jpg',
    pathConf.src.images + '/**/*.gif',
    pathConf.src.images + '/**/*.png'
  ])
    .pipe(imagemin())
    .pipe(gulp.dest(pathConf.dest.ext.images));
});
