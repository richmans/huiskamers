<?php
/*
Plugin Name: Huiskamers
Plugin URI: http://github.com/richmans/huiskamers
Description: Provides a plugin for huiskamers.nl to administer a list of local groups. It allows visitors to connect to the groups by sending an email.
Version: 0.1
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

		// Hooks fired when the Widget is activated and deactivated
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

	

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );

		// register the function to build up the admin menu
		add_action('admin_menu', array($this, 'build_admin_menu'));

		add_shortcode( 'huiskamers', array($this, 'render_shortcode') );
	} // end constructor

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 */
	public function widget() {
		// Check if there is a cached output
		$cache = wp_cache_get( 'huiskamers' );

		if ( !is_array( $cache ) )
			$cache = array();


		if ( isset ( $cache[ 'widget' ] ) )
			return print $cache[ 'widget' ];


		$widget_string = $before_widget;

		// TODO: Here is where you manipulate your widget's values based on their input fields
		ob_start();
		include( plugin_dir_path( __FILE__ ) . 'views/widget.php' );
		$widget_string .= ob_get_clean();
		$widget_string .= $after_widget;


		$cache[ 'widget']  = $widget_string;

		wp_cache_set( 'huiskamers', $cache);

		return $widget_string;

	} 
	
	//This is the function that is executed when [huiskamers] is found in a post
  public function render_shortcode( $atts ) {
  	echo $this->widget();
  }


	public function flush_widget_cache() 
	{
    	wp_cache_delete( 'huiskamers' );
	}
	

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/

	/**
	 * Loads the Widget's text domain for localization and translation.
	 */
	public function widget_textdomain() {
		load_plugin_textdomain( 'huiskamers', false, plugin_dir_path( __FILE__ ) . 'lang/' );
	} // end widget_textdomain

	/**
	 * Fired when the plugin is activated.
	 *
	 * @param  boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public function activate( $network_wide ) {
		// TODO define activation functionality here
	} // end activate

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
	 */
	public function deactivate( $network_wide ) {
		// TODO define deactivation functionality here
	} // end deactivate

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {

		// TODO: Change 'widget-name' to the name of your plugin
		wp_enqueue_style( 'huiskamers-admin-styles', plugins_url( 'huiskamers/css/admin.css' ) );

	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {

		// TODO: Change 'widget-name' to the name of your plugin
		wp_enqueue_script( 'huiskamers-admin-script', plugins_url( 'huiskamers/js/admin.js' ), array('jquery') );

	} // end register_admin_scripts

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {

		// TODO: Change 'widget-name' to the name of your plugin
		wp_enqueue_style( 'huiskamers-widget-styles', plugins_url( 'huiskamers/css/widget.css' ) );

	} // end register_widget_styles

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {

		// TODO: Change 'widget-name' to the name of your plugin
		wp_enqueue_script( 'huiskamers-script', plugins_url( 'huiskamers/js/widget.js' ), array('jquery') );

	} // end register_widget_scripts

	/**
	* Registers the admin menu 
	*/
	public function build_admin_menu(){
		add_menu_page('Huiskamers', 'Huiskamers', 'manage_options', 'huiskamers', array($this, 'show_admin_page'), 'dashicons-book-alt');
		add_submenu_page('huiskamers', 'Regios beheren', 'Regios', 'manage_options', 'show_regions_page', array($this, 'show_regions_page'));
	}

	/** Shows the main admin page **/
	public function show_admin_page(){

	}

	/** Shows the regions page **/
	public function show_regions_page(){

	}
} // end class
$huiskamers = new Huiskamers();
?>