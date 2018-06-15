<?php
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
		$fields = array_merge($customs, $defaults);
		return $fields;
	}

	public static function default_fields() {
		return array(
			'name' => array('type' => 'string', 'caption' => 'Naam'),
			'description' => array('type' => 'text', 'validate' => 'description', 'caption' => 'Beschrijving'),
			'email' => array('type' => 'string', 'validate' => 'email', 'caption' => 'Email'),
			'regions' => array('type' => 'multiple_dropdown', 'model' => 'Region', 'caption' => 'Regios'),
			'group_size' => array('type' => 'dropdown', 'lookup' => 'group_sizes', 'caption' => 'Grootte'),
			'group_type' => array('type' => 'string', 'caption' => 'Samenstelling'),
			'age_max' => array('type' => 'dropdown', 'lookup' => 'ages', 'caption' => 'Maximum leeftijd'),
			'age_min' => array('type' => 'dropdown', 'lookup' => 'ages', 'caption' => 'Minimum leeftijd'),
			'day_part' => array('type' => 'string', 'caption' => 'Wanneer'),
			'frequency' => array('type' => 'string', 'caption' => 'Hoe vaak'),
			'active' => array('type' => 'boolean', 'caption' => 'Actief', 'default' => true),
			'available' => array('type' => 'boolean', 'caption' => 'Beschikbaar', 'default' => true),
			'unavailable_since' => array('type' => 'timestamp', 'optional' => true),
			'seeking_members' => array('type' => 'boolean', 'caption' => 'Leden gezocht', 'default' => false),
			'order_nr'  => array('type' => 'number'),
		);
	}

	public function before_create() {
		global $wpdb;
		$max_order = $wpdb->get_var("SELECT MAX( order_nr ) FROM  {$this->prefixed_table_name()}");
		if($max_order == NULL) $max_order = 0;
		$this->set_order_nr($max_order + 1);
	}
	
	public function before_update() {
		if($this->available() == false && $this->unavailable_since() == 0) {
			$this->set('unavailable_since', timestamp());
		}
		if($this->available() == true){
			$this->set('unavailable_since', '0000-00-00');
		}
	
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
		return array('name', 'group_size', 'age_max', 'age_min', 'day_part', 'frequency', 'order_nr');
	}

	public function region_ids() {
		$ids = explode(",", $this->regions());
		$ids = array_map(function($m) {return intval(substr($m, 1, -1));}, $ids);
		return $ids;
	}

	public function active_pretty() {
		return ($this->active() == 1) ? "<span style='color:#0a0;'>Ja</span>" : "<span style='color:#a00;'>Nee</span>";
	}

	public function available_pretty() {
		return ($this->available() == 1) ? "<span style='color:#0a0;'>Ja</span>" : "<span style='color:#a00;'>Nee</span>";
	}        
        public function seeking_members_pretty() {
		return ($this->seeking_members() == 1) ? "<span style='color:#0a0;'>Ja</span>" : "<span style='color:#a00;'>Nee</span>";
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
                $headers = array('Content-Type: text/html; charset=UTF-8', 'From: '.get_option('huiskamers_from-name').' <'.get_option('huiskamers_from-email').'>');                
		$result = wp_mail( $this->email(), $subject, $message, $headers); 
		if($result == false) return false;

		$admin_email = get_option('huiskamers_admin-email');
		if(is_email($admin_email)){
			$result = wp_mail($admin_email , $subject, $message, $headers); 
			if($result == false) return false;
		}
		return true;
	}

	public function description_truncated() {
		$maxlen = 50;
		if(strlen($this->description()) < $maxlen) return $this->description();
		return substr($this->description(), 0, $maxlen) . '...';
	}
	
	public function form_title() {
		return ($this->available()) ? 'huiskamers-email-form' : 'huiskamers-unavailable';
	}
}
?>