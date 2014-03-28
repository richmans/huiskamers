(function ($) {
	
	function filter_age(row){
		var min_age = $(row).attr('data-age-min');
		var max_age = $(row).attr('data-age-max');
		var prefered_age = $('input#huiskamers-select-age').val();
		if(prefered_age){
			return ((min_age <= prefered_age) && (max_age >= prefered_age));
		} else {
			return true;	
		}
		
	}

	function filter_region(row){
		var regions = $(row).attr('data-regions');
		var prefered_region = $('select#huiskamers-select-region').val();
		if(prefered_region != -1){

			
			return (regions.search("(" + prefered_region + ")") != -1);
		} else {
			return true;	
		}
		
	}

	function run_filters(row) {
		if (filter_age(row) == false) return false;
		if (filter_region(row) == false) return false;
		return true;
	}

	function apply_filters() {
		$('table.huiskamers tr.huiskamer-row').each(function() {
			var matches = true;
			matches = run_filters($(this));
			display = (matches) ? 'table-row': 'none';
			$(this).css('display', display);
		})
	}

	$(function () {
		$('a.huiskamer-email').click(function(){
			var huiskamer = $(this).attr('data-huiskamer');
			$('input#huiskamer-id').val(huiskamer);
		  var t = this.title || this.name || null;
		  var a = this.href || this.alt;
		  var g = this.rel || false;
		  tb_show(t,a,g);
		  this.blur();
		  return false;
  	});

  	$('select#huiskamers-select-region').change(function() {
  		apply_filters();
  	})

  	$('input#huiskamers-select-age').keydown(function( event ) {
		  if ( event.which == 13 ) {
		    apply_filters();
		  }
		});

		$('button#huiskamers-search').click(function() {
			apply_filters();
		})


		
	});
}(jQuery));