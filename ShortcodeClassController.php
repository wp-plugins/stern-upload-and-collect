<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include_once plugin_dir_path( __FILE__ ).'/Widget.php';
include_once plugin_dir_path( __FILE__ ).'/Templates/showLoadFileButtonTemplate.php';
include_once plugin_dir_path( __FILE__ ).'/Templates/showLoadMutuelleTemplate.php';
include_once plugin_dir_path( __FILE__ ).'/Templates/showPrescriptionsListTemplate.php';
include_once plugin_dir_path( __FILE__ ).'/Templates/OptionBackOfficeTemplate.php';
include_once plugin_dir_path( __FILE__ ).'/Templates/backOfficeInstallTemplate.php';
include_once plugin_dir_path( __FILE__ ).'/Templates/CustomUserFieldsTemplate.php';
include_once plugin_dir_path( __FILE__ ).'/Templates/showMutuelleList_Template.php';
include_once plugin_dir_path( __FILE__ ).'/Templates/showPrescriptionsSummaryToggle.php';
include_once plugin_dir_path( __FILE__ ).'/Templates/showSinglePrescriptionTemplate.php';
include_once plugin_dir_path( __FILE__ ).'/Templates/showSinglePictureTemplate.php';
include_once plugin_dir_path( __FILE__ ).'/Templates/showMutuelleListAdminTemplate.php';
include_once plugin_dir_path( __FILE__ ).'/Templates/showButtonsInPrescriptionTemplate.php';
include_once plugin_dir_path( __FILE__ ).'/Templates/showPrescriptionsListAdminTemplate.php';



include_once plugin_dir_path( __FILE__ ).'/Repository/PrescriptionRepository.php';
include_once plugin_dir_path( __FILE__ ).'/Classes/Document.php';
include_once plugin_dir_path( __FILE__ ).'/Classes/Prescription.php';
include_once plugin_dir_path( __FILE__ ).'/Classes/Mutuelle.php';
// http://php.net/manual/fr/security.magicquotes.disabling.php 





class ShortcodeClass{

	public function showLoadFileButton( $atts, $content ) {
	
		ob_start();
		
		loadPrescription();
		
        $typeDocument = getTypeDocument($atts);
        if($typeDocument == 'prescription'){			
            new showLoadFileButtonTemplate($typeDocument);
        }
		if($typeDocument == 'mutuelle'){			
            new showLoadMutuelleTemplate();
        }
		
		
		
		return ob_get_clean();
	}

	public function showSinglePictureFunction($atts) {
        ob_start();
		$idPrescription = getIdInShortcode($atts);
		$type_user = getTypeUser($atts);
	//	$user_ID = get_current_user_id();		
		if ( $idPrescription != NULL ) {
			$oPrescription = new Prescription($idPrescription);
		//	$filterWhereArray = getFilterWhereArray($atts,'showSingle');
		//	$orderByArray = getOrderByArray('DESC');
			
		//	$arrayPrescriptions = PrescriptionRepository::getPrescriptionSearch($filterWhereArray, $orderByArray );
			new showSinglepictureTemplate($oPrescription,$type_user);			
		}
        return ob_get_clean();	
	}
	
	
	
	public function showSinglePrescriptionFunction($atts) {
        ob_start();
		$idPrescription = getIdInShortcode($atts);
	/*	getUserIdFromIdPrescription($idPrescription); */
		
		$type_user = getTypeUser($atts);
		
		
		$user_ID = get_current_user_id();

		
		if ( $idPrescription != NULL ) {
		//	$filterWhereArray = getFilterWhereArray($atts,'showSingle');
		//	$orderByArray = getOrderByArray('DESC');
			$oPrescription = new Prescription($idPrescription);
			$userIdFromIdPrescription = $oPrescription->getUser_id();


			$pharmacist = esc_attr( get_the_author_meta( 'pharmacist',  get_current_user_id()) ) ;
			if ($pharmacist =='on') {
				new showSinglePrescriptionTemplate($oPrescription,$type_user);	
				} else {
					if ($userIdFromIdPrescription == $user_ID) {
						new showSinglePrescriptionTemplate($oPrescription,$type_user);
					} else {
						echo "Vous devez être pharamcien pour voir cette page";
					}
				}
		}
	
        return ob_get_clean();
    }

	public function showPrescriptionsListAdminFunction ( $atts, $content ) {
		ob_start();
		$all_Users_IDs = NULL;
		$arrayAll_Users_IDs = NULL;
		$woo_order_id = NULL;
		/*$user_ID = NULL;*/
		$typeDocument ='prescription';
		
	//	$type_user = getTypeUser($atts);
		$type_user = "admin";
		$typeDocumentValue = 'prescription';
	
		
		if ($type_user == "admin") {
	
			if (isset($_GET['user']) && $_GET['user'] != NULL) {
				$search = $_GET['user'];
				$all_Users_IDs = PrescriptionRepository::getUserIdsWithSearch($search);			
				$arrayAll_Users_IDs = array($all_Users_IDs);
			}
			if (isset($_GET['order']) && $_GET['order'] !=NULL) {
				$woo_order_id = $_GET['order'];									
			}			
			
		} else {			
			$all_Users_IDs = array(get_current_user_id());		
		}
		
		if (	
				isset($_GET['seeCheckBoxStatut0'])
				or isset($_GET['seeCheckBoxStatut1']) 
				or isset($_GET['seeCheckBoxStatut2'])
				or isset($_GET['seeCheckBoxStatut3'])
				or isset($_GET['seeCheckBoxStatut4'])
				or isset($_GET['seeCheckBoxStatut5'])
				or isset($_GET['seeCheckBoxStatut50'])				
			)
			{
				$arrayStatut_order_value = array( );
			} else {
				$arrayStatut_order_value = array( 1,2,3,4,5 );
			}
				

		$statut_shortcode = getStatutInShortcode($atts);
		if ($statut_shortcode != NULL) {
			$arrayStatut_order_value = array ($statut_shortcode);
		} else {					
			if(isset($_GET['seeCheckBoxStatut0'])){
				$arrayStatut_order_value[] = 0 ;				
			}			
			if(isset($_GET['seeCheckBoxStatut1'])){
				$arrayStatut_order_value[] =  1 ;				
			}
			if(isset($_GET['seeCheckBoxStatut2'])){
				$arrayStatut_order_value[] =  2 ;				
			}
			if(isset($_GET['seeCheckBoxStatut3'])){
				$arrayStatut_order_value[] =  3 ;				
			}
			if(isset($_GET['seeCheckBoxStatut4'])){
				$arrayStatut_order_value[] =  4 ;				
			}
			if(isset($_GET['seeCheckBoxStatut5'])){
				$arrayStatut_order_value[] =  5 ;				
			}
			if(isset($_GET['seeCheckBoxStatut50'])){
				$arrayStatut_order_value[] =  50 ;				
			}		
		}
	

		$filterWhereArray = getDocumentWhereArray($typeDocument, $all_Users_IDs, $arrayStatut_order_value,$woo_order_id);
        $orderByArray = getOrderByArray ();		
		
		$args = $filterWhereArray;
		$the_query  = new WP_Query( $args  );
		
		
		$pharmacist = esc_attr( get_the_author_meta( 'pharmacist',  get_current_user_id()) ) ;
		if ($pharmacist !='on' and $type_user=='admin') {
			echo  __('Sorry, you must be a pharmacist for this area.' , 'SternUPAC'); 
		} else {
			new showPrescriptionsListAdminTemplate($the_query ,$type_user);
		}
		
		return ob_get_clean();
	}
  
    public function showFilesShortcode( $atts, $content ) {
		ob_start();
		$all_Users_IDs = NULL;
		$arrayAll_Users_IDs = NULL;
		$woo_order_id = NULL;
		/*$user_ID = NULL;*/
		$typeDocument ='prescription';
		
		$type_user = getTypeUser($atts);
		$typeDocumentValue = 'prescription';
	
		
		if ($type_user == "admin") {
	
			if (isset($_GET['user']) && $_GET['user'] != NULL) {
				$search = $_GET['user'];
				$all_Users_IDs = PrescriptionRepository::getUserIdsWithSearch($search);			
				$arrayAll_Users_IDs = array($all_Users_IDs);
			}
			if (isset($_GET['order']) && $_GET['order'] !=NULL) {
				$woo_order_id = $_GET['order'];									
			}			
			
		} else {			
			$all_Users_IDs = array(get_current_user_id());		
		}
		
		if (	
				isset($_GET['seeCheckBoxStatut0'])
				or isset($_GET['seeCheckBoxStatut1']) 
				or isset($_GET['seeCheckBoxStatut2'])
				or isset($_GET['seeCheckBoxStatut3'])
				or isset($_GET['seeCheckBoxStatut4'])
				or isset($_GET['seeCheckBoxStatut5'])
				or isset($_GET['seeCheckBoxStatut50'])				
			)
			{
				$arrayStatut_order_value = array( );
			} else {
				$arrayStatut_order_value = array( 1,2,3,4,5,50 );
			}
				

		$statut_shortcode = getStatutInShortcode($atts);
		if ($statut_shortcode != NULL) {
			$arrayStatut_order_value = array ($statut_shortcode);
		} else {					
			if(isset($_GET['seeCheckBoxStatut0'])){
				$arrayStatut_order_value[] = 0 ;				
			}			
			if(isset($_GET['seeCheckBoxStatut1'])){
				$arrayStatut_order_value[] =  1 ;				
			}
			if(isset($_GET['seeCheckBoxStatut2'])){
				$arrayStatut_order_value[] =  2 ;				
			}
			if(isset($_GET['seeCheckBoxStatut3'])){
				$arrayStatut_order_value[] =  3 ;				
			}
			if(isset($_GET['seeCheckBoxStatut4'])){
				$arrayStatut_order_value[] =  4 ;				
			}
			if(isset($_GET['seeCheckBoxStatut5'])){
				$arrayStatut_order_value[] =  5 ;				
			}
			if(isset($_GET['seeCheckBoxStatut50'])){
				$arrayStatut_order_value[] =  50 ;				
			}		
		}
	
		/*
		$filterWhereArray = array (
			'post_type' => 'sternupac'
		);
			
		if($user_ID!=NULL) {
			$filterWhereArray['post_author'] = $user_ID;
		}
		
		$metaQueryArray = array();
		
		if($arrayStatut_order_value!=NULL) {
			$arrayStatut_order = array (
				'key' => 'statut_order',
				'value' => $arrayStatut_order_value,
				'compare' => 'IN'
			);
			$metaQueryArray[] = $arrayStatut_order ;
		}
		
		if($all_Users_IDs!=NULL) {
			$arrayPost_author_meta = array (
				'key' => 'post_author_meta',
				'value' => array ($all_Users_IDs),
				'compare' => 'IN'
			);
			$metaQueryArray[] = $arrayPost_author_meta ;
		}	
		
		if($typeDocument!=NULL) {
			$arrayTypeDocument = array ( 
				'key' => 'typeDocument',
				'value' => $typeDocument
			);
			$metaQueryArray[] = $arrayTypeDocument ;			
		}
		
		if($woo_order_id!=NULL) {
			$arrayWoo_order_id = array (
				'key' => 'woo_order_id',
				'value' => $woo_order_id
			);
			$metaQueryArray[] = $arrayWoo_order_id;
		}

		$filterWhereArray['meta_query'] = $metaQueryArray;
		*/

		$filterWhereArray = getDocumentWhereArray($typeDocument, $all_Users_IDs, $arrayStatut_order_value,$woo_order_id);
        $orderByArray = getOrderByArray ();		
		
		$args = $filterWhereArray;
		$the_query  = new WP_Query( $args  );
		
		
		$pharmacist = esc_attr( get_the_author_meta( 'pharmacist',  get_current_user_id()) ) ;
		if ($pharmacist !='on' and $type_user=='admin') {
			echo  __('Sorry, you must be a pharmacist for this area.' , 'SternUPAC'); 
		} else {
			new showPrescriptionsListTemplate($the_query ,$type_user);
		}
		
		return ob_get_clean();
	}

    public function customUserFields_shortcode() {
        ob_start();
		
		if ( isset( $_POST['cf-submitted'] ) ) {

			// sanitize form values
			$user_id = get_current_user_id();
			$message = esc_textarea( $_POST["cf-message"] );
			$gender =  $_POST["gender"] ;
			$communication_type =  $_POST["communication_type"] ;
			$social_security_number = $_POST["social_security_number"] ;
			$alert_product_refunded = $_POST["alert_product_refunded"] ;
			$user_firstname = $_POST["user_firstname"] ;
			$user_lastname = $_POST["user_lastname"] ;
			$birthdate = $_POST["birthdate"] ;
			$user_email = $_POST["user_email"] ;


			update_user_meta($user_id ,'social_security_number', $social_security_number );
			update_user_meta($user_id ,'gender', $gender );
			update_user_meta($user_id ,'communication_type', $communication_type );
			update_user_meta($user_id ,'alert_product_refunded', $alert_product_refunded );
			update_user_meta($user_id ,'birthdate', $birthdate );
			update_user_meta($user_id ,'user_email', $user_email );

			wp_update_user(
							array(
								'ID' => $user_id ,
								'first_name'=> $user_firstname,
								'last_name' => $user_lastname 
							)
			);
		}
		
		
        new CustomUserFieldsTemplate();
        return ob_get_clean();
    }
	
	
	
	public function showPrescriptionsSummaryToggleFunction() {
        ob_start();
        new showPrescriptionsSummaryToggle();
        return ob_get_clean();
    }
	



	public function showMutuelleList_shortcode() {
        ob_start();
		$arrayStatus = array(10,50);
        $user_ID = get_current_user_id();  
       // $arrayDoc = getArrayMutuelle($user_ID,$arrayStatus);
		
		
	
		
		$filterWhereArray = getDocumentWhereArray('mutuelle', array($user_ID), $arrayStatus,NULL,NULL );		
        $orderByArray = getOrderByArray();
		


		$args = $filterWhereArray;
		$the_query  = new WP_Query( $args  );
        new ShowMutuelleList_Template($the_query );
        return ob_get_clean();
    }
	
	
	
	public function showMutuelleListAdminShortcode() {
		ob_start();
		$user_ID = get_current_user_id();
		if (isset($_GET['doc']) && $_GET['doc'] != NULL) {
			$Pid = $_GET['doc'];
		} else {
			$Pid =NULL ;
		}
		
		if(isset($_POST['updateMutuelleAdminButton'])) {
				if(isset($_POST['hiddenId'])){
					$idRow = (int)$_POST['hiddenId'];
					$statut_order = $_POST['statut_order'];
					$date_end_validity = $_POST['date_end_validity'];
					if($idRow !=null) {
						$oMutuelle = new Mutuelle($idRow );
						$oMutuelle->setStatut_order($statut_order);
						$oMutuelle->setDate_end_validity($date_end_validity);
						$oMutuelle->setUser_id_validate_mutuelle($user_ID);
						$oMutuelle->setDate_validate_mutuelle(date("Y-m-d H:i:s"));
						$oMutuelle->save();
					}
				}
		}
		$arrayStatus = array(10,11,50);
		//Function getDocumentWhereArray($typeDocument=NULL, $array_Users_IDs=NULL,$arrayStatut_order_value=null,$woo_order_id=NULL,$posts_per_page=5 , $Pid=NULL) {

		$filterWhereArray = getDocumentWhereArray('mutuelle', NULL, $arrayStatus,NULL,NULL,$Pid );		
		$orderByArray = getOrderByArray();				
		$args = $filterWhereArray;
		$the_query  = new WP_Query( $args  );
		
		
		
		$pharmacist = esc_attr( get_the_author_meta( 'pharmacist',  get_current_user_id()) ) ;
		if ($pharmacist !=true) {
			echo  __('Sorry, you must be a pharmacist for this area.' , 'SternUPAC'); 
		} else {
			new showMutuelleListAdminTemplate($the_query);
		}
		
		
		

		
        
		return ob_get_clean();
	}

}





/*
echo "<pre>";
    var_dump($filterWhereArray);
echo "</pre>";
*/






