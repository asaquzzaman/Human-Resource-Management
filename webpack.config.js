const path = require('path');
//var webpack = require('webpack');

module.exports = {
	entry: './asset/js/hrm-vue.js',

	output: {
		path: path.resolve( __dirname, 'asset/js'),
		filename: 'hrm-bundle.js',
		publicPath: 'asset/js',
		chunkFilename: 'chunk/[id].chunk-bundle.js',
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

    resolve : {
        alias: {
            jquery: "./asset/js/jquery.js",
            date: "./asset/js/date.js"
        }
    },

    // plugins: [
	   //  new webpack.DefinePlugin({
	   //    'process.env': {
	   //      NODE_ENV: JSON.stringify('production')
	   //    }
	   //  })
    // ]
}


