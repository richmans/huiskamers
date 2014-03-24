<?
namespace Huiskamers;
class Huiskamer extends Base {
	public static function table_name() { return 'huiskamers'; }
	public static function fields() {
		return array(
			'name' => array('type' => 'string'),
			'description' => array('type' => 'text'),
			'email' => array('type' => 'string', 'validate' => 'email'),
			'regions' => array('type' => 'multiple_dropdown', 'model' => 'Region'),
			'group_size' => array('type' => 'dropdown', 'lookup' => 'group_sizes'),
			'age_max' => array('type' => 'dropdown', 'lookup' => 'ages'),
			'age_min' => array('type' => 'dropdown', 'lookup' => 'ages'),
			'day_part' => array('type' => 'string'),
			'frequency' => array('type' => 'string'),
		);
	}

	public static function indexes() {
		return array('name', 'group_size', 'age_max', 'age_min', 'day_part', 'frequency');
	}

	public function region_ids() {
		$ids = explode(",", $this->regions());
		$ids = array_map(function($m) {return substr($m, 1, -1);}, $ids);
	}

}
?>