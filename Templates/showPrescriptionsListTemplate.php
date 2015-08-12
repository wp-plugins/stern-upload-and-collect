<?php


Class showPrescriptionsListTemplate{

    function __construct($the_query , $type_user){
		if (is_user_logged_in()){
			if(isset($_GET['toggle']) ) {
				$toggle = $_GET['toggle'];
			}
			if (count($the_query->post_count) >0 or $type_user== "admin" )
			{
				if(isset($_GET['idPrescription'])){
					$idPrescription = $_GET['idPrescription'];				
					echo do_shortcode( '[showSinglePrescription id='. $idPrescription . ' type_user=' . $type_user .']' );
					echo '<hr>';
				}
				/*
				if(isset($_GET['showPicture'])){
					if($_GET['showPicture'] == 1 ) {
						echo do_shortcode( '[showSinglePicture id='. $idPrescription . ' type_user=' . $type_user .']' );
					}
				}
				*/
				
			if($type_user== "admin" ) {
				$new_query = add_query_arg( array('toggle' => 2) );
				echo "<form action=".$new_query." >";
				?>
				<input type="checkbox"  id="showSearchOptions" name="showSearchOptions" <?php if(isset($_GET["showSearchOptions"])) {echo "checked";} else {echo"";} ?>>
				<?php _e('Search Criteria' , 'SternUPAC'); ?><br>
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
									$order = NULL;
									
									if(isset($_GET['user']) or isset($_GET['order']) ) {
										$search = $_GET['user'];
										$order = $_GET['order'];
									}										
									echo __('Name' , 'SternUPAC');
									echo "<input type='text' id='searchtext' style='width:80px' name='user' value='".$search."'>";
								echo '</td><td>';
									echo __('Order' , 'SternUPAC');
									echo "<input type='text' id='searchorder' style='width:80px' name='order' value= '".$order."'>";
									
									?>
								</td>
								<td>
									<input type="submit" value="<?php _e('Search' , 'SternUPAC'); ?>"/>
								</td>
							</tr>
						</table>
					</div>						
				<?php
				echo '</form>';
				}
				?>		
					
				
				<table width="100%" class="table ">
					<thead>
						<?php 
						echo "<tr>";				
							
							if(	$type_user== "admin") {
								echo "<th>";																		
									echo  __('Name' , 'SternUPAC');
								echo "</th>";
								echo "<th>";
									echo "#Order Id";
								echo "</th>";
							}					
							
							echo '<th>' . __('Details' , 'SternUPAC') . '</th>';	
							echo '<th>' . __('Sent date' , 'SternUPAC') . '</th>';								
							echo '<th>' . __('Statut' , 'SternUPAC') . '</th>';	
									
								
						echo "</tr>";
						?>
					</thead>					 
					<tbody>
					<?php
					
					while($the_query->have_posts()) 
					{
						echo $the_query->the_post();
						
						$idRow = get_the_id();
						if ($idRow!=NULL) { 
				
							$objetPrescription = new Prescription($idRow);
						}
					
					//foreach( $arrayPrescriptions as $objetPrescription ) {

							echo "<tr>";				

							$statut_order = $objetPrescription->getStatut_order();
							$user_id = $objetPrescription->getUser_id();
									
							$user_info = get_userdata($user_id);
							$first_name  = $user_info->first_name;
							$last_name  = $user_info->last_name;
							$user_name = $first_name . ' ' . $last_name  ;

							if(	$type_user== "admin") {echo "<td>".$user_name."</td>";};
							if(	$type_user== "admin") {echo "<td>".$objetPrescription->getWoo_order_id_HTML(). "</td>";};
							
							echo "<td>";								
								echo "<table>";
									echo "<tr>";
										echo "<td>";
											$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
											$url = 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0] . '?idPrescription='. $objetPrescription->getId().'&toggle=2';
											echo "<a href='". $url ." '><button><span class='glyphicon glyphicon-search' aria-hidden='true'></span></button></a>";
										echo "</td>";
										echo "<td>";
											if ($statut_order == 50) {	
												$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);				

													$new_query = add_query_arg( array('toggle' => 2) );
													echo '<form action="' . $new_query.'" method="post">';
												
													echo "<input type='hidden' name='hiddenId' value='". $objetPrescription->getId() . " ' />";											
													echo "<input type='submit' name='delete' value='X'/>";
												echo "</form>";	
											}
										echo "</td>";
									echo "</tr>";
								echo "</table>";
								
								
							echo "</td>";
							

							echo "<td>";
								echo $objetPrescription->getDate_file_sent() ;
							echo "</td>";

							
							echo "<td>";
								echo PrescriptionRepository::getStatusLabel($statut_order);
							echo "</td>";
							
						echo "</tr>";
						
					} 
					?>
					
					</tbody>
				</table>
				
						
				<?php
				global $paged;
				$range = '';
				$pages = '';
				pagination($range,$paged,$pages,$the_query);

				
			} else {
				echo "No prescriptions yet. Visit our ";
				global $woocommerce;
				$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
				?>
					<a href="<?php echo $shop_page_url; ?>" title="<?php _e('Store','woothemes'); ?>"><?php _e('Store','woothemes'); ?></a>
				<?php
			}
		} else {
			echo  __('You must be logged in. ' , 'SternUPAC'); 
			?>
			<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login / Register','woothemes'); ?>"><?php _e('Login','woothemes'); ?></a>
			<?php		
		}
	}
/*
		echo "henry <pre>";
		var_dump($objetPrescription);
		echo "</pre>";	
*/	
}				