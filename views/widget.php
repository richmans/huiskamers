<?php 
    function GetColumnHeader($slug, $columnName)
    {
        $result = "";
        if ($slug == 'age_min') {
            $result = "Leeftijdsspreiding";
        } else {
            $result = esc_html($columnName);
        }
        
        return $result;
    };

?>

<?php if ($email_sent == 'ok') {?>
     <div class='huiskamer-email-sent'>Uw email is verstuurd - bedankt!</div>
<?php } ?>
<?php if ($email_sent == 'fail') {?>
     <div class='huiskamer-email-fail'>Uw email kon niet verstuurd worden. Probeer het later nog eens.</div>
<?php } ?>
<?php if ($email_sent == 'unavailable') {?>
     <div class='huiskamer-email-fail'>Uw email kon niet verstuurd worden, omdat de huiskamer momenteel geen aanmeldingen kan aannemen. Probeer het later nog eens.</div>
<?php } ?>

<div id="huiskamers">
    <p>
        Zoek een huiskamer in 
        <select style="width:150px" id='huiskamers-select-region'>
        <option value='-1'>Heel Nederland</option>
        <?php foreach(Huiskamers\Region::all() as $region) { ?>
             <option value='<?php echo $region->id()?>'><?php echo esc_html($region->name())?></option>
        <?php } ?>
        </select>
        geschikt voor mensen van <input type='text' name='huiskamers-age' style='width:90px' id='huiskamers-select-age'/> jaar. 
        <!--<button id='huiskamers-search'>Zoek</button>-->
    </p>
    <table class='huiskamers-table'>
        <thead>
            <tr class="even">
                <?php foreach($columns as $column){ ?>
                     <?php if ($column->slug() == 'age_max') continue; ?>
                     <?php $custom_style = $custom_styles[$column->slug()]; ?>
                     <?php $custom_style = ($custom_style) ? " style='$custom_style' " : ""; ?>
                     <th <?php echo $custom_style?>>
                         <?php echo GetColumnHeader($column->slug(), $column->name()); ?>
                     </th>
                <?php } ?>
                <th>Email</th>
            </tr>
        </thead>
        <?php
            $isEvenRow = false;
            foreach($huiskamers as $huiskamer) {
                $evenOddClass = $isEvenRow == true ? "even" : "odd";
                $seekingMembersClass = $huiskamer->seeking_members() ? "seeking-members" : "";
                $isEvenRow = !$isEvenRow;
        ?>
            <tr class='huiskamer-row <?php echo $evenOddClass ?> <?php echo $seekingMembersClass ?>' data-regions='<?php echo $huiskamer->regions()?>' data-age-min='<?php echo $huiskamer->age_min()?>' data-age-max='<?php echo $huiskamer->age_max()?>'>
                <?php foreach($columns as $column){ ?>
                    <?php if ($column->slug() == 'age_max') continue; ?>
                <td data-label="<?php echo GetColumnHeader($column->slug(), $column->name()); ?>">
                            <?php $slug = $column->slug();?>
                            <?php if($slug == 'age_min') { ?>
                                 <?php echo $huiskamer->age_min()?>-<?php echo $huiskamer->age_max()?>
                            <?php } else if ($slug == 'group_size') { ?>
                                 <?php echo Huiskamers\Lookup::get('group_sizes', $huiskamer->group_size())?>
                            <?php } else if ($slug == 'regions') { ?>
                                 <?php echo esc_html($huiskamer->region_names())?>
                            <?php } else if ($slug == 'description') { ?>
                                 <?php
                                 echo esc_html($huiskamer->description());
                                 if($huiskamer->seeking_members())
                                 {
                                     echo "<div class='seeking-members-message'>Wij zijn actief op zoek naar nieuwe leden voor onze huiskamer.</div>";
                                 }
                                 ?>
                            <?php } else { ?>
                                 <?php echo esc_html($huiskamer->$slug())?>
                            <?php } ?>
                        </td>
                <?php } ?>
                <td data-label="Email">
                    <a title='Bericht naar huiskamer' href="#TB_inline?width=400&height=400&inlineId=<?php echo $huiskamer->form_title()?>" data-huiskamer='<?php echo $huiskamer->id()?>' class="huiskamer-email">
                        <img class='huiskamer-email' src='<?php echo WP_PLUGIN_URL . '/huiskamers/images/email_button.png'?>'/>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <div class="huiskamers-not-found" id="huiskamers-not-found-message"
         style="display: none;">
        Helaas geen resultaat gevonden.
    </div>
</div>

<!-- email pop up -->
<div id="huiskamers-email-form" style="display:none;">
     <p>Verstuur een bericht naar een vertegenwoordiger van de huiskamer.</p>
     <form method='post' class='huiskamer'>
          <input type='hidden' name='huiskamer_message[huiskamer]' id='huiskamer-id' value='<?php echo $huiskamer_id?>'/>
          <div class='field'>
               <label for='name'>Naam</label><input type='text' name='huiskamer_message[name]'/>
          </div>
          <div class='field'>
               <label for='email'>Uw&nbsp;email&nbsp;adres</label><input type='text' id='huiskamer-email-input' name='huiskamer_message[email]'/>
          </div>
          <div class='field'>
               <label for='bericht'>Bericht</label><textarea name='huiskamer_message[message]'></textarea>
          </div>
          <input type='submit' value='Versturen'/>
     </form>
     </p>
</div>

<!-- gesloten huiskamer pop up -->
<div id="huiskamers-unavailable" style="display:none;">
    <p>Dankjewel voor je interesse in deze huiskamer! Helaas kan deze huiskamer tijdelijk geen nieuwe leden opnemen. Wellicht heeft één van de andere huiskamers ook je interesse.</p>
    <p>Het huiskamerteam</p>
</div>
