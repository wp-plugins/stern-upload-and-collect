<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

wc_print_notices(); ?>

	<?php
	$pharmacist = esc_attr( get_the_author_meta( 'pharmacist',  get_current_user_id()) ) ;
		if ($pharmacist ==true) {

			$linkPageAdminPrescriptions = get_permalink( esc_attr( get_option('idPageAdminPrescriptions') ) );
			$linkPageAdminMutuelle = get_permalink( esc_attr( get_option('idPageAdminMutuelle') ) );
			$linkPageMyPrescriptions = get_permalink( esc_attr( get_option('idPageMyPrescriptions') ) ); 
			$linkPageNewPrescription = get_permalink( esc_attr( get_option('idPageNewPrescription') ) );			

		?>
			<a href="<?php echo $linkPageAdminPrescriptions; ?>" class="button view">Admin Prescriptions</a>
			<a href="<?php echo $linkPageAdminMutuelle; ?>" class="button view">Admin Other Documents</a>
			<br><br>
		<?php }	?>			
			
<a href="<?php echo $linkPageMyPrescriptions; ?>" class="button view">My Prescriptions</a>
<a href="<?php echo $linkPageNewPrescription; ?>" class="button view">Send a Prescription</a>
<br><br>
<p class="myaccount_user">
	<?php
	printf(
		__( 'Hello <strong>%1$s</strong> (not %1$s? <a href="%2$s">Sign out</a>).', 'woocommerce' ) . ' ',
		$current_user->display_name,
		wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) )
	);

	printf( __( 'From your account dashboard you can view your recent orders, manage your shipping and billing addresses and <a href="%s">edit your password and account details</a>.', 'woocommerce' ),
		wc_customer_edit_account_url()
	);
	?>
</p>


<?php do_action( 'woocommerce_before_my_account' ); ?>

<?php wc_get_template( 'myaccount/my-downloads.php' ); ?>

<?php wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>

<?php wc_get_template( 'myaccount/my-address.php' ); ?>

<?php do_action( 'woocommerce_after_my_account' ); ?>
