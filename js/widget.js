(function ($) {
    function validate_email(email) {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
    
    function validate_text(text) {            
        return text != null && text != "";
    }
    
    function valuefilter_only_numeric(value)
    {
        return value.replace(/[^0-9]+/g, '');
    }
    
    function valuefilter_max_length(value, length)
    {
        return value.substring(0, length)
    }

    function createSearchData()
    {
        var checkedRegionsCheckboxes = document.querySelectorAll("#huiskamers-searcher-regions input[type=checkbox]:checked");
        var checkedDaysCheckboxes = document.querySelectorAll("#huiskamers-searcher-days input[type=checkbox]:checked");
        var checkedMomentsCheckboxes = document.querySelectorAll("#huiskamers-searcher-moments input[type=checkbox]:checked");
        
        return {
            age: $('input#huiskamers-select-age').val(),
            regions: Array.from(checkedRegionsCheckboxes, x => x.value),
            days: Array.from(checkedDaysCheckboxes, x => x.value),
            moments: Array.from(checkedMomentsCheckboxes, x => x.value)
        };
    }

    function apply_filters() 
    {
        var searchData = createSearchData();
        var findCount = 0;
        $('div.huiskamers-searchResults div.huiskamers-searchResult').each(function() {
            var matches = true;
            matches = run_filters($(this), searchData);
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
    
    function run_filters(row, searchData) {
        if (filter_age(row, searchData.age) === false) return false;
        if (filter_regions(row, searchData.regions) === false) return false;
        if (filter_days(row, searchData.days) === false) return false;
        if (filter_moments(row, searchData.moments) === false) return false;
        return true;
    }
    
    function filter_age(row, prefered_age){
        var min_age = parseInt($(row).attr('data-age-min'));
        var max_age = parseInt($(row).attr('data-age-max'));
        if(prefered_age){
            prefered_age = parseInt(prefered_age);
            return ((min_age <= prefered_age) && (max_age >= prefered_age));
        } else {
            return true;	
        }
    }
    
    function filter_regions(row, prefered_regions){
        var rowRegions = $(row).attr('data-regions').toLowerCase();
        if(prefered_regions.length === 0)
        {
            return true; // no prefered region selected
        }
        else            
        {
            for (i = 0; i < prefered_regions.length; i++) { 
                if(rowRegions.indexOf("(" + prefered_regions[i] + ")") !== -1)
                {
                    return true; // prefered region found
                }               
            }
        
            return false; // no prefered region found
        }        
    }
    
    function filter_days(row, prefered_days){
        var rowMoment = $(row).attr('data-moment').toLowerCase();
        if(prefered_days.length === 0)
        {
            return true; // no prefered day selected
        }
        else            
        {
            for (i = 0; i < prefered_days.length; i++) { 
                if(rowMoment.includes(prefered_days[i]))
                {
                    return true; // prefered day found
                }                
            }
        
            return false; // no prefered day found
        }        
    }
    
    function filter_moments(row, prefered_moments){
        var rowMoment = $(row).attr('data-moment').toLowerCase();
        if(prefered_moments.length === 0)
        {
            return true; // no prefered moment selected
        }
        else            
        {
            for (i = 0; i < prefered_moments.length; i++) { 
                if(rowMoment.includes(prefered_moments[i]))
                {
                    return true; // prefered moment found
                }                
            }
        
            return false; // no prefered moment found
        }        
    }

    function update_not_found_message(findCount)
    {  
        // Update visibility.
        var messageObject = $('div#huiskamers-not-found-message');
        if (findCount <= 0)
        {
            messageObject.css('display', '');
            // Update error text.
            document.getElementById('huiskamers-not-found-message').innerHTML = "Helaas geen ThuisVerder-kring gevonden voor geselecteerde filters.";
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
            var name = $('input#huiskamer-contact-name-input').val();
            if(!(validate_text(name))){
                alert("Vul uw naam in.");
                return false;
            }                
            var email = $('input#huiskamer-contact-email-input').val();
            if(!(validate_email(email))){
                alert("Vul uw e-mail in.");
                return false;
            }           
            var message = $('textarea#huiskamer-contact-message-textarea').val();
            if(!(validate_text(message))){
                alert("Vul een bericht in.");
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
        
        var regionsCheckboxes = document.querySelectorAll("#huiskamers-searcher-regions input[type=checkbox]");
        for (i = 0; i < regionsCheckboxes.length; i++) {
            regionsCheckboxes[i].addEventListener('change', apply_filters, false);
        }  
                
        var daysCheckboxes = document.querySelectorAll("#huiskamers-searcher-days input[type=checkbox]");
        for (i = 0; i < daysCheckboxes.length; i++) {
            daysCheckboxes[i].addEventListener('change', apply_filters, false);
        }   
        
        var momentsCheckboxes = document.querySelectorAll("#huiskamers-searcher-moments input[type=checkbox]");
        for (i = 0; i < momentsCheckboxes.length; i++) {
            momentsCheckboxes[i].addEventListener('change', apply_filters, false);
        }
    });
}(jQuery));