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
                    'js/dist/block.min.js': ['<%= concat.block.dest %>']
                }
            }
        },
        watch: {
            files: ['<%= concat.block.src %>'],
            tasks: ['concat', 'uglify', 'notify:done']
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
    grunt.loadNpmTasks('grunt-notify');
    grunt.registerTask('default', ['concat', 'uglify', 'watch', 'notify:done']);
    grunt.registerTask('watchJS', ['watch']);
};
