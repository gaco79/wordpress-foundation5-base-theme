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
          'style.css': 'src/scss/style.scss',
          'editor-style.css': 'src/scss/editor-style.scss'
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
    
    copy: {
      main: {
        src: 'bower_components/foundation/js/foundation.min.js',
        dest: 'js/foundation.min.js',
      }
    },
    
    imagemin: {
     dynamic: {                         
        files: [{
          expand: true,
          src: ['**.{jpg,gif,png}'],
          cwd: 'src/img/',
          dest: 'img/'
        }]
      }
    },

    watch: {
      grunt: { files: ['Gruntfile.js'] },

      sass: {
        files: 'src/scss/**/*.scss',
        tasks: ['sass']
      },
      javascripts: {
        files: 'src/javascripts/*.js',
        tasks: ['uglify']
      },
      images: {
        files: 'src/img/**/*',
        tasks: ['imagemin']
      }
    }
  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-imagemin');
  grunt.loadNpmTasks('grunt-contrib-copy');

  grunt.registerTask('build', ['sass', 'uglify', 'copy', 'imagemin']);
  grunt.registerTask('default', ['build','watch']);
}