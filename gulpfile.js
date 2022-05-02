const del = require("del");
const { src, dest, watch, series, parallel } = require("gulp");
const postcss = require("gulp-postcss");
const rename = require("gulp-rename");
const sourcemaps = require('gulp-sourcemaps')
const compiler = require("webpack");
const webpack = require("webpack-stream");
const webpackConf = require("./webpack.config.js");

function scripts() {
  return src("src/js/*.js")
    .pipe(webpack(webpackConf, compiler))
    .pipe(dest("dist/js"));
}

function styles() {
  return src("src/css/*.css")
    .pipe(sourcemaps.init())
      .pipe(postcss())
      .pipe(rename({ extname: ".min.css" }))
    .pipe(sourcemaps.write('./'))
    .pipe(dest("dist/css"));
}

function clean() {
  return del(["dist"]);
};

exports.build = series(clean, parallel(scripts, styles));
exports.default = function () {
  watch(["src/**/*.{js,css}", "**/*.{html,php}", "!node_modules/**"], { ignoreInitial: false }, series("build"));
};
