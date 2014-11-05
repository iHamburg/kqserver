<?php


class Shopbranch2_m extends MY_Model{
	
	
	public $_table = 'shopbranch';
	protected $return_type = 'array';
	

	
	public function __construct(){
		parent::__construct();
	
	}
	
	public function get_shopbranches_from_shopId($shopId){
		
		$query = $this->db->query("select * 
from shopbranch 
where shopId=$shopId
and active=1");
		
		$results = $query->result_array();
		
		return $results;
	}

	
}