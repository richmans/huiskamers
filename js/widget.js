(function ($) {
    function validate_email(email) {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
    
    function valuefilter_only_numeric(value)
    {
        return value.replace(/[^0-9]+/g, '');
    }
    
    function valuefilter_max_length(value, length)
    {
        return value.substring(0, length)
    }

    function filter_age(row){
        var min_age = parseInt($(row).attr('data-age-min'));
        var max_age = parseInt($(row).attr('data-age-max'));
        var prefered_age = $('input#huiskamers-select-age').val();
        if(prefered_age){
            prefered_age = parseInt(prefered_age);
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
        var findCount = 0;
        $('table.huiskamers-table tr.huiskamer-row').each(function() {
            var matches = true;
            matches = run_filters($(this));
            if (matches)
            {
                $(this).css('display', ''); // Remove display property.
                findCount++;
            }
            else
            {
                $(this).css('display', 'none');                            
            }
        })

        apply_even_odd_classes();
        update_not_found_message(findCount);
    }
    
    function update_not_found_message(findCount)
    {  
        // Update visibility.
        var messageObject = $('div#huiskamers-not-found-message');
        if (findCount <= 0)
        {
            messageObject.css('display', '');
            // Update error text.
            document.getElementById('huiskamers-not-found-message').innerHTML = "Helaas geen huiskamer gevonden in " + $('select#huiskamers-select-region>option:selected').html() + " geschikt voor mensen van " + $('input#huiskamers-select-age').val() + " jaar.";
        }
        else
        {
            messageObject.css('display', 'none');
        }
    }

    function apply_even_odd_classes()
    {
        var $allRows = $('tr:visible');
        var $oddRows = $allRows.filter(':odd');
        var $evenRows = $allRows.filter(':even');

        // Remove old classes, then add new ones.
        $oddRows.removeClass('even').addClass('odd');
        $evenRows.removeClass('odd').addClass('even');            
    }
    
    function on_age_changed()
    {
            var filteredValue = $('input#huiskamers-select-age').val();
            filteredValue = valuefilter_only_numeric(filteredValue);
            filteredValue = valuefilter_max_length(filteredValue, 3);
            $('input#huiskamers-select-age').val(filteredValue);
            
            apply_filters();        
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

  	$('div#huiskamers-email-form form').submit(function(){
            var email = $('input#huiskamer-email-input').val();
            if(!(validate_email(email))){
                alert("Vul uw email adres in zodat we contact met u op kunnen nemen!");
                return false;
            }
  	});

  	$('select#huiskamers-select-region').change(function() {
            apply_filters();
  	});
        
        $('#huiskamers-select-age').on('input', function() {
            on_age_changed();
  	});
        
        $('#huiskamers-select-age').bind('input', function() {
            on_age_changed();
  	});
        
//        $('#huiskamers-select-age').keyup(function( event ) {
//            apply_filters();
//        }



// The following code is replaced by filtering the data directly.
//  	$('input#huiskamers-select-age').keydown(function( event ) {
//            if ( event.which == 13 ) {
//                apply_filters();
//            }
//        });
//        
//        $('button#huiskamers-search').click(function() {
//            apply_filters();
//        })
    });
}(jQuery));