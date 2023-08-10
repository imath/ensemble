const path = require( 'path' );

/**
 * WordPress Dependencies
 */
const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );

module.exports = {
    ...defaultConfig,
	...{
        entry: {
            'image-a-la-une/index': './src/image-a-la-une/index.js',
			'signet/index': './src/signet/index.js',
			'post-format-template/index': './src/post-format-template/index.js',
        },
		output: {
			filename: '[name].js',
			path: path.join( __dirname, '..', 'assets', 'blocks' ),
		}
    }
}
