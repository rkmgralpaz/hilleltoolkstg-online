'use strict';

const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const terser = require('gulp-terser');
const rename = require('gulp-rename');
const { pipeline } = require('stream');
const browserSync = require('browser-sync').create();
const reload = browserSync.reload;
const rollup = require('@rollup/stream');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');

// Plugin: strip query strings from import paths (e.g. './utils.js?v=032' → './utils.js')
const stripQueryStrings = () => ({
  name: 'strip-query-strings',
  resolveId(importee, importer) {
    if (importee.includes('?')) {
      return this.resolve(importee.split('?')[0], importer, { skipSelf: true });
    }
    return null;
  }
});


exports.serve = () => {
  browserSync.init({
    proxy: 'http://localhost:10169/',
    host: '192.168.100.96',
    open: false,
    // ghostMode: false,
    notify: false
  })
  gulp.watch('./scss/framework/*.scss', buildStyles)
  gulp.watch('./scss/framework/variables/*.scss', buildStyles)
  gulp.watch('./scss/main/*.scss', buildStyles)
  gulp.watch('./scss/main/blocks/*.scss', buildStyles)
  gulp.watch('./scss/main/components/*.scss', buildStyles)
  gulp.watch('./scss/main/news/*.scss', buildStyles)
  gulp.watch('./scss/main/globals/*.scss', buildStyles)
  gulp.watch('./scss/*.scss', buildStyles)
  gulp.watch('./js/js-modules/*.js', buildScripts)
  gulp.watch('./js/js-modules/blocks/*.js', buildScripts)
  gulp.watch('./js/js-modules/components/*.js', buildScripts)
  gulp.watch('./js/js-modules/globals/*.js', buildScripts)
  gulp.watch('./js/main.js', buildScripts)
  gulp.watch("**/*.php").on("change", reload);
}


const buildStyles = () => gulp.src('./scss/*.scss')
  .pipe(sass.sync({ outputStyle: 'compressed' }))
  .pipe(gulp.dest('./'))
  .pipe(browserSync.stream())


const buildScripts = () => {
  return rollup({
    input: './js/main.js',
    plugins: [stripQueryStrings()],
    output: {
      format: 'iife',
      sourcemap: false
    }
  })
  .pipe(source('main.js'))
  .pipe(buffer())
  .pipe(terser())
  .pipe(rename({ extname: '.min.js' }))
  .pipe(gulp.dest('./js/'))
  .pipe(browserSync.stream());
}
