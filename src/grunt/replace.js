module.exports = {
	css : {
		options : {
			patterns : [ {
				match : 'version',
				replacement : '<%= pkg.version %>'
			}, {
				match : 'timestamp',
				replacement : '<%= grunt.template.today() %>'
			} ]
		},
		files : {
			'style.css' : 'style.css',
			'editor-style.css' : 'editor-style.css'
		}
	}
}