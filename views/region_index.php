<div class='wrap'>
		<h2>Regios <a href="<?=$this->url('insert');?>" class='add-new-h2'>Nieuwe regio</a></h2>
		<table>
		<? foreach($models as $regio) { ?>
			<tr>
				<td><?=$regio->id()?></td>
				<td><?= $regio->name() ?></td>
				<td><a href='<?=$this->url('edit', $regio->id())?>'>Edit</a></td>
				<td><a href='<?=$this->url('delete', $regio->id())?>'>Delete</a></td>
				</tr>
		<? } ?>
		</table>
	</div>
</div>

