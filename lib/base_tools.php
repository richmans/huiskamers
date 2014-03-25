<?
	namespace Huiskamers;
	function fix_slashes($data){
		if(!(is_string($data))) return $data;
		if(get_magic_quotes_gpc() == TRUE){
			$data = stripslashes($data);
		}
		return $data;
	}

	function timestamp() {
		date_default_timezone_set('Europe/Amsterdam');
		return  date( 'Y-m-d H:i:s', time() );
	}

	function huiskamer_option($name,$default=NULL){
		$default_options = array();
		$options = get_option( 'huiskamer-options', $default_options );
		if(array_key_exists($name, $options)){
			return $options[$name];
		}else{
			return $default;
		}
	}
?>