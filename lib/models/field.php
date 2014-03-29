<?
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
		
		if(array_key_exists($this->slug(), Huiskamer::default_fields())){
			$this->errors['slug'] = 'is al een standaard kolom.';	
		}
	}

	public static function indexes() {
		return array('name', 'visible');
	}

	public function before_create() {
		global $wpdb;
		$max_order = $wpdb->get_var("SELECT MAX( order_nr ) FROM  {$this->table_name()}");
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
		Huiskamer::add_column($this->slug(), $this->options());
	}

	public function after_delete() {
		Huiskamer::delete_column($this->slug());
	}

	public function before_update() {
		global $wpdb;
		$table_name = $this->prefixed_table_name();
		$id = $this->id();
		$this->old_slug = $wpdb->get_var("select slug from $table_name where id=$id");		
	}

	public function after_update() {
		Huiskamer::update_column($this->old_slug, $this->slug(), $this->options());
	}
}
?>