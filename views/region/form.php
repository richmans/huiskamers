<? $form = new Huiskamers\FormHelper('region'); ?>
<div class='wrap'>
	<h2><?=($form_mode == 'create') ? 'Nieuwe regio' : 'Regio bewerken' ?></h2>
	<form method='post' action='<?=$this->url($form_mode, $id);?>'>
	<table class='form-table'>
		<tbody>
			<? $form->input('name', 'Naam', $model) ?>
			
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" name="submit" id="submit" class="button button-primary" value="Opslaan">
	</p>
	</form>
</div>

