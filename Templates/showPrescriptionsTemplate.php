<?php


Class showPrescriptionsTemplate{
    /**
     * @param $arrayPrescriptions
     */
    function __construct($arrayPrescriptions, $type_user){


		if (is_user_logged_in()){
			?>
			<table width="100%" class="table ">
				<thead>
					<?php 
					echo "<tr>";
						
						
						/*
							
					$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);				
					echo '<form action="' . 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0] . '?toggle=3" method="post">';
					
					*/
						
						?>						
						
						
						<form action="<?php echo  $_SERVER["REQUEST_URI"] ?>">
							<?php
							echo "<th>$type_user</th>";
							if(	$type_user== "admin") {
								echo "<th>";
								// Show search only if admin
								if(	$type_user== "admin") {
									$search = $_GET['q'];
									
									echo "<input type='text' id='searchtext' style='width:80px' name='user' value= '$search'>";
									
								}
								echo "User Name";
								echo "</th>";					
							}					
							
							echo "<th>See details</th>";
							echo "<th>Date File Sent</th>";
							echo "<th>Date Forecast</th>";
							echo "<th>note Cust</th>";
							echo "<th>note Pharm</th>";
							echo "<th>date start prep</th>";
							echo "<th>date finish prep</th>";
							echo "<th>date cust pick up</th>";
							echo "<th>Statut</th>";
							echo "<th>Order</th>";
							echo "<th>Actions</th>";
							echo "<th></th>";
						echo "</form>";						
					echo "</tr>";
					?>
				</thead>					 
				<tbody>
				<?php
				foreach( $arrayPrescriptions as $objetPrescription ) {
				
				
								
					
					
					//echo "<form enctype='multipart/form-data'  method='post'>";
						echo "<tr>";

	
									

									echo "<input type='hidden' name='target_repository' value='". $objetPrescription->getTarget_repository()." ' />";
									echo "<input type='hidden' name='name_file' value=' " .$objetPrescription->getName_file() . " ' />";
								
									$statut_order = $objetPrescription->getStatut_order();
									$user_id = $objetPrescription->getUser_id();
									$user_info = get_userdata($user_id);
									$first_name  = $user_info->first_name;
									$last_name  = $user_info->last_name;
									$user_name = $first_name . ' ' . $last_name  ;
									
									
									
									
									echo "<td>";
									$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);	
									echo '<form action="' . 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0] . '?toggle=2" method="post">';
									echo "<input type='hidden' name='hiddenId' value='". $objetPrescription->getId() . " ' />";
									?>								
										<input type="submit" name="Download" value="&#8682;"/>								
									<?php 
									echo "</form>";	
									echo "</td>";
																	
									

									
									if(	$type_user== "admin") {echo "<td>$user_name</td>";};
									$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);	
									
									$url = 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0] . '?idPrescription='. $objetPrescription->getId();
									echo "<td><a href='". $url ." '><button>Visit Google</button></a></td>";
									
									echo "<td>".$objetPrescription->getDate_file_sent()."</td>";									
									
									echo "<td>".$objetPrescription->getDate_forecast_cust_pick_up()."</td>";
									echo "<td>".$objetPrescription->getNoteCustToPharm()."</td>";

									echo "<td>";
										if ($statut_order == 2 and $type_user=="admin") { 							
											echo "<TEXTAREA rows='2' name='notePharmToCust'>" .$objetPrescription->getNotePharmToCust() ." </TEXTAREA>";
										} else {
										echo $objetPrescription->getNotePharmToCust();
										echo "<input type='hidden' name='notePharmToCust' value='".$objetPrescription->getNotePharmToCust ."'> ";
										}					
									echo "</td>";				
									
									echo "<td>". $objetPrescription->getDate_start_prep()."</td>";
									echo "<td>". $objetPrescription->getDate_finish_prep() ."</td>";
									echo "<td>". $objetPrescription->getDate_cust_pick_up() ."</td>";
									
									echo "<td>";
										echo arrayStatut($statut_order);
										//echo $arrayStatut['statut'.$statut_order];
									echo "</td>";
									$orderId = $objetPrescription->getWoo_order_id();
									if($orderId == NULL) {
										$hash = ""; 
									} else {
										$hash = "#";
									}
										echo "<td>" . $hash. "<a href='".  get_site_url() . "/my-account/view-order/". $orderId . "'/>" . $orderId ."</a></td>";
									
									$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);	
									echo '<form action="' . 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0] . '?toggle=2" method="post">';
									echo "<input type='hidden' name='hiddenId' value='". $objetPrescription->getId() . " ' />";
						//			$statut_order = $objetPrescription->statut_order;
									if ($type_user=="admin") {	
										if ($statut_order == 1) {	
											?>
											<td>
												<input type="submit" name="delete" value="X"/>    
											</td>					
											<td>
												<input type="submit" name="TaskStatut2" value="<?php echo arrayStatutAction(2); ?>"/>   
											</td>												
											<?php						
										} else if ($statut_order == 2) { 					
											?>							
											<td>
												<input type="submit" name="TaskStatut1" value="<"/>
											</td>					
											<td>
												<input type="submit" name="TaskStatut3" value="<?php echo arrayStatutAction(3); ?>"/> 
											</td>
											<?php						
										} else if ($statut_order == 3) {					
											?>
											<td>
												<input type="submit" name="TaskStatut2" value="<"/>
											</td>					
											<td>
												<input type="submit" name="TaskStatut4" value="<?php echo arrayStatutAction(4); ?>"/>
											</td>					
											<?php						
										} else if ($statut_order == 4) {					
											?>
											<td>
												<input type="submit" name="TaskStatut3" value="<"/>
											</td>
											<td>
											</td>
											<?php					
										}
									} else {
										if ($statut_order == 1) {
											?>
											<td>
												<input type="submit" name="delete" value="X"/>    
											</td>	
											<?php
											}
											?>
											<td>
											</td>
											<?php	
									}							
								
								echo "</form>";
						
						echo "</tr>";
					
				} 
				?>
				</tbody>
			</table>
			
			<hr>
			
			
			<?php
			
			
			$idPrescription = $_GET['idPrescription'];
				
				$user_id = get_current_user_id();				
				$arrayPrescriptions = PrescriptionRepository::getArrayPrescriptionsByIDAndUser($idPrescription,$user_id );	
		
				
				foreach( $arrayPrescriptions as $objetPrescription ) {	
								$orderId = $objetPrescription->getWoo_order_id();
								if($orderId == NULL) {
								$hash = ""; 
								} else {
								$hash = "#";
								}

								
				echo "<h3> Prescription".   $hash. "<a href='".  get_site_url() . "/my-account/view-order/". $orderId . "'/>" . $orderId ."</a>". " </h3>";
					//echo  $objetPrescription->getId();
					//echo  $objetPrescription->getTarget_repository();
					?>
					<table width="100%" class="table ">
						<thead>					 
							<tr>
								<th>
								hello
								</th>
								<th>
								ca va
								</th>								
	
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
								<?php echo __('Order ID' , 'SternUPAC'); ?>
								</td>
								<td>
								<?php
								echo  $hash. "<a href='".  get_site_url() . "/my-account/view-order/". $orderId . "'/>" . $orderId ."</a>";
								?>
								</td>
							</tr>
							<tr>
								<td>
								<?php echo __('File name' , 'SternUPAC'); ?>
								</td>
								<td>
								<?php echo $objetPrescription->getOriginal_name_file() ; ?>
								</td>
							</tr>
							<tr>
								<td>
								
								</td>
								<td>
								
								</td>
							</tr>
							<tr>
								<td>
								
								</td>
								<td>
								
								</td>	

								
							</tr>
						</tbody>
					</table>
							
							
					<?php
					echo "<div class='row'>";
						echo "<div class='one-third'>";
						
						echo "</div>";
						echo "<div class='one-third'>";
							echo $objetPrescription->getOriginal_name_file() ;
						echo "</div>";
						echo "<div class='one-third'>";
							echo $objetPrescription->getStatut_order() ;						
						echo "</div>";
					echo "</div>";
					echo "<div>";
						echo  $objetPrescription->getDate_start_prep();
					echo "</div>";
					echo "<div>";
						echo  $objetPrescription->getDate_finish_prep();
					echo "</div>";
					echo "<div>";
						echo  $objetPrescription->getDate_cust_pick_up();
					echo "</div>";
					echo "<div>";
						echo  $objetPrescription->getDate_start_prep();
					echo "</div>";

					

					
				


					
					}
			?>
			
	
	

			
					
		<?php
		} else {
			echo  __('You must be logged in.' , 'SternUPAC').' '; 
			?>
			<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login / Register','woothemes'); ?>"><?php _e('Login','woothemes'); ?></a>
			<?php		
		}
	}
}
				