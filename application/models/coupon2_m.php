<?php


class Coupon2_m extends MY_Model{
	
	
	public $_table = 'coupon';
	protected $return_type = 'array';
//	public $has_many = array('couponcontent'=>array('model'=>'couponcontent2_m', 'primary_key' => 'couponId' ));
	
	
	
	public function __construct(){
		parent::__construct();
	
	}
	
	/**
	 * 
	 * 同时增加真实数字和显示梳子
	 * @param unknown_type $couponId
	 */
	public function dcount_increment($couponId){
		
		$this->db->query("update coupon set downloadedCount = downloadedCount+1, displayedDCount=displayedDCount+1 where id=$couponId");
		
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

	
}