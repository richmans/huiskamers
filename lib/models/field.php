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
		if(!(preg_match("/^[a-z_]*$/", $this->slug))) {
			$this->errors['slug'] = 'mag alleen kleine letters en underscore bevatten';
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
}
?>