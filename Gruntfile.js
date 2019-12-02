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
      }
    },
    notify: {
      done: {
        options: {
          title: 'Task Complete', // optional
          message: 'Finished JS concat and uglify', //required
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
  grunt.registerTask('default', ['concat', 'uglify', 'sass', 'watch', 'notify:done']);
  grunt.registerTask('watchJS', ['watch']);
};
