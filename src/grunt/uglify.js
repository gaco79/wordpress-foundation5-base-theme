module.exports = {
	options : {
		banner : '<%= project.banner %>'
	},
	myfiles : {
		files : [ {
			expand : true, // Enable dynamic expansion.
			cwd : 'src/javascripts/', // Src matches are relative to this
										// path.
			src : '*.js', // Actual pattern(s) to match.
			dest : 'js/', // Destination path prefix.
			ext : '.min.js', // Dest filepaths will have this extension.
		}, ]
	},
	modernizr : {
		files : {
			'js/modernizr.min.js' : 'bower_components/modernizr/modernizr.js'
		},
	}
};