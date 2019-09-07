<div class='wrap'>
		<h2>Regio's <a href="<?php echo $this->url('insert');?>" class='add-new-h2'>Nieuwe regio</a></h2>
		<form method="post">
		<?php
			 $region_table = new Huiskamers\TableHelper($this, $model_name);
			 $region_table->page_length = 50;
			 $region_table->columns = array( 
                                'huiskamer_count' => 'Huiskamers',
			 	'title'     => 'Naam',
                                'created_at'    => 'Gemaakt',
                                'updated_at'  => 'Bewerkt');
			 $region_table->sortable_columns = array(
                             'title' => array('name',false),
                             'created_at' => array('created_at',false),
                             'updated_at' => array('updated_at',false),
//                             'huiskamer_count'=> array('huiskamer_count',false), // huiskamer_count can't be easily sorted because it is a function not a database field
                             );
                        $region_table->columns_width = array(
                            'huiskamer_count'    => "80px",
                            'created_at'    => "100px",
                            'updated_at'  => "100px",
                        );
  		 $region_table->prepare_items();
  		 $region_table->display();
    ?>
    </form>
</div>

