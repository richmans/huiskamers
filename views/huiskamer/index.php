<div class='wrap'>
		<h2>Huiskamers <a href="<?=$this->url('insert');?>" class='add-new-h2'>Nieuwe huiskamer</a></h2>
		<form method="post">
		<?
			 $huiskamer_table = new Huiskamers\TableHelper($this, $model_name);
			 $huiskamer_table->page_length = 50;
			  $field_table->sortable_columns = array(
            'order_nr'     => array('order_nr',false));
			    $field_table->default_sort='order_nr';
			 $huiskamer_table->columns = array( 
			 			'title'     => 'Naam',
			 			'description_truncated'     => 'Beschrijving',
			 			'region_names' => 'Regio',
			 			'day_part'     => 'Wanneer',
			 			'frequency'     => 'Hoe vaak',
			 			'active_pretty' => 'Actief',
			 			'order_nr' => 'Volgorde',
            'created_at'    => 'Gemaakt',
            'updated_at'  => 'Bewerkt'

            );
  		 $huiskamer_table->prepare_items();
  		 $huiskamer_table->display();
    ?>
    </form>
</div>

