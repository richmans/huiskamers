<? if ($email_sent == 'ok') {?>
     <div class='huiskamer-email-sent'>Uw email is verstuurd - bedankt!</div>
<? } ?>
<? if ($email_sent == 'fail') {?>
     <div class='huiskamer-email-fail'>Uw email kon niet verstuurd worden. Probeer het later nog eens.</div>
<? } ?>
<? if ($email_sent == 'unavailable') {?>
     <div class='huiskamer-email-fail'>Uw email kon niet verstuurd worden, omdat de huiskamer momenteel geen aanmeldingen kan aannemen. Probeer het later nog eens.</div>
<? } ?>
<section id="middle" class="grey_section">
    <div class="huiskamers">
        <div class="row blog">
            <div id="post-24" class="post-24 page type-page status-publish hentry">	
                <div class="postTitle">
                    <h1>Vind een huiskamer</h1>
                </div>
                <div class="pf-content">
                    <p>
                        Zoek een huiskamer in 
                        <select style="width:150px" id='huiskamers-select-region'>
                        <option value='-1'>Heel Nederland</option>
                        <? foreach(Huiskamers\Region::all() as $region) { ?>
                             <option value='<?=$region->id()?>'><?=esc_html($region->name())?></option>
                        <? } ?>
                        </select>

                        geschikt voor mensen van <input type='text' name='huiskamers-age' style='width:90px' id='huiskamers-select-age'/>

                        jaar. <button id='huiskamers-search'>Zoek</button>
                    </p>
                    <table class='custom-table style-3 huiskamers'>
                    <? $custom_styles = array('description' => 'width:400px', 'frequency' => 'width:150px');?>
                    <tr>
                    <? foreach($columns as $column){ ?>
                         <? if ($column->slug() == 'age_max') continue; ?>
                         <? $custom_style = $custom_styles[$column->slug()]; ?>
                         <? $custom_style = ($custom_style) ? " style='$custom_style' " : ""; ?>
                         <th <?=$custom_style?>>
                         <? if ($column->slug() == 'age_min') { ?>
                              Leeftijdspreiding
                         <? } else { ?>
                              <?=esc_html($column->name())?>
                         <? } ?>
                         </th>
                    <? } ?>

                    <th>Email</th>
                    </tr>
                    <?foreach($huiskamers as $huiskamer) { ?>

                            <tr class='huiskamer-row' data-regions='<?=$huiskamer->regions()?>' data-age-min='<?=$huiskamer->age_min()?>' data-age-max='<?=$huiskamer->age_max()?>'>
                                    <? foreach($columns as $column){ ?>
                                   <? if ($column->slug() == 'age_max') continue; ?>
                                   <td>
                                   <? $slug = $column->slug();?>
                                   <? if($slug == 'age_min') { ?>
                                        <?=$huiskamer->age_min()?>-<?=$huiskamer->age_max()?>
                                   <? } else if ($slug == 'group_size') { ?>
                                        <?=Huiskamers\Lookup::get('group_sizes', $huiskamer->group_size())?>
                                   <? } else if ($slug == 'regions') { ?>
                                        <?=esc_html($huiskamer->region_names())?>
                                   <? } else { ?>
                                        <?=esc_html($huiskamer->$slug())?>
                                   <? } ?>
                                   </td>
                              <? } ?>

                                    <td>
                                   <a title='Bericht naar huiskamer' href="#TB_inline?width=400&height=400&inlineId=<?=$huiskamer->form_title()?>" data-huiskamer='<?=$huiskamer->id()?>' class="huiskamer-email">
                                        <img class='huiskamer-email' src='<?=WP_PLUGIN_URL . '/huiskamers/images/email_button.png'?>'/>
                                   </a>	
                              </td>
                            </tr>
                    <?}?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="huiskamers-email-form" style="display:none;">
     <p>Verstuur een bericht naar een vertegenwoordiger van de huiskamer.</p>
     <form method='post' class='huiskamer'>
          <input type='hidden' name='huiskamer_message[huiskamer]' id='huiskamer-id' value='<?=$huiskamer_id?>'/>
          <div class='field'>
               <label for='name'>Naam</label><input type='text' name='huiskamer_message[name]'/>
          </div>
          <div class='field'>
               <label for='email'>Uw email adres</label><input type='text' id='huiskamer-email-input' name='huiskamer_message[email]'/>
          </div>
          <div class='field'>
               <label for='bericht'>Bericht</label><textarea name='huiskamer_message[message]'></textarea>
          </div>
          <input type='submit' value='Versturen'/>
     </form>
     </p>
</div>

<div id="huiskamers-unavailable" style="display:none;">
     <p>Dankjewel voor je interesse in deze huiskamer! Helaas kan deze huiskamer tijdelijk geen nieuwe leden opnemen. Wellicht heeft één van de andere huiskamers ook je interesse.</p>

<p>Het huiskamerteam</p>
</div>
