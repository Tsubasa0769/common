define(['jquery'], function($) {
	return {
		init: function(currentPage){
			var myobj = this;
			console.log(currentPage)
			//需要执行的代码
			$(function(){
				$('#test').click(function() {
					myobj.haha($(this).data('id'))
				})				
			})
		},
		haha: function(msg) {
			alert(msg)
		}
	}
})