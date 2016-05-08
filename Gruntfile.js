module.exports = function(grunt) {
  require('jit-grunt')(grunt);

  grunt.initConfig({
        // setting folder templates
        dirs: {
            css: 'asset/css',
            images: 'asset/images',
            js: 'asset/js',
            less: 'asset/less'
        },
         // Compile all .less files.
        less: {

            admin: {
                files: {
                    '<%= dirs.css %>/admin.css': ['<%= dirs.css %>/admin.less'],
                }
            }
        },
  

    watch: {
        less: {
            files: ['asset/css/*.less' ],
            tasks: ['less:admin'],
            options: {
                livereload: true
            }
        }
    },

  });

  grunt.registerTask('default', ['less', 'watch']);
};