<?
namespace Huiskamers;
class Region extends Base {
	public static function table_name() { return 'regions'; }
	public static function fields() {
		return array(
			'name' => array('type' => 'string')
		);
	}

	public static function indexes() {
		return array('name');
	}
}
?>