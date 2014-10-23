module.exports = {
	grunt : {
		files : [ 'Gruntfile.js' ]
	},
	sass : {
		files : 'src/scss/**/*.scss',
		tasks : [ 'sass', 'notify:sass' ]
	},
	javascripts : {
		files : 'src/javascripts/*.js',
		tasks : [ 'uglify', 'notify:concat']
	}
};