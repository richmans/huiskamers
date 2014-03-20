<?
namespace Huiskamers;
class Region extends Base {
	public static function table_name() { return 'regions'; }
	public static function fields() {
		return array(
			'name' => array('sql' => 'VARCHAR( 255 ) NOT NULL'),
			'description' => array('sql' => 'TEXT NULL')
		);
	}

	public static function indexes() {
		return array('name');
	}
}
?>