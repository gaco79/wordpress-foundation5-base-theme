module.exports = {
	options : {
		includePaths : [ 'bower_components/foundation/scss' ]
	},
	dist : {
		options : {
			// Would be ideal, but currently strips "loud" comments and
			// therefore the information
			// required by the Wordpress Appearance admin page is misssing.
			// outputStyle: 'compressed'

			// Will have to do for now...
			outputStyle : 'compact'
		},
		files : {
			'style.css' : 'src/scss/style.scss',
			'editor-style.css' : 'src/scss/editor-style.scss'
		}
	}
};