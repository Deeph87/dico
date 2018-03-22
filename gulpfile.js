'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function () {
    return gulp.src('public/assets/sass/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('public/assets/css'));
});

gulp.task('sass:watch', function () {
    gulp.watch('public/assets/sass/*.scss', ['sass']);
});