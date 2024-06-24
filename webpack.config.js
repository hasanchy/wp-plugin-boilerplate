const path = require('path');
const defaultConfig = require("@wordpress/scripts/config/webpack.config");

module.exports = {
	...defaultConfig,
	devServer:{
		devMiddleware: {
			writeToDisk: true,
		},
		allowedHosts: 'auto',
		host: 'localhost',
		port: 8891,
		proxy: {
			'/build': {
				pathRewrite: {
					'^/build': '',
				},
			},
		},
	}
};