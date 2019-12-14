'use strict';
module.exports = function (grunt) {
  // Project configuration.
  grunt.initConfig({
    concat: {
      options: {
        separator: ';\r\n'
      },
      block: {
        src: [
          'js/block/*'
        ],
        dest: 'js/dist/block.js'
      },
      user: {
        src: [
          'js/user/*'
        ],
        dest: 'js/dist/code-playground.js'
      }
    },
    uglify: {
      options: {
        banner: '/* (c) ClassCube.com */\n',
        report: 'min',
        compress: {
          drop_console: false,
          sequences: false
        }
      },
      dist: {
        files: {
          'js/dist/block.min.js': ['<%= concat.block.dest %>'],
          'js/dist/code-playground.min.js': ['<%= concat.user.dest %>']
        }
      }
    },
    sass: {
      user: {
        options: {
          style: 'compressed'
        },
        files: {
          'css/playground.css': 'css/scss/user/playground.scss'
        }
      }
    },
    watch: {
      js: {
        files: ['<%= concat.block.src %>', ['<%= concat.user.src %>']],
        tasks: ['concat', 'uglify', 'notify:done']
      },
      css: {
        files: '**/*.scss',
        tasks: ['sass']
      },
      php: {
        files: '**/*.php',
        tasks: ['lang']
      }
    },
    notify: {
      done: {
        options: {
          title: 'Task Complete', // optional
          message: 'Finished JS concat and uglify', //required
        }
      }
    },
    makepot: {
      target: {
        options: {
          cwd: '', // Directory of files to internationalize.
          domainPath: 'lang', // Where to save the POT file.
          exclude: [], // List of files or directories to ignore.
          include: [], // List of files or directories to include.
          mainFile: '', // Main project file.
          potComments: '', // The copyright at the beginning of the POT file.
          potFilename: '', // Name of the POT file.
          potHeaders: {
            poedit: true, // Includes common Poedit headers.
            'x-poedit-keywordslist': true, // Include a list of all possible gettext functions.
            'Report-Msgid-Bugs-To': 'https://github.com/ClassCube/wordpress-code-playground'
          }, // Headers to add to the generated POT file.
          processPot: null, // A callback function for manipulating the POT file.
          type: 'wp-plugin', // Type of project (wp-plugin or wp-theme).
          updateTimestamp: true, // Whether the POT-Creation-Date should be updated without other changes.
          updatePoFiles: false              // Whether to update PO files in the same directory as the POT file.
        }
      }
    },
    addtextdomain: {
      options: {
        textdomain: 'code-playground', // Project text domain.
        updateDomains: true  // List of text domains to replace.
      },
      target: {
        files: {
          src: [
            '*.php',
            '**/*.php',
            '!node_modules/**',
            '!tests/**'
          ]
        }
      }
    }
  });
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-notify');
  grunt.loadNpmTasks('grunt-wp-i18n');

  grunt.registerTask('default', ['concat', 'uglify', 'sass', 'watch', 'notify:done']);
  grunt.registerTask('watchJS', ['watch']);
  grunt.registerTask('lang', ['addtextdomain', 'makepot']);
};
