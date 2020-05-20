require.config({
	baseUrl: '/req/src/js/',
	urlArgs: "v=1.0_" + (new Date).getTime(),
	paths: {
		"jquery": "lib/jquery",
		"bootstrap": 'lib/bootstrap',
		"css": 'lib/css',
		"css-builder": 'lib/css-builder',
		"normalize": 'lib/normalize'
	},
	shim: {
		'bootstrap':['css!/req/build/css/index.css']
	}
})