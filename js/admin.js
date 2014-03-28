(function ($) {
	"use strict";
	$(function () {
		$('div.multiple-select-container a.add').click(function(){
			var container = $(this).parent();
			var element = container.children().first();
			var new_element = element.clone(true, true);
			new_element.find('select').value = -1;
			new_element.find('a.delete').css('display', 'inline');
			$(this).before(new_element);
			return false;
		})
		$('div.multiple-select a.delete').click(function(){
			$(this).parent().remove();
			return false;
		})

	});
}(jQuery));