<div class='wrap'>
		<h2>Regio's <a href="<?=$this->url('insert');?>" class='add-new-h2'>Nieuwe regio</a></h2>
		<form method="post">
		<?
			 $region_table = new Huiskamers\RegionTableHelper($this, $model_name);
  		 $region_table->prepare_items();
  		 $region_table->display();
    ?>
    </form>
</div>

