<?php

global $wpdb;
class Prescription extends Document {	
		/*protected $post_author_meta;*/
		protected $woo_order_id;
		protected $date_start_prep;
		protected $date_finish_prep;
		protected $date_cust_pick_up;
		protected $date_forecast_cust_pick_up;
		protected $renewable;
		protected $user_finish_prep_id;
		protected $price;
		
	function __construct($id = null){
		if($id != null){
			parent::__construct($id);
			$this->id = $id;
		/*	$this->post_author_meta = get_post_meta( $id, 'post_author_meta',true );  */ /* ICI K8, cette ligne, elle est deja mis dans l'obet Document*/
			$this->woo_order_id = get_post_meta( $id, 'woo_order_id',true ); 
			$this->typeDocument = get_post_meta( $id, 'typeDocument',true ); 
			$this->target_repository = get_post_meta( $id, 'target_repository',true ); 
			$this->name_file = get_post_meta( $id, 'name_file',true ); 
			$this->noteCustToPharm = get_post_meta( $id, 'noteCustToPharm',true ); 
			$this->notePharmToCust = get_post_meta( $id, 'notePharmToCust',true ); 
			$this->original_name_file = get_post_meta( $id, 'original_name_file',true ); 
			$this->statut_order = get_post_meta( $id, 'statut_order',true ); 
			$this->date_file_sent = get_post_meta( $id, 'date_file_sent' ,true); 
			$this->date_start_prep = get_post_meta( $id, 'date_start_prep',true ); 
			$this->date_finish_prep = get_post_meta( $id, 'date_finish_prep',true ); 
			$this->date_cust_pick_up = get_post_meta( $id, 'date_cust_pick_up' ,true); 
			$this->date_forecast_cust_pick_up = get_post_meta( $id, 'date_forecast_cust_pick_up',true ); 
			$this->user_finish_prep_id = get_post_meta( $id, 'user_finish_prep_id',true ); 
			$this->price = get_post_meta( $id, 'price',true ); 				
		}

	}
		
		

	
	
	
/*	
		$arrayData = array();
		$this->nom_table = $this->getNomTable();
		if($id != null){
			global $wpdb;
			$nom_table = $wpdb->prefix."SternUploadAndCollect";
			$requete = "SELECT * FROM  $nom_table where id=$id";
			$arrayData = $wpdb->get_results( $requete );


            foreach($arrayData as $object){
				foreach ($object as $key => $value)
				{
				$this->$key = $value;
				}
			}
		}
		*/
	

	static public function getNomTable(){
		global $wpdb;
		return $wpdb->prefix."SternUploadAndCollect";
	}
	
	//function getId(){                   			return $this->id; }
 /*   function getUser_id() {            				return $this->post_author_meta; }*/
	function getWoo_order_id() {        			return $this->woo_order_id; }
	//function getTypeDocument() {        			return $this->typeDocument; }
//    function getTarget_repository() {	  			return $this->target_repository; }
//    function getName_file() {		        		return $this->name_file; }
//    function getNoteCustToPharm() {     			return $this->noteCustToPharm; }
//    function getNotePharmToCust() {     			return $this->notePharmToCust; }
//    function getOriginal_name_file() {  			return $this->original_name_file; }
    function getStatut_order() {        			return $this->statut_order; }
    function getDate_file_sent() {      			return $this->date_file_sent; }
    function getDate_start_prep() {     			return $this->date_start_prep; }
    function getDate_finish_prep() {    			return $this->date_finish_prep; }
    function getDate_cust_pick_up() {   			return $this->date_cust_pick_up; }
	function getDate_forecast_cust_pick_up() {   	return $this->date_forecast_cust_pick_up; }
	function getRenewable() {   					return $this->renewable; }
	function getUser_finish_prep_id() {   			return $this->user_finish_prep_id; }
	function getPrice() {   						return $this->price; }

	


 //   function setId($id) {                                       			$this->id = $id; }
 /*   function setUser_id($post_author_meta) {                             	$this->post_author_meta = $post_author_meta; }*/
	function setWoo_order_id($woo_order_id) {                             	$this->woo_order_id = $woo_order_id; }	
//	function setTypeDocument($typeDocument) {                   			$this->typeDocument = $typeDocument; }
//    function setTarget_repository($target_repository) {         			$this->target_repository = $target_repository; }
//    function setNoteCustToPharm($noteCustToPharm) {             			$this->noteCustToPharm = $noteCustToPharm; }
//	function setNotePharmToCust($notePharmToCust) {							$this->notePharmToCust = $notePharmToCust; }
//    function setOriginal_name_file($original_name_file) {       			$this->original_name_file = $original_name_file; }
    function setStatut_order($statut_order) {                   			$this->statut_order = $statut_order; }
//    function setDate_file_sent($date_file_sent) {               			$this->date_file_sent = $date_file_sent; }
    function setDate_start_prep($date_start_prep) {             			$this->date_start_prep = $date_start_prep; }
    function setDate_finish_prep($date_finish_prep) {           			$this->date_finish_prep = $date_finish_prep; }
    function setDate_cust_pick_up($date_cust_pick_up) {         			$this->date_cust_pick_up = $date_cust_pick_up; }
	function setDate_forecast_cust_pick_up($date_forecast_cust_pick_up) {	$this->date_forecast_cust_pick_up = $date_forecast_cust_pick_up; }
    function setRenewable($renewable) {										$this->renewable = $renewable; }
	function setUser_finish_prep_id($user_finish_prep_id) {					$this->user_finish_prep_id = $user_finish_prep_id; }
	function setPrice($price) {												$this->price = $price; }
	
	
	
	function getWoo_order_id_HTML()
	{
		$orderId = $this->woo_order_id;
		if($orderId == NULL) {
			$hash = ""; 
		} else {
			$hash = "#";
		}					
		return  $hash. "<a href='".  get_site_url() . "/my-account/view-order/". $orderId . "'/>" . $orderId ."</a>";
	}

	function save(){
		$post = array(
		  'post_status'           => 'publish', 
		  'post_type'             => 'SternUPAC',
		  'post_author'           => $this->post_author_meta,
		  'ping_status'           => get_option('default_ping_status'), 
		  'post_parent'           => 0,
		  'menu_order'            => 0,
		  'to_ping'               => '',
		  'pinged'                => '',
		  'post_password'         => '',
		  'guid'                  => '',
		  'post_content_filtered' => '',
		  'post_excerpt'          => '',
		  'import_id'             => 0
		);
			
		if($this->id != null){ $post['ID'] = $this->id ; }


		$post_id = wp_insert_post( $post );	
		update_post_meta($post_id , 'post_author_meta' , $this->post_author_meta);
		update_post_meta($post_id , 'woo_order_id' , $this->woo_order_id);		
		update_post_meta($post_id , 'name_file' , $this->name_file);
		update_post_meta($post_id , 'typeDocument' , $this->typeDocument);
		update_post_meta($post_id , 'original_name_file' , $this->original_name_file);
		update_post_meta($post_id , 'noteCustToPharm' , $this->noteCustToPharm);
		update_post_meta($post_id , 'notePharmToCust' , $this->notePharmToCust);
		update_post_meta($post_id , 'target_repository' , $this->target_repository);
		update_post_meta($post_id , 'date_file_sent' , $this->date_file_sent);
		update_post_meta($post_id , 'statut_order' , $this->statut_order);
		update_post_meta($post_id , 'date_start_prep' , $this->date_start_prep);
		update_post_meta($post_id , 'date_finish_prep' , $this->date_finish_prep);
		update_post_meta($post_id , 'date_cust_pick_up' , $this->date_cust_pick_up);
		update_post_meta($post_id , 'date_forecast_cust_pick_up' , $this->date_forecast_cust_pick_up);
		update_post_meta($post_id , 'renewable' , $this->renewable);
		update_post_meta($post_id , 'user_finish_prep_id' , $this->user_finish_prep_id);
		update_post_meta($post_id , 'price' , $this->price);
		update_post_meta($post_id , 'user_id' , $this->user_id);
		
		
	}	
}
    /*
echo "<pre>";
    var_dump($this);
    echo "</pre>";
*/