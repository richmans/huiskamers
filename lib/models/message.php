<?
namespace Huiskamers;
class Message extends Base {
	public static function table_name() { return 'messages'; }
	public static function fields() {
		return array(
			'name' => array('type' => 'string', 'optional' => true),
			'huiskamer' => array('type' => 'dropdown', 'model' => 'Huiskamer'),
			'email' => array('type' => 'string', 'validate' => 'email'),
			'message' => array('type' => 'text', 'optional' => true),
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
		$subject = '[Inschrijving] Nieuwe inschrijving bij thuisverder.nl';
		$message = $this->render_email($huiskamer);
		return $huiskamer->send_email($subject, $message);
	}

	public function send_reminder_email() {
		$huiskamer = $this->get_huiskamer();
		$subject = '[Herinnering] Nieuwe inschrijving bij thuisverder.nl';
		$message = $this->render_email($huiskamer, 'huiskamers_reminder-email-message');
		return $huiskamer->send_email($subject, $message);
	}

	public function render_email($huiskamer, $template_name ='huiskamers_new-message-email-message') {
		$template = get_option($template_name);
		$email = $template;
		$email = str_replace('[huiskamer]', $huiskamer->name(), $email);
		$email = str_replace('[naam]', $this->name(), $email);
		$email = str_replace('[email]', $this->email(), $email);
		$email = str_replace('[ip]', $this->ip(), $email);
		$email = str_replace('[bericht]', $this->message(), $email);
		return $email;
	}
}
?>