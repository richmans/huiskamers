<?php $form = new Huiskamers\FormHelper('field'); ?>
<div class='wrap'>

	<h2><?php echo ($form_mode == 'create') ? 'Nieuwe kolom' : 'Kolom bewerken' ?></h2>

	<form method='post' action='<?php echo $this->url($form_mode, $id);?>'>
	<table class='form-table'>
		<tbody>
		 

			<?php $form->input('name', 'Naam', $model, 'Naam van de kolom die zichtbaar is op de website.') ?>
			<?php if ($model->is_default()) {?>
				<tr><th scope='row'>Slug</th><td>
				<?php echo esc_html($model->slug());?>
				</td></tr>
			<?php } else { ?>
				<?php $form->input('slug', 'Slug', $model, 'Naam van de kolom in het systeem. Gebruik alleen kleine letters en underscore.') ?>
			<?php } ?>
			<?php $form->input('order_nr', 'Volgorde', $model) ?>
			<?php $form->input('required', 'Verplicht', $model) ?>
			<?php $form->input('visible', 'Zichtbaar', $model, 'Zichtbaar op de website?') ?>
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" name="submit" id="submit" class="button button-primary" value="Opslaan">
	</p>
	</form>
</div>

