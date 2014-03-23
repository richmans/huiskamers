<div class='wrap'>
		<h2>Regio's <a href="<?=$this->url('insert');?>" class='add-new-h2'>Nieuwe regio</a></h2>

		<?if (empty($models)) { ?>
			Er zijn nog geen regio's!
		<? } else { ?>
			<table class='wp-list-table widefat fixed posts'>
			<thead><tr>
				<th>#</th>
				<th>Naam</th>
				<th>Gemaakt</th>
				<th>Bewerkt</th>
				<th>&nbsp;</th>
			</tr></thead>
			<tbody>
			<? $alternate = FALSE; ?>
			<? foreach($models as $regio) { ?>
				<? $alternate = ($alternate) ? FALSE : TRUE; ?>
				<tr class='<?=($alternate) ? 'alternate' : ''?>'>
					<td><?=$regio->id()?></td>
					<td><?= $regio->name() ?></td>
					<td><?= $regio->created_at() ?></td>
					<td><?= $regio->updated_at() ?></td>
					
					<td>
						<span class='edit'><a href='<?=$this->url('edit', $regio->id())?>'>Edit</a></span>&nbsp;&nbsp;
						<span class='delete'><a href='<?=$this->url('delete', $regio->id())?>'>Delete</a></span>
					</td>
					</tr>
			<? } ?>
			</tbody>
			</table>
	<? } ?>
</div>

