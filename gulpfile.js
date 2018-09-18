/*jslint node: true */
"use strict";

var $            = require( "gulp-load-plugins" )();
var argv         = require( "yargs" ).argv;
var gulp         = require( "gulp" );
var browserSync  = require( "browser-sync" ).create();
var sequence     = require( "run-sequence" );
var del          = require( "del" );
var zip          = require( "gulp-zip" );
var phpcs        = require( "gulp-phpcs" );
var config       = require( "./config.json" );

gulp.task( "watch", [ 'copy-files' ], function() {
    browserSync.init({
        proxy : config.dev.proxy
    });

    gulp.watch( 'src/**', [ 'copy-files' ] ).on('change', browserSync.reload);
});

gulp.task( 'publish', [ 'build' ], function() {
    del( [ config.project.zip ] );

    return sequence( 'publish:copy', 'publish:make:zip', 'publish:cleanup' );
});

gulp.task( "build", [ "clean" ], function(done) {
    return sequence( [ 'copy-files' ] );
});

gulp.task( 'copy-files', function() {
    return sequence( [ 'copy-files:php' ] )
});

gulp.task( "tests", function() {
    return sequence( [ 'phpcs' ] );
});

gulp.task( "clean", function() {
    return del([
        config.dev.destination + "**"
    ], {
        force: true
    });
});

gulp.task( 'publish:copy', function() {
    return gulp.src( [ config.dev.destination + '**' ] )
        .pipe( gulp.dest( config.project.slug ) );
});

gulp.task( 'publish:make:zip', function() {
    return gulp.src(
        [ config.project.slug + '/**' ],
        {
            base : '.'
        } )
        .pipe( zip( config.project.zip ) )
        .pipe( gulp.dest( '.' ) );
});

gulp.task( 'publish:cleanup', function() {
    return del( [ config.project.slug + '/**' ] );
});

gulp.task( 'copy-files:php', function() {
    return gulp.src( 'src/**' )
        .pipe( gulp.dest( config.dev.destination ) );
});

gulp.task( 'phpcs', function() {
    return gulp.src( config.paths.watch.php )
        .pipe( phpcs({
            bin: 'vendor/bin/phpcs.bat',
            standard: 'wpcs-ruleset.xml',
            colors: true,
            showSniffCode: true
        }))
        .pipe( phpcs.reporter( 'log' ) );
});
