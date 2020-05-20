({
	appDir: './src',
	baseUrl: './js',
	dir: './build',
	mainConfigFile: './src/js/require.config.js',
	// name: 'app'		//单模块打包
	inlineText: false,	//不把文本文件一起打包，针对Text插件
	//多模块打包
	modules: [{
		name: 'app',
		// exclude: ['bootstrap'],	//移除需要打包的依赖并且这个包所需的依赖也不会打包
		// excludeShallow: ['bootstrap'],	//移除需要打包的依赖,但这个包所需的依赖不会移除
		// include: ['modernizr']	//把需要打包的包，但暂时没用到也打包进来
		// insertRequire: ['modernizr']	//会在打包的模块最后引入这个包
	}]
})