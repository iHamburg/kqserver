<?php


class Card2_m extends MY_Model{
	
	
	public $_table = 'card';
	protected $return_type = 'array';
	
	public function __construct(){
		parent::__construct();
	
	}
	
	
	public function get_id($id){

		$this->db->select('A.id as cardId,A.title,logoUrl,B.title as bankTitle');
		$this->db->from('card as A');
		$this->db->join('bank as B','A.bankId = B.id','left');
		$this->db->where('A.id',$id);
		
		$query = $this->db->get();
		
		$results = $query->result_array();
		
		return $results[0];
		
		
		
	}

	
}