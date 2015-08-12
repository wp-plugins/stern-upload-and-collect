<?php

class PrescriptionRepository{
	static public function getPrescriptionSearch(array $filterWhereArray, array $orderByArray=array() )
	{	
	$args = $filterWhereArray;
	$the_query  = new WP_Query( $args  );
		while($the_query->have_posts()) 
		{
		 echo $the_query->the_post();
		 
			$idRow  = get_the_id();
			if ($idRow!=NULL) {		 
				$retour[] = new Prescription($idRow);
			}
		}		
        return $retour;	
	}

	static public function getMutuelleSearch(array $filterWhereArray, array $orderByArray=array() )
	{	
	$args = $filterWhereArray;
	$the_query  = new WP_Query( $args  );
		while($the_query->have_posts()) 
		{
		 echo $the_query->the_post();
		 
			$idRow  = get_the_id();
			if ($idRow!=NULL) {			 
				$mutuelleArray[] = new Mutuelle($idRow);
			}
		}		
        return $mutuelleArray;	
	}	
	
	
	static function getStatusLabel($statut=null)
	{
		$arrayStatut = array(
			'0' => __('Deleted' , 'SternUPAC'),
			'1' => __('Prescription received' , 'SternUPAC'),
			'2' => __('Preparation in progress' , 'SternUPAC'),
			'3' => __('Preparation completed' , 'SternUPAC'),
			'4' => __('Prescription received and paid' , 'SternUPAC'),
			'5' => __('Partial preparation complete' , 'SternUPAC'),
			'10' => __('Document validated' , 'SternUPAC'),
			'11' => __('Expired document' , 'SternUPAC'),
			'50' => __('Pending validation' , 'SternUPAC'),
		);
		if ($statut !=null) {
			Return $arrayStatut[$statut];
		} else {
			Return $arrayStatut;
		}
	}

	static function getStatusLabelPrescription($statut=null)
	{
		$arrayStatut = array(
			'0' => __('Deleted' , 'SternUPAC'),
			'1' => __('Prescription received' , 'SternUPAC'),
			'2' => __('Preparation in progress' , 'SternUPAC'),
			'3' => __('Preparation completed' , 'SternUPAC'),
			'4' => __('Prescription received and paid' , 'SternUPAC'),
			'5' => __('Partial preparation complete' , 'SternUPAC'),
			'50' => __('Pending validation' , 'SternUPAC'),
		);
		if ($statut !=null) {
			Return $arrayStatut[$statut];
		} else {
			Return $arrayStatut;
		}
	}	
	
	static public function getPrescriptionQuery(array $filterWhereArray, array $orderByArray=array() )
	{
		//$user_ID = get_current_user_id();
		
		$args = $filterWhereArray;

		$the_query  = new WP_Query( $args  );
		return $the_query;

	}	
	
	static public function countPrescriptionSearch(array $filterWhereArray, array $orderByArray=array() )
	{
	//$user_ID = get_current_user_id();
	
	$args = $filterWhereArray;

	$the_query  = new WP_Query( $args  );
	return $the_query->post_count;

	}	
	
	
	// ALAN
	static public function getArrayPrescriptionsByStatusAndUser($statut, $idUser) {
		$filterWhereArray = array (
		'post_type' => 'SternUPAC',
		'post_author' => $idUser,
		'meta_query' => array (
							array ( 
								'key' => 'statut_order',
								'value' => $statut 
							) ,
							array ( 
								'key' => 'typeDocument',
								'value' => 'prescription'
							)
						)										
		);	
		
		$orderByArray = array (
				'date_file_sent' => 'DESC'
		);		
		return $arrayPrescriptions = PrescriptionRepository::getPrescriptionSearch($filterWhereArray, $orderByArray );
		//return $arrayPrescriptions = getPrescriptionSearch($filterWhereArray, $orderByArray );
	}
	

	
	static public function getPricePrescriptionByWooOrderId($woo_order_id){
		$typeDocument = 'prescription';
		$filterWhereArray = getDocumentWhereArray($typeDocument,null,null,$woo_order_id,99);
		$args = $filterWhereArray;
		$the_query  = new WP_Query( $args );
		
		$totalPrice = 0;
		while($the_query->have_posts()) 
		{
		 echo $the_query->the_post();
			$oPrescription= new Prescription(get_the_id());
	
			$totalPrice = $totalPrice + $oPrescription->getPrice();
		}		
        return $totalPrice;	
	}
	
	
	
	
	
	static public function getCountPrescritpionbyStatusAndTypeDocument($status, $typeDocument) {
	
		$user_ID = get_current_user_id();
		$filterWhereArray = getDocumentWhereArray($typeDocument, array($user_ID),$status,NULL,99 ) ;
		$args = $filterWhereArray;
		$the_query  = new WP_Query( $args  );
		
	//	($typeDocument=NULL, $array_Users_IDs=NULL,$arrayStatut_order_value=null,$woo_order_id=NULL,$posts_per_page=5 ) {
		

	
		$orderByArray = array (
				'date_file_sent' => 'DESC'
		);
		return $arrayPrescriptions = PrescriptionRepository::countPrescriptionSearch($filterWhereArray, $orderByArray );
	}

	/*
	static public function getUserIdFromIdPrescription($idPrescription) {
	//	$user_ID = get_current_user_id();
		$filterWhereArray = array (
		'post_type' => 'sternupac',
		'ID' => $idPrescription,
	//	'post_author' => $user_ID,	
		'meta_query' => array (
							array ( 
								'key' => 'statut_order',
								'value' => array( $status ),
								'compare' => 'IN'
							) ,
							array ( 
								'key' => 'typeDocument',
								'value' => 'prescription'
							)
						)									
		);
		$orderByArray = array (
				'date_file_sent' => 'DESC'
		);
		return $arrayPrescriptions = PrescriptionRepository::countPrescriptionSearch($filterWhereArray, $orderByArray );
	}	
*/	


	
	static public function getArrayPrescriptionsByIDAndUser($idPrescription, $idUser) {
		$filterWhereArray = array (
			'post_author' => $idUser,
			'ID' => $idPrescription,
			'meta_query' => array (
								array (
									'key' => 'typeDocument',
									'value' => 'prescription'
								)
							)		
		);	
		
		$orderByArray = array (
				'date_file_sent' => 'DESC'
		);		
		return $arrayPrescriptions = PrescriptionRepository::getPrescriptionSearch($filterWhereArray, $orderByArray );
		//return $arrayPrescriptions = getPrescriptionSearch($filterWhereArray, $orderByArray );
	}

	

    static public function getUserIdsWithSearch($search){
        $args = array(
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => 'last_name',
                    'value' => $search,
                    'compare' => 'LIKE'
                ),
                array(
                    'key' => 'first_name',
                    'value' => $search,
                    'compare' => 'LIKE'
                )
            )
        );

        $user_query = new WP_User_Query($args);
        $all_Users_IDs = "";
        if (!empty($user_query->results)) {
            foreach ($user_query->results as $user) {
                //echo '<p>' . $user->display_name . $user->id . $user->user_firstname   .  $user->user_lastname .  $user->user_nicename. '</p>';
                //    $all_IDsArray[] = $user->id;
                $all_Users_IDs .= $user->id . ',';
                //  echo $user->id;
            }
            $all_Users_IDs = substr($all_Users_IDs, 0, -1);
        }
    return $all_Users_IDs;
    }
}

/*
echo "<pre>";
    var_dump($query);
    echo "</pre>";
*/