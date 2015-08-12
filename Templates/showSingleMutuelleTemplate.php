<?php

Class ShowSingkeMutuelle_Template{
    function __construct($the_query)
    {
		if (is_user_logged_in()){
			$user_id = get_current_user_id();        	
			echo 'Mutuelle enregistrée : <br />';
			
			while($the_query->have_posts()) 
				{
					echo $the_query->the_post();
					
					
				$idRow  = get_the_id();
				if ($idRow!=NULL) { 
					$oMutuelle  = new Mutuelle($idRow);
				}
						
						
			
		//	foreach( $arrayPrescriptions as $oMutuelle ) {
				$toggle = 4; 
				$new_query = add_query_arg( array('toggle' => $toggle) );
				?>
			<table>
				<tr>				
					<td>
					<?php _e('Download' , 'SternUPAC'); ?>
					</td>
				<?php
					echo "<td>";
					echo '<form action="' . $new_query.'" method="post">';
						echo "<input type='hidden' name='hiddenId' value='". $oMutuelle->getid(). " ' />";
						echo '<input type="submit" name="Download" value="&#8682;"/>';
					echo '</form>';
					echo "</td>";
				?>
				</tr>
				<tr>
					<td>
					<?php _e('Delete' , 'SternUPAC'); ?>
					</td>				
				<?php	
					echo "<td>";
						echo '<form action="' . $new_query.'" method="post">';
							echo "<input type='hidden' name='hiddenId' value='". $oMutuelle->getid(). " ' />";					
							echo "<input type='submit' name='delete' value='X'/>";
						echo '</form>';					
					echo "</td>";
				?>
				</tr>
				<tr>
					<td>
					<?php _e('File name' , 'SternUPAC'); ?>
					</td>
					<td>					
					<?php echo $oMutuelle->getOriginal_name_file(); ?>
					</td>
				</tr>
				<tr>
					<td>
					<?php _e('End of validity' , 'SternUPAC'); ?>
					</td>
					<td>					
					<?php echo $oMutuelle->getDate_end_validity(); ?>
					</td>
				</tr>
				<tr>
					<td>
					<?php _e('Status' , 'SternUPAC'); ?>
					</td>
					<td>					
					<?php echo $oMutuelle->getStatut_order(); ?>
					</td>
				</tr>
				
			</table>
			<br><hr>
			<?php				
			}
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