<h1>Kring overzicht</h1>
<? if ($email_sent == 'ok') {?>
     <div class='huiskamer-email-sent'>Uw email is verstuurd - bedankt!</div>
<? } ?>
<? if ($email_sent == 'fail') {?>
     <div class='huiskamer-email-fail'>Uw email kon niet verstuurd worden. Probeer het later nog eens.</div>
<? } ?>
<p>
Zoek een huiskamer in 
<select style="width:150px" id='huiskamers-select-region'>
<option value='-1'>Heel Nederland</option>
<? foreach(Huiskamers\Region::all() as $region) { ?>
     <option value='<?=$region->id()?>'><?=esc_html($region->name())?></option>
<? } ?>
</select>

geschikt voor mensen van <input type='text' name='huiskamers-age' style='width:90px' id='huiskamers-select-age'/>

jaar.
</p>
<table class='custom-table style-4'>
<?foreach($huiskamers as $huiskamer) { ?>
<tr>
<th>Aantal leden</th>
<th>Leeftijdspreiding</th>
<th>Samenstelling</th>
<th>Regio</th>
<th>Dagdeel</th>
<th>Frequentie</th>
<th>Beschrijving</th>
<th>Email</th>
</tr>
	<tr>
		<td><?=Huiskamers\Lookup::get('group_sizes', $huiskamer->group_size())?></td>
          <td><?=$huiskamer->age_min()?>-<?=$huiskamer->age_max()?></td>
          <td><?=esc_html($huiskamer->group_type())?></td>
		<td><?=esc_html($huiskamer->region_names())?></td>
		<td><?=esc_html($huiskamer->day_part())?></td>
          <td><?=esc_html($huiskamer->frequency())?></td>
          <td><?=esc_html($huiskamer->description())?></td>
		<td>
               <a title='Bericht naar huiskamer' href="#TB_inline?width=400&height=400&inlineId=huiskamers-email-form" data-huiskamer='<?=$huiskamer->id()?>' class="huiskamer-email">
                    <img class='huiskamer-email' src='<?=WP_PLUGIN_URL . '/huiskamers/images/email_button.png'?>'/>
               </a>	
          </td>
	</tr>
<?}?>
</table>

<div id="huiskamers-email-form" style="display:none;">
     <p>Verstuur een bericht naar een vertegenwoordiger van de huiskamer.</p>
     <form method='post' class='huiskamer'>
          <input type='hidden' name='huiskamer_message[huiskamer]' id='huiskamer-id' value='<?=$huiskamer_id?>'/>
          <div class='field'>
               <label for='name'>Naam</label><input type='text' name='huiskamer_message[name]'/>
          </div>
          <div class='field'>
               <label for='email'>Uw email adres</label><input type='text' name='huiskamer_message[email]'/>
          </div>
          <div class='field'>
               <label for='bericht'>Bericht</label><textarea name='huiskamer_message[message]'></textarea>
          </div>
          <input type='submit'/>
     </form>
     </p>
</div>