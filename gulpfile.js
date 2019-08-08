const gulp = require( 'gulp' );
const del = require( 'del' );
const run = require( 'gulp-run' );
const zip = require( 'gulp-zip' );

gulp.task( 'bundle', function() {
	return gulp.src( [
		'**/*',
		'!bin/**/*',
		'!node_modules/**/*',
		'!vendor/**/*',
		'!composer.*',
		'!release/**/*',
		'!src/**/*',
		'!src',
		'!tests/**/*',
		'!phpcs.xml'
	] )
		.pipe( gulp.dest( 'release/user-profile-picture-enhanced' ) );
} );

gulp.task( 'remove:bundle', function() {
	return del( [
		'release/user-profile-picture-enhanced',
	] );
} );

gulp.task( 'wporg:prepare', function() {
	return run( 'mkdir -p release' ).exec();
} );

gulp.task( 'release:copy-for-zip', function() {
	return gulp.src('release/user-profile-picture-enhanced/**')
		.pipe(gulp.dest('user-profile-picture-enhanced'));
} );

gulp.task( 'release:zip', function() {
	return gulp.src('user-profile-picture-enhanced/**/*', { base: "." })
	.pipe(zip('user-profile-picture-enhanced.zip'))
	.pipe(gulp.dest('.'));
} );

gulp.task( 'cleanup', function() {
	return del( [
		'release',
		'user-profile-picture-enhanced'
	] );
} );

gulp.task( 'clean:bundle', function() {
	return del( [
		'release/user-profile-picture-enhanced/bin',
		'release/user-profile-picture-enhanced/node_modules',
		'release/user-profile-picture-enhanced/vendor',
		'release/user-profile-picture-enhanced/tests',
		'release/user-profile-picture-enhanced/trunk',
		'release/user-profile-picture-enhanced/gulpfile.js',
		'release/user-profile-picture-enhanced/Makefile',
		'release/user-profile-picture-enhanced/package*.json',
		'release/user-profile-picture-enhanced/phpunit.xml.dist',
		'release/user-profile-picture-enhanced/README.md',
		'release/user-profile-picture-enhanced/CHANGELOG.md',
		'release/user-profile-picture-enhanced/webpack.config.js',
		'release/user-profile-picture-enhanced/.editorconfig',
		'release/user-profile-picture-enhanced/.eslistignore',
		'release/user-profile-picture-enhanced/.eslistrcjson',
		'release/user-profile-picture-enhanced/.git',
		'release/user-profile-picture-enhanced/.gitignore',
		'release/user-profile-picture-enhanced/src/block',
		'package/prepare',
	] );
} );

gulp.task( 'default', gulp.series(
	'remove:bundle',
	'bundle',
	'wporg:prepare',
	'clean:bundle',
	'release:copy-for-zip',
	'release:zip',
	'cleanup'
) );
