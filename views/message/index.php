<div class='wrap'>
		<h2>Berichten</h2>
		<form method="post">
		<?
			 $message_table = new Huiskamers\TableHelper($this, $model_name);
			 $message_table->page_length = 50;
			 $message_table->columns = array( 
			 			'title'     => 'Naam',
			 			'email'     => 'Email',
			 			'message' => 'Bericht',
			 			'created_at'    => 'Gemaakt',
            'updated_at'  => 'Bewerkt'

            );
			 $message_table->disable_edit = true;
  		 $message_table->prepare_items();
  		 $message_table->display();
    ?>
    </form>
</div>

