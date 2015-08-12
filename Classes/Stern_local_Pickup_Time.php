<?php

class Local_Pickup_Time {

	
	protected static $instance = null;

	
	private function __construct() {

		// Add the local pickup time field to the checkout page
		$public_hooked_location = apply_filters( 'local_pickup_time_select_location', 'woocommerce_after_order_notes' );
		add_action( $public_hooked_location, array( $this, 'time_select' ) );

		// Process the checkout
		//add_action( 'woocommerce_checkout_process', array( $this, 'field_process' ) );

		// Update the order meta with local pickup time field value
		add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'update_order_meta' ) );

		// Add local pickup time field to order emails
		add_filter('woocommerce_email_order_meta_keys', array( $this, 'update_order_email' ) );

	}

	

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	 /*
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}
	*/

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		// No activation functionality needed... yet
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// No deactivation functionality needed... yet
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	/*public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}
	*/

	/**
	 * Create an array of times starting with an hour past the current time
	 *
	 * @since    1.0.0
	 */
	

	/**
	 * Add the local pickup time field to the checkout page
	 *
	 * @since    1.0.0
	 */
	public function time_select( $checkout ) {
		echo '<div id="local-pickup-time-select"><h2>' . __( 'Pickup Time', $this->plugin_slug ) . '</h2>';
		
							
					echo '<p>';
					echo 'Heure prévue de récupération : ';
					$dateEstimatedPickedUp = date("Y-m-d") ;
					$timeEstimatedPickedUp = date("H:i", strtotime("+20 minutes" )) ;
					//Y-m-d H:i:s
					echo '<input type="date" name="dateEstimatedPickedUp" pattern="[a-zA-Z0-9 ]+" value="' . $dateEstimatedPickedUp . '" size="40" />';
					echo '<input type="time" name="timeEstimatedPickedUp" pattern="[a-zA-Z0-9 ]+" value="' . $timeEstimatedPickedUp . '" size="40" />';
					echo '</p>';
					
					
				$user_id = get_current_user_id();
				$statut = 50;	
				$arrayPrescriptions = PrescriptionRepository::getArrayPrescriptionsByStatusAndUser($statut,$user_id );
		
		
		
		
				foreach( $arrayPrescriptions as $objetPrescription ) {	
					//echo  $objetPrescription->getId();
					//echo  $objetPrescription->getTarget_repository();
					echo $objetPrescription->getOriginal_name_file() ;
					}
									
	/*								
echo "<pre>";
    var_dump($arrayPrescriptions);
    echo "</pre>";
*/
									
									
		//$oPrescription = new Prescription(11);
		//echo $oPrescription->getName_file();
		
		echo '</div>';
	}

	/**
	 * Process the checkout
	 *
	 * @since    1.0.0
	 */
	 /*
	public function field_process() {
		global $woocommerce;

		// Check if set, if its not set add an error.
		if ( !$_POST['dateEstimatedPickedUp'] )
			 $woocommerce->add_error( __( 'Please select a pickup time.', $this->plugin_slug ) );
	}
	*/

	/**
	 * Update the order meta with local pickup time field value
	 *
	 * @since    1.0.0
	 */
	public function update_order_meta( $order_id ) {

				
		if ( $_POST['dateEstimatedPickedUp'] ) {
				$user_id = get_current_user_id();
				$statut = 50;
				$dateEstimatedPickedUp = $_POST['dateEstimatedPickedUp'];
				$timeEstimatedPickedUp = $_POST['timeEstimatedPickedUp'];
				$fullDateEstimatedPickedUp = date('Y-m-d H:i:s', strtotime("$dateEstimatedPickedUp $timeEstimatedPickedUp"));		
		
				update_post_meta( $order_id, '_local_pickup_time_select', esc_attr( $fullDateEstimatedPickedUp ) );		
				$arrayPrescriptions = PrescriptionRepository::getArrayPrescriptionsByStatusAndUser($statut,$user_id );
				$statut = 1;				
				foreach( $arrayPrescriptions as $objetPrescription ) {	
					$objetPrescription->setWoo_order_id($order_id);	
					$objetPrescription->setStatut_order($statut);	
					$objetPrescription->setDate_forecast_cust_pick_up($fullDateEstimatedPickedUp);
					$objetPrescription->save();	
				}									
		}
	}

	/**
	 * Add local pickup time field to order emails
	 *
	 * @since    1.0.0
	 */
	public function update_order_email( $keys ) {
		$keys['Pickup time'] = '_local_pickup_time_select';
		return $keys;
	}

}
