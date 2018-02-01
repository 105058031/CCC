// Gulpfile
const init = require('./initialisation');
var sass = require('gulp-sass');
var gutil = require('gulp-util');
var gulp = require('gulp');
var coffee = require('gulp-coffee');
var uglify = require('gulp-uglify'),
	//livereload = require('gulp-livereload'),
	concat = require('gulp-concat'),
	connecta = require('gulp-connect'),
	connect = require('gulp-connect-php'),
	browserSync = require('browser-sync');


gulp.task('log', function() {
  gutil.log('== My Log Task ==')
});

gulp.task('copy', function() {
  gulp.src('index.html')
  .pipe(gulp.dest('assets'))
});


gulp.task('coffee', function() {
  gulp.src('scripts_g/hello.coffee')
  .pipe(coffee({bare: true})
    .on('error', gutil.log))
  .pipe(gulp.dest('scripts_g'))
});


gulp.task('sass', function() {
  gulp.src('styles/main.scss')
  .pipe(sass({style: 'expanded'}))
    .on('error', gutil.log)
  .pipe(gulp.dest('assets'))
});



gulp.task('js', function() {
	gulp.src('scripts_g/*.js')
	.pipe(uglify())
	.pipe(concat('script.js'))
	.pipe(gulp.dest('assets'))
});

  gulp.task('watch', function() {
	gulp.watch('scripts_g/hello.coffee',['coffee']);
	gulp.watch('scripts_g/*.js',['js']);
	gulp.watch('scripts_g/main.scss',['sass']);

	});
	
gulp.task('connect-sync', function() {
  connect.server({        
		hostname: 'localhost',
		bin:'C:/php/php.exe',
		ini:'C:/php/php.ini',
		host:'0.0.0.0',
		port:'8000',
		base: 'htdocs',
		open: true
		//livereload: true	
    });
	
	browserSync({
		files: ["\!vendor/**/*.*"],
		notify: false,
		hostname: '127.0.0.1:8000',
		
		server: {
			baseDir: ['./htdocs'],
			routes: {
				'/bower_components': 'bower_components'
					}
				}
    });
  
  gulp.watch('htdocs/*.php').on('change', function () {
    browserSync.reload();
  });
  
});


gulp.task('connect', function() {
	connecta.server({
		root: 'htdocs',
	livereload: true
	})
	
});

gulp.task('html', function() {
  gulp.src('htdocs/*.html')
  gulp.src('htdocs/*.php')
  //.pipe(connect.reload())
});

gulp.task('default', [ 'coffee', 'js', 'sass', 'connect-sync','html', 'watch']);
