<?
namespace Huiskamers;
class Huiskamer extends Base {
	public static function table_name() { return 'huiskamers'; }
	public static function fields() {
		return array(
			'name' => array('sql' => 'VARCHAR( 255 ) NOT NULL'),
			'description' => array('sql' => 'TEXT'),
			'email' => array('sql' => 'VARCHAR( 255 ) NOT NULL'),
			'regions' => array('sql' => 'VARCHAR( 255 ) NOT NULL'),
			'group_size' => array('sql' => 'INT NOT NULL'),
			'age_max' => array('sql' => 'INT NOT NULL'),
			'age_min' => array('sql' => 'INT NOT NULL'),
			'day_part' => array('sql' => 'VARCHAR( 255 ) NOT NULL'),
			'frequency' => array('sql' => 'VARCHAR( 255 ) NOT NULL'),
		);
	}

	public static function indexes() {
		return array('name', 'group_size', 'age_max', 'age_min', 'day_part', 'frequency');
	}
}
?>