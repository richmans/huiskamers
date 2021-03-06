<?php
namespace Huiskamers;
abstract class Base {
	abstract public static function table_name();
	abstract public static function fields();
	private $values = array();
	public $errors = array();

	public function __construct($values=array()) {
		foreach($this::fields() as $field => $options){
			if(!isset($values[$field]) && isset($options['default'])){
				$values[$field] = $options['default'];
			}
		}
        $this->values = $values;
	}

	public function can_delete() {
		return true;
	}
	public static function get_namespace() {
		return trim(strtolower(__NAMESPACE__));
	}

	public static function indexes() {
		return array(); 
	}

	public static function prefixed_table_name() {
		global $wpdb;
		$namespace = static::get_namespace();
		return $table_name = $wpdb->prefix.$namespace.'_'.static::table_name();
	}

	public static function drop_table(){
		global $wpdb;
		$table_name = static::prefixed_table_name();
		$sql = "DROP TABLE $table_name;";
		$e = $wpdb->query($sql);
	}

	public static function column_definition($field, $options){
		$sql_options = $options['sql'];
		$defaultdef = ($options['default'] == null) ? '' : "default " . $options['default'];
		if($options['type'] == 'string'){
			$sql_definition='VARCHAR( 255 )';
		}else if ($options['type'] == 'text'){
			$sql_definition='TEXT';
		}else if ($options['type'] == 'number'){
			$sql_definition='INT';
		}else if ($options['type'] == 'dropdown'){
			$sql_definition='INT';
		}else if ($options['type'] == 'multiple_dropdown'){
			$sql_definition='VARCHAR( 255 )';
		}else if ($options['type'] == 'boolean'){
			$sql_definition='TINYINT';
		}else if ($options['type'] == 'timestamp'){
			$sql_definition='TIMESTAMP';
		}
		$nulldef = ($options['optional']) ? '' : 'not null';
		return  "$field $sql_definition $nulldef $defaultdef";
	}

	public static function add_column($field, $options){
		global $wpdb;
		$table_name = static::prefixed_table_name();
		$col_def = static::column_definition($field, $options);
		$sql = "alter table $table_name add column $col_def";
		$wpdb->query($sql);
	}

	public static function update_column($old_field, $field, $options){
		global $wpdb;
		$table_name = static::prefixed_table_name();
		$col_def = static::column_definition($field, $options);
		$sql = "alter table $table_name change column $old_field $col_def";
		$wpdb->query($sql);
	}

	public static function delete_column($field){
		global $wpdb;
		$table_name = static::prefixed_table_name();
		$sql = "alter table $table_name drop column $field";
		$wpdb->query($sql);
	}

	public static function create_table(){
		global $wpdb;

		$table_name = static::prefixed_table_name();
		
		$sql = "CREATE TABLE  $table_name (\n";
		$sql .= "id INT NOT NULL AUTO_INCREMENT, \n";
		$fields = static::fields();
		$indexes = static::indexes();
		foreach($fields as $field => $options) {
			$sql .= static::column_definition($field, $options) . ", \n";
		}
		$sql .= "created_at TIMESTAMP NOT NULL DEFAULT 0, \n";
		$sql .= "updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, \n";
		$sql .= "PRIMARY KEY  (id), \n";
		foreach($indexes as $index) {
			$sql .= "KEY $index ($index), \n";
		}
		$sql .= "KEY created_at (created_at), \n";
		$sql .= "KEY updated_at (updated_at)";
	
		$sql .= ");";

		$e = $wpdb->query($sql);
	
	}

	public function hook($hook_name){
		if (method_exists($this, $hook_name)){
			$this->$hook_name();
		}
	}

	public function create() {
		global $wpdb;
		$this->hook('before_create');
		if ($this->validate() == false) return false;
		$table_name = static::prefixed_table_name();
		$values = array_merge($this->values, array('created_at' => timestamp(), 'updated_at' => timestamp()));
		$wpdb->insert( $table_name, $values); 
		$this->values['id'] = $wpdb->insert_id;
		$this->hook('after_create');
		return true;
	}

	public function save() { 
		if ($this->id() == NULL) {
			return $this->create();
		}else{
			return $this->update();
		}
	}

	public function update() {
		global $wpdb;
		$this->hook('before_update');
		if ($this->validate() == false) return false;
		$table_name = static::prefixed_table_name();
		if($this->id() == NULL) throw new \Exception("Tried to update an unsaved record");
		$where = array('id' => $this->id());
		$values = array_merge($this->values, array('updated_at' => timestamp()));
		$wpdb->update( $table_name, $values, $where); 		
		$this->hook('after_update');
		return true;
	}

	public function update_fields($fields) {
		foreach($this->fields() as $name => $options){
                        $type = null;
                        if(isset($options['type']))
                        {
                            $type = $options['type'];
                        }
                            
                        if(isset($fields[$name])) {
                                $this->set($name, fix_slashes($fields[$name]));
                        } else if($type == 'boolean') {
                                $this->set($name, fix_slashes(false));
                        }
		}
	}

	public function delete() {
		global $wpdb;
		$this->hook('before_delete');
		$table_name = static::prefixed_table_name();
		if($this->id() == NULL) throw new \Exception("Tried to delete an unsaved record");
		$where = array('id' => $this->id());
		$wpdb->delete( $table_name, $where); 
		$this->hook('after_delete');
	}

	public static function limit($page, $page_length) {
		if($page == 0) return '';
		$start = ($page - 1) * $page_length;
		return "limit $start, $page_length";
	}

	public static function count($sql_where){
		global $wpdb;
		$table_name = static::prefixed_table_name();
		$sql = "SELECT count(*) FROM $table_name where $sql_where;";
		$count = $wpdb->get_var( $sql );
		return $count;
	}

	public static function delete_bulk($input_ids){
		global $wpdb;
		$table_name = static::prefixed_table_name();
		$ids = array();
		//check that all ids are ints
		foreach($input_ids as $id) {
			$id = intval($id);
			if($id > 0) $ids[] = $id;
		}
		$id_string = implode(',', $ids);
		$sql = "delete from $table_name where id in ($id_string);";
		$wpdb->query($sql);
	}

	public function is_invalid($field){
		return (array_key_exists($field, $this->errors));
	}

	public function validate_presence($field, $options){
		if(isset($options['optional']) && $options['optional'] == true)
                {
                    return true;
                }
                
		$value = $this->values[$field];
		if($value == NULL || $value == ''){
			$this->errors[$field] = "mag niet leeg zijn.";
		}
	}

	public function validate_email($field, $options){
		$value = $this->values[$field];
		if(!(is_email($value))){
			$this->errors[$field] = "is geen geldig email adres.";
		}
	}

	public function validate_dropdown($field, $options){
		$value = $this->values[$field];
		if($value === NULL || $value === ''){
			$this->errors[$field] = "is niet gekozen.";
		}
	}

	public function validate_multiple_dropdown($field, $options){
		$value = $this->values[$field];
		if(strpos($value, '()') !== false){
			$this->errors[$field] = "zijn niet allemaal ingevuld.";
		}
	}

	public function validate_number($field, $options){
		$value = $this->values[$field];
		if(!(is_numeric($value))){
			$this->errors[$field] = "is geen nummer.";
		}
	}

	public function validate_unique($field, $options){
		global $wpdb;
		$value = $this->values[$field];
		$id = $this->id();
		$table = $this->prefixed_table_name();
		$sql = $wpdb->prepare("select id from $table where $field = %s", $value);
		$other_id = $wpdb->get_var($sql);
		if($other_id != NULL && $other_id != $id) {
			$this->errors[$field] = 'bestaat al.';
		}
	}

	public function validate() {
		$fields = $this->fields();
		$this->errors = array();

		foreach($fields as $field => $options){
			
			if($options['type'] == 'number'){
				$this->validate_number($field, $options);
			}else if ($options['type'] == 'dropdown'){
				$this->validate_dropdown($field, $options);
			}else if ($options['type'] == 'multiple_dropdown'){
				$this->validate_multiple_dropdown($field, $options);
			}else if ($options['type'] != 'boolean') {
				$this->validate_presence($field, $options);
			}
                        
                        $validations = null;
                        if(isset($options['validate']))
                        {
                            $validations = $options['validate'];
                        }

			if($validations != NULL){
				if(!(is_array($validations))) $validations = array($validations);
				foreach($validations as $validation) {
					$validation_method = "validate_$validation";
					$this->$validation_method($field, $options);
				}

			}
			
		}
		return empty($this->errors);
	}

	public static function all($order='id asc'){
		return static::where('1=1', $order, 0);
	}

	public static function where($sql_where, $order='id asc', $page=1, $page_length=100){
		global $wpdb;
		$limit = self::limit($page, $page_length);
		$table_name = static::prefixed_table_name();
		$sql = "SELECT * FROM $table_name where $sql_where order by $order $limit;";
		$records = $wpdb->get_results( $sql, ARRAY_A );
		$result = array();
		foreach($records as $record) {
			$result[intval($record['id'])] = new static($record);
		}
		return $result;
	}

	public static function find($id){
		global $wpdb;
		$id = intval($id);
		$table_name = static::prefixed_table_name();
		$sql = "SELECT * FROM $table_name where id=$id";
		$record = $wpdb->get_row( $sql, ARRAY_A );
		if($record==NULL)
                    return NULL;
		$instance = new static($record);
		return $instance;
	}

	public function get($name){
            if(isset($this->values[$name]))
            {
		return $this->values[$name];
            }
            else                
            {
                return null;
            }
	}

	public function set($name, $value){
		$fields = $this->fields();
                $options = null;
                if(isset($fields[$name]))
                {
                    $options = $fields[$name];
                }
                
		if($options != NULL and $options['type'] == 'multiple_dropdown' and is_array($value)){
			$value = array_map(function($value){return "($value)";}, $value);
			$value = implode(",", $value);
                }
                
		$this->values[$name] = $value;
	}

	public function __call($name, $arguments){
		if(strpos($name, 'set_') === 0){
			$name = substr($name, 4);
			return $this->set($name, $arguments[0]);
		}else{
			return $this->get($name);
		}
	}
}
?>