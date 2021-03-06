<?php 
    function GetColumnHeader($columnSlug, $columnName)
    {
        $result = "";
        if ($columnSlug == 'age_min') {
            $result = "Leeftijdsspreiding";
        } else {
            $result = esc_html($columnName);
        }
        
        return $result;
    };

    function DrawColumnHTML($huiskamer, $columnSlug, $columnName)
    {
        echo "<div class=\"huiskamers-searchResult-column\" data-label=\"" . GetColumnHeader($columnSlug, $columnName) . "\">";
            echo "<div class=\"huiskamers-searchResult-column-header\">";
                echo GetColumnHeader($columnSlug, $columnName);                        
            echo "</div>";
            echo "<div class=\"huiskamers-searchResult-column-content\">";
                if($columnSlug == 'age_min') {
                     echo $huiskamer->age_min() . "-" . $huiskamer->age_max();
                } else if ($columnSlug == 'group_size') {
                     echo Huiskamers\Lookup::get('group_sizes', $huiskamer->group_size());
                } else if ($columnSlug == 'regions') {
                     echo esc_html($huiskamer->region_names());
                } else if ($columnSlug == 'description') {
                    echo esc_html($huiskamer->description());
                } else {
                    echo esc_html($huiskamer->$columnSlug());
                }
            echo "</div>";
        echo "</div>";
    }
?>

<?php if ($email_sent == 'ok') {?>
    <div class="wpcf7-response-output wpcf7-display-none wpcf7-mail-sent-ok" role="alert">
        <div class="wpcf7-valid-tip-text">Uw bericht werd succesvol verzonden.</div>
    </div>
     <!--<div class='huiskamers-contact-sent'>Uw bericht werd succesvol verzonden.</div>-->
<?php } ?>
<?php if ($email_sent == 'fail') {?>
     <div class='huiskamers-contact-fail'>Error: Bericht niet verstuurd! Probeer het nog eens.<br/>
         Als het probleem zich blijft voordoen dan graag contact opnemen met het ThuisVerder-team.</div>
<?php } ?>
<?php if ($email_sent == 'unavailable') {?>
     <div class='huiskamers-contact-fail'>Error: Bericht niet verstuurd!<br/>
         De huiskamer neemt momenteel geen aanmeldingen aan.</div>
<?php } ?>

<div class="huiskamers">    
    <div class="huiskamers-spacer-top"></div>
    <div class="huiskamers-searcher">
        <div class="huiskamers-searcher-background">
            <div class="huiskamers-searcher-content">
                <div id='huiskamers-searcher-regions'>
                    <b>Locatie</b><br/>
                    <?php foreach(Huiskamers\Region::all() as $region) { 
                        if($region->huiskamer_visible_count() > 0){?>
                        
                        <span class="huiskamers-searcher-checkbox-span"><input type='checkbox' class="huiskamers-searcher-checkbox" value='<?php echo $region->id()?>' id='huiskamers-searcher-day-<?php echo $region->id()?>' /><label class="huiskamers-searcher-checkbox-label" for='huiskamers-searcher-day-<?php echo $region->id()?>'><?php echo esc_html($region->name())?></label></span>
                    <?php }} ?>
                </div>
                <div style="margin-top:10px;" id='huiskamers-searcher-days'>
                    <b>Dag</b><br/>
                    <span class="huiskamers-searcher-checkbox-span"><input type='checkbox' class="huiskamers-searcher-checkbox" value='maandag' id='huiskamers-searcher-day-maandag' /><label class="huiskamers-searcher-checkbox-label" for='huiskamers-searcher-day-maandag'>Maandag</label></span>
                    <span class="huiskamers-searcher-checkbox-span"><input type='checkbox' class="huiskamers-searcher-checkbox" value='dinsdag' id='huiskamers-searcher-day-dinsdag' /><label class="huiskamers-searcher-checkbox-label" for='huiskamers-searcher-day-dinsdag'>Dinsdag</label></span>
                    <span class="huiskamers-searcher-checkbox-span"><input type='checkbox' class="huiskamers-searcher-checkbox" value='woensdag' id='huiskamers-searcher-day-woensdag' /><label class="huiskamers-searcher-checkbox-label" for='huiskamers-searcher-day-woensdag'>Woensdag</label></span>
                    <span class="huiskamers-searcher-checkbox-span"><input type='checkbox' class="huiskamers-searcher-checkbox" value='donderdag' id='huiskamers-searcher-day-donderdag' /><label class="huiskamers-searcher-checkbox-label" for='huiskamers-searcher-day-donderdag'>Donderdag</label></span>
                    <span class="huiskamers-searcher-checkbox-span"><input type='checkbox' class="huiskamers-searcher-checkbox" value='vrijdag' id='huiskamers-searcher-day-vrijdag' /><label class="huiskamers-searcher-checkbox-label" for='huiskamers-searcher-day-vrijdag'>Vrijdag</label></span>
                    <span class="huiskamers-searcher-checkbox-span"><input type='checkbox' class="huiskamers-searcher-checkbox" value='zaterdag' id='huiskamers-searcher-day-zaterdag' /><label class="huiskamers-searcher-checkbox-label" for='huiskamers-searcher-day-zaterdag'>Zaterdag</label></span>
                    <span class="huiskamers-searcher-checkbox-span"><input type='checkbox' class="huiskamers-searcher-checkbox" value='zondag' id='huiskamers-searcher-day-zondag' /><label class="huiskamers-searcher-checkbox-label" for='huiskamers-searcher-day-zondag'>Zondag</label></span>
                </div>
                <div style="margin-top:10px;" id='huiskamers-searcher-moments'>
                    <b>Moment</b><br/>
                    <span class="huiskamers-searcher-checkbox-span"><input type='checkbox' class="huiskamers-searcher-checkbox" value='ochtend' id='huiskamers-searcher-moment-ochtend' /><label class="huiskamers-searcher-checkbox-label" for='huiskamers-searcher-moment-ochtend'>Ochtend</label></span>
                    <span class="huiskamers-searcher-checkbox-span"><input type='checkbox' class="huiskamers-searcher-checkbox" value='middag' id='huiskamers-searcher-moment-middag' /><label class="huiskamers-searcher-checkbox-label" for='huiskamers-searcher-moment-middag'>Middag</label></span>
                    <span class="huiskamers-searcher-checkbox-span"><input type='checkbox' class="huiskamers-searcher-checkbox" value='avond' id='huiskamers-searcher-moment-avond' /><label class="huiskamers-searcher-checkbox-label" for='huiskamers-searcher-moment-avond'>Avond</label></span>
                </div>
                <div style="margin-top:10px;">
                    <b>Leeftijd</b><br/>
                    <input type='text' name='huiskamers-age' id='huiskamers-select-age' class='huiskamers-searcher-inputAge'/>
                </div>
            </div>
        </div>
    </div>
    
        <div class="huiskamers-noResults" id="huiskamers-not-found-message"
             style="display: none;">
            <div class="huiskamers-spacer"></div>
            <div class="huiskamers-noResults-background">
                <div class="huiskamers-noResults-content">
                    Helaas geen ThuisVerder-kring gevonden voor geselecteerde filters.
                </div>
            </div>    
        </div>
    
    <div class="huiskamers-searchResults">
        <div class="huiskamers-searchResults-content">
            <?php
                $isEvenRow = false;
                foreach($huiskamers as $huiskamer) {
                    $evenOddClass = $isEvenRow == true ? "even" : "odd";
                    $seekingMembersClass = $huiskamer->seeking_members() ? "seeking-members" : "";
                    $isEvenRow = !$isEvenRow;
            ?>
                <!-- Search results -->
                <div class='huiskamers-searchResult <?php echo $evenOddClass ?> <?php echo $seekingMembersClass ?>' 
                     data-regions='<?php echo $huiskamer->regions()?>' 
                     data-age-min='<?php echo $huiskamer->age_min()?>' 
                     data-age-max='<?php echo $huiskamer->age_max()?>'
                     data-moment='<?php echo $huiskamer->day_part()?>'>
                    <div class="huiskamers-spacer"></div>
                    <div class="huiskamers-searchResult-background">
                        <div class='huiskamers-searchResult-content <?php echo $evenOddClass ?> <?php echo $seekingMembersClass ?>'>
                            <!-- Seeking members message -->
                            <?php if($huiskamer->seeking_members()) { ?>
                                <div class='huiskamers-seeking-members-message'>Deze ThuisVerder-kring is op zoek naar nieuwe leden</div>
                            <?php } ?>
                            <!-- Not available message -->
                            <?php if(!$huiskamer->available()) { ?>
                                <div class='huiskamers-not-available-message'>Deze ThuisVerder-kring neemt momenteel geen nieuwe leden aan</div>
                            <?php } ?>
                            <!-- Columns -->
                            <?php 
                                $leftColumnsCount = ceil((count($columns) - 2) / 2);
                                $leftColumns = null;
                                $rightColumns = null;
                                $fullSizeColumns = null;
                                $columnNr = 0;
                                foreach($columns as $column){                      
                                    $columnSlug = $column->slug();
                                    if ($columnSlug == 'age_max') 
                                    { 
                                            continue;                             
                                    }                        
                                    else if ($columnSlug == 'description')
                                    {
                                        $fullSizeColumns[] = $column;
                                        continue;
                                    }

                                    if($columnNr < $leftColumnsCount)
                                    {
                                        $leftColumns[] = $column;
                                    }
                                    else
                                    {
                                        $rightColumns[] = $column;
                                    }

                                    $columnNr++;
                                } 

                                // Draw left columns
                                if(isset($leftColumns))
                                {
                                    echo "<div class=\"huiskamers-searchResult-leftColumns\">";
                                        foreach($leftColumns as $column)
                                        {
                                            DrawColumnHTML($huiskamer, $column->slug(), $column->name());
                                        }
                                    echo "</div>";
                                }

                                // Draw right columns
                                if(isset($rightColumns))
                                {
                                    echo "<div class=\"huiskamers-searchResult-rightColumns\">";
                                        foreach($rightColumns as $column)
                                        {
                                            DrawColumnHTML($huiskamer, $column->slug(), $column->name());
                                        }
                                    echo "</div>";
                                }

                                // Draw full size columns
                                if(isset($fullSizeColumns))
                                {
                                    echo "<div class=\"huiskamers-searchResult-fullSizeColumns\">";
                                        foreach($fullSizeColumns as $column)
                                        {
                                            DrawColumnHTML($huiskamer, $column->slug(), $column->name());
                                        }
                                    echo "</div>";
                                }
                                ?>
                                <!-- contact button -->
                                <?php if($huiskamer->available()) { ?>                
                                <div class="vc_btn3-container vc_btn3-left huiskamers-searchResult-contactButton-container">
                                    <a class="vc_general vc_btn3 vc_btn3-size-sm vc_btn3-shape-round vc_btn3-style-modern vc_btn3-icon-left vc_btn3-color-inverse huiskamers-searchResult-contactButton huiskamer-email" 
                                       title='Contact ThuisVerder-kring: <?php echo $huiskamer->name()?>' href="#TB_inline?width=375&height=290&inlineId=<?php echo $huiskamer->form_title()?>" data-huiskamer='<?php echo $huiskamer->id()?>'>
                                        <i class="vc_btn3-icon fa fa-envelope"></i> CONTACT
                                    </a>
                                </div>        
                                <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="huiskamers-spacer-bottom"></div>
    </div>


<!-- email pop up -->
<div id="huiskamers-email-form" class="huiskamers-contactForm-container" style="display:none;">
    <form method='post' id="huiskamers-contactForm-form" class='huiskamers-contactForm-form'>
        <div class='huiskamers-contactForm-background'>
            <div class='huiskamers-contactForm-content'>
                <input type='hidden' name='huiskamer_message[huiskamer]' id='huiskamer-id' value='<?php echo $huiskamer_id?>'/>
                <div class='field'>
                     <label for='name' class="huiskamers-contactForm-header">Naam</label><br/>
                     <input type='text' class="huiskamers-contactForm-input" id='huiskamer-contact-name-input'  name='huiskamer_message[name]' autofocus/>
                </div>
                <div class='field'>
                     <label for='email' class="huiskamers-contactForm-header">E-mail</label><br/>
                     <input type='text' class="huiskamers-contactForm-input" id='huiskamer-contact-email-input' name='huiskamer_message[email]'/>
                </div>
                <div class='field'>
                     <label for='bericht' class="huiskamers-contactForm-header">Bericht</label><br/>
                     <textarea class="huiskamers-contactForm-textarea" id='huiskamer-contact-message-textarea' name='huiskamer_message[message]'></textarea>
                </div>
                <input type='submit' value='VERSTUREN'/>
            </div>
        </div>
    </form>
</div>

<!-- gesloten huiskamer pop up -->
<div id="huiskamers-unavailable" style="display:none;">
    <div class='huiskamers-unavailable-container'>
        <p>Dankjewel voor je interesse in deze ThuisVerder-kring! Helaas kan deze kring tijdelijk geen nieuwe leden opnemen. Wellicht heeft één van de andere kring ook je interesse.</p>
        <p>Het ThuisVerder-team</p>
    </div>
</div>
