/*
*
* Made by AJARCMS
*
*/

var gulp   = require('gulp'),
    util = require('gulp-util'),
    watch = require('gulp-watch'),
    gulpif = require('gulp-if'),
    jshint = require('gulp-jshint'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    sass   = require('gulp-sass'),
    postcss = require('gulp-postcss'),
    sourcemaps = require('gulp-sourcemaps');
// postcss
var autoprefixer = require('autoprefixer'),
    mqpacker = require('css-mqpacker'),
    cssnano = require('cssnano');
var config = {
    production: !!util.env.production,
    sourceMaps: !util.env.production
};
/* jshint task would be here */
gulp.task('sass', function () {
    var processors =
        (config.production)
            ?[autoprefixer({browsers: ['last 2 version']}), mqpacker(), cssnano()]
            :[autoprefixer({browsers: ['last 2 version']}), mqpacker()]
    ;
    return gulp.src('./src/Assets/scss/app.scss')
        .pipe(gulpif(config.sourceMaps, sourcemaps.init()))
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss(processors))
        .pipe(gulpif(config.sourceMaps, sourcemaps.write('.')))
        .pipe(gulp.dest('./public/css/'));
});
gulp.task('js', function() {
    return gulp.src('./src/Assets/js/app.js')
        .pipe(gulpif(config.sourceMaps, sourcemaps.init()))
        .pipe(jshint())
        .pipe(jshint.reporter('jshint-stylish'))
        .pipe(concat('app.js'))
        .pipe(gulpif(config.production, uglify()))
        .pipe(gulpif(config.sourceMaps, sourcemaps.write('.')))
        .pipe(gulp.dest('./public/js/'));
});
// define the default task and add the watch task to it
gulp.task('default', ['watch']);
// configure which files to watch and what tasks to use on file changes
gulp.task('watch', function() {
    gulp.watch('./src/assets/scss/*/**', ['sass']);
    gulp.watch('./src/assets/scss/*', ['sass']);
    gulp.watch('./src/assets/js/app.js', ['js']);
});
gulp.task('install', ['sass', 'js']);