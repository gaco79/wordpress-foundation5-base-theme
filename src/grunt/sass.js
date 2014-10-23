module.exports = {
	options : {
		includePaths : [ 'bower_components/foundation/scss' ]
	},
	dist : {
		options : {
			outputStyle: 'compressed'

			// May be useful for debugging
			//outputStyle : 'nested'
		},
		files : {
			'style.css' : 'src/scss/style.scss',
			'editor-style.css' : 'src/scss/editor-style.scss'
		}
	}
};