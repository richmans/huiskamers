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
			'group_size' => array('type' => 'dropdown', 'values' => array('2-5', '5-10', '10-15', '15-20', '20+')),
			'age_max' => array('type' => 'dropdown', 'values' => array(0, 5, 10, 15, 20, 25, 30, 40, 50, 60, 70, 80, 90, 100)),
			'age_min' => array('type' => 'dropdown', 'values' => array(0, 5, 10, 15, 20, 25, 30, 40, 50, 60, 70, 80, 90, 100)),
			'day_part' => array('type' => 'string'),
			'frequency' => array('type' => 'string'),
		);
	}

	public static function indexes() {
		return array('name', 'group_size', 'age_max', 'age_min', 'day_part', 'frequency');
	}
}
?>