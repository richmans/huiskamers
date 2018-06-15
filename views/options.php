<div class="wrap">
<h2>Huiskamers</h2>
<form method="post" action="options.php"> 
<?php settings_fields( 'huiskamers' ); ?>
<?php do_settings_sections( 'huiskamers' );?>
    <table class='form-table'>

        <tr valign='top'>
            <th scope='row'>Admin Email</th>
            <td><input name='huiskamers_admin-email' value='<?php echo esc_attr(get_option('huiskamers_admin-email'))?>' class='regular-text'/>
            <p class='description'>Berichten    aan alle huiskamers worden ook naar dit adres gestuurd.</p>
            </td>
        </tr>

        <tr valign='top'>
            <th scope='row'>From Email Name</th>
            <td><input name='huiskamers_from-name' value='<?php echo esc_attr(get_option('huiskamers_from-name'))?>' class='regular-text'/>
            </td>
        </tr>
        <tr valign='top'>
            <th scope='row'>From Email</th>
            <td><input name='huiskamers_from-email' value='<?php echo esc_attr(get_option('huiskamers_from-email'))?>' class='regular-text'/>
            </td>
        </tr>

        <tr valign='top'>
            <th scope='row'>Herinnering sturen na</th>
            <td><input name='huiskamers_send-reminder-email-after' value='<?php echo esc_attr(get_option('huiskamers_send-reminder-email-after'))?>' class='regular-text'/> dagen</td>
        </tr>

        <tr valign='top'>
            <th scope='row'>Huiskamers weer beschikbaar maken na</th>
            <td><input name='huiskamers_reset-availability-days' value='<?php echo esc_attr(get_option('huiskamers_reset-availability-days'))?>' class='regular-text'/> dagen</td>
        </tr>

    </table>
    <h2 class="title">Email inhoud</h2>    
    <div style="margin-left: 0px;">
        <p class='description'>De inhoud van de e-mail is html. Gebruik de volgende velden om de gegevens van de aanmelding weer te geven:</p>
        <ul style="margin-left: 20px;">
            <li><strong>[huiskamer]</strong> De naam van de huiskamer</li>
            <li><strong>[naam]</strong> De naam van de aanmelding</li>
            <li><strong>[email]</strong> Het email adres van de aanmelding</li>
            <li><strong>[bericht]</strong> Het bericht van de aanmelding</li>
        </ul>
    </div>
    <table class='form-table'>
        <tr valign='top'>
            <th scope='row'>Nieuwe aanmelding</th>
            <td>
            <input name='huiskamers_new-message-email-subject' value='<?php echo esc_attr(get_option('huiskamers_new-message-email-subject'))?>' class='regular-text' style="width: 100%;"/>
            <textarea name="huiskamers_new-message-email-message" rows="10" cols="50" class="large-text code"><?php echo esc_html(get_option('huiskamers_new-message-email-message'))?></textarea>
            </td>
        </tr>

        <tr valign='top'>
            <th scope='row'>Herinnering</th>
            <td>
            <input name='huiskamers_reminder-email-subject' value='<?php echo esc_attr(get_option('huiskamers_reminder-email-subject'))?>' class='regular-text' style="width: 100%"/>
            <textarea name="huiskamers_reminder-email-message" rows="10" cols="50" class="large-text code"><?php echo esc_html(get_option('huiskamers_reminder-email-message'))?></textarea>
            </td>
        </tr>
    </table>



<?php submit_button(); ?>
</form>
</div>