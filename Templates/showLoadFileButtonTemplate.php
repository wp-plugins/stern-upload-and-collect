<?php

Class showLoadFileButtonTemplate{
	function __construct($typeDocument){

		if (is_user_logged_in()){	
				$toggle = 1;
				$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
				if($typeDocument == "prescription") {
					$toggle = 2;
				}
				if($typeDocument == "mutuelle") {
					$toggle = 4;
				}
				
				
			$new_query = add_query_arg( array('toggle' => $toggle) );
			echo '<form enctype="multipart/form-data" action="' . $new_query.'" method="post">';

			$urImgupload =  dirname (plugin_dir_url( __FILE__ )).'/img/Files-Upload-File-icon.png';
			
			?>		
				<img class=" size-medium wp-image-978 alignright" src="<?php echo $urImgupload; ?>" alt="Logo_caud3" width="110" height="110" />
				<input type="hidden" name="MAX_FILE_SIZE" value="1500000" />
				<input type="hidden" name="typeDocument" value="<?php echo $typeDocument ?>" />
				<?php
				
				
						
			
			
				echo '<br>';
				echo '<h4>';
					echo __('Send your' , 'SternUPAC'). $typeDocument ;
				echo '</h4>';
				echo "<br>". __('Upload your prescription. File size is maximum 800 Ko.' , 'SternUPAC')."<br>";
	//			echo "<input type='file' name='myfile' />";
				
				?>
				<!-- <input id="uploadFile" placeholder="Choose File" disabled="disabled" /> -->
				<div class="fileUpload btn btn-primary">
					
					<input id="myfile" type="file" name="myfile" class="upload" />
				</div>
				
				<br>
								
				<?php
				

				if($typeDocument == "prescription") {
					echo '<br><p>';				
				//	echo '<TEXTAREA rows="5" name="noteCustToPharm">'. __('Vos commentaires' , 'SternUPAC') . '</TEXTAREA>';
					
					?>
					<div class="form-group">
					  <label for="comment"><?php _e('Your comments' , 'SternUPAC'); ?></label>
					  <textarea name="noteCustToPharm" class="form-control" rows="5" id="comment"></textarea>
					</div>
					<?php
					
					echo '</p>';
					
					if( esc_attr( get_option('isRenewableOtpion') )==true) {
						echo '<p>';	
						echo '<input type="checkbox"  id="renewable" name="renewable" >'. __('Renewable?' , 'SternUPAC') . '<br>';
						echo '</p>';
					}
					
					
					
					?>
					


					<div id="active_sub" style="display:none">
						<p><span>Renouvellements : </span><br>
						<label><input type="number" name="quantity" min="1" max="6"><?php _e( 'Renewed every', 'SternUPAC' ) ?></label>
						<label>
							<input list="frequencies" name="frequency">
							<datalist id="frequencies">
							  <option value="Semaines">
							  <option value="Mois">
							  <option value="2 Mois">
							  <option value="6 Mois">
							</datalist>
						</label>
					</div>
					
		
					
					<?php
			/*		
			
					echo '<p>';
					echo 'Heure prévue de récupération : ';
					$dateEstimatedPickedUp = date("Y-m-d") ;
					$timeEstimatedPickedUp = date("H:i", strtotime("+20 minutes" )) ;

					echo '<input type="date" name="dateEstimatedPickedUp" pattern="[a-zA-Z0-9 ]+" value="' . $dateEstimatedPickedUp . '" size="40" />';
					echo '<input type="time" name="timeEstimatedPickedUp" pattern="[a-zA-Z0-9 ]+" value="' . $timeEstimatedPickedUp . '" size="40" />';
					echo '</p>';
					
					*/
					
				}
				?>
				
				<input type="submit" name="loadFileButton" class="upload" />
				
				
			</form>
			<?php
		} else {
			echo  __('You must be logged in. ' , 'SternUPAC'); 
			?>
			<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login / Register','woothemes'); ?>"><?php _e('Login','woothemes'); ?></a>
			<?php		
		}
	}
/*
echo "<pre>";
var_dump($social_security_number);
echo "</pre>";
*/
}