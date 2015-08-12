<?php



class showButtonsInPrescriptionTemplate{
	function __construct($oPrescription,$type_user) {

		$statut_order = $oPrescription->GetStatut_order() ;
		if ($type_user=="admin") {	
			if ($statut_order == 1) {
				
				echo '<td>';
				//	echo '<form action="' . $new_query.'" method="post">';
						echo "<input type='hidden' name='hiddenId' value='".$oPrescription->getId(). " ' />";
						echo '<input type="submit" name="delete" value="X"/>';   
				//	echo '</form>';
				echo '</td>';
					
									
				echo '<td>';
				//	echo '<form action="' . $new_query.'" method="post">';
						echo "<input type='hidden' name='hiddenId' value='".$oPrescription->getId(). " ' />";
						echo '<input type="submit" name="TaskStatut2" value="'.arrayStatutAction(2).' "/>';
				//	echo '</form>';
				echo '</td>';				
			} else if ($statut_order == 2) { 					
				echo '<td>';
				//	echo '<form action="' . $new_query.'" method="post">';
						echo "<input type='hidden' name='hiddenId' value='".$oPrescription->getId(). " ' />";
						echo '<input type="submit" name="TaskStatut1" value="<"/>';
				//	echo '</form>';
				echo '</td>';
				
				echo '<td>';
				echo '</td>';
				
				
				echo '<td>';
				//	echo '<form action="' . $new_query.'" method="post">';
						echo "<input type='hidden' name='hiddenId' value='".$oPrescription->getId(). " ' />";
						echo '<input type="submit" name="TaskStatut3" value="'.arrayStatutAction(3).'"/>';
				//	echo '</form>';
				echo '</td>';								

								
			} else if ($statut_order == 3) {					
				echo '<td>';
				//	echo '<form action="' . $new_query.'" method="post">';
						echo "<input type='hidden' name='hiddenId' value='".$oPrescription->getId(). " ' />";
						echo '<input type="submit" name="TaskStatut2" value="<"/>';
				//	echo '</form>';
				echo '</td>';	
				echo '<td>';
				//	echo '<form action="' . $new_query.'" method="post">';
						echo "<input type='hidden' name='hiddenId' value='".$oPrescription->getId(). " ' />";
						echo '<input type="submit" name="TaskStatut4" value="'.arrayStatutAction(4).'"/>';
				//	echo '</form>';
				echo '</td>';									


							
			} else if ($statut_order == 4) {					
				echo '<td>';											
						echo '<input type="submit" name="TaskStatut3" value="<"/>';
				echo '</td>';									
				echo '<td>';
					$urlAdminOrder = get_site_url().'/wp-admin/post.php?post='.$oPrescription->getWoo_order_id().'&action=edit';
					echo "<a href='".$urlAdminOrder." ' target='_blank'><span class='glyphicon glyphicon-search' aria-hidden='true'> Voir Admin Order</span></a>";				
				echo '</td>';
			}
		} else {
			if ($statut_order == 50) {
				echo '<td>';
				//	echo '<form action="' . $new_query.'" method="post">';
						echo "<input type='hidden' name='hiddenId' value='".$oPrescription->getId(). " ' />";
						echo '<input type="submit" name="delete" value="X"/> ';
				//	echo '</form>';
				echo '</td>';

				}
				echo '<td>';
				echo '</td>';
		}
	}
}