<?
namespace Huiskamers;
class Message extends Base {
	public static function table_name() { return 'messages'; }
	public static function fields() {
		return array(
			'name' => array('type' => 'string'),
			'huiskamer' => array('type' => 'dropdown', 'model' => 'Huiskamer'),
			'email' => array('type' => 'string', 'validate' => 'email'),
			'message' => array('type' => 'text'),
			'ip' => array('type' => 'string'),
			'reminder_sent' => array('type' => 'boolean')
		);
	}

	public static function indexes() {
		return array('name');
	}

	public function get_huiskamer() {
		return Huiskamer::find($this->huiskamer());
	}

	public function send_first_email() {
		$huiskamer = $this->get_huiskamer();
		$subject = 'Nieuwe inschrijving bij thuisverder.nl';
		$message = "De naam is {$this->name()}";
		
		return $huiskamer->send_email($subject, $message);
	}
}
?>