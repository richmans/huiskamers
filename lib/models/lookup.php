<?
namespace Huiskamers;
class Lookup {
	public static $lookups = array(
		'group_sizes' => array(
			2 => '2-5',
			5 => '5-10',
			10 => '10-15', 
			15 => '15-20', 
			20 => '20+'
		),
		'ages' => array(
				0 => 0, 
				5 => 5, 
				10 => 10, 
				15 => 15, 
				20 => 20, 
				25 => 25, 
				30 => 30, 
				40 => 40, 
				50 => 50, 
				60 => 60, 
				70 => 70, 
				80 => 80, 
				90 => 90, 
				100 =>100
			),

		);

	public static function get($group, $value){
		if(!(array_key_exists($group, self::$lookups))) return 'onbekend';
		if(!(array_key_exists($value, self::$lookups[$group]))) return 'onbekend';
		return self::$lookups[$group][$value];
	}	
}
?>