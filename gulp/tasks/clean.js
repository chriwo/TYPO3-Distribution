var gulp = require('gulp');
var runSequence = require('run-sequence');
var del = require('del');
var vinylPaths = require('vinyl-paths');

var gulpConf = require('../config');
var taskConf = gulpConf;
var pathConf = gulpConf.pathConf;

gulp.task(
  'clean', [
    'clean:css',
    'clean:js',
    'clean:images',
    'clean:fonts'
  ]
);

// https://github.com/gulpjs/gulp/blob/master/docs/recipes/delete-files-folder.md

gulp.task('clean:css', function () {
  var conf = taskConf;

  return del([
    pathConf.dest.ext.css + '/**/*'
  ]);
});

gulp.task('clean:js', function () {
  var conf = taskConf;

  return del([
    pathConf.dest.ext.js + '/**/*'
  ]);
});

gulp.task('clean:images', function () {
  var conf = taskConf;

  return del([
    pathConf.dest.ext.images + '/**/*'
  ]);
});

gulp.task('clean:fonts', function () {
  var conf = taskConf;

  return del([
    pathConf.dest.ext.fonts + '/**/*'
  ]);
});

// Handle the error
function handleError(error) {
  console.log(error.toString());
  this.emit('end');
}
