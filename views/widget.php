<h1>Kring overzicht</h1>
<? if ($email_sent == 'ok') {?>
     <div class='huiskamer-email-sent'>Uw email is verstuurd - bedankt!</div>
<? } ?>
<? if ($email_sent == 'fail') {?>
     <div class='huiskamer-email-fail'>Uw email kon niet verstuurd worden. Probeer het later nog eens.</div>
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