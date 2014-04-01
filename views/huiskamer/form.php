<? $form = new Huiskamers\FormHelper('huiskamer'); ?>
<div class='wrap'>
	<h2><?=($form_mode == 'create') ? 'Nieuwe huiskamer' : 'Huiskamer bewerken' ?></h2>
	<form method='post' action='<?=$this->url($form_mode, $id);?>'>
	<table class='form-table'>
		<tbody>
			<? $form->input('name', 'Naam', $model) ?>
			<? $form->input('description', 'Beschrijving', $model) ?>
			<? $form->input('email', 'Email', $model) ?>
			<? $form->input('regions', 'Regio\'s', $model) ?>
			<? $form->input('group_size', 'Grootte', $model) ?>
			<? $form->input('group_type', 'Samenstelling', $model) ?>
			<? $form->input('age_min', 'Minimum leeftijd', $model) ?>
			<? $form->input('age_max', 'Maximum leeftijd', $model) ?>
			<? $form->input('day_part', 'Wanneer', $model) ?>
			<? $form->input('frequency', 'Hoe vaak', $model) ?>
			<? $form->input('active', 'Actief', $model) ?>
			<? foreach(Huiskamers\Field::all() as $field) { ?>
			<? if($field->is_default()) continue; ?>
			<? $form->input($field->slug(), $field->name(), $model) ?>
			<? } ?>
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" name="submit" id="submit" class="button button-primary" value="Opslaan">
	</p>
	</form>
</div>
