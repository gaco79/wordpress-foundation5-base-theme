module.exports = {
	main : {
		options : {
			archive : 'dist/<%= pkg.name %>.zip'
		},
		files : [
				{
					src : [ '*', '!bower.json', '!Gruntfile.js',
							'!package.json', 'inc/**/*', 'js/**/*',
							'template-parts/**/*' ],
					dest : '<%= pkg.name %>/'
				}, ]
	}
};