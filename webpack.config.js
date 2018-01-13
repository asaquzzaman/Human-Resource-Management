const path = require('path');
//var webpack = require('webpack');

function resolve (dir) {
  return path.join(__dirname, './assets/js/src', dir)
}

module.exports = {
	entry: {
        'hrm-bundle': './assets/js/src/start.js',
        'library': './assets/js/src/helpers/library.js',
    },
	
	output: {
		path: path.resolve( __dirname, 'assets/js'),
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


