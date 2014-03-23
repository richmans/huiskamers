<?
namespace Huiskamers;
abstract class Base {
	abstract public static function table_name();
	abstract public static function fields();
	private $values = array();

	public function __construct($values=array()) {
		$this->values = $values;
	}

	public static function get_namespace() {
		return trim(strtolower(__NAMESPACE__));
	}

	public static function indexes() {
		return array(); 
	}

	public static function prefixed_table_name() {
		global $wpdb;
		$namespace = self::get_namespace();
		return $table_name = $wpdb->prefix.$namespace.'_'.static::table_name();
	}

	public static function drop_table(){
		global $wpdb;
		$table_name = static::prefixed_table_name();
		$sql = "DROP TABLE $table_name;";
		$e = $wpdb->query($sql);
	}

	public static function create_table(){
		global $wpdb;
		$table_name = static::prefixed_table_name();
		$sql = "CREATE TABLE  $table_name (\n";
		$sql .= "id INT NOT NULL AUTO_INCREMENT, \n";
		$fields = static::fields();
		$indexes = static::indexes();
		foreach($fields as $field => $options) {
			$sql_options = $options['sql'];
			$sql .= "$field $sql_options, \n";
		}
		$sql .= "created_at TIMESTAMP NOT NULL DEFAULT 0, \n";
		$sql .= "updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, \n";
		$sql .= "PRIMARY KEY  (id), \n";
		foreach($indexes as $index) {
			$sql .= "KEY $index ($index), \n";
		}
		$sql = substr($sql,0,-3);
		$sql .= ");";

		$e = $wpdb->query($sql);
	}


	public function create() {
		global $wpdb;
		$table_name = static::prefixed_table_name();
		$values = array_merge($this->values, array('created_at' => timestamp(), 'updated_at' => timestamp()));
		$wpdb->insert( $table_name, $values); 
		$this->values['id'] = $wpdb->insert_id;
	}

	public function save() { 
		if ($this->id() == NULL) {
			$this->create();
		}else{
			$this->update();
		}
	}

	public function update() {
		global $wpdb;
		$table_name = static::prefixed_table_name();
		if($this->id() == NULL) throw new \Exception("Tried to update an unsaved record");
		$where = array('id' => $this->id());
		$values = array_merge($this->values, array('updated_at' => timestamp()));
		$wpdb->update( $table_name, $values, $where); 		

	}

	public function update_fields($fields) {
		foreach($this->fields() as $name => $type){
			if($name == 'id') continue;
			$this->values[$name] = fix_slashes($fields[$name]);
		}
	}

	public function delete() {
		global $wpdb;
		$table_name = static::prefixed_table_name();
		if($this->id() == NULL) throw new \Exception("Tried to delete an unsaved record");
		$where = array('id' => $this->id());
		$wpdb->delete( $table_name, $where); 
	}

	public static function where($sql_where){
		global $wpdb;
		$table_name = static::prefixed_table_name();
		$sql = "SELECT * FROM $table_name where $sql_where";
		$records = $wpdb->get_results( $sql, ARRAY_A );
		$result = array();
		foreach($records as $record) {
			$result[] = new static($record);
		}
		return $result;
	}

	public static function find($id){
		global $wpdb;
		$id = intval($id);
		$table_name = static::prefixed_table_name();
		$sql = "SELECT * FROM $table_name where id=$id";
		$record = $wpdb->get_row( $sql, ARRAY_A );
		if($record==NULL) throw new \Exception("Record not found");
		$instance = new static($record);
		return $instance;
	}

	public function get($name){
		return $this->values[$name];
	}

	public function set($name, $value){
		$this->values[$name] = $value;
	}

	public function __call($name, $arguments){
		if(strpos($name, 'set_') === 0){
			return $this->set($name, $arguments);
		}else{
			return $this->get($name);
		}
	}
}
?>