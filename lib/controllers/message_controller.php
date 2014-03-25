<?
namespace Huiskamers;
class MessageController extends BaseController {
	public function send_message() {
		$data = $_REQUEST['huiskamer_message'];
		$message = new Message();
		$message->update_fields($data);
		$message->set_ip($_SERVER['REMOTE_ADDR']);
		$result = $message->save();
		if( $result == false) return false ;
		$result = $message->send_first_email();
		return $result;
	}
}
?>