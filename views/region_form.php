<div class='wrap'>
		<h2><?=($form_mode == 'create') ? 'Nieuwe regio' : 'Regio bewerken' ?></h2>
		<form method='post' action='<?=$this->url($form_mode, $id);?>'>
		<table class='form-table'>
			<tbody>
				<tr valign='top'>
					<th scope='row'><label for='name'>Naam</label></th>
					<td>
						<input name="region[name]" type="text" id="region_name" value="<?=esc_attr($model->name())?>" class="regular-text" autocomplete='off'/>
					</td>
			</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button button-primary" value="Opslaan">
		</p>
		</form>
	</div>
</div>

