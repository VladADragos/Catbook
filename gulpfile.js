const gulp = require('gulp');
const sass = require('gulp-sass');
const browserSync = require('browser-sync').create();
const connect = require('gulp-connect-php');


// function connect(){
//     connect.server();
// }

function style() {
    // node-sass -o ./style/css/main.css ./style/sass/main.scss --watch
    return gulp.src('./style/sass/*.scss')
        .pipe(sass())
        .pipe(gulp.dest('./style/css'))
        .pipe(browserSync.stream());
}

function watch() {
    browserSync.init({
        // server: {
        //     baseDir: './',
        // },
        proxy: "http://localhost/C/"
    });
    gulp.watch('./style/sass/*.scss', style);
    gulp.watch('./**/*.php').on('change', browserSync.reload);
    gulp.watch('./javascript/*.js').on('change', browserSync.reload);
}

exports.style = style;
exports.watch = watch;