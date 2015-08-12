<?php

Class ShowMutuelleList_Template{
    function __construct($the_query)
    {
		if (is_user_logged_in()){
			$user_id = get_current_user_id();        	
			echo 'Mutuelle enregistr&eacute;e : <br>';
			$toggle = 4; 
			$new_query = add_query_arg( array('toggle' => $toggle) );
			
			?>
			<table width="100%" class="table">
				<thead>
					<tr>				
						<th>
						<?php _e('Download' , 'SternUPAC'); ?>
						</th>
						<th>
						<?php _e('Delete' , 'SternUPAC'); ?>
						</th>
						<th>
						<?php _e('File Name' , 'SternUPAC'); ?>
						</th>
						<th>
						<?php _e('End of validity' , 'SternUPAC'); ?>
						</th>
						<th>
						<?php _e('Status' , 'SternUPAC'); ?>
						</th>
					</tr>
				</thead>
				<tbody>
			<?php
			
			while($the_query->have_posts()) 
			{
				echo $the_query->the_post();
				$idRow = get_the_id();
				if ($idRow!=NULL) { 				
					$oMutuelle = new Mutuelle(get_the_id());
				}
				
				
					
		//	foreach( $arrayPrescriptions as $oMutuelle ) {
			?>			
				
					<tr>
					
					<?php
						echo "<td>";
						echo '<form action="' . $new_query.'" method="post">';
							echo "<input type='hidden' name='hiddenId' value='".$oMutuelle->getid()."' />";
							echo '<input type="submit" name="Download" value="&#8682;"/>';
						echo '</form>';
						echo "</td>";
					?>

				
					<?php	
						echo "<td>";
							echo '<form action="' . $new_query.'" method="post">';
								echo "<input type='hidden' name='hiddenId' value='".$oMutuelle->getid()."' />";					
								echo "<input type='submit' name='delete' value='X'/>";
							echo '</form>';					
						echo "</td>";
					?>


						<td>					
						<?php echo $oMutuelle->getOriginal_name_file(); ?>
						</td>

						<td>					
						<?php echo $oMutuelle->getDate_end_validity(); ?>
						</td>				

						<td>					
						<?php echo PrescriptionRepository::getStatusLabel($oMutuelle->getStatut_order()); ?>
						</td>
					</tr>			
			<?php				
			}
			?>
				</tbody>				
			</table>
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