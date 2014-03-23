<?
namespace Huiskamers;
class Huiskamer extends Base {
	public static function table_name() { return 'huiskamers'; }
	public static function fields() {
		return array(
			'name' => array('type' => 'string'),
			'description' => array('type' => 'text'),
			'email' => array('type' => 'string', 'validate' => 'email'),
			'regions' => array('type' => 'string'),
			'group_size' => array('type' => 'number'),
			'age_max' => array('type' => 'number'),
			'age_min' => array('type' => 'number'),
			'day_part' => array('type' => 'string'),
			'frequency' => array('type' => 'string'),
		);
	}

	public static function indexes() {
		return array('name', 'group_size', 'age_max', 'age_min', 'day_part', 'frequency');
	}
}
?>