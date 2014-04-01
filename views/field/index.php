<div class='wrap'>
		<h2>Kolommen <a href="<?=$this->url('insert');?>" class='add-new-h2'>Nieuwe kolom</a></h2>
		
		<form method="post">

		<?
			 $field_table = new Huiskamers\TableHelper($this, $model_name);
			 $field_table->page_length = 50;
			  $field_table->sortable_columns = array(
            'order_nr'     => array('order_nr',false));
			  $field_table->default_sort='order_nr';
			 $field_table->columns = array( 
			 			'title'     => 'Naam',
			 			'order_nr'  => 'Volgorde',
			 			'visible_pretty' => 'Zichtbaar',
            'created_at'    => 'Gemaakt',
            'updated_at'  => 'Bewerkt');
  		 $field_table->prepare_items();
  		 $field_table->display();
    ?>
    </form>
</div>

