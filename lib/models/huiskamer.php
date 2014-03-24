<?
namespace Huiskamers;
class Huiskamer extends Base {
	public static function table_name() { return 'huiskamers'; }
	public static function fields() {
		return array(
			'name' => array('type' => 'string'),
			'description' => array('type' => 'text', 'validate' => 'description'),
			'email' => array('type' => 'string', 'validate' => 'email'),
			'regions' => array('type' => 'multiple_dropdown', 'model' => 'Region'),
			'group_size' => array('type' => 'dropdown', 'lookup' => 'group_sizes'),
			'age_max' => array('type' => 'dropdown', 'lookup' => 'ages'),
			'age_min' => array('type' => 'dropdown', 'lookup' => 'ages'),
			'day_part' => array('type' => 'string'),
			'frequency' => array('type' => 'string'),
			'active' => array('type' => 'boolean'),
		);
	}

	public function validate_description() {
		$length = strlen($this->description());
		if($length > 200){
			$this->errors['description'] =  "mag niet langer zijn dan 200 tekens (huidig $length)";
		}
	}

	public static function indexes() {
		return array('name', 'group_size', 'age_max', 'age_min', 'day_part', 'frequency');
	}

	public function region_ids() {
		$ids = explode(",", $this->regions());
		$ids = array_map(function($m) {return intval(substr($m, 1, -1));}, $ids);
		return $ids;
	}

	public function active_pretty() {
		return ($this->active() == 1) ? "<span style='color:#0a0;'>Ja</span>" : "<span style='color:#a00;'>Nee</span>";
	}

	public function region_names() {
		$ids = $this->region_ids();
		$lookup = Region::all();
		$names = array();
		foreach($ids as $id){
			if($lookup[$id] != NULL){
				$name = $lookup[$id]->name();
			} else {
				$name = 'onbekend';
			}
			$names[] = $name;
		}
		return implode(', ', $names);
	}
}
?>