const autoprefixer = require( 'autoprefixer' );
const loadGrundModules = require( 'load-grunt-tasks' );

module.exports = function ( grunt ) {
	grunt.initConfig( {
		config: {
			assets: {
				src: 'resources/assets/',
				dest: 'svn-assets/'
			},

			name: 'TextModules',

			src: 'src/',

			styles: {
				src: 'resources/scss/',
				dest: 'assets/css/'
			},

			tests: {
				php: 'tests/php/'
			}
		},

		/**
		 * @see {@link https://github.com/gruntjs/grunt-contrib-cssmin grunt-contrib-cssmin}
		 * @see {@link https://github.com/jakubpawlowicz/clean-css clean-css}
		 */
		cssmin: {
			styles: {
				options: {
					compatibility: 'ie8'
				},
				expand: true,
				cwd: '<%= config.styles.dest %>',
				src: [ '*.css', '!*.min.css' ],
				dest: '<%= config.styles.dest %>',
				ext: '.min.css'
			}
		},

		/**
		 * @see {@link https://github.com/tfrommen/grunt-delegate grunt-delegate}
		 */
		delegate: {
			'imagemin-assets': {
				src: [ '<%= config.assets.src %>**/*.{gif,jpeg,jpg,png}' ],
				task: 'imagemin:assets'
			},

			'sass-convert': {
				src: [ '<%= config.styles.src %>**/*.scss' ],
				task: 'sass:convert'
			}
		},

		/**
		 * @see {@link https://github.com/gruntjs/grunt-contrib-imagemin grunt-contrib-imagemin}
		 * @see {@link https://github.com/imagemin/imagemin imagemin}
		 */
		imagemin: {
			options: {
				optimizationLevel: 7
			},

			assets: {
				expand: true,
				cwd: '<%= config.assets.src %>',
				src: [ '*.{gif,jpeg,jpg,png}' ],
				dest: '<%= config.assets.dest %>'
			}
		},

		/**
		 * @see {@link https://github.com/brandonramirez/grunt-jsonlint grunt-jsonlint}
		 * @see {@link https://github.com/zaach/jsonlint JSON Lint}
		 */
		jsonlint: {
			options: {
				indent: 2
			},

			configs: {
				src: [ '.*rc' ]
			},

			json: {
				src: [ '*.json' ]
			}
		},

		/**
		 * @see {@link https://github.com/suisho/grunt-lineending grunt-lineending}
		 */
		lineending: {
			options: {
				eol: 'lf',
				overwrite: true
			},

			github: {
				src: [ '.github/*' ]
			},

			root: {
				src: [ '*' ]
			},

			src: {
				src: [
					'<%= config.src %>**/*.php'
				]
			},

			styles: {
				src: [
					'<%= config.styles.src %>**/*.scss',
					'<%= config.styles.dest %>*.css'
				]
			},

			tests: {
				src: [
					'<%= config.tests.php %>**/*.php'
				]
			}
		},

		/**
		 * @see {@link https://github.com/jgable/grunt-phplint grunt-phplint}
		 */
		phplint: {
			root: {
				src: [ '*.php' ]
			},

			src: {
				src: [ '<%= config.src %>**/*.php' ]
			},

			tests: {
				src: [ '<%= config.tests.php %>**/*.php' ]
			}
		},

		/**
		 * @see {@link https://github.com/nDmitry/grunt-postcss grunt-postcss}
		 * @see {@link https://github.com/postcss/postcss PostCSS}
		 */
		postcss: {
			styles: {
				options: {
					processors: [
						/**
						 * @see {@link https://github.com/postcss/autoprefixer Autoprefixer}
						 */
						autoprefixer( {
							browsers: '> 1%, last 2 versions, IE 8',
							cascade: false
						} )
					],
					failOnError: true
				},
				expand: true,
				cwd: '<%= config.styles.dest %>',
				src: [ '*.css', '!*.min.css' ],
				dest: '<%= config.styles.dest %>'
			}
		},

		/**
		 * @see {@link https://github.com/gruntjs/grunt-contrib-sass grunt-contrib-sass}
		 */
		sass: {
			options: {
				unixNewlines: true,
				noCache: true
			},

			check: {
				options: {
					check: true
				},
				src: '<%= config.styles.src %>*.scss'
			},

			convert: {
				options: {
					sourcemap: 'none',
					style: 'expanded'
				},
				expand: true,
				cwd: '<%= config.styles.src %>',
				src: [ '*.scss' ],
				dest: '<%= config.styles.dest %>',
				ext: '.css'
			}
		},

		/**
		 * @see {@link https://github.com/sindresorhus/grunt-shell grunt-shell}
		 */
		shell: {
			phpunit: {
				command: 'phpunit'
			}
		},

		/**
		 * @see {@link https://github.com/twolfson/grunt-zip grunt-zip}
		 */
		zip: {
			release: {
				src: [
					'*.{php,txt}',
					'assets/**',
					'<%= config.src %>**/*.php'
				],
				dest: 'TextModules.zip',
				router( filepath ) {
					// Put files into "text-modules/" folder.
					return `text-modules/${filepath}`;
				}
			}
		}
	} );

	/**
	 * @see {@link https://github.com/sindresorhus/load-grunt-tasks load-grunt-tasks}
	 */
	loadGrundModules( grunt );

	grunt.registerTask( 'styles', [
		'newer:delegate:sass-convert',
		'newer:postcss',
		'newer:lineending:styles',
		'changed:cssmin'
	] );

	grunt.registerTask( 'common', [
		'jsonlint',
		'phplint',
		// 'shell:phpunit'
	] );

	grunt.registerTask( 'ci', [
		'common',
		'sass:check'
	] );

	grunt.registerTask( 'develop', [
		'newer:jsonlint',
		'newer:phplint:src',
		'newer:lineending',
		'styles'
	] );

	grunt.registerTask( 'pre-commit', [
		'changed-clean',
		'newer-clean',
		'imagemin',
		'common',
		'lineending',
		'styles'
	] );

	grunt.registerTask( 'release', [
		'pre-commit',
		'zip:release'
	] );

	grunt.registerTask( 'default', 'develop' );
};
