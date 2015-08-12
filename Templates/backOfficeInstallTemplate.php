<?php
/**
 * Created by PhpStorm.
 * User: alanszt
 * Date: 4/12/2015
 * Time: 1:45 AM
 */



Class backOfficeInstallTemplate{
function __construct(){

$filename =  dirname (plugin_dir_url( __FILE__ ) ).'/img/BCK_1000.png';	

    ?>

    <div class="wrap">
        <h2>Stern Upload And Collect</h2>
		
		<img src="<?php echo $filename; ?>" />
		<br>	
		<?php echo __('Please visit us!' , 'SternUPAC').' '; ?>
		<a href="http://sternwebagency.com/en/stern-prescription-upload-and-collect-plugin/" target='_blank'>SternWebAgency.com</a>

    </div>
<?php


    }
}