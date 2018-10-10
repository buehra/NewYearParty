var gulp = require('gulp');
var concat = require('gulp-concat');

gulp.task('default', function() {
    gulp.start(
        'concatjs',
        'concatcss',
        'copyfonts'
    );
});

gulp.task('concatjs', function() {
    return gulp.src([
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/popper.js/dist/umd/popper.js',
        'node_modules/bootstrap/dist/js/bootstrap.min.js',
        'node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js'
    ])
        .pipe(concat('global.js'))
        .pipe(gulp.dest('public/js'));
});

gulp.task('concatcss', function() {
    return gulp.src([
        'node_modules/bootstrap/dist/css/bootstrap.min.css',
        'node_modules/font-awesome/css/font-awesome.min.css',
        'node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css'
    ])
        .pipe(concat('global.css'))
        .pipe(gulp.dest('public/css'));
});

gulp.task('copyfonts', function() {
    return gulp.src([
        'node_modules/bootstrap/dist/fonts/*',
        'node_modules/font-awesome/fonts/*'
    ])
        .pipe(gulp.dest('public/fonts'));
});