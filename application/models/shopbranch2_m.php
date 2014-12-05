<?php


class Shopbranch2_m extends MY_Model{
	
	
	public $_table = 'shopbranch';
	protected $return_type = 'array';
	

	
	public function __construct(){
		parent::__construct();
	
	}
	
//	public function get_shopbranches_from_shopId($shopId, $longitude=0,$latitude=0){
//		
//		if (empty($longitude) ||empty($latitude)){
//			
//		$sql = "select * 
//from shopbranch 
//where shopId=$shopId
//and active=1";
//		
//		}
//		else{
//		
//			$sql = "select * 
//from shopbranch 
//where shopId=$shopId
//and active=1";
//		
//		}
//		
//		
//		$query = $this->db->query($sql);
//		
//		$results = $query->result_array();
//		
//		return $results;
//	}

	
}