<? $form = new Huiskamers\FormHelper('field'); ?>
<div class='wrap'>

	<h2><?=($form_mode == 'create') ? 'Nieuwe kolom' : 'Kolom bewerken' ?></h2>

	<form method='post' action='<?=$this->url($form_mode, $id);?>'>
	<table class='form-table'>
		<tbody>
			<? $form->input('name', 'Naam', $model, 'Naam van de kolom die zichtbaar is op de website.') ?>
			<? $form->input('slug', 'Slug', $model, 'Naam van de kolom in het systeem. Gebruik alleen kleine letters en underscore.') ?>
			<? $form->input('required', 'Verplicht', $model) ?>
			<? $form->input('visible', 'Zichtbaar', $model, 'Zichtbaar op de website?') ?>
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" name="submit" id="submit" class="button button-primary" value="Opslaan">
	</p>
	</form>
</div>

