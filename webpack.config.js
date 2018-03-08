const path = require('path');
const shell = require('shelljs');
const outputPath = path.resolve( __dirname, 'assets/js')


//Remove all webpack build file
shell.rm('-rf', outputPath)

function resolve (dir) {
  return path.join(__dirname, './assets/src', dir)
}

module.exports = {
	entry: {
        'hrm': './assets/src/start.js',
        'library': './assets/src/helpers/library.js',
    },
	
	output: {
		path: outputPath,
		filename: '[name].js',
		publicPath: '',
		chunkFilename: 'chunk/[chunkhash].chunk-bundle.js',
		jsonpFunction: 'wpSpearHrm',
	},

	resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
          '@components': resolve('components'),
          '@directives': resolve('directives'),
          '@helpers': resolve('helpers'),
          '@router': resolve('router'),
          '@store': resolve('store'),
          '@src': resolve('')
        }
    },

	module: {
		rules: [
			// doc url https://vue-loader.vuejs.org/en/options.html#loaders
			{   
				test: /\.vue$/,
				loader: 'vue-loader',
				options: {
					loaders: {
			        	 js: 'babel-loader'
			        }
				}
			},
			{
				test: /\.js$/,
				loader: 'babel-loader',
				exclude: /node_modules/	
			},
			{
				test: /\.(png|jpg|gif|svg)$/,
				loader: 'file-loader',
				exclude: /node_modules/,
				options: {
					name: '[name].[ext]?[hash]'
				}
			}
		]
	},
}


