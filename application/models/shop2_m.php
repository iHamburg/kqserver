<?php


class News2_m extends MY_Model{
	
	
	public $_table = 'shop';
	protected $return_type = 'array';
	
	/**
	 * 
	 * Enter description here ...
	 * @var Avoslibrary
	 */
//	var $avoslibrary;
	
	public function __construct(){
		parent::__construct();
	
	}
	
	public function countBranches($id){
	
		$query = $this->db->query("select count(*) as num from shopbranch where shopId = $id 
AND active = 1");
		
		$results = $query->result_array();
		
		$num = $results[0]['num'];
		
		return $num;
	}
	

	
}