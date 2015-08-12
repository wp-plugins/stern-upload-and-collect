<?php

Class showPrescriptionsSummaryToggle{
    function __construct()
    {
		if (is_user_logged_in()){
			
			if(isset($_GET['toggle']) ) {
				$toggle = $_GET['toggle'];
			} else {
				$toggle=1;
			}
			if($toggle==NULL) { $toggle=1;}
			$user_id = get_current_user_id();        	
			
			
			?>
			

			<div class="yourcustomclass">
				<ul class="nav nav-tabs" id="oscitas-tabs-0">
					<li class="<?php if($toggle==1) {echo "active";} ?>">
						<a class="" href="#pane-0-0" data-toggle="tab"><?php _e('1. Load Prescription' , 'SternUPAC'); ?></a>
					</li>
					<li class="<?php if($toggle==2) {echo "active";} ?>">
						<a class="" href="#pane-0-1" data-toggle="tab"><?php _e('2. Prescriptions list' , 'SternUPAC'); ?></a>
					</li>
					<li class="<?php if($toggle==3) {echo "active";} ?>">
						<a class="" href="#pane-0-2" data-toggle="tab"><?php _e('3. Client Information' , 'SternUPAC'); ?></a>
					</li>
					<li class="<?php if($toggle==4) {echo "active";} ?>">
						<a class="" href="#pane-0-3" data-toggle="tab"><?php _e('4. Other document to be attached ' , 'SternUPAC'); ?></a>
					</li>
					<li class="<?php if($toggle==5) {echo "active";} ?>">
						<a class="" href="#pane-0-4" data-toggle="tab"><?php _e('5. Add to cart' , 'SternUPAC'); ?></a>
					</li>					
				</ul>
				<div class="tab-content">
					<div class="tab-pane <?php if($toggle==1) {echo "active";} ?>" id="pane-0-0">
						<?php echo do_shortcode( '[Stern_Upload_And_Collect_upload_button type_document="prescription"]' ) ?>	
					</div>
					<div class="tab-pane <?php if($toggle==2) {echo "active";} ?>" id="pane-0-1">
						<br>
						<?php echo do_shortcode( '[Stern_Upload_And_Collect_dashboard type_user="cust" statut_shortcode="50"]' ) ?>	
						<br>

					</div>
					<div class="tab-pane <?php if($toggle==3) {echo "active";} ?>" id="pane-0-2">
						
						<?php echo do_shortcode( '[sitepoint_contact_form]' ) ?>	
						
					</div>
					<div class="tab-pane <?php if($toggle==4) {echo "active";} ?>" id="pane-0-3">
						<?php echo do_shortcode( '[Stern_Upload_And_Collect_upload_button type_document="mutuelle"]' ) ?>	
						<?php echo do_shortcode( '[showMutuelle_shortcode]' ) ?>		
					</div>
					<div class="tab-pane <?php if($toggle==5) {echo "active";} ?>" id="pane-0-4">
					<br>

							
					<?php
					echo '<p>';
						$user_firstname = get_the_author_meta( 'user_firstname',get_current_user_id() );
						$user_lastname = get_the_author_meta( 'user_lastname',get_current_user_id() );
						echo "Patient : ";
						echo $user_firstname . ' '. $user_lastname;
					echo '</p>';					
					echo '<p>';
						echo _e('Pending prescriptions:' , 'SternUPAC'); 
						echo ' ';
						$status = array(50);
						$nbPendingPrescriptions = (int)PrescriptionRepository::getCountPrescritpionbyStatusAndTypeDocument($status ,"prescription");
						echo $nbPendingPrescriptions ;
					echo '</p>';
					echo '<p>';
						echo _e('Other document loaded: ' , 'SternUPAC'); 
						$status = array(50,10);
						echo PrescriptionRepository::getCountPrescritpionbyStatusAndTypeDocument($status,"mutuelle");
					echo '</p>';					
					
//					global $woocommerce;
//					$cart_url = $woocommerce->cart->get_cart_url();	
					$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
					$idProductCheckout = get_option('idProductCheckout');
					$urlChartPrescription = $shop_page_url."?add-to-cart=".$idProductCheckout;
					if($nbPendingPrescriptions >0 ) {
						echo "<a href='".$urlChartPrescription." '><button><span class='glyphicon glyphicon-shopping-cart' aria-hidden='true'></span>". _e("Add to cart" , "SternUPAC")."</button></a>";
					} else {
					echo __('Please load at least 1 prescription.', 'SternUPAC');
					}


					
					?>
					
								
					</div>					
						
				</div>
			</div>
						
			<?php
			

						
		} else {
			echo  __('You must be logged in. ' , 'SternUPAC'); 
			?>
			<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login / Register','woothemes'); ?>"><?php _e('Login','woothemes'); ?></a>
			<?php		
		}        
    }
}

/*
echo "<pre>";
var_dump($social_security_number);
echo "</pre>";
*/