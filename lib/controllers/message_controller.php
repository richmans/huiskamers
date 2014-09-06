<?
namespace Huiskamers;
class MessageController extends BaseController {
	public function send_message() {
		$data = $_REQUEST['huiskamer_message'];
		$message = new Message();
		$huiskamer_id = $data['huiskamer'];
		$huiskamer = Huiskamer::find($huiskamer_id);
		if($huiskamer->available() == false ) return 'unavailable';
		$message->update_fields($data);
		$message->set_ip($_SERVER['REMOTE_ADDR']);
		$result = $message->save();
		if( $result == false) return 'fail' ;
		$result = $message->send_first_email();

		return ($result) ? 'ok' : fail;
	}
}
?>