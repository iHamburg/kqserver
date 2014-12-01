<?php


class Coupon2_m extends MY_Model{
	
	
	public $_table = 'coupon';
	protected $return_type = 'array';

	
	
	
	public function __construct(){
		parent::__construct();
	
	}
	
	/**
	 * 
	 * 同时增加真实数字和显示梳子
	 * @param unknown_type $couponId
	 */
	public function dcount_increment($couponId){
	
		$dnum = rand(3,5);
		$this->db->query("update coupon set downloadedCount = downloadedCount+1, displayedDCount=displayedDCount+$dnum where id=$couponId");

		
		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
		
	}
	
	public function increment_acount($couponId){
		$this->db->query("update coupon set acceptedCount = acceptedCount+1, displayedACount=displayedACount+1 where id=$couponId");
		
		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function get_complete_title($couponId){
		
		$query = $this->db->query("select A.title , B.`discountContent`
from coupon A
left join couponcontent B
on A.id=B.couponId
where A.id=$couponId");
		
		$results = $query->result_array();
		
		$result = $results[0];
		
		$title = $result['title'].$result['discountContent'];
		
		return $title;
		
	}

	
}