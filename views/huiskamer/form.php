<?php $form = new Huiskamers\FormHelper('huiskamer'); ?>
<div class='wrap'>
	<h2><?php echo ($form_mode == 'create') ? 'Nieuwe huiskamer' : 'Huiskamer bewerken' ?></h2>
	<form method='post' action='<?php echo $this->url($form_mode, $id);?>'>
	<table class='form-table'>
		<tbody>
			<?php $form->input('name', 'Naam', $model) ?>
			<?php $form->input('description', 'Beschrijving', $model) ?>
			<?php $form->input('email', 'Email', $model) ?>
			<?php $form->input('regions', 'Regio\'s', $model) ?>
			<?php $form->input('group_size', 'Grootte', $model) ?>
			<?php $form->input('group_type', 'Samenstelling', $model) ?>
			<?php $form->input('age_min', 'Minimum leeftijd', $model) ?>
			<?php $form->input('age_max', 'Maximum leeftijd', $model) ?>
			<?php $form->input('day_part', 'Wanneer', $model) ?>
			<?php $form->input('frequency', 'Hoe vaak', $model) ?>
			<?php $form->input('active', 'Zichtbaar', $model) ?>
			<?php $form->input('available', 'Open', $model) ?>
                        <?php $form->input('seeking_members', 'Zoekend (naar leden)', $model) ?>
			<?php $form->input('order_nr', 'Volgorde', $model) ?>
			<?php foreach(Huiskamers\Field::all() as $field) { ?>
			<?php if($field->is_default()) continue; ?>
			<?php $form->input($field->slug(), $field->name(), $model) ?>
			<?php } ?>
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" name="submit" id="submit" class="button button-primary" value="Opslaan">
	</p>
	</form>
</div>
