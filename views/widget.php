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
         Als het probleem zich blijft voordoen dan graag contact opnemen met het huiskamer team.</div>
<?php } ?>
<?php if ($email_sent == 'unavailable') {?>
     <div class='huiskamers-contact-fail'>Error: Bericht niet verstuurd!<br/>
         De huiskamer neemt momenteel geen aanmeldingen aan.</div>
<?php } ?>

<div class="huiskamers">
    <div class="huiskamers-searcher">
        <div style="margin-bottom:10px;">
            <b>Locatie</b><br/>
            <select class='huiskamers-searcher-selectRegion' id='huiskamers-select-region'>
            <option value='-1'>heel Nederland</option>
            <?php foreach(Huiskamers\Region::all() as $region) { ?>
                 <option value='<?php echo $region->id()?>'><?php echo esc_html($region->name())?></option>
            <?php } ?>
            </select>
        </div>
        <div style="margin-top:10px;">
            <b>Leeftijd</b><br/>
            <input type='text' name='huiskamers-age' id='huiskamers-select-age' class='huiskamers-searcher-inputAge'/>
        </div>
    </div>
    
    <div class="huiskamers-noResults" id="huiskamers-not-found-message"
         style="display: none;">
        Geen huiskamers beschikbaar
    </div>
    
    
    <div class="huiskamers-searchResults">
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
                 style="">
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
                    <div class="vc_btn3-container vc_btn3-right huiskamers-searchResult-contactButton">
                        <a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-modern vc_btn3-icon-left vc_btn3-color-inverse huiskamer-email" 
                           title='Contact ThuisVerder-kring' href="#TB_inline?width=375&height=290&inlineId=<?php echo $huiskamer->form_title()?>" data-huiskamer='<?php echo $huiskamer->id()?>'>
                            <i class="vc_btn3-icon fa fa-envelope"></i> Contact
                        </a>
                    </div>        
                    <?php } ?>
            </div>
        <?php } ?>
    </div>
    


<!-- email pop up -->
<div id="huiskamers-email-form" class="huiskamers-contactForm-container" style="display:none;">
     <form method='post' id="huiskamers-contactForm-form" class='huiskamers-contactForm-form'>
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
          <input type='submit' value='Versturen'/>
     </form>
</div>

<!-- gesloten huiskamer pop up -->
<div id="huiskamers-unavailable" style="display:none;">
    <p>Dankjewel voor je interesse in deze huiskamer! Helaas kan deze huiskamer tijdelijk geen nieuwe leden opnemen. Wellicht heeft één van de andere huiskamers ook je interesse.</p>
    <p>Het huiskamerteam</p>
</div>
