module.exports = {
	grunt : {
		files : [ 'Gruntfile.js', 'src/grunt/*' ]
	},
	sass : {
		files : 'src/scss/**/*.scss',
		tasks : [ 'sass', 'replace', 'notify:sass' ]
	},
	javascripts : {
		files : 'src/javascripts/*.js',
		tasks : [ 'uglify', 'notify:concat']
	}
};