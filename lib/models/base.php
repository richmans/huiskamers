<?
namespace Huiskamers;
abstract class Base {
	abstract public static function table_name();
	abstract public static function fields();
	private $values = array();

	public function __construct($values) {
		$this->values = $values;
	}

	public static function indexes() {
		return array(); 
	}

	public static function prefixed_table_name() {
		global $wpdb;
		return $table_name = $wpdb->prefix.'huiskamers_'.static::table_name();
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
		$sql .= "PRIMARY KEY  (id), \n";
		foreach($indexes as $index) {
			$sql .= "KEY $index ($index), \n";
		}
		$sql = substr($sql,0,-3);
		$sql .= ");";

		$e = $wpdb->query($sql);
	}

	public static function get($id){
		global $wpdb;
		$table_name = static::prefixed_table_name();
		$sql = "SELECT * FROM $table_name where id=$id";
		$record = $wpdb->get_row( $sql, ARRAY_A );

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