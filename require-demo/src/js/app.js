require(['jquery','bootstrap'], function($){
	var currentPage = $('#current-page').attr('current-page');
	var targetModule = $('#current-page').attr('target-module');
	require([targetModule], function(targetModule) {
		targetModule.init(currentPage)
	})
})