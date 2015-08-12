<?php

Class CustomUserFieldsTemplate{
    function __construct()
    {
		if (is_user_logged_in()){

			$user_id = get_current_user_id();
				
				$new_query = add_query_arg( array('toggle' => 3) );
				echo '<form action="' . $new_query.'" method="post">';
				echo '<p>';
				echo __('Fisrt Name' , 'SternUPAC'); 
				echo '<br/>';
				$user_firstname = get_the_author_meta( 'user_firstname',get_current_user_id() );
				echo '<input type="text" name="user_firstname" pattern="[a-zA-Z0-9 ]+" value="' . $user_firstname . '" size="40" />';
				echo '</p>';

				echo '<p>';
				echo __('Name' , 'SternUPAC'); 
				echo '<br/>';
				$user_lastname = get_the_author_meta( 'user_lastname',get_current_user_id() );
				echo '<input type="text" name="user_lastname" pattern="[a-zA-Z0-9 ]+" value="' . $user_lastname . '" size="40" />';
				echo '</p>';

				echo '<p>';
				echo __('Birthdate' , 'SternUPAC'); 
				echo '<br/>';
				$birthdate = get_the_author_meta( 'birthdate',get_current_user_id() );
				echo '<input type="date" name="birthdate" pattern="[a-zA-Z0-9 ]+" value="' . $birthdate . '" size="40" />';
				echo '</p>';


				echo '<p>';
				echo __('Email' , 'SternUPAC'); 
				echo '<br/>';
				$user_email = get_the_author_meta( 'user_email',get_current_user_id() );
				echo '<input type="email" name="user_email" value="' . $user_email. '" size="40" />';
				echo '</p>';

	/*
				echo '<p>';
				echo 'Subject (required) <br />';
				echo '<input type="text" name="cf-subject" pattern="[a-zA-Z ]+" value="' . (isset($_POST["cf-subject"]) ? esc_attr($_POST["cf-subject"]) : '') . '" size="40" />';
				echo '</p>';

	*/





			echo '<p>';
				echo _e('Gender' , 'SternUPAC').'<br/>';
				$gender = get_the_author_meta( 'gender',get_current_user_id() );
				?>
				<input type="radio" name="gender"
					<?php if (isset($gender) && $gender=="female") echo "checked";?>
					   value="female"><?php _e('Female' , 'SternUPAC'); ?>
				<input type="radio" name="gender"
					<?php if (isset($gender) && $gender=="male") echo "checked";?>
					   value="male"><?php _e('Male' , 'SternUPAC'); ?>
				<?php
				echo '</p>';



				echo '<p>';
				echo __('How you want to be informed ?' , 'SternUPAC').'<br/>';
				$communication_type =  get_the_author_meta( 'communication_type',get_current_user_id() );
				?>
				<input type="radio" name="communication_type"
					<?php if (isset($communication_type) && $communication_type=="mail") echo "checked";?>
					   value="mail"><?php _e('Email' , 'SternUPAC'); ?>
				<input type="radio" name="communication_type"
					<?php if (isset($communication_type) && $communication_type=="sms") echo "checked";?>
					   value="sms"><?php _e('SMS' , 'SternUPAC'); ?>
				<input type="radio" name="communication_type"
					<?php if (isset($communication_type) && $communication_type=="mobile") echo "checked";?>
					   value="mobile"><?php _e('Mobile' , 'SternUPAC'); ?>
				<input type="radio" name="communication_type"
					<?php if (isset($communication_type) && $communication_type=="home_phone") echo "checked";?>
					   value="home_phone"><?php _e('Phone' , 'SternUPAC'); ?>
				<?php
				echo '</p>';




				echo '<p>';
				echo __('Alert' , 'SternUPAC').'<br />';
				$alert_product_refunded = get_the_author_meta( 'alert_product_refunded',get_current_user_id() );
				?>
				<input type="radio" name="alert_product_refunded"
					<?php if (isset($alert_product_refunded) && $alert_product_refunded=="alert") echo "checked";?>
					   value="alert"><?php _e('Let me know if a product is not refunded' , 'SternUPAC'); ?>
				<input type="radio" name="alert_product_refunded"
					<?php if (isset($alert_product_refunded) && $alert_product_refunded=="accept") echo "checked";?>
					   value="accept"><?php _e('Accept all outstanding products' , 'SternUPAC'); ?>
				<?php
				echo '</p>';


				echo '<p>';
				echo _e('Social security number' , 'SternUPAC') . '<br />';
				$social_security_number =  get_the_author_meta( 'social_security_number',get_current_user_id() );
				echo '<input type="text" name="social_security_number" pattern="[a-zA-Z0-9 ]+" value="'.$social_security_number.'" size="40" />';

				echo '</p>';

	/*
				echo '<p>';
				echo 'Your Message (required) <br />';
				echo '<textarea rows="10" cols="35" name="cf-message">' . (isset($_POST["cf-message"]) ? esc_attr($_POST["cf-message"]) : '') . '</textarea>';
				echo '</p>';
	*/			
				
				echo '<p><input type="submit" name="cf-submitted" value="Ok"/></p>';
				echo '</form>';
		   
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