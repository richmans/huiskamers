<?php
namespace Huiskamers;
class Field extends Base {
	public static function table_name() { return 'fields'; }
	public static function fields() {
		return array(
			'name' => array('type' => 'string'),
			'required' => array('type' => 'boolean'),
			'visible' => array('type' => 'boolean'),
			'slug'  => array('type' => 'string', 'validate' => array('slug', 'unique')),
			'order_nr'  => array('type' => 'number'),
		);
	}

	public function validate_slug() {
		if(!(preg_match("/^[a-z_]*$/", $this->slug()))) {
			$this->errors['slug'] = 'mag alleen kleine letters en underscore bevatten.';
		}
		
	}

	public function can_delete() {
		return $this->is_custom();
	}

	public function is_custom() {
		return (!(array_key_exists($this->slug(), Huiskamer::default_fields())));
	}

	public function is_default() {
		return (array_key_exists($this->slug(), Huiskamer::default_fields()));
	}

	public static function indexes() {
		return array('name', 'visible', 'order_nr');
	}

	public function before_create() {
		global $wpdb;
		$max_order = $wpdb->get_var("SELECT MAX( order_nr ) FROM  {$this->prefixed_table_name()}");
		if($max_order == NULL) $max_order = 0;
		$this->set_order_nr($max_order + 1);
	}

	public function options() {
		$options = array();
		$options['type'] = 'string';
		if(!($this->required())) $options['optional'] = true;
		return $options;
	}

	public function after_create() {
		if($this->is_default()) return;
		Huiskamer::add_column($this->slug(), $this->options());
	}

	public function after_delete() {
		if($this->is_default()) return;
		Huiskamer::delete_column($this->slug());
	}

	public function before_update() {
		global $wpdb;
		$table_name = $this->prefixed_table_name();
		$id = $this->id();
		$this->old_slug = $wpdb->get_var("select slug from $table_name where id=$id");		
	}

	public function after_update() {
		if($this->is_default()) return;
		Huiskamer::update_column($this->old_slug, $this->slug(), $this->options());
	}

	public function before_delete() {
		if($this->is_default()) {
			throw new \Exception("Kan standaard kolommen niet weg gooien");
		}
	}

	public function visible_pretty() {
		return ($this->visible() == 1) ? "<span style='color:#0a0;'>Ja</span>" : "<span style='color:#a00;'>Nee</span>";
	}
}
?>