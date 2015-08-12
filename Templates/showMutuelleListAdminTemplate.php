<?php

Class showMutuelleListAdminTemplate{
    function __construct($the_query)
    {
		if (is_user_logged_in()){
			$user_id = get_current_user_id();        	
			echo 'Mutuelle enregistrée : <br>';
			$toggle = 4; 
			$new_query = add_query_arg( array('toggle' => $toggle) );
			$type_user="admin";

			
			if($type_user== "admin" ) {
				$new_query = add_query_arg( array('toggle' => 2) );
				echo "<form action=".$new_query." >";
				?>
				<input type="checkbox"  id="showSearchOptions" name="showSearchOptions" <?php if(isset($_GET["showSearchOptions"])) {echo "checked";} else {echo"";} ?>><?php _e('Search criteria' , 'SternUPAC'); ?><br>
				<div id="active_sub" style="<?php if(isset($_GET["showSearchOptions"])) {echo "";} else {echo"display:none";} ?>">
				<?php
									
						$allStatuts = PrescriptionRepository::getStatusLabel();
						foreach ($allStatuts as $statut_order => $statut_orderName)
						{
							?>
							<INPUT type="checkbox" name="seeCheckBoxStatut<?php echo $statut_order; ?>" <?php if(isset($_GET["seeCheckBoxStatut".$statut_order])) {echo "checked";} else {echo"";} ?>>
							<?php 
							echo $statut_orderName;				
						}
						?>
						<br>
						<table>
							<tr>
								<td>
									<?php
									$search = NULL;
									$doc = NULL;
									
									if(isset($_GET['user']) or isset($_GET['doc']) ) {
										$search = $_GET['user'];
										$doc = $_GET['doc'];
									}										
									echo 'Nom';
									echo "<input type='text' id='searchtext' style='width:80px' name='user' value='".$search."'>";
								echo '</td><td>';
									echo __('Order' , 'SternUPAC');
									echo "<input type='text' id='searchorder' style='width:80px' name='doc' value= '".$doc."'>";
									
									?>
								</td>
								<td>
									<input type="submit" value="Search"/>
								</td>
							</tr>
						</table>
					</div>						
				<?php
				echo '</form>';
				}
				
				
			
			?>
			<table width="100%" class="table">
				<thead>
					<tr>				
						<th>
						Télécharger
						</th>
						<th>
						Supprimer
						</th>
						<th>
						Auteur
						</th>						
						<th>
						Nom du fichier
						</th>
						<th>
						Fin de validité / status
						</th>
						<th>
						Audit
						</th>
					</tr>
				</thead>
				<tbody>
			<?php
			
			while($the_query->have_posts()) 
			{
				echo $the_query->the_post();
				$idRow  = get_the_id();
				if ($idRow!=NULL) { 
					$oMutuelle  = new Mutuelle($idRow);
				}
			
			
			//foreach( $arrayPrescriptions as $oMutuelle ) {
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
							<?php 
							$user_id = $oMutuelle->getUser_id();
							$user_firstname = get_the_author_meta( 'user_firstname',$user_id );
							$user_lastname = get_the_author_meta( 'user_lastname',$user_id );
							$fullName= $user_firstname . ' '. $user_lastname;
							echo $fullName;
							?>
						</td>
						
						<td>						
						<?php echo $oMutuelle->getOriginal_name_file(); ?>
						</td>						

						<td>
							<form method="post">
							<input type="hidden" name="hiddenId" value="<?php echo $oMutuelle->getid(); ?>" />	
								<table>									
									<tr>
										<td>
											 <input type="date" name="date_end_validity" value ="<?php echo $oMutuelle->getDate_end_validity(); ?>">
											
										</td>
										<td>
											
											<?php 
											$statut_order = $oMutuelle->getStatut_order();
											?>
											
											
											<select name="statut_order">
											  <option value="50" <?php if($statut_order==50) { echo 'selected';} ?>>En attente</option>
											  <option value="10" <?php if($statut_order==10) { echo 'selected';} ?>>Ok</option>
											  <option value="11" <?php if($statut_order==11) { echo 'selected';} ?>>Périmée</option>
											  <option value="0" <?php if($statut_order==0) { echo 'selected';} ?>>Supprimée</option>
											</select>


										</td>
										<td>
											<input type="submit" name="updateMutuelleAdminButton" value="Update">
										</td>										
									</tr>								
								</table>
							</form>			
						
						</td>	
						<td>
						Envoyé le
						<?php echo $oMutuelle->getDate_file_sent(); ?>						
						et MAJ le 
						<?php echo $oMutuelle->getDate_validate_mutuelle(); ?>
						par 						
						<?php
						$user_id_validate_mutuelle = $oMutuelle->getUser_id_validate_mutuelle();
						$user_firstname = get_the_author_meta( 'user_firstname',$user_id_validate_mutuelle );
						$user_lastname = get_the_author_meta( 'user_lastname',$user_id_validate_mutuelle );
						$fullName= $user_firstname . ' '. $user_lastname;
						echo $fullName;
						?>
						
						
						
						</td>						

				
					</tr>			
			<?php				
			}
			?>
				</tbody>				
			</table>
			<?php
			global $paged;
			$range ='';
			$pages = '';
			pagination($range,$paged,$pages,$the_query);			
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