<?php

Class OptionBackOfficeTemplate{
function __construct(){



    ?>

    <div class="wrap">
        <h2>Stern Upload And Collect</h2>
		
		<form method="post">
		 <table class="form-table">
				<tr valign="top">
					<th scope="row">WooCommerce Plugin</th>
					<td>
						<?php
						if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {											
							echo __('Ok. Activated' , 'SternUPAC'); 						
						} else {							
							echo __('Thanks to install WooCommerce plugin.' , 'SternUPAC'). '<a href = "'.get_admin_url().'plugin-install.php?tab=search&s=WooCommerce">Plugin</a>';
						}
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Easy Bootstrap Shortcode</th>					
					<?php
					if ( is_plugin_active( 'easy-bootstrap-shortcodes/osc_bootstrap_shortcode.php' ) ) {
					?>						
						<td><?php _e('Ok. Activated' , 'SternUPAC'); ?> </td>				
					<?php
					} else {
					?>						
						<td><?php _e('Error. Thanks to activate it!' , 'SternUPAC'); ?> <a href = "<?php echo get_admin_url(); ?>/plugin-install.php?tab=search&s=Easy+Bootstrap+Shortcode">Plugin</a></td>
					<?php
					}
					?>
				</tr>


                <tr valign="top">
                    <th scope="row"><?php _e('Create pages' , 'SternUPAC'); ?></th>
                    <td>
					
						<?php
						if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {											
						?>	
							<input type="submit" name="createPagesInstall" value="&#8682;"/>
						<?php					
						} else {							
							echo __('Thanks to install WooCommerce plugin.' , 'SternUPAC'). '<a href = "'.get_admin_url().'plugin-install.php?tab=search&s=WooCommerce">Plugin</a>';
						}
						?>					
					
					</td>						
                </tr>	

                <tr valign="top">
                    <th scope="row"><?php _e('Create 2 products' , 'SternUPAC'); ?></th>
                    <td>
					
					
						<?php
						if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {											
						?>	
							<input type="submit" name="createProductsInstall" value="&#8682;"/>
						<?php					
						} else {							
							echo __('Thanks to install WooCommerce plugin.' , 'SternUPAC'). '<a href = "'.get_admin_url().'plugin-install.php?tab=search&s=WooCommerce">Plugin</a>';
						}
						?>

					</td>					
                </tr>	
				

		   </table>

        

		</form>

        <form method="post" action="options.php">
            <?php settings_fields( 'Stern-Upload-And-Collect-group' ); ?>
            <?php do_settings_sections( 'Stern-Upload-And-Collect-group' ); ?>
            <table class="form-table">


                <tr valign="top">
                    <th scope="row">ID Produit Ordonnance</th>
                    <td><input type="text" name="idProductPrescription" value="<?php echo esc_attr( get_option('idProductPrescription') ); ?>" /></td>
					<?php $link = get_permalink( esc_attr( get_option('idProductPrescription') ) ); ?>
					<td><a href="<?php echo $link; ?>"><?php echo $link; ?></a></td>
                </tr>

                <tr valign="top">
                    <th scope="row">ID Produit Ordonnance Checkout</th>
                    <td><input type="text" name="idProductCheckout" value="<?php echo esc_attr( get_option('idProductCheckout') ); ?>" /></td>
					<?php $link = get_permalink( esc_attr( get_option('idProductCheckout') ) ); ?>
					<td><a href="<?php echo $link; ?>"><?php echo $link; ?></a></td>
                </tr>

				


				
				
                <tr valign="top">
                    <th scope="row">ID Page my-prescriptions</th>
                    <td><input type="text" name="idPageMyPrescriptions" value="<?php echo esc_attr( get_option('idPageMyPrescriptions') ); ?>" /></td>
					<?php $link = get_permalink( esc_attr( get_option('idPageMyPrescriptions') ) ); ?>
					<td><a href="<?php echo $link; ?>"><?php echo $link; ?></a></td>
                </tr>
				
                <tr valign="top">
                    <th scope="row">ID Page new-prescriptions</th>
                    <td><input type="text" name="idPageNewPrescription" value="<?php echo esc_attr( get_option('idPageNewPrescription') ); ?>" /></td>
					<?php $link = get_permalink( esc_attr( get_option('idPageNewPrescription') ) ); ?>
					<td><a href="<?php echo $link; ?>"><?php echo $link; ?></a></td>
                </tr>
				


				

                <tr valign="top">
                    <th scope="row">ID Page Admin Prescriptions</th>
                    <td><input type="text" name="idPageAdminPrescriptions" value="<?php echo esc_attr( get_option('idPageAdminPrescriptions') ); ?>" /></td>
					<?php $link = get_permalink( esc_attr( get_option('idPageAdminPrescriptions') ) ); ?>
					<td><a href="<?php echo $link; ?>"><?php echo $link; ?></a></td>
                </tr>	

                <tr valign="top">
                    <th scope="row">ID Page Admin Mutuelle</th>
                    <td><input type="text" name="idPageAdminMutuelle" value="<?php echo esc_attr( get_option('idPageAdminMutuelle') ); ?>" /></td>
					<?php $link = get_permalink( esc_attr( get_option('idPageAdminMutuelle') ) ); ?>
					<td><a href="<?php echo $link; ?>"><?php echo $link; ?></a></td>
                </tr>	


                <tr valign="top">
                    <th scope="row">woocommerce_shop_page_id</th>
					<?php $idpage = esc_attr( get_option('woocommerce_shop_page_id') ); ?>
                    <td><?php echo $idpage ; ?></td>
					<?php $link = get_permalink( $idpage  ); ?>
					<td><a href="<?php echo $link; ?>"><?php echo $link; ?></a></td>
                </tr>					


                <tr valign="top">
                    <th scope="row">woocommerce_cart_page_id</th>
					<?php $idpage = esc_attr( get_option('woocommerce_cart_page_id') ); ?>
                    <td><?php echo $idpage ; ?></td>
					<?php $link = get_permalink( $idpage  ); ?>
					<td><a href="<?php echo $link; ?>"><?php echo $link; ?></a></td>
                </tr>	

                <tr valign="top">
                    <th scope="row">woocommerce_myaccount_page_id</th>
					<?php $idpage = esc_attr( get_option('woocommerce_myaccount_page_id') ); ?>
                    <td><?php echo $idpage ; ?></td>
					<?php $link = get_permalink( $idpage  ); ?>
					<td><a href="<?php echo $link; ?>"><?php echo $link; ?></a></td>
                </tr>
				
					

                <tr valign="top">
                    <th scope="row">Renouvleable</th>
                    <td><input type="checkbox" id="isRenewableOtpion" name="isRenewableOtpion" <?php if(esc_attr( get_option('isRenewableOtpion') )) {echo "checked";} else {echo"";} ?> /></td>
                </tr>				
				
			
            </table>

            <?php submit_button(); ?>

        </form>
    </div>
<?php


    }
}