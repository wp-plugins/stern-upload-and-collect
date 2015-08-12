<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Plugin Name: Stern Upload And Collect
Plugin URI: http://sternwebagency.com
Description: Stern Upload And Collect
Version: 0.1
Author: Alan SZTERNBERG
Plugin URI: http://sternwebagency.com
License: GPL2
Text Domain: SternUPAC
Domain Path: /fr
*/

//date_default_timezone_set('Europe/Paris');

class UploadCommercePlugin
{
	public function __construct()
	{
		include_once plugin_dir_path( __FILE__ ).'/ShortcodeClassController.php';
		include_once plugin_dir_path( __FILE__ ).'/SternFunctions.php';
		include_once plugin_dir_path( __FILE__ ).'/Classes/UploadPrescriptionPlginCLass.php';

		$Shortcode  = new ShortcodeClass();
		new UploadPrescriptionPlginCLass($Shortcode);
		register_activation_hook(__FILE__, array('UploadPrescriptionPlginCLass', 'install'));
		register_uninstall_hook(__FILE__, array('UploadPrescriptionPlginCLass', 'uninstall'));
		
		
		require_once( plugin_dir_path( __FILE__ ) . 'Classes/Stern_local_Pickup_Time.php' );

		/*
		* Register hooks that are fired when the plugin is activated or deactivated.
		* When the plugin is deleted, the uninstall.php file is loaded.

		register_activation_hook( __FILE__, array( 'Local_Pickup_Time', 'activate' ) );
		register_deactivation_hook( __FILE__, array( 'Local_Pickup_Time', 'deactivate' ) );
		*/

		add_action( 'plugins_loaded', array( 'Local_Pickup_Time', 'get_instance' ) );

 
	}
}



new UploadCommercePlugin();




