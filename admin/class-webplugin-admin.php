<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://shivweb.com
 * @since      1.0.0
 *
 * @package    Webplugin
 * @subpackage Webplugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Webplugin
 * @subpackage Webplugin/admin
 * @author     Shivlal <shiv.sheladiya@gmail.com>
 */
class Webplugin_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// Boat Search Widget
		add_action( 'widgets_init', array( $this, 'wep_demo_widget' ) );

		// Reset Setting Ajax Action
		add_action( 'wp_ajax_webp_set_default', array( $this, 'webp_set_default' ) );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Webplugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Webplugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/webplugin-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style('jquery-ui-datepicker');
		wp_enqueue_style( 'wp-color-picker');

	}	

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Webplugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Webplugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/webplugin-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'wp-color-picker');
		wp_enqueue_media();

	}

	/**
	* Create admin side WebPluing Main page
	* 
	* @since  1.0.0
	*/
	public function webplugin_main_page() {
		$this->plugin_screen_hook_suffix = add_menu_page(
		__( 'Webplugin', 'webplugin' ),
		__( 'Webplugin', 'webplugin' ),
		'manage_options',
		'webp-page',
		array( $this, 'webplugin_main_display' )                        
	);
	}

	/**
	 * Render the WebPluing Main page function for plugin
	 *
	 * @since  1.0.0
	 */
	public function webplugin_main_display() {
		
	}

	/**
	* Create WebPluing  Setting Page
	* 
	* @since  1.0.0
	*/
	public function webplugin_setting_page() {
		$this->plugin_screen_hook_suffix = add_submenu_page(
					'webp-page',
		__( 'WebPluing Settings', 'webplugin' ),
		__( 'WebPluing Settings', 'webplugin' ),
		'manage_options',
		'webplugin-setting',
		array( $this, 'webplugin_setting_display' )                        
	);
	}

	/**
	 * Render the WebPluing Setting page function for plugin
	 *
	 * @since  1.0.0
	 */
	public function webplugin_setting_display() {
		include_once 'partials/webplugin-admin-setting-page.php';
	}

	

	/**
	 * WebPluing register setting
	 * @since  1.0.0
	 */
	public function webplugin_register_setting(){

		register_setting('webplugin_widget_setting', 'wp_title', array( $this, 'my_settings_title_validation') );
		register_setting('webplugin_widget_setting', 'wp_description');
		register_setting('webplugin_widget_setting', 'wp_enter_content');
		register_setting('webplugin_widget_setting', 'wp_date', array( $this, 'my_settings_date_validation'));
		register_setting('webplugin_widget_setting', 'wp_color');
		register_setting('webplugin_widget_setting', 'wp_image');
	}

	/**
	 * Title Field Validation
	 * @since  1.0.0
	 */
	public function my_settings_title_validation( $value ) {
	      if ( empty( $value ) ) {
	        $t_value = get_option( 'wp_title' ); // ignore the user's changes and use the old database value
	    
	        add_settings_error( 'my_option_notice', 'invalid_wp_title', 'Title is required.' );
	    }

    	return $value;
	}

	/**
	 * Date Field Validation
	 * @since  1.0.0
	 */
	public function my_settings_date_validation( $value ) {
	     if ( empty( $value ) ) { 
	        $d_value = get_option( 'wp_date' ); // ignore the user's changes and use the old database value
	        add_settings_error( 'my_option_notice', 'invalid_wp_date', 'Date is required.' );
	    }

    	return $value;
	}

	/**
	 * Register Web Demo Widget.
	 * 
	 * @since 1.0.0
	 */
	public function wep_demo_widget(){
		register_widget( 'webplugin_widget_demo' );
	}

	/**
	 * Reset Setting options ajax function
	 * 
	 * @since 1.0.0
	 */
	public function webp_set_default(){
        $rml_options = array (
            'wp_title' => '',
            'wp_description' => '',
            'wp_enter_content' => '',
            'wp_date' => '',
            'wp_image' => '',
            'wp_color' => '#000000',
        );

        // Set as default options...
        foreach ($rml_options as $name => $val) {
            update_option($name,$val);
        }
        die;
    }
}
