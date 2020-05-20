define(['jquery'], function($) {
	return {
		init: function(currentPage){
			console.log(currentPage)
			//需要执行的代码
			$(function(){
				$('#test').click(function() {
					alert('123')
				})				
			})
		}
	}
})