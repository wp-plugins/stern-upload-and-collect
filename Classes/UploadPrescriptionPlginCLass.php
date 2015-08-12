<?php

class UploadPrescriptionPlginCLass
{
    public function __construct($Object )
    {
        add_action('widgets_init', function(){register_widget('Zero_Newsletter_Widget');});
        add_action('wp_loaded', array($this, 'ActionFunction'));
    //    add_action( 'wp_enqueue_scripts', 'safely_add_stylesheet' );
        //add_action( 'wp_enqueue_scripts', 'safely_add_javascript' );
        add_shortcode( 'Stern_Upload_And_Collect_upload_button', array( $Object, 'showLoadFileButton' ) );
        add_shortcode( 'Stern_Upload_And_Collect_dashboard', array( $Object, 'showFilesShortcode' ) );
        add_shortcode( 'sitepoint_contact_form', array( $Object, 'customUserFields_shortcode' ));
		add_shortcode( 'showMutuelle_shortcode', array( $Object, 'showMutuelleList_shortcode' ));
		add_shortcode( 'showMutuelleAdminShortcode', array( $Object, 'showMutuelleListAdminShortcode' ));		
		add_shortcode( 'showPrescriptionsSummaryToggle', array( $Object, 'showPrescriptionsSummaryToggleFunction' ));
		add_shortcode( 'showSinglePrescription', array( $Object, 'showSinglePrescriptionFunction' ));
		add_shortcode( 'showSinglePicture', array( $Object, 'showSinglePictureFunction' ));
		add_shortcode( 'showPrescriptionsListAdmin', array( $Object, 'showPrescriptionsListAdminFunction' ));

    }


    /**
     * Add stylesheet to the page
     */
    function safely_add_stylesheet() {
        $src2 = plugin_dir_url( __FILE__ ) . 'css/SternUploadAndCollect.css"';
        echo '<link href="' . $src2 . '" rel="stylesheet" type="text/css">';
    }



    public static function install()
    {
		$date = date('m/d/Y h:i:s a', time());
		update_option('dateInstallPlugin',$date );
		
		update_option('sternDpmo',1 );
		
	/*
        global $wpdb;
        $nom_table = $wpdb->prefix."SternUploadAndCollect";
        $wpdb->query("CREATE TABLE IF NOT EXISTS ". $nom_table." (
		id INT AUTO_INCREMENT PRIMARY KEY,
		user_id INT NOT NULL,
		typeDocument VARCHAR(255) NOT NULL,
		woo_order_id INT,
		target_repository  VARCHAR(255) NOT NULL,		
		name_file VARCHAR(255) NOT NULL,
		noteCustToPharm TEXT,
		notePharmToCust TEXT,
		original_name_file VARCHAR(255),
		statut_order INT,
		date_file_sent DATETIME,
		date_start_prep DATETIME,
		date_finish_prep DATETIME,
		date_cust_pick_up DATETIME,
		date_forecast_cust_pick_up DATETIME);");
		*/
    }
	


    public static function uninstall()
    {
	/*
        global $wpdb;
        $nom_table = Prescription::getNomTable();
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}SternUploadAndCollect;");
	*/
    }




    public function ActionFunction()
    {
		$noteWoocommerce = '';
		
		if(isset($_POST['hiddenId'])){
			$idRow = (int)$_POST['hiddenId'];
			if ($idRow!=NULL) { 
				$oPrescription = new Prescription($idRow );
			}
		}
		
        //$nom_table = Prescription::getNomTable();


        // Action Delete row
        if(isset($_POST['delete'])){
            $statut = 0;
			if ($idRow!=NULL) { 
				$oDocument = new Document($idRow );
			 }
            //$wpdb->delete($nom_table, array('id' => $idRow));
            $oDocument->setStatut_order($statut);
            $oDocument->save();
        }

        // Action TaskStatut1
        if(isset($_POST['TaskStatut1'])){
            $statut = 1;
            $oPrescription->setStatut_order($statut);
            $oPrescription->save();
            sendMailStatut($statut);
        }
        // Action TaskStatut2
        if(isset($_POST['TaskStatut2'])){
            $statut = 2;
            $oPrescription->setStatut_order($statut);
			$oPrescription->setDate_start_prep( date("Y-m-d H:i:s"));
            $oPrescription->save();
            sendMailStatut($statut);
        }
        // Action TaskStatut3
        if(isset($_POST['TaskStatut3'])){
            $statut = 3;
			$woo_order_id = $oPrescription->getWoo_order_id();
			$order = new WC_Order($woo_order_id);			
            $oPrescription->setStatut_order($statut);
			//$oPrescription->setNotePharmToCust($notePharmToCust);			
			$oPrescription->setDate_finish_prep( date("Y-m-d H:i:s"));
			$oPrescription->setUser_finish_prep_id(get_current_user_id());
			
			if(isset($_POST['notePharmToCust'])){
				$notePharmToCust = $_POST['notePharmToCust'];
				$oPrescription->setNotePharmToCust($notePharmToCust);	
				$noteWoocommerce = $notePharmToCust;			
				/*send to note woocommerce */				
					if ($noteWoocommerce != '') {
						$order->add_order_note( $noteWoocommerce ,1);
					}
				/*send to note woocommerce */				
			}
			if(isset($_POST['price'])){
				$price = $_POST['price'];
				$oPrescription->setPrice($price);	
				
				/*send to note woocommerce */
					$noteWoocommerce = __('Price of your prescription is:' , 'SternUPAC').' '.$price;
					if ($noteWoocommerce != '' && $price!='') {
						$order->add_order_note( $noteWoocommerce ,1);
					}
				/*send to note woocommerce */				
			}				
			
            $oPrescription->save();
            sendMailStatut($statut);
        }
        // Action TaskStatut4
        if(isset($_POST['TaskStatut4'])){
            $statut = 4;
			$woo_order_id = $oPrescription->getWoo_order_id();
            $oPrescription->setStatut_order($statut);
			$oPrescription->setDate_cust_pick_up( date("Y-m-d H:i:s"));
            $oPrescription->save();
			$price = $oPrescription->getPrice($price);	


			/*Update WooCommerce order */
			$woo_order_id = $oPrescription->getWoo_order_id();
			$order = new WC_Order($woo_order_id);			
			$items = $order->get_items(); 
			$idProductCheckout = esc_attr( get_option('idProductCheckout') ); 
			
			foreach ($items as $key => $product ) {
				$item_id = $key;
				$product_id = $product['product_id'];

					if($product_id  == $idProductCheckout) {
						wc_update_order_item_meta($item_id,'_line_subtotal',$price,'');
						wc_update_order_item_meta($item_id,'_line_total',$price,'');
						
						//$order->calculate_totals();
						$order->set_total( $order->calculate_totals() );
						
					}
				}				
			/*Update WooCommerce order */	
			
			/*send to note woocommerce */
				$noteWoocommerce = 'Votre ordonnance d\'un montant de : '.$price.'€ a été retirée en magasin et payée. Votre facture a été mise à jour dans votre espace.';
				if ($noteWoocommerce != '') {
					$order->add_order_note( $noteWoocommerce ,1);
				}
			/*send to note woocommerce */	
				
	/*
			$order = new WC_Order( $woo_order_id );
			$order->update_status('completed', __('Merci pour votre confiance', 'woothemes'));
	*/
            sendMailStatut($statut);
        }		
		

        // Action Download
        if(isset($_POST['Download'])){

            $target_repository = $oPrescription->getTarget_repository();
            $name_file = $oPrescription->getName_file();

            $file = dirname(plugin_dir_path( __FILE__ )).$target_repository.$name_file;
			
            sendMailStatut(1,$file);
            downloadFile($file);            
        }

		
		// Action Download Dynamique
		if(isset($_POST['hiddenId'])){
		
			$user_id = $oPrescription->getUser_id();		
			
			
		
			$filterWhereArray = getDocumentWhereArray('mutuelle', array($user_id), NULL,NULL );
			$orderByArray = getOrderByArray();
			
			
			$objectsMutuelle = PrescriptionRepository::getMutuelleSearch($filterWhereArray, $orderByArray );
			
			
			
			
			foreach ($objectsMutuelle as $oMutuelle) {			
			
				if(isset($_POST['Download'.$oMutuelle->getid()])){
					$target_repository = $oMutuelle->getTarget_repository();
					$name_file = $oMutuelle->getName_file();

					$file = dirname(plugin_dir_path( __FILE__ )).$target_repository.$name_file;
					//sendMailStatut(1,$file);
					downloadFile($file); 
				}
			}
		}
		
							
        // Action export PDF
        if(isset($_POST['ExportPDF'])){
			exportPDF($oPrescription);
            $target_repository = $oPrescription->getTarget_repository();
            $name_file = $oPrescription->getName_file();
			
			$file = dirname(plugin_dir_path( __FILE__ )).$target_repository.$name_file;
			
           // $file = 'http://upload.wikimedia.org/wikipedia/commons/thumb/8/80/MaisonCausapscal.JPG/220px-MaisonCausapscal.JPG';
        //    sendMailStatut(1,plugin_dir_path( __FILE__ ).'alan'.$target_repository.'alan'.$name_file);
//            exportPDF($file);
            

            
        }		
		


    }
}

/*
echo "ALAN<pre>";
    var_dump($oPrescription);
echo "</pre>";
*/




