var gulp = require('gulp');
var browserSync = require('browser-sync');

var gulpConf = require('../config');
var taskConf = gulpConf.browserSync;
var pathConf = gulpConf.pathConf;

// Static server
gulp.task('browser-sync', function() {
    browserSync({
        server: {
            baseDir: pathConf.dest.ext.public
        }
    });
});
