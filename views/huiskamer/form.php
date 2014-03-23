<div class='wrap'>
	<h2><?=($form_mode == 'create') ? 'Nieuwe huiskamer' : 'Huiskamer bewerken' ?></h2>
	<form method='post' action='<?=$this->url($form_mode, $id);?>'>
	<table class='form-table'>
		<tbody>
			<tr valign='top'>
				<th scope='row'><label for='name'>Naam</label></th>
				<td>
					<input name="huiskamer[name]" type="text" id="huiskamer_name" value="<?=esc_attr($model->name())?>" class="regular-text" autocomplete='off'/>
				</td>
			</tr>
			<tr valign='top'>
				<th scope='row'><label for='description'>Beschrijving</label></th>
				<td>
					<textarea name="huiskamer[description]" type="text" id="huiskamer_description"><?=esc_html($model->description())?></textarea>
				</td>
			</tr>
			<tr valign='top'>
				<th scope='row'><label for='email'>Email</label></th>
				<td>
					<input name="huiskamer[email]" type="text" id="huiskamer_email" value="<?=esc_attr($model->email())?>" class="regular-text" autocomplete='off'/>
				</td>
			</tr>
			<tr valign='top'>
				<th scope='row'><label for='regions'>Regio's</label></th>
				<td>
					<input name="huiskamer[regions]" type="text" id="huiskamer_regions" value="<?=esc_attr($model->regions())?>" class="regular-text" autocomplete='off'/>
				</td>
			</tr>
			<tr valign='top'>
				<th scope='row'><label for='group_size'>Grootte</label></th>
				<td>
					<input name="huiskamer[group_size]" type="text" id="huiskamer_group_size" value="<?=esc_attr($model->group_size())?>" class="regular-text" autocomplete='off'/>
				</td>
			</tr>
			<tr valign='top'>
				<th scope='row'><label for='age_min'>Minimum leeftijd</label></th>
				<td>
					<input name="huiskamer[age_min]" type="text" id="huiskamer_age_min" value="<?=esc_attr($model->age_min())?>" class="regular-text" autocomplete='off'/>
				</td>
			</tr>
			<tr valign='top'>
				<th scope='row'><label for='age_max'>Maximum leeftijd</label></th>
				<td>
					<input name="huiskamer[age_max]" type="text" id="huiskamer_age_max" value="<?=esc_attr($model->age_max())?>" class="regular-text" autocomplete='off'/>
				</td>
			</tr>
			<tr valign='top'>
				<th scope='row'><label for='day_part'>Wanneer</label></th>
				<td>
					<input name="huiskamer[day_part]" type="text" id="huiskamer_day_part" value="<?=esc_attr($model->day_part())?>" class="regular-text" autocomplete='off'/>
				</td>
			</tr>
			<tr valign='top'>
				<th scope='row'><label for='frequency'>Hoe vaak</label></th>
				<td>
					<input name="huiskamer[frequency]" type="text" id="huiskamer_frequency" value="<?=esc_attr($model->frequency())?>" class="regular-text" autocomplete='off'/>
				</td>
			</tr>
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" name="submit" id="submit" class="button button-primary" value="Opslaan">
	</p>
	</form>
</div>
