<div class='wrap'>
		<h2>Berichten</h2>
		<form method="post">
		<?php
			 $message_table = new Huiskamers\TableHelper($this, $model_name);
			 $message_table->page_length = 50;
			 $message_table->columns = array( 
			 			'title'     => 'Naam',
			 			'email'     => 'Email',
			 			'huiskamer'     => 'Huiskamer',
			 			'message' => 'Bericht',
			 			'created_at'    => 'Verstuurd',          
                            );
                         
			 $message_table->sortable_columns = array(
                             'title' => array('name',false),
                             'created_at' => array('created_at',false),
                             'updated_at' => array('updated_at',false),
                             'email' => array('email',false),
                             'huiskamer' => array('huiskamer',false),
                             );
			 $message_table->disable_edit = true;
                        $message_table->columns_width = array(
                            'title'    => "150px",
                            'email'    => "200px",
                            'huiskamer'    => "100px",
                            'created_at'    => "100px",
                            'updated_at'  => "100px",
                        );
  		 $message_table->prepare_items("desc");
  		 $message_table->display();
    ?>
    </form>
</div>

