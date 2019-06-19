<div class='wrap'>
		<h2>Regio's <a href="<?php echo $this->url('insert');?>" class='add-new-h2'>Nieuwe regio</a></h2>
		<form method="post">
		<?php
			 $region_table = new Huiskamers\TableHelper($this, $model_name);
			 $region_table->page_length = 50;
			 $region_table->columns = array( 
			 			'title'     => 'Naam',
                             'huiskamer_count' => 'Huiskamers',
            'created_at'    => 'Gemaakt',
            'updated_at'  => 'Bewerkt');
  		 $region_table->prepare_items();
  		 $region_table->display();
    ?>
    </form>
</div>

