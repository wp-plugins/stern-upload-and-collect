<?php



Class showSinglePictureTemplate{

    function __construct($oPrescription, $type_user){


		if (is_user_logged_in()){
				$new_query = add_query_arg( array('toggle' => 2) );
				$user_id = get_current_user_id();				
				//$arrayPrescriptions = PrescriptionRepository::getArrayPrescriptionsByIDAndUser($idPrescription,$user_id );	
		
		//	foreach( $arrayPrescriptions as $oPrescription ) {
				$statut_order = $oPrescription->GetStatut_order() ;
				echo "<h3>Prescription ";
					echo $oPrescription->getWoo_order_id_HTML();
				echo "</h3>";

				
				$target_repository = $oPrescription->getTarget_repository();
				$name_file = $oPrescription->getName_file();

				$file = dirname(plugin_dir_path( __FILE__ )). $target_repository.$name_file;

				
				//$file = dirname(plugin_dir_path( __FILE__ )).$target_repository.$name_file;
					?>
					<table width="50%" class="table ">
						<thead>					 
							<tr>
								<th>
								
								<?php 
								/*
								$contents = file_get_contents($file);
								header('Content-type: image/jpeg');
								echo $contents; 
								*/
								
$args = array(
	'width'         => 980,
	'height'        => 60,
	'default-image' => file_get_contents($file),
);
add_theme_support( 'custom-header', $args );	

							
								
								?>
							<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
								</th>
								<th>
								<?php
								echo $oPrescription->getWoo_order_id_HTML();
								?>
								</th>
							</tr>
						</thead>
						
					</table>	

					<?php
					
		//	}
					
		} else {
			echo  __('Vous devez vous enregistrer pour atteindre cet espace : ' , 'SternUPAC'); 
			?>
			<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login / Register','woothemes'); ?>"><?php _e('Login','woothemes'); ?></a>
			<?php		
		}
	}
}
				