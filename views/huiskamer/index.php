<div class='wrap'>
		<h2>Huiskamers <a href="<?php echo $this->url('insert');?>" class='add-new-h2'>Nieuwe huiskamer</a></h2>
		<form method="post">
		<?php
			 $huiskamer_table = new Huiskamers\TableHelper($this, $model_name);
			 $huiskamer_table->page_length = 50;
			 $huiskamer_table->default_sort='order_nr';
			 $huiskamer_table->columns = array( 
			 			'title'     => 'Naam',
                                                'active_pretty' => 'Zichtbaar',
						'available_pretty' => 'Open',
                                                'seeking_members_pretty' => 'Zoekend',
			 			'order_nr' => 'Volgorde',
			 			'day_part'     => 'Wanneer',
			 			'frequency'     => 'Hoe vaak',	
			 			'region_names' => 'Regio',		 			
                                                'created_at'    => 'Gemaakt',
                                                'updated_at'  => 'Bewerkt',
//			 			'description_truncated'     => 'Beschrijving',
                                );                         
			 $huiskamer_table->sortable_columns = array(
                             'title' => array('name',false),
                             'created_at' => array('created_at',false),
                             'updated_at' => array('updated_at',false),
                             'region_names' => array('regions',false),
                             'day_part' => array('day_part',false),
                             'frequency' => array('frequency',false),
                             'active_pretty' => array('active',false),
                             'available_pretty' => array('available',false),
                             'seeking_members_pretty' => array('seeking_members',false),
                             'order_nr' => array('order_nr',false),
                             );
                        $huiskamer_table->columns_width = array(
                            'title'    => "100px",
//                            'region_names'    => "150px",
                            'day_part'    => "150px",
                            'frequency'    => "170px",
                            'active_pretty'    => "95px",
                            'available_pretty'    => "85px",
                            'seeking_members_pretty'    => "90px",
                            'order_nr'    => "90px",
                            'created_at'    => "100px",
                            'updated_at'  => "100px",
                        );
  		 $huiskamer_table->prepare_items();
  		 $huiskamer_table->display();
    ?>
    </form>
</div>

