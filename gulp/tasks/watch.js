var gulp = require('gulp');
var watch = require('gulp-watch');
var batch = require('gulp-batch');
var runSequence = require('run-sequence');

var gulpConf = require('../config');
var taskConf = gulpConf.watch;
var pathConf = gulpConf.pathConf;

gulp.task('watch', function (callback) {
  runSequence(
    ['watch:all'],
    callback);
});

gulp.task('watch:all', [
  'watch:sass',
  'watch:js',
  'watch:images'
]);

gulp.task('watch:sass', function (callback) {
  var conf = taskConf;
  var src = pathConf.src.sass + '/**/*.scss';

  watch(src, batch(function (events, done) {
    gulp.start('sass');

    done(console.log('All tasks finished.'));
  }));
});

gulp.task('watch:js', function (callback) {
  var conf = taskConf;
  var src = [
    pathConf.src.js + '/**/*.js'
  ];

  watch(src, batch(function (events, done) {
    gulp.start('js');

    done(console.log('All tasks finished.'));
  }));
});

gulp.task('watch:images', function (callback) {
  var conf = taskConf;
  var src = [
    pathConf.src.images + '/**/*.png',
    pathConf.src.images + '/**/*.jpg',
    pathConf.src.images + '/**/*.gif'
  ];

  watch(src, batch(function (events, done) {
    gulp.start('images');

    done(console.log('All tasks finished.'));
  }));
});
