var gulp = require( 'gulp' );
var rename = require( 'gulp-rename' );
var sass = require( 'gulp-sass' );

var adminstylesrc = './assets/src/scss/admin.scss';
var adminstyledist = './assets/dist/css';

var frontendstylesrc = './assets/src/scss/frontend.scss';
var frontendstyledist = './assets/dist/css';

gulp.task('adminstyle', function(){

	gulp.src( adminstylesrc )
		.pipe( sass( {
			errorLogToConsole: true,
			outputStyle: 'compressed'
		} ) )
		.on( 'error' , console.error.bind( console ) )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( adminstyledist ) );

});

gulp.task('frontendstyle', function(){

	gulp.src( frontendstylesrc )
		.pipe( sass( {
			errorLogToConsole: true,
			outputStyle: 'compressed'
		} ) )
		.on( 'error' , console.error.bind( console ) )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( frontendstyledist ) );

});