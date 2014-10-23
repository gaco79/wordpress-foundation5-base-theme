module.exports = function(grunt) {
	var path = require('path');

	require('load-grunt-config')(
			grunt,
			{
				configPath : path.join(process.cwd(), 'src/grunt'),
				data : { // data passed into config
					pkg : grunt.file.readJSON('package.json'),
					project : {
						banner : '/*!\n' + ' * Theme Name: <%= pkg.title %>\n'
								+ ' * Theme URI: <%= pkg.themeUrl %>\n'
								+ ' * \n' + ' * Author: <%= pkg.author %>\n'
								+ ' * Version: <%= pkg.version %>\n'
								+ ' * License: <%= pkg.licence %>\n' + ' */\n'
					}
				},
			});
};