<?php
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
				35 => 35, 
				40 => 40,
				45 => 45,  
				50 => 50,  
				55 => 55, 
				60 => 60,
				65 => 65, 
				70 => 70, 
				75 => 75, 
				80 => 80, 
				85 => 85, 
				90 => 90,
				95 => 95, 
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