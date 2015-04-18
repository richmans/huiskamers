<?php $form = new Huiskamers\FormHelper('region'); ?>
<div class='wrap'>
	<h2><?php echo ($form_mode == 'create') ? 'Nieuwe regio' : 'Regio bewerken' ?></h2>
	<form method='post' action='<?php echo $this->url($form_mode, $id);?>'>
	<table class='form-table'>
		<tbody>
			<?php $form->input('name', 'Naam', $model) ?>
			
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" name="submit" id="submit" class="button button-primary" value="Opslaan">
	</p>
	</form>
</div>

