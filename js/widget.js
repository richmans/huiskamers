(function ($) {
	"use strict";
	$(function () {
		$('a.huiskamer-email').click(function(){
			var huiskamer = $(this).attr('data-huiskamer');
		  var t = this.title || this.name || null;
		  var a = this.href || this.alt;
		  var g = this.rel || false;
		  tb_show(t,a,g);
		  this.blur();
		  return false;
  	});
   
		
	});
}(jQuery));