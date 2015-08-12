<?php

global $wpdb;
class Mutuelle extends Document{		
	/*	protected $id; */
		protected $user_id;		
		protected $post_author_meta;
		protected $target_repository;
		protected $name_file;		
		protected $noteCustToPharm;
		protected $notePharmToCust;		
		protected $original_name_file;
	/*	protected $statut_Mutuelle; */
		protected $date_file_sent;
		protected $date_end_validity;
		protected $user_id_validate_mutuelle;
		protected $date_validate_mutuelle;
		protected $statut_order;
		
	function __construct($id = null){
		if($id != null){
			parent::__construct($id);		
			$this->id = $id;
			$this->user_id = get_post_meta( $id, 'user_id',true ); 
			$this->post_author_meta = get_post_meta( $id, 'post_author_meta',true ); 
			$this->target_repository = get_post_meta( $id, 'target_repository',true ); 
			$this->name_file = get_post_meta( $id, 'name_file',true ); 
			$this->noteCustToPharm = get_post_meta( $id, 'noteCustToPharm',true ); 
			$this->notePharmToCust = get_post_meta( $id, 'notePharmToCust',true ); 
			$this->original_name_file = get_post_meta( $id, 'original_name_file',true ); 
		/*	$this->statut_Mutuelle = get_post_meta( $id, 'statut_Mutuelle',true );  */
			$this->date_file_sent = get_post_meta( $id, 'date_file_sent' ,true); 
			$this->date_end_validity = get_post_meta( $id, 'date_end_validity',true ); 
			$this->user_id_validate_mutuelle = get_post_meta( $id, 'user_id_validate_mutuelle',true ); 
			$this->date_validate_mutuelle = get_post_meta( $id, 'date_validate_mutuelle' ,true);
			$this->typeDocument = get_post_meta( $id, 'typeDocument',true ); 	
			$this->statut_order = get_post_meta( $id, 'statut_order',true ); 			
		}
	}
	
	/*function getid(){                   			return $this->id; } */
    function getUser_id() {            				return $this->user_id; }
    function getTarget_repository() {	  			return $this->target_repository; }
    function getName_file() {		        		return $this->name_file; }
    function getNoteCustToPharm() {     			return $this->noteCustToPharm; }
    function getNotePharmToCust() {     			return $this->notePharmToCust; }
    function getOriginal_name_file() {  			return $this->original_name_file; }    
    function getDate_file_sent() {      			return $this->date_file_sent; }
    function getDate_end_validity() {     			return $this->date_end_validity; }
    function getUser_id_validate_mutuelle() {    	return $this->user_id_validate_mutuelle; }
    function getDate_validate_mutuelle() {   		return $this->date_validate_mutuelle; }	
/*	function getStatut_Mutuelle() {   				return $this->statut_Mutuelle; } */
	function getTypeDocument() {        			return $this->typeDocument; }
	function getStatut_order() {        			return $this->statut_order; }
    
	
	
	

 /*   function setid($id) {                                       				$this->id = $id; } */
    function setUser_id($user_id) {                             				$this->user_id = $user_id; }
    function setTarget_repository($target_repository) {         				$this->target_repository = $target_repository; }
    function setName_file($name_file) {                         				$this->name_file = $name_file; }
    function setNoteCustToPharm($noteCustToPharm) {            					$this->noteCustToPharm = $noteCustToPharm; }
	function setNotePharmToCust($notePharmToCust) {								$this->notePharmToCust = $notePharmToCust; }
    function setOriginal_name_file($original_name_file) {       				$this->original_name_file = $original_name_file; }
    function setDate_file_sent($date_file_sent) {               				$this->date_file_sent = $date_file_sent; }
    function setDate_end_validity($date_end_validity) {             			$this->date_end_validity = $date_end_validity; }
    function setUser_id_validate_mutuelle($user_id_validate_mutuelle) {       	$this->user_id_validate_mutuelle = $user_id_validate_mutuelle; }
    function setDate_validate_mutuelle($date_validate_mutuelle) {         		$this->date_validate_mutuelle = $date_validate_mutuelle; }
/*	function setStatut_Mutuelle($statut_Mutuelle) {         					$this->statut_Mutuelle = $statut_Mutuelle; } */
	function setTypeDocument($typeDocument) {                   				$this->typeDocument = $typeDocument; }	
	function setStatut_order($statut_order) {                   				$this->statut_order = $statut_order; }

	
	
	function save(){
		$post = array(
		  'post_status'           => 'publish', 
		  'post_type'             => 'SternUPAC',
		  'post_author'           => $post_author,
		  'ping_status'           => get_option('default_ping_status'), 
		  'post_parent'           => 0,
		  'menu_order'            => 0,
		  'to_ping'               =>  '',
		  'pinged'                => '',
		  'post_password'         => '',
		  'guid'                  => '',
		  'post_content_filtered' => '',
		  'post_excerpt'          => '',
		  'import_id'             => 0
		);			
		if($this->id != null){ $post['ID'] = $this->id ; }

		$post_id = wp_insert_post( $post );	

		
		/*update_post_meta($post_id , 'post_author_meta' , $this->post_author_meta);		*/
		update_post_meta($post_id , 'name_file' , $this->name_file);
		update_post_meta($post_id , 'typeDocument' , 'mutuelle');
		update_post_meta($post_id , 'original_name_file' , $this->original_name_file);
		update_post_meta($post_id , 'noteCustToPharm' , $this->noteCustToPharm);
		update_post_meta($post_id , 'notePharmToCust' , $this->notePharmToCust);
		update_post_meta($post_id , 'target_repository' , $this->target_repository);
		update_post_meta($post_id , 'date_file_sent' , $this->date_file_sent);
	/*	update_post_meta($post_id , 'statut_Mutuelle' , $this->statut_Mutuelle); */
		update_post_meta($post_id , 'date_end_validity' , $this->date_end_validity);
		update_post_meta($post_id , 'date_validate_mutuelle' , $this->date_validate_mutuelle);
		update_post_meta($post_id , 'user_id_validate_mutuelle' , $this->user_id_validate_mutuelle);
		update_post_meta($post_id , 'statut_order' , $this->statut_order);
		update_post_meta($post_id , 'user_id' , $this->user_id);
			
	}
}


    /*
echo "<pre>";
    var_dump($this);
    echo "</pre>";
*/