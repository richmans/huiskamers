<div class="wrap">
<h2>Huiskamers</h2>
<form method="post" action="options.php"> 
<? settings_fields( 'huiskamers' ); ?>
<? do_settings_sections( 'huiskamers' );?>
<table class='form-table'>
<tr valign='top'>
<th scope='row'>Admin Email</th>
<td><input name='huiskamers_admin-email' value='<?=esc_attr(get_option('huiskamers_admin-email'))?>' class='regular-text'/>
<p class='description'>Berichten aan alle huiskamers worden ook naar dit adres gestuurd.</p>
</td>
</tr>

<tr valign='top'>
<th scope='row'>Herinnering sturen na</th>
<td><input name='huiskamers_send-reminder-email-after' value='<?=esc_attr(get_option('huiskamers_send-reminder-email-after'))?>' class='regular-text'/> dagen</td>
</tr>

<tr valign='top'>
<th scope='row'>Email bij nieuwe aanmelding</th>
<td>
<p class='description'>Gebruik de volgende velden om de gegevens van de aanmelding weer te geven:</p>
<ul>
<li><strong>[huiskamer]</strong> De naam van de huiskamer</li>
<li><strong>[naam]</strong> De naam van de aanmelding</li>
<li><strong>[email]</strong> Het email adres van de aanmelding</li>
<li><strong>[bericht]</strong> Het bericht van de aanmelding</li>
</UL>
<textarea name="huiskamers_new-message-email-message" rows="10" cols="50" class="large-text code"><?=esc_html(get_option('huiskamers_new-message-email-message'))?></textarea>
</td>
</tr>

<tr valign='top'>
<th scope='row'>Email bij herinnering</th>
<td>
<textarea name="huiskamers_reminder-email-message" rows="10" cols="50" class="large-text code"><?=esc_html(get_option('huiskamers_reminder-email-message'))?></textarea>
</td>
</tr>
</table>



<? submit_button(); ?>
</form>
</div>