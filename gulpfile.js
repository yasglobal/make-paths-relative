const { src, dest, parallel } = require('gulp');
const cleanCSS = require('gulp-clean-css');
const del = require('del');
const package = require("./package.json");
const rename = require('gulp-rename');

// Get Plugin Version from `package.json`
const pluginVersion = package.makePathsRelative.pluginVersion;

async function deleteMinFiles() {
	await del(['assets/**/*.min.*']);
}

function minifyCss() {
	return src(['assets/css/src/*.css'])
		.pipe(cleanCSS({ compatibility: 'ie8' }))
		.pipe(rename(function(path) {
			path.extname = '-' + pluginVersion + '.min.css';
		}))
		.pipe(dest('assets/css'));
}

exports.build = parallel(deleteMinFiles, minifyCss);
