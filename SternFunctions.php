<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



load_plugin_textdomain( 'SternUPAC', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' ); 
		

		

/* woocomerce AMMIN template */
		add_action( 'woocommerce_admin_order_data_after_order_details', 'hello' );
		add_action( 'woocommerce_admin_order_item_values', 'show_atts_in_admin_order');
		add_action( 'woocommerce_admin_order_item_headers', 'admin_order_item_header');
/* woocomerce AMMIN template */

function hello() {
echo "SternUploadAndCollect";
}

function show_atts_in_admin_order( $product, $item, $item_id ) {	
	$woo_order_id = $_GET['post'];
	//$oPrescription= new Prescription($woo_order_id);

	$totalPrice = PrescriptionRepository::getPricePrescriptionByWooOrderId($woo_order_id);
	$idProductPrescription = esc_attr( get_option('idProductPrescription') );
	if($product->id==$idProductPrescription ){
		echo '<td><div class="view">'.$woo_order_id .' - '. $totalPrice .'€</div></td>';
	} else {
		echo '<td><div class="view">-</div></td>';
	}				
}
	
function admin_order_item_header() {
		echo '<th class="wsa-custom-attributes">Ordo</th>';		
}
	
	



/* woocomerce template */
function myplugin_plugin_path() {
 
  // gets the absolute path to this plugin directory
 
  return untrailingslashit( plugin_dir_path( __FILE__ ) );
 
}
 
 
 
add_filter( 'woocommerce_locate_template', 'myplugin_woocommerce_locate_template', 10, 3 );
 
 
 
function myplugin_woocommerce_locate_template( $template, $template_name, $template_path ) {
 
  global $woocommerce;
 
 
 
  $_template = $template;
 
  if ( ! $template_path ) $template_path = $woocommerce->template_url;
 
  $plugin_path  = myplugin_plugin_path() . '/woocommerce/';
 
 
 
  // Look within passed path within the theme - this is priority
 
  $template = locate_template(
 
    array(
 
      $template_path . $template_name,
 
      $template_name
 
    )
 
  );
 
 
 
  // Modification: Get the template from this plugin, if it exists
 
  if ( ! $template && file_exists( $plugin_path . $template_name ) )
 
    $template = $plugin_path . $template_name;
 
 
 
  // Use default template
 
  if ( ! $template )
 
    $template = $_template;
 
 
 
  // Return what we found
 
  return $template;
 
}
/* wocommerce template */

/* ajax test */
/*
add_action( 'wp_ajax_mon_action', 'mon_action' );
add_action( 'wp_ajax_nopriv_mon_action', 'mon_action' );

function mon_action() {

	$param = $_POST['param'];

	
echo "<pre>";
    var_dump($param);
    echo "</pre>";

	
	//$idRow = (int)$_POST['hiddenId'];
	$idRow = 1186;
			$oPrescription = new Prescription($idRow );
	
	            $target_repository = $oPrescription->getTarget_repository();
            $name_file = $oPrescription->getName_file();

            $file = (plugin_dir_path( __FILE__ )).$target_repository.$name_file;
            //sendMailStatut(1,$file);
			
			echo "<pre>";
    var_dump($file);
    echo "</pre>";
            downloadFile($file);   


	die();
}

/* ajax test */




function loadPrescription()
{
	
        // Action Upload file
        if (isset($_POST['loadFileButton'])) {
            if (isset($_FILES['myfile']['name']) && !empty($_FILES['myfile']['name'])) {


                $nomOrigine = $_FILES['myfile']['name'];
                $noteCustToPharm = $_POST['noteCustToPharm'];
				if (isset($_POST['renewable'])) {
					$renewable = $_POST['renewable'];
				} else {
					$renewable ='';
				}
                $typeDocument = $_POST['typeDocument'];
				/*
				$dateEstimatedPickedUp = $_POST['dateEstimatedPickedUp'];
				$timeEstimatedPickedUp = $_POST['timeEstimatedPickedUp'];
				$fullDateEstimatedPickedUp = date('Y-m-d H:i:s', strtotime("$dateEstimatedPickedUp $timeEstimatedPickedUp"));
				*/
                $path_parts = pathinfo($nomOrigine);
                $extensionFichier = $path_parts['extension'];
                $originalFileName = $path_parts['filename'];
                $extensionsAutorisees = array("jpeg", "jpg", "gif","png", "pdf" );
                $user_id = get_current_user_id();

                if (!(in_array($extensionFichier, $extensionsAutorisees))) {
                    echo "Le fichier n'a pas l'extension attendue";
                } else {
                    // Copie dans le repertoire du script avec un nom
                    // incluant l'heure a la seconde pres
                    $DestinationDirectory = "/upload/". $user_id . "/" ;
                    $FullDestinationDirectory = (dirname(__FILE__)).$DestinationDirectory ;

	
	
                    if (!file_exists($FullDestinationDirectory)) {
                        mkdir($FullDestinationDirectory, 0777, true);
                    }

                    $savedFileNameInFtp = date("YmdHis").".".$user_id .".". $originalFileName.".".$extensionFichier;

                    if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $FullDestinationDirectory.$savedFileNameInFtp)) {
                        //echo "Le fichier temporaire ".$_FILES["myfile"]["tmp_name"]." a �t� d�plac� vers ".$FullDestinationDirectory.$savedFileNameInFtp;

                        //$name_file = $savedFileNameInFtp;

                        $filePathName = realpath($nomOrigine);
                        $filePath = realpath(dirname($nomOrigine));
                        $basePath = realpath($_SERVER['DOCUMENT_ROOT']);
                        $originalFileNameAndExtension = $originalFileName.".".$extensionFichier ;
						
						//Statut in chart. Not validated
                        $statut = 50;
						if ($typeDocument == "prescription") {
							$oPrescription = new Prescription();
							$oPrescription->setStatut_order($statut);
							$oPrescription->setName_file($savedFileNameInFtp);
							$oPrescription->setOriginal_name_file($originalFileNameAndExtension);
							$oPrescription->setUser_id($user_id);
							$oPrescription->setNoteCustToPharm($noteCustToPharm);
							$oPrescription->setTarget_repository($DestinationDirectory);
							$oPrescription->setDate_file_sent( date("Y-m-d H:i:s"));
							$oPrescription->setTypeDocument($typeDocument);
							$oPrescription->setRenewable($renewable);
							$oPrescription->save();
						}
						
						if ($typeDocument == "mutuelle") {
							$oMutuelle = new Mutuelle();
							$oMutuelle->setStatut_order($statut);
							$oMutuelle->setName_file($savedFileNameInFtp);
							$oMutuelle->setOriginal_name_file($originalFileNameAndExtension);
							$oMutuelle->setUser_id($user_id);
							$oMutuelle->setNoteCustToPharm($noteCustToPharm);
							$oMutuelle->setTarget_repository($DestinationDirectory);
							$oMutuelle->setDate_file_sent( date("Y-m-d H:i:s"));
							$oMutuelle->save();						
						}

                        sendMailStatut($statut);
                    } else {
                        echo "Fichier trop gros";
                    }
                }
            }
        }
}


function add_js_scripts() {
	//wp_enqueue_script( 'script', get_template_directory_uri().'/js/script.js', array('jquery'), '1.0', true );
	    wp_register_script( 'script',  plugins_url( '/js/script.js' , __FILE__ ), array('jquery') );
    wp_enqueue_script( 'script' );
	
	
	//wp_enqueue_script( 'script',);

	
	// pass Ajax Url to script.js
	wp_localize_script('script', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}
add_action('wp_enqueue_scripts', 'add_js_scripts');


/*
Add option pharmacist in backoffice
*/

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

	<h3><?php echo __('Pharmacist' , 'SternUPAC'); ?></h3>

	<table class="form-table">

		<tr>
			<th><label for="pharmacist"><?php echo __('Pharmacist' , 'SternUPAC'); ?></label></th>

			<td>
				
				<input type="checkbox" id="pharmacist" name="pharmacist" <?php if(esc_attr( get_the_author_meta( 'pharmacist', $user->ID ) )) {echo "checked";} else {echo"";} ?> /><br />
				
				<?php 
				echo esc_attr( get_the_author_meta( 'pharmacist', $user->ID ) );
				?>
			</td>
		</tr>

	</table>
<?php }


add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	/* Copy and paste this line for additional fields. Make sure to change 'pharmacist' to the field ID. */
	update_usermeta( $user_id, 'pharmacist', $_POST['pharmacist'] );
}













/*

add_action( 'wp_ajax_mon_action', 'mon_action' );
add_action( 'wp_ajax_nopriv_mon_action', 'mon_action' );

function mon_action() {

	$param = $_POST['param'];

	echo $param;

	die();
}

*/


// Exclude products from a particular category on the shop page
add_action( 'pre_get_posts', 'custom_pre_get_posts_query' );

function custom_pre_get_posts_query( $q ) {

	if ( ! $q->is_main_query() ) return;
	if ( ! $q->is_post_type_archive() ) return;
	
	if ( ! is_admin() && is_shop() ) {

		$q->set( 'tax_query', array(array(
			'taxonomy' => 'product_cat',
			'field' => 'slug',
			'terms' => array( 'ordonnance check out' ), // Don't display products in the knives category on the shop page
			'operator' => 'NOT IN'
		)));
	
	}

	remove_action( 'pre_get_posts', 'custom_pre_get_posts_query' );

}









function login_redirect() {

    // Current Page
    global $pagenow;

    // Check to see if user in not logged in and not on the login page
    if(!is_user_logged_in() && $pagenow != 'wp-login.php')
	{
          // If user is, Redirect to Login form.
          auth_redirect();
	//	  wp_redirect( 'http://www.pharmacie-silvie.com/my-account/' ); 
	}
}
// add the block of code above to the WordPress template
//add_action( 'wp', 'login_redirect' );


function downloadFile($file)
{

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
}

//$jpg_image = imagecreatefromjpeg('http://upload.wikimedia.org/wikipedia/commons/e/e4/Color-blue.JPG');

function exportPDF($oPrescription)
{
			
		$target_repository = $oPrescription->getTarget_repository();
		$name_file = $oPrescription->getName_file();

		$fileUrl 		= plugin_dir_url( __FILE__ ). $target_repository.$name_file;
		$fileAbsolute 	= plugin_dir_path( __FILE__ ).$target_repository.$name_file;
		$targetFullFile = plugin_dir_path( __FILE__ ).$target_repository.'FULL_'.$name_file;

		echo "<pre>";
			var_dump($fileUrl);
			echo "</pre>";
			
		echo "<pre>";
			var_dump($fileAbsolute);
			echo "</pre>";	

		echo "<pre>";
			var_dump($targetFullFile);
			echo "</pre>";		
		$file = $fileAbsolute;

			
	//	$im1 = imagecreatefromjpeg($file) ;
		
		
// On charge d'abord les images
$prescriptionImage = imagecreatefromjpeg($file); // Le logo est la prescriptionImage


$largeur_prescriptionImage = imagesx($prescriptionImage);
$hauteur_prescriptionImage = imagesy($prescriptionImage);
$largeur_whiteBackgroundImage = imagesx($whiteBackgroundImage);
$hauteur_whiteBackgroundImage = imagesy($whiteBackgroundImage);

$whiteBackgroundImage =  imagecreatetruecolor($largeur_prescriptionImage + 1200, $hauteur_prescriptionImage); // La photo est la whiteBackgroundImage
imagecolorallocate($whiteBackgroundImage, 255, 255, 255);

$textImage = imagecreatetruecolor($largeur_prescriptionImage, $hauteur_prescriptionImage); 
imagecolorallocate($textImage, 125, 125, 125);
$text_color = imagecolorallocate($textImage, 233, 14, 91);
imagestring($textImage, 1, 5, 5,  'Une simple chaîne de texte', $text_color);

// On veut placer le logo en bas à droite, on calcule les coordonnées où on doit placer le logo sur la photo
//$whiteBackgroundImage_x = $largeur_whiteBackgroundImage - $largeur_prescriptionImage;
$whiteBackgroundImage_x = 0;
$whiteBackgroundImage_y =  0;



// On met le logo (prescriptionImage) dans l'image de whiteBackgroundImage (la photo)
imagecopymerge($whiteBackgroundImage, $prescriptionImage, $whiteBackgroundImage_x, $whiteBackgroundImage_y, 0, 0, $largeur_prescriptionImage, $hauteur_prescriptionImage, 100);
//imagecopy( $whiteBackgroundImage, $prescriptionImage, 10, 10, 0, 0, 200, 200 );

$whiteBackgroundImage_x = $largeur_prescriptionImage;
$whiteBackgroundImage_y =  0;

imagecopymerge($whiteBackgroundImage, $textImage, $whiteBackgroundImage_x, $whiteBackgroundImage_y, 0, 0, $largeur_prescriptionImage, $hauteur_prescriptionImage, 100);
//imagecopy( $whiteBackgroundImage, $prescriptionImage, 10, 10, 0, 0, 200, 200 );

$im = $whiteBackgroundImage;
		
		//list($width1, $height1, $type1, $attr1) = getimagesize($file);
		//$im0 = imagecreate(800, 800);
		//$im1 = imagecreatefromjpeg($file) ;
		//$im2 = imagecreate(1400,30);
		//$im0 = imagecreate(400, 700);
		//Create Image 1
		
		
		// Create second image same size as the first one.
		//$im2 = imagecreate($width1, $height1);
		
		// White background and blue text
		//imagecolorallocate($im0, 255, 255, 255);
		//imagecolorallocate($im0, 255, 255, 255);
		//$textcolor = imagecolorallocate($im2, 0, 0, 255);
		// Write the string at the top left
		//imagestring($im1, 0, 0, 0, 'alan '.$width1. ' '. $height1, $textcolor);
		
		//merge
		//imagecopymerge($im0,$im1, 0, 0, 0, 0, $width1, $height1, 100);
		//imagecopy($img1,$img0,0, 0, $width1, $height1,1500, 1500);
		
		// Create a 100*30 image
		//$im = imagecreate(1400, 30);




	
		

		//$im = resizeImage($file,2);
		// Output the image
		header('Content-type: image/png');

		imagejpeg($im, $targetFullFile );
		imagedestroy($im);

		downloadFile($targetFullFile);

}

function resizeImage($filename,$percent)
{
// File and new size
//$filename = 'test.jpg';
//$percent = 0.5;

// Content type
header('Content-Type: image/jpeg');

// Get new sizes
list($width, $height) = getimagesize($filename);
$newwidth = $width * $percent;
$newheight = $height * $percent;

// Load
$thumb = imagecreatetruecolor($newwidth, $newheight);
$prescriptionImage = imagecreatefromjpeg($filename);

// Resize
imagecopyresized($thumb, $prescriptionImage, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

// Output
return $thumb;

}

/*
		$filterWhereArray = array (
		'post_type' => 'SternUploadAndCollect',
		'post_author' => $idUser,
		'ID' => $idPrescription,
		'meta_query' => array (
							array ( 
								'key' => 'statut_order',
								'value' => array( 1,2,3, 4,5,50 ),
								'compare' => 'IN'
							) ,
							array ( 
								'key' => 'typeDocument',
								'value' => 'prescription'
							)
						)									
		);
		
	*/	
function pagination($range,$paged,$pages,$the_query)
{
	$showitems = ($range * 2)+1;  

	global $paged;
	if(empty($paged)) $paged = 1;

	if($pages == '')
	{		 
		 $pages = $the_query->max_num_pages;
		 if(!$pages)
		 {
			 $pages = 1;
		 }
	}   
	


	if(1 != $pages)
	{
	 echo "<div class=\"pagination\"><span>Page ".$paged." sur ".$pages." </span>";
	 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; Premier</a> ";
	 if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Précédent</a> ";

	 for ($i=1; $i <= $pages; $i++)
	 {
		 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
		 {
			 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
		 }
	 }

	 if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">". __('Suivant' , 'SternUPAC')." &rsaquo;</a> ";  
	 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>".  __('Dernier' , 'SternUPAC')." &raquo;</a> ";
	 echo "</div>\n";
	}
}
	
/* XL */
Function getDocumentWhereArray($typeDocument=NULL, $array_Users_IDs=NULL,$arrayStatut_order_value=null,$woo_order_id=NULL,$posts_per_page=5 , $Pid=NULL) {
		$filterWhereArray = array (
			'post_type' => 'sternupac',
			'meta_key' => 'date_file_sent',
			'orderby' => 'meta_value',
			'order'   => 'DESC',
		);
		
		global $paged;
		$curpage = $paged ? $paged : 1;
		
		$filterWhereArray['posts_per_page'] = $posts_per_page;
		$filterWhereArray['paged'] = $paged;
		
		if($Pid!=NULL) {
			$filterWhereArray['p'] = $Pid;
		}
		/*
		echo "<pre>";
    var_dump($filterWhereArray);
    echo "</pre>";
*/
		/*
ALAN must be done		
		if($user_id!=NULL) {
			$filterWhereArray['post_author'] = $user_id;
		}
		*/
		
		$metaQueryArray = array();
		
		if($arrayStatut_order_value!=NULL) {
			$arrayStatut_order = array (
				'key' => 'statut_order',
				'value' => $arrayStatut_order_value,
				'compare' => 'IN'
			);
			$metaQueryArray[] = $arrayStatut_order ;
		}
		/*
		if($array_Users_IDs!=NULL) {
			$arrayPost_author_meta = array (
				'key' => 'post_author_meta',
				'value' => $array_Users_IDs,
				'compare' => 'IN'
			);
			$metaQueryArray[] = $arrayPost_author_meta ;
		}
		*/
		
		if($array_Users_IDs!=NULL) {
			$arrayUser_id = array (
				'key' => 'user_id',
				'value' => $array_Users_IDs,
				'compare' => 'IN'
			);
			$metaQueryArray[] = $arrayUser_id ;
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

		return $filterWhereArray;

}

/* doit etre dépracé */	
function getMutuelleWhereArray($user_id) {
		$arrayStatut_order_value = array( 50 );
		$typeDocument = 'mutuelle';
		$metaQueryArray = array();
		$filterWhereArray = array();		
		
		$arrayStatut_order = array ( 
				'key' => 'statut_order',
				'value' => $arrayStatut_order_value,
				'compare' => 'IN'
			);
		$metaQueryArray[] = $arrayStatut_order ;	
			
		$arrayTypeDocument = array ( 
				'key' => 'typeDocument',
				'value' => $typeDocument
			);
		$metaQueryArray[] = $arrayTypeDocument ;
		

		$filterWhereArray['post_type'] = 'sternupac';	
		$filterWhereArray['post_author'] = $user_id;	
		$filterWhereArray['meta_query'] = $metaQueryArray;
		
		return $filterWhereArray;
		
}
/* must be deprecated by getDocumentWhereArray*/
function getArrayMutuelle($user_id,$arrayStatus=NULL){	


	
			$filterWhereArray = getDocumentWhereArray('mutuelle', array($user_id), $arrayStatus,NULL ,100);
			$orderByArray = getOrderByArray();
			$arrayDoc = PrescriptionRepository::getMutuelleSearch($filterWhereArray, $orderByArray );
			return $arrayDoc;
}

/* must be deprecated by getDocumentWhereArray*/
function getObjectsMutuelle($user_id){		
		//	$filterWhereArray = getMutuelleWhereArray($user_id);		
			$filterWhereArray = getDocumentWhereArray('mutuelle', array($user_id), array(50),NULL );
			$orderByArray = getOrderByArray();
			$arrayDoc = PrescriptionRepository::getMutuelleSearch($filterWhereArray, $orderByArray );
			return $arrayDoc;
}


/* must be deprecated by getDocumentWhereArray*/
function getObjectsMutuelleAdmin(){	
			$filterWhereArray = getDocumentWhereArray('mutuelle', NULL, NULL,NULL );
			$orderByArray = getOrderByArray();
			

			$arrayDoc = PrescriptionRepository::getMutuelleSearch($filterWhereArray, $orderByArray );
			return $arrayDoc;
}

/*
function getFilterWhereArray($atts,$typeFunction) {
	if($typeFunction == 'showSingle') {
		$idPrescription = getIdInShortcode($atts);
		$type_user = getTypeUser($atts);
		$user_id = get_current_user_id();

		$filterWhereArray = array (
		'post_type' => 'sternuapc',
		'post_author' => $idUser,
		'ID' => $idPrescription,
		'id' => $idPrescription,
		'post_id' => $idPrescription,
		'meta_query' => array (
							array ( 
								'key' => 'statut_order',
								'value' => array( 1,2,3,4,5,50 ),
								'compare' => 'IN'
							) ,
							array ( 
								'key' => 'typeDocument',
								'value' => 'prescription'
							)
						)									
		);						
		if ($type_user != "admin") {
			$filterWhereArray['post_author'] = $user_id ;
		}
	return $filterWhereArray;
	}
}
*/

function getOrderByArray($orderBy='DESC') {
	if($orderBy == 'DESC') {
		$orderByArray = array (
				'date_file_sent' => 'DESC'
		);
	}
return $orderByArray;
}
	




function getTypeDocument($atts)
{
    $a = shortcode_atts( array(
        'type_document' => 'prescription'
    ), $atts );
    $type_document = $a['type_document'];

    return $type_document;
}


function getTypeUser($atts)
{
    $a = shortcode_atts( array(
        'type_user' => 'cust',
        'show_search' => 0,
    ), $atts );
    $type_user_shortcode = $a['type_user'];
    return $type_user_shortcode;
}

function getStatutInShortcode($atts)
{
    $a = shortcode_atts( array(
        'statut_shortcode' => NULL
    ), $atts );
    $statut_shortcode = $a['statut_shortcode'];
    return $statut_shortcode;
}

function getIdInShortcode($atts)
{
    $a = shortcode_atts( array(
        'id' => NULL
    ), $atts );
    $id = $a['id'];
    return $id;
}





function arrayStatutAction($statut)
{
    $arrayStatutAction = array(
        '0' => 'Supprimée',
        '1' => 'Prescription received',
        '2' => 'Préparer',
        '3' => 'Terminer preparation',
        '4' => 'Ordonnance récupérée et payée',
		'5' => 'Préparation patielle terminée',
		'10' => 'Valider Mutuelle',
		'50' => 'Commande en cours de validation'
		
    );
    Return $arrayStatutAction[$statut];
}



function sendMailStatut($Statut , $PersoString="")
{
    $boolSend = get_option('SendEmail');
    if ($boolSend == 1) {
        $multiple_recipients = array(
            get_option('EmailBusiness')
        );

        $ContentEmail = esc_attr( get_option('ContentEmail') );
        $subj = 'The email subject :'. $Statut;
        $body = 'This is the body of the email' . $ContentEmail . ' Statut : ' . $Statut. '  ' . $PersoString;
        wp_mail( $multiple_recipients, $subj, $body );
    }
}






// http://www.sitepoint.com/build-your-own-wordpress-contact-form-plugin-in-5-minutes/

function customUserFields() {


}










add_action('admin_menu', 'Stern_Upload_And_Collect_setup_menu');

function Stern_Upload_And_Collect_setup_menu(){
    add_menu_page( 'Stern Upload And Collect', 'Stern Upload And Collect', 'edit_posts', 'Stern-Upload-And-Collect-Options', 'Stern_Upload_And_Collect_init_back_office' );
    add_submenu_page('Stern-Upload-And-Collect-Options', 'Options', 'Options', 'edit_posts' , 'Stern-Upload-And-Collect-settings', 'Stern_Upload_And_Collect_options');

    //call register settings function
    add_action( 'admin_init', 'register_mysettings' );

}

function register_mysettings() {
    //register our settings
    register_setting( 'Stern-Upload-And-Collect-group', 'SendEmail' );
    register_setting( 'Stern-Upload-And-Collect-group', 'ContentEmail' );
    register_setting( 'Stern-Upload-And-Collect-group', 'EmailBusiness' );
    register_setting( 'Stern-Upload-And-Collect-group', 'some_other_option' );
    register_setting( 'Stern-Upload-And-Collect-group', 'option_etc' );
	register_setting( 'Stern-Upload-And-Collect-group', 'idProductPrescription' );
	register_setting( 'Stern-Upload-And-Collect-group', 'idProductCheckout' );
	
	register_setting( 'Stern-Upload-And-Collect-group', 'idPageMyPrescriptions' );
	register_setting( 'Stern-Upload-And-Collect-group', 'idPageNewPrescription' );
	register_setting( 'Stern-Upload-And-Collect-group', 'idPageAdminPrescriptions' );
	register_setting( 'Stern-Upload-And-Collect-group', 'idPageAdminMutuelle' );
	register_setting( 'Stern-Upload-And-Collect-group', 'isRenewableOtpion' );

	
	
}





function installCreateContent($post_content,$post_type,$user_id,$post_title,$nameOptionToUpdate,$visibility)
{
	
	$post = array(
		 'post_author' => $user_id,
		 'post_content' => $post_content,
		 'post_status' => 'publish',
		 'post_title' => $post_title ,
		 'post_parent' => '',
		 'post_type' => $post_type,
		 );
		 $post_id = wp_insert_post( $post, $wp_error );
		 
		if($post_id){
			update_option($nameOptionToUpdate,$post_id );
			update_post_meta( $post_id, '_visibility', $visibility );
		
		/*
			$attach_id = get_post_meta($product->parent_id, "_thumbnail_id", true);
			add_post_meta($post_id, '_thumbnail_id', $attach_id);
		*/
		}
		
		return $post_id ;
}

function createPagesInstall() {
	$user_id = get_current_user_id();
	$post_type = 'page';
	$visibility = 'visible';
	
	$post_title = 'My Prescriptions';
	$post_content = '[Stern_Upload_And_Collect_dashboard type_user="cust"]';	
	$nameOptionToUpdate = 'idPageMyPrescriptions';	
	$post_id = installCreateContent($post_content,$post_type,$user_id,$post_title,$nameOptionToUpdate,$visibility);
	
	$post_title = 'New prescription';
	$post_content = '[showPrescriptionsSummaryToggle]';	
	$nameOptionToUpdate = 'idPageNewPrescription';	
	$post_id = installCreateContent($post_content,$post_type,$user_id,$post_title,$nameOptionToUpdate,$visibility);
	

	$post_title = 'Admin Prescriptions';
	$post_content = '[showPrescriptionsListAdmin]';	
	$nameOptionToUpdate = 'idPageAdminPrescriptions';	
	$post_id = installCreateContent($post_content,$post_type,$user_id,$post_title,$nameOptionToUpdate,$visibility);
	
	$post_title = 'Admin mutuelles';
	$post_content = '[showMutuelleAdminShortcode]';	
	$nameOptionToUpdate = 'idPageAdminMutuelle';	
	$post_id = installCreateContent($post_content,$post_type,$user_id,$post_title,$nameOptionToUpdate,$visibility);
	

}


function uploadPicture($filename,$new_post_id) {		
		
		/* upload image */
			//add product image:
		//require_once 'inc/add_pic.php';
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		$thumb_url = $filename;

		// Download file to temp location
		$tmp = download_url( $thumb_url );

		// Set variables for storage
		// fix file name for query strings
		preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $thumb_url, $matches);
		$file_array['name'] = basename($matches[0]);
		$file_array['tmp_name'] = $tmp;

		// If error storing temporarily, unlink
		if ( is_wp_error( $tmp ) ) {
		@unlink($file_array['tmp_name']);
		$file_array['tmp_name'] = '';
		$logtxt .= "Error: download_url error - $tmp\n";
		}else{
		$logtxt .= "download_url: $tmp\n";
		}

		//use media_handle_sideload to upload img:
		$thumbid = media_handle_sideload( $file_array, $new_post_id, 'gallery desc' );
		// If error storing permanently, unlink
		if ( is_wp_error($thumbid) ) {
		@unlink($file_array['tmp_name']);
		//return $thumbid;
		$logtxt .= "Error: media_handle_sideload error - $thumbid\n";
		}else{
		$logtxt .= "ThumbID: $thumbid\n";
		}

		set_post_thumbnail($new_post_id, $thumbid);

		/* upload image */

}

function createProducts() {
	
	//Create prouct ProductPrescription
	$user_id = get_current_user_id();
	$post_content = '';
	$post_type = 'product';
	$post_title = 'ProductPrescription';
	$nameOptionToUpdate = 'idProductPrescription';
	$visibility = 'visible';
	$post_id = installCreateContent($post_content,$post_type,$user_id,$post_title,$nameOptionToUpdate,$visibility );
	if($post_id){
		update_post_meta( $post_id, '_product_url', get_permalink( esc_attr( get_option('idPageNewPrescription') ) ) );
		update_post_meta( $post_id, '_button_text', 'Go' );
		wp_set_object_terms( $post_id, 'external', 'product_type' );
		
		$filename =  plugin_dir_url( __FILE__ ) .'/img/ordo.png';		
		uploadPicture($filename,$post_id); 
	
	}
	

	//Create prouct ProductCheckout
	$user_id = get_current_user_id();
	$post_content = '';
	$post_type = 'product';
	$post_title = 'ProductCheckout';
	$nameOptionToUpdate = 'idProductCheckout';
	$visibility = 'hidden';
	$post_id = installCreateContent($post_content,$post_type,$user_id,$post_title,$nameOptionToUpdate,$visibility );
	if($post_id){
	//	update_option('idProductCheckout',$post_id );
	//	wp_set_object_terms( $post_id, 'ordonnance Checkout', 'product_cat' );
		update_post_meta( $post_id, '_regular_price', '0' );
		update_post_meta( $post_id, '_price', '0' );
	//	update_post_meta( $post_id, '_visibility', 'hidden' );
		$filename =  plugin_dir_url( __FILE__ ) .'/img/ordo.png';		
		uploadPicture($filename,$post_id); 
		
	}
     
}


function Stern_Upload_And_Collect_init_back_office(){
    echo "<h1>Stern Upload And Collect</h1>";
    //echo do_shortcode('[Stern_Upload_And_Collect_dashboard type_user="admin"]');
	if (isset($_POST['createProductsInstall'])) { 		createProducts(); 	}
	if (isset($_POST['createPagesInstall'])) 	{ 		createPagesInstall(); 		}	
	new backOfficeInstallTemplate();	
}


function Stern_Upload_And_Collect_options() {
	if (isset($_POST['createProductsInstall'])) { 		createProducts(); 	}
	if (isset($_POST['createPagesInstall'])) 	{ 		createPagesInstall(); 		}
	
    new OptionBackOfficeTemplate();
}

/*
echo "<pre>";
    var_dump($query);
    echo "</pre>";
*/