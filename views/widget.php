<h1>Kring overzicht</h1>
<table class='custom-table style-4'>
<?foreach($huiskamers as $huiskamer) { ?>
<tr>
<th>Naam</th>

<th>Beschrijving</th>
<th>Regio</th>
<th>Email</th>
</tr>
	<tr>
		<td><?=$huiskamer->name()?></td>
		<td><?=$huiskamer->description()?></td>
		<td><?=$huiskamer->region_names()?></td>

		<td><a href="#TB_inline?width=400&height=200&inlineId=my-content-id" class="thickbox">Email</a>	</td>
	</tr>
<?}?>
</table>

<div id="my-content-id" style="display:none;">
     <p>
     <form method='post'>
     	Here is some awesome information that you would not see otherwise   
     	<input name='dit'/><br/>
     	<textarea></textarea> 
     	<input type='submit'/>
     	</form>
     </p>
</div>