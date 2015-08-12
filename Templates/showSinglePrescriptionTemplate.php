<?php



Class showSinglePrescriptionTemplate{

    function __construct($oPrescription, $type_user){


		if (is_user_logged_in()){
				$toggle = $_GET['toggle'];
				$new_query = add_query_arg( array('toggle' => 2) );
				$user_id = get_current_user_id();				
				//$arrayPrescriptions = PrescriptionRepository::getArrayPrescriptionsByIDAndUser($idPrescription,$user_id );	
				$new_query_remove_single_post = add_query_arg( array(
							'idPrescription' => false,
							'toggle' => 2
						));
			$statut_order = $oPrescription->GetStatut_order() ;
			$url_remove_single_post = get_site_url().$new_query_remove_single_post;
			?>
			<table>
				<tr>
					<td>
					<?php
					echo "<a href='".$url_remove_single_post." '><button><span class='glyphicon glyphicon-eye-close' aria-hidden='true'></span></button></a>";	
					?>
					</td>
					<td>
					<?php
					echo "<h3>";
						echo "Ordonnance #";
						echo $oPrescription->getId();
						echo ' '.__('linked with order' , 'SternUPAC').' ';
						echo $oPrescription->getWoo_order_id_HTML();
					echo "</h3>";
					?>				
					</td>
				</tr>
				</tr>
			</table>
			<?php
			

			echo '<form action="' .$new_query.'" method="post">';
			?>

				<table width="50%" class="table ">
					<thead>					 
						<tr>
							<th>
													
							</th>
							<th>
							<?php
							echo $oPrescription->getWoo_order_id_HTML();
							?>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
							<?php _e('Patient' , 'SternUPAC'); ?>	
							
							
							</td>
							<td>
							<?php 
							$user_id = $oPrescription->getUser_id();
							$user_info = get_userdata($user_id);
							$first_name  = $user_info->first_name;
							$last_name  = $user_info->last_name;
							$user_name = $first_name . ' ' . $last_name ;
							echo $user_name;		
							?>
							</td>
						</tr>						
						<tr>
							<td>
							<?php _e('Nom du fichier' , 'SternUPAC'); ?>	
							
							</td>
							<td>
							<?php echo $oPrescription->getOriginal_name_file() ; ?>							
							</td>
						</tr>
						<tr>
							<td>
							<?php _e('Download' , 'SternUPAC'); ?>	
							
							</td>
							<td>
								<?php 
								echo "<input type='hidden' name='hiddenId' value='".$oPrescription->getId(). " ' />";
								?>
								<button class='glyphicon glyphicon-cloud-download' name='Download' ></button>				
							</td>					
						</tr>
						<tr>
							<td>
							<?php _e('Download formatted' , 'SternUPAC'); ?>	
							
							</td>
							<td>							
								<button class='glyphicon glyphicon-cloud-download' name='ExportPDF' ></button>								
							</td>					
						</tr>						
						<tr>
							<td>
							<?php _e('Statut' , 'SternUPAC'); ?>	
							
							</td>
							<td>								
							<?php 
							
							echo PrescriptionRepository::getStatusLabel($statut_order);
							?>
							</td>
						</tr>
						<tr>
							<td>
							<?php _e('Mutuelles' , 'SternUPAC'); ?>	
							
							</td>
							<td>								
							<?php 
							$arrayStatus = NULL;
							$arrayStatus=array(10,50);
							$objectsMutuelle = getArrayMutuelle($user_id,$arrayStatus);
							$new_query = add_query_arg( array('toggle' => $toggle) );
							
							foreach ($objectsMutuelle as $oMutuelle) {
												//	echo '<form action="' . $new_query.'" method="post">';
												//	echo "<input type='hidden' name='hiddenId' value='".$oMutuelle->getid()."' />";
												//	echo '<input type="submit" name="Download'.$oMutuelle->getid().'" value="&#8682;"/>';
													$link = get_permalink( esc_attr( get_option('idPageAdminMutuelle') ) ).'?doc='.$oMutuelle->getid();
													
													echo '<button class="glyphicon glyphicon-cloud-download" name="Download'.$oMutuelle->getid().'" ></button>';
													echo '<a href="'.$link.'">'.PrescriptionRepository::getStatusLabel($oMutuelle->getStatut_order()).'</a>';
													echo '<br>';
													
												//	echo '</form>';
							}
							
							
							
							/*
							<button type="button" id = "12"> 
							  Cliquez ici 
							</button>
								*/							
								?>

							</td>
						</tr>						
						
						
						<tr>
							<td>
							<?php _e('Submission date' , 'SternUPAC'); ?>	
							
							</td>
							<td>
							<?php echo $oPrescription->getDate_file_sent() ; ?>
							</td>									
						</tr>
						<tr>
							<td>
							<?php _e('Start date of preparation' , 'SternUPAC'); ?>	
							
							</td>
							<td>
							<?php echo $oPrescription->getDate_start_prep() ; ?>
							</td>									
						</tr>
						<tr>
							<td>
							<?php _e('End date of preparation' , 'SternUPAC'); ?>	
							
							</td>
							<td>
							<?php echo $oPrescription->getDate_finish_prep() ; ?>
							</td>									
						</tr>
						<tr>
							<td>
							<?php _e('prepared by the pharmacist' , 'SternUPAC'); ?>	
							
							</td>
							<td>
							<?php 
							$user_id = $oPrescription->getUser_finish_prep_id();
							if($user_id!=NULL) {
								$user_info = get_userdata($user_id);
								$first_name  = $user_info->first_name;
								$last_name  = $user_info->last_name;
								$user_name = $first_name . ' ' . $last_name ;
								echo $user_name;
							}
							?>
							</td>									
						</tr>							
						<tr>
							<td>
							<?php _e('Receipt physically Date' , 'SternUPAC'); ?>	
							
							</td>
							<td>
							<?php echo $oPrescription->getDate_cust_pick_up() ; ?>
							</td>									
						</tr>
						<tr>
							<td>
							<?php _e('Date d"estimation de fin de la pr&eacute;paration' , 'SternUPAC'); ?>	
							
							</td>
							<td>
							<?php echo $oPrescription->getDate_forecast_cust_pick_up() ; ?>
							</td>									
						</tr>
						<tr>
							<td>
							<?php _e('Details' , 'SternUPAC'); ?>	
						
							</td>
							<td>
							<?php echo $oPrescription->getNoteCustToPharm() ; ?>
							</td>									
						</tr>
						<tr>
							<td>
							<?php _e('Pharmacist comment' , 'SternUPAC'); ?>	
							
							</td>
							<td>
								<?php								
								if ($statut_order == 2 and $type_user=="admin") {									
									echo "<TEXTAREA rows='2' name='notePharmToCust'>".$oPrescription->getNotePharmToCust()."</TEXTAREA>";
								} else {
								echo $oPrescription->getNotePharmToCust();
								}									
								?>
							</td>
						</tr>							
						<tr>
							<td>
							<?php _e('Price' , 'SternUPAC'); ?>	
							
							</td>
							<td>
								<?php								
								if ($statut_order == 2 and $type_user=="admin") {
									echo '<input type="number" step="any" name="price" value="'.$oPrescription->getPrice().'"/> €';
								} else {
									if ($oPrescription->getPrice() != '') {
										echo $oPrescription->getPrice(). " €";
									}
								}									
								?>
							</td>
						</tr>
					<?php 
					if($type_user=="admin") {
					?>
						<tr>
							<td>
							<?php _e('View admin order' , 'SternUPAC'); ?>	
							
							</td>
							<?php
							echo "<td>";
									$urlAdminOrder = get_site_url().'/wp-admin/post.php?post='.$oPrescription->getWoo_order_id().'&action=edit';
									echo "<a href='".$urlAdminOrder." ' target='_blank'><span class='glyphicon glyphicon-search' aria-hidden='true'></span></a>";							
							echo '</td>';
							?>
						</tr>
					<?php 
					}
					?>
					</tbody>
				</table>	
				<table width="30%">
					
						<tr>
							<?php
							new showButtonsInPrescriptionTemplate($oPrescription,$type_user);
												
							?>								
						</tr>
					
				</table>
			</form>
			<br><br>
		<?php		
		} else {
			echo  __('You must be logged in.' , 'SternUPAC').' '; 
			?>
			<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login / Register','woothemes'); ?>"><?php _e('Login','woothemes'); ?></a>
			<?php		
		}
	}
}				