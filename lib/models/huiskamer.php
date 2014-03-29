<?
namespace Huiskamers;
class Huiskamer extends Base {
	public static function table_name() { return 'huiskamers'; }

	public static function fields() {
		$defaults = static::default_fields();
		$columns = Field::all();
		$customs = array();
		foreach($columns as $column) {
			$customs[$column->slug()] = $column->options();
		}
		$fields = array_merge($defaults, $customs);
		return $fields;
	}

	public static function default_fields() {
		return array(
			'name' => array('type' => 'string'),
			'description' => array('type' => 'text', 'validate' => 'description'),
			'email' => array('type' => 'string', 'validate' => 'email'),
			'regions' => array('type' => 'multiple_dropdown', 'model' => 'Region'),
			'group_size' => array('type' => 'dropdown', 'lookup' => 'group_sizes'),
			'group_type' => array('type' => 'string'),
			'age_max' => array('type' => 'dropdown', 'lookup' => 'ages'),
			'age_min' => array('type' => 'dropdown', 'lookup' => 'ages'),
			'day_part' => array('type' => 'string'),
			'frequency' => array('type' => 'string'),
			'active' => array('type' => 'boolean'),
		);
	}

	public static function visible_custom_fields() {
		$columns = Field::where(array('visible' => 1));
		$customs = array();
		foreach($columns as $column) {
			$customs[$column->slug()] = $column->options();
		}
		return $customs;
	}

	public function validate_description() {
		$description_length = count(explode(' ', $this->description()));
		if($description_length > 50){
			$this->errors['description'] =  "mag niet langer zijn dan 50 woorden (huidig $description_length)";
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


	public function send_email($subject, $message){
		$result = wp_mail( $this->email(), $subject, $message); 
		if($result == false) return false;

		$admin_email = get_option('huiskamers_admin-email');
		if(is_email($admin_email)){
			$result = wp_mail($admin_email , $subject, $message); 
			if($result == false) return false;
		}
		return true;
	}

	public function description_truncated() {
		$maxlen = 50;
		if(strlen($this->description()) < $maxlen) return $this->description();
		return substr($this->description(), 0, $maxlen) . '...';
	}
}
?>