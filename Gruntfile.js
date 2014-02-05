module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    
    project: {
      banner: '/*!\n' +
          ' * Theme Name: <%= pkg.title %>\n' +
          ' * Theme URI: <%= pkg.themeUrl %>\n' +
          ' * \n' +
          ' * Author: <%= pkg.author %>\n' +
          ' * Version: <%= pkg.version %>\n' +
          ' * License: <%= pkg.licence %>\n' +
          ' */\n'
    },

    sass: {
      options: {
        includePaths: ['bower_components/foundation/scss']
      },
      dist: {
        options: {
          // Would be ideal, but currently strips "loud" comments and therefore the information
          // required by the Wordpress Appearance admin page is misssing.
          // outputStyle: 'compressed' 

          // Will have to do for now...
          outputStyle: 'compact'
        },
        files: {
          'style.css': 'src/scss/style.scss'
        }        
      }
    },

    uglify: {
      options: {
        banner: '<%= project.banner %>'
      },
      myfiles: {
         files: [
        {
          expand: true,             // Enable dynamic expansion.
          cwd: 'src/javascripts/',  // Src matches are relative to this path.
          src: '*.js',              // Actual pattern(s) to match.
          dest: 'js/',              // Destination path prefix.
          ext: '.min.js',           // Dest filepaths will have this extension.
        },
        ]
      },
      modernizr: {
        files: {
          'js/modernizr.min.js': 'bower_components/modernizr/modernizr.js'
        },
      }
    },

    watch: {
      grunt: { files: ['Gruntfile.js'] },

      sass: {
        files: 'src/scss/**/*.scss',
        tasks: ['sass']
      },
      javascripts: {
        files: 'src/javascripts/**/*.js',
        tasks: ['uglify']
      }
    }
  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('build', ['sass', 'uglify']);
  grunt.registerTask('default', ['build','watch']);
}