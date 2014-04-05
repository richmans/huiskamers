<?
	namespace Huiskamers;
	function fix_slashes($data){
		if(!(is_string($data))) return $data;
		$data = stripslashes($data);
		return $data;
	}

	function timestamp() {
		date_default_timezone_set('Europe/Amsterdam');
		return  date( 'Y-m-d H:i:s', time() );
	}

?>