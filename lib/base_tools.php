<?
	namespace Huiskamers;
	function fix_slashes($data){
		echo get_magic_quotes_gpc();
		if(get_magic_quotes_gpc() == TRUE){
			$data = stripslashes($data);
		}
		return $data;
	}

	function timestamp() {
		date_default_timezone_set('Europe/Amsterdam');
		return  date( 'Y-m-d H:i:s', time() );
	}
?>