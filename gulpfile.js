// Require our dependencies
//const babel = require("gulp-babel");
const gulp = require('gulp');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const imagemin = require('gulp-imagemin');
const del = require('del');
const clean = require('gulp-clean');
const rename = require('gulp-rename');
const browserSync = require('browser-sync').create();
const cssnano = require('gulp-cssnano');
const zip = require('gulp-zip');
const unzip = require('gulp-unzip');
const minimatch = require('minimatch');
const mkdirp = require('mkdirp');

var paths = {
	acf: 'includes/acf/',
	app: 'app/',
	containers: 'app/containers/',
	utils: 'app/utils/',
	test: 'test/',
	api: 'includes/api/',
	native: 'native/',
	electron: 'native/electron-quick-start/',
	test: 'includes/api/',
	vendor: 'vendor/',
	node: 'node_modules/',
	webpack: 'webpack.config.js/',
	yml: '_config.yml/',
	yarn: 'yarn.*/',
	composer: 'composer.json/',
	gulp: 'gulpfile.js/',
	npm: 'package.json/',
	yarn: 'yarn.*/',
	assets: 'assets/',
	classes: 'classes/',
	data: 'assets/data/',
	dist: 'dist/',
	logs: 'logs/',
	includes: 'includes/',
	images: 'assets/images/*.png',
	js: 'assets/js/*.js',
	css: 'assets/css/*',
	min_js: 'dist/js/*',
	min_css: 'dist/css/*',
	min_img: 'dist/images/',
	log: 'assets/log/',
	backups: 'assets/backups/',
	dist_data: 'dist/data/',
	archive: 'dist/data/archive.zip',
	exports: 'assets/export/',
	endpoint: 'includes/Endpoint/',
	img: 'assets/images/*',
	archive: 'assets/archive/',
	dist_js: 'dist/',
	dist_css: 'dist/',
	dist_img: 'dist/images/',
	host: 'http://localhost/wp/wp-admin',
	php: '*.php',
	wpb: 'wp-wp-ironcurtain.php',
};

// Not all tasks need to use streams
// A gulpfile is just another node program and you can use any package available on npm
gulp.task('purge', function () {
	gulp.src(paths.dist + 'js/*').pipe(clean());
	gulp.src(paths.dist + 'css/*').pipe(clean());
	gulp.src(paths.assets + 'js/*.min.js').pipe(clean());
	gulp.src(paths.assets + 'css/*.min.css').pipe(clean());
});

// Copy all static images
gulp.task('imagemin', function () {
	gulp.src(paths.images).pipe(imagemin()).pipe(gulp.dest(paths.min_img));
});

gulp.task('cssnano', function () {
	gulp.src(paths.css).pipe(cssnano()).pipe(rename({suffix: '.min'})).pipe(gulp.dest('dist/css'));
	gulp.src(paths.css).pipe(cssnano()).pipe(rename({suffix: '.min'})).pipe(gulp.dest('assets/css'));
});

gulp.task('scripts', function () {
	return gulp.src(paths.data).pipe(concat('*')).pipe(gulp.dest('archive'));
});

/**
 * Minify compiled JavaScript.
 *
 * https://www.npmjs.com/package/gulp-uglify
 */
gulp.task('uglify', function () {

	gulp.src(paths.js).pipe(uglify()).pipe(rename({suffix: '.min'})).pipe(gulp.dest('dist/js'));
	gulp.src(paths.js).pipe(uglify()).pipe(rename({suffix: '.min'})).pipe(gulp.dest('assets/js'));
});

gulp.task('zip', function () {
	gulp.src(paths.data).pipe(zip('archive.zip')).pipe(gulp.dest(paths.dist));
});

gulp.task('unzip', function () {
	gulp.src('archive/*').pipe(unzip()).pipe(gulp.dest('dist'));
});

// Static Server + watching scss/html files
gulp.task('serve', function () {

	browserSync.init({
		proxy: paths.host
	});

});

// Rerun the task when a file changes
gulp.task('watch', function () {
	//gulp.watch(paths.scripts, ["scripts"]);
	gulp.watch(paths.wpb).on('change', browserSync.reload);
	gulp.watch(paths.includes + '*').on('change', browserSync.reload);
	gulp.watch(paths.classes + '*').on('change', browserSync.reload);
	gulp.watch(paths.assets + '*').on('change', browserSync.reload);
	gulp.watch(paths.dist + '*').on('change', browserSync.reload);
});


gulp.task('clean', ['purge', 'imagemin', 'cssnano', 'uglify']);
gulp.task('run', ['purge', 'imagemin', 'cssnano', 'uglify', 'zip', 'scripts', 'serve', 'watch']);
gulp.task('live', ['serve', 'watch']);

