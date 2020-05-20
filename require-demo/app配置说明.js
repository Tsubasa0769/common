//text插件 https://github.com/requirejs/text
//CSS插件 https://github.com/guybedford/require-css
//打包命令 r.js.cmd -o baseUrl=js name=user out=build.js 或者 node r.js -o baseUrl=js name=user out=build.js
//baseUrl需要打包的文件路径
//name需要打包的文件名
//打包后输出的文件名
//配置文件打包 r.js.cmd -o app.build.js
//使用npm打包
//1.npm init 生成 package.josn文件
//2.npm run package   这个命令会运行package.json里script对象里的package方法,所以我们要修改package.json里script中的代码

requirejs.config({
	baseUrl: './src/js',	//配置基础路径
	urlArgs: '_=' + new Date().getTime(),	//配置请求时所带的参数
	paths: {
		'jquery': './lib/jquery',
		'api': './app/api',
		'text': './lib/text',
		'css': './lib/css',
		'bootstrap': './lib/bootstrap',
		'foo': [
				'./lib/foo',		//当这个路径找不到的时候，去找第2个路径
				'./lib/foo2'
				],
	},
    config: {
    	//text插件设置需要的时候才配置，否则会报错
        // text: {
        //     onXhr: function (xhr, url) {
        //     	//发送之前执行，可以设置header头
        //         //Called after the XHR has been created and after the
        //         //xhr.open() call, but before the xhr.send() call.
        //         //Useful time to set headers.
        //         //xhr: the xhr object
        //         //url: the url that is being used with the xhr object.
        //     },
        //     createXhr: function () {
        //     	//一般不用
        //         //Overrides the creation of the XHR object. Return an XHR
        //         //object from this function.
        //         //Available in text.js 2.0.1 or later.
        //     },
        //     onXhrComplete: function (xhr, url) {
        //     	//请求完成后执行的函数，感觉也不用
        //         //Called whenever an XHR has completed its work. Useful
        //         //if browser-specific xhr cleanup needs to be done.
        //     }
        // }
    },	
	//不支付amd格式的JS配置方式
	shim: {
		'modernizr': {
			deps: ['jquery'],	//表示该模块需要的依赖
			exports: 'Modernizr',	//将该模块的对象输出
			init: function($) {		//这个一般不用
				return $;
			}
		},
		'bootstrap': ['jquery','css!/req/src/css/bootstrap.css']
	},
	//map表示模块配置 当我请求a模块时，a模块用到jquery，就会从下面的地址进行查找
	map: {
		'*': {
			'jquery': '../js/lib/jquery'
		}
	}
});
require(['jquery','api','bootstrap'], function($,api) {
	$('#btn').click(function() {
		// api.getJsonp();
		api.getUserHtml();
	})

})