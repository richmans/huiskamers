<?php
/*
Plugin Name: Huiskamers
Plugin URI: http://github.com/richmans/huiskamers
Description: Provides a plugin for huiskamers.nl to administer a list of local groups. It allows visitors to connect to the groups by sending an email.
Version: 1.4
Author: Richard Bronkhorst
License: GPL2
*/


class Huiskamers {

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		// load plugin text domain
		add_action( 'init', array( $this, 'widget_textdomain' ) );
		add_action('init', array($this, 'process_application'));
		// Hooks fired when the Widget is activated and deactivated
		// Uses weird path because when used with symlinks, it doesnt work
		// http://wordpress.org/support/topic/register_activation_hook-does-not-work
		register_activation_hook( WP_PLUGIN_DIR . '/huiskamers/huiskamers.php', array( $this, 'activate' ) );
		register_deactivation_hook( WP_PLUGIN_DIR . '/huiskamers/huiskamers.php', array( $this, 'deactivate' ) );

		// Register admin styles and scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );

		// register the function to build up the admin menu
		add_action('admin_menu', array($this, 'build_admin_menu'));
		add_action( 'admin_init', array($this, 'register_settings') );

		add_shortcode( 'huiskamers', array($this, 'render_shortcode') );
		add_action( 'huiskamer_send_reminders', array($this, 'send_reminders' ));
	} 

	/**
	 * Outputs the content of the widget.
	 */
	public function widget() {
		$this->use_lib();
		add_thickbox();
		$email_sent = $_REQUEST['huiskamers-email-sent'];
		$widget_string = '';
		ob_start();
		$huiskamers = Huiskamers\Huiskamer::where("active=1");
		$custom_columns = Huiskamers\Field::where('visible=1');
		include( plugin_dir_path( __FILE__ ) . 'views/widget.php' );
		$widget_string .= ob_get_clean();
		
		return $widget_string;
	} 
	
	//This is the function that is executed when [huiskamers] is found in a post
  public function render_shortcode( $atts ) {
  	echo $this->widget();
  }

	
	/**
	 * Loads the Widget's text domain for localization and translation.
	 */
	public function widget_textdomain() {
		load_plugin_textdomain( 'huiskamers', false, plugin_dir_path( __FILE__ ) . 'lang/' );
	}


	/** This loads everything in /lib **/
	public function use_lib(){
		include plugin_dir_path( __FILE__ ) . 'lib/include.php';
	}
	/**
	 * Fired when the plugin is activated.
	 *
	 * @param  boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public function activate(){
		$this->use_lib();
		$this->register_settings();
		$this->setting_defaults();
		$this->add_auth();

		Huiskamers\Region::create_table();
		Huiskamers\Field::create_table();
		Huiskamers\Huiskamer::create_table();
		Huiskamers\Message::create_table();
		wp_schedule_event( time(), 'daily', 'huiskamer_send_reminders' );
		$this->check_default_columns();
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
	 */
	public function deactivate( ) {
		$this->use_lib();
		$this->unregister_settings();
		Huiskamers\Region::drop_table();
		Huiskamers\Huiskamer::drop_table();
		Huiskamers\Message::drop_table();
		Huiskamers\Field::drop_table();
		wp_clear_scheduled_hook( 'huiskamer_send_reminders' );
	}

	public function add_auth() {
		$role = get_role( 'administrator' );
		$role->add_cap( 'manage_huiskamers' );
		add_role('huiskamer_manager', 'Huiskamer Manager', array(
  		'manage_huiskamers' => true,
  		'read' => true
  	));
	}

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
		wp_enqueue_style( 'huiskamers-admin-styles', plugins_url( 'huiskamers/css/admin.css' ) );
	}

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {
		wp_enqueue_script( 'huiskamers-admin-script', plugins_url( 'huiskamers/js/admin.js' ), array('jquery') );
	}

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {
		wp_enqueue_style( 'huiskamers-widget-styles', plugins_url( 'huiskamers/css/widget.css' ) );
	}

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {
		wp_enqueue_script( 'huiskamers-script', plugins_url( 'huiskamers/js/widget.js' ), array('jquery') );
	}

	/**
	* Registers the admin menu 
	*/
	public function build_admin_menu(){
		add_menu_page('Huiskamers', 'Huiskamers', 'manage_huiskamers', 'huiskamers_huiskamer', array($this, 'show_admin_page'), 'dashicons-groups');
		add_submenu_page('huiskamers_huiskamer', 'Berichten beheren', 'Berichten', 'manage_huiskamers', 'huiskamers_message', array($this, 'show_messages_page'));
		add_submenu_page('huiskamers_huiskamer', 'Regio\'s beheren', 'Regio\'s', 'manage_huiskamers', 'huiskamers_region', array($this, 'show_regions_page'));
		add_submenu_page('huiskamers_huiskamer', 'Kolommen beheren', 'Kolommen', 'manage_huiskamers', 'huiskamers_field', array($this, 'show_fields_page'));
	  add_options_page('Huiskamer options', 'Huiskamers', 'manage_huiskamers', 'huiskamer-options', array( $this, 'show_options_page' ));
        
	}

	public function register_settings() {
		register_setting( 'huiskamers', 'huiskamers_admin-email', 'is_email' );
		register_setting( 'huiskamers', 'huiskamers_new-message-email-message' );
	  register_setting( 'huiskamers', 'huiskamers_reminder-email-message' );
	  register_setting( 'huiskamers', 'huiskamers_send-reminder-email-after', 'intval' );
	}

	public function unregister_settings() {
		delete_option( 'huiskamers_admin-email');
		delete_option(  'huiskamers_new-message-email-message' );
	  delete_option( 'huiskamers_reminder-email-message' );
	  delete_option( 'huiskamers_send-reminder-email-after');
	}

	public function setting_defaults() {
		update_option('huiskamers_admin-email', 'huiskamers@kvdnvlaardingen.nl');
		update_option('huiskamers_send-reminder-email-after', 10);
		update_option('huiskamers_new-message-email-message', "Hallo,

Er is een aanmelding binnen gekomen op thuisverder.nl voor huiskamer [huiskamer].

Naam: [naam]
Email: [email]
Bericht: [bericht]

Groeten, thuisverder.nl");
		update_option('huiskamers_reminder-email-message', "Hallo,

Hierbij een herinnering voor de aanmelding bij huiskamer [huiskamer] op thuisverder.nl.

Naam: [naam]
Email: [email]
Bericht: [bericht]

Groeten, thuisverder.nl");
	}

	public function show_options_page() {
		$this->use_lib();
		$options_controller = new Huiskamers\OptionsController();
		$options_controller->route();
	}

	/** Shows the main admin page **/
	public function show_admin_page(){
		$this->use_lib();
		$huiskamer_controller = new Huiskamers\HuiskamerController();
		$huiskamer_controller->route();
	}

	public function show_messages_page(){
		$this->use_lib();
		$message_controller = new Huiskamers\MessageController();
		$message_controller->route();
	}

	public function show_fields_page(){
		$this->use_lib();
		$this->check_default_columns();
		$field_controller = new Huiskamers\FieldController();
		$field_controller->route();
	}

	/** Shows the regions page **/
	public function show_regions_page(){
		$this->use_lib();
		$region_controller = new Huiskamers\RegionController();
		$region_controller->route();
	}

	public function process_application() {
		if (isset( $_POST['huiskamer_message'])) {
			$this->use_lib();
			$message_controller = new Huiskamers\MessageController();
			$result = $message_controller->send_message();
			$result_tag = ($result == true) ? 'ok' : 'fail';
			wp_redirect(add_query_arg(array( 'huiskamers-email-sent'=> $result_tag) ), 302);
			exit;
		}
	}

	public function send_reminders() {
		$this->use_lib();
		$reminder_interval = intval(get_option('huiskamers_send-reminder-email-after'));
		if($reminder_interval == 0) return;
		$messages = Huiskamers\Message::where("reminder_sent=0 and datediff(curdate(), created_at) > $reminder_interval");
		foreach($messages as $message){
			$message->send_reminder_email();
			$message->set_reminder_sent(true);
			$message->update();
		}
	}

	public function check_default_columns() {
		global $wpdb;
		$existing = Huiskamers\Field::where("slug='name'");
		if(!(empty($existing))) return;
		$field_table = Huiskamers\Field::prefixed_table_name();
		$sql = "update $field_table set order_nr = order_nr + 11";
		$wpdb->query($sql);
		$counter = 1;
		foreach(Huiskamers\Huiskamer::default_fields() as $field => $options) {
			$hash = array('slug' => $field, 'visible' => 1, 'required' => 1, 'name' => $options['caption']);
			$field = new Huiskamers\Field($hash);
			$field->save();
			$field->set_order_nr($counter);
			$field->save();
			$counter += 1;
		}
	}

} // end class
include('lib/controllers/plugin_updater.php');
if ( is_admin() ) {
    new Huiskamers\PluginUpdater( __FILE__, 'richmans', "huiskamers" );
}
$huiskamers = new Huiskamers();
?>