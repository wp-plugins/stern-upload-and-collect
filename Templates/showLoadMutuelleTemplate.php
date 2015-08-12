<?php

Class showLoadMutuelleTemplate{
	function __construct(){

		if (is_user_logged_in()){					
			$toggle = 4;
				
				
				
			$new_query = add_query_arg( array('toggle' => $toggle) );
			echo '<form enctype="multipart/form-data" action="' . $new_query.'" method="post">';

			
			
			?>		
				<input type="hidden" name="MAX_FILE_SIZE" value="800000" />
				<input type="hidden" name="typeDocument" value="mutuelle" />
				<?php
				echo __('Send your document.' , 'SternUPAC');
				echo "<br>Max 800Ko";
				echo "<input type='file' name='myfile' />";
				echo '<p>';				
				echo '<TEXTAREA rows="5" name="noteCustToPharm">'. __('Vos commentaires' , 'SternUPAC') . '</TEXTAREA>';
				echo '</p>';
					
				
				?>
				<input type="submit" name="loadFileButton" />
			</form>
			<?php
		} else {
			echo __('Sorry, you must be a pharmacist for this area.' , 'SternUPAC');
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