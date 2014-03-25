<h1>Kring overzicht</h1>
<? if ($email_sent == true) {?>
     <div class='huiskamer-email-sent'>Uw email is verstuurd - bedankt!</div>
<? } ?>
<table class='custom-table style-4'>
<?foreach($huiskamers as $huiskamer) { ?>
<tr>
<th>Naam</th>

<th>Beschrijving</th>
<th>Regio</th>
<th>Email</th>
</tr>
	<tr>
		<td><?=$huiskamer->name()?></td>
		<td><?=$huiskamer->description()?></td>
		<td><?=$huiskamer->region_names()?></td>

		<td>
               <a title='Bericht naar huiskamer' href="#TB_inline?width=200&height=300&inlineId=huiskamers-email-form" data-huiskamer='<?=$huiskamer->id()?>' class="huiskamer-email">
                    <img class='email' src='<?=WP_PLUGIN_URL . '/huiskamers/images/email_button.png'?>' height='50px;'/>
               </a>	
          </td>
	</tr>
<?}?>
</table>

<div id="huiskamers-email-form" style="display:none;">
     <p>Verstuur een bericht naar een vertegenwoordiger van de huiskamer.</p>
     <form method='post' class='huiskamer'>
          <input type='hidden' name='huiskamer_application[huiskamer_id]' value='<?=$huiskamer_id?>'/>
          <div class='field'>
               <label for='name'>Naam</label><input type='text' name='huiskamer_application[name]'/>
          </div>
          <div class='field'>
               <label for='email'>Uw email adres</label><input type='text' name='huiskamer_application[email]'/>
          </div>
          <div class='field'>
               <label for='bericht'>Bericht</label><textarea name='huiskamer_application[message]'></textarea>
          </div>
          <input type='submit'/>
     </form>
     </p>
</div>