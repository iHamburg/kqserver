<?php


class User2_m extends MY_Model{
	
	
	public $_table = 'user';
	protected $return_type = 'array';
	
	
	public function __construct(){
		parent::__construct();
	}

	public function isSessionValid($uid,$sessionToken){


		$query = $this->db->query(" SELECT COUNT(*) AS `numrows`FROM (`user`)
WHERE `id` =  $uid
AND sessionToken = '$sessionToken'
AND `expireDate` > now()");
		$results = $query->result_array();
		
		$result = $results[0];
		$count = $result['numrows'];
		
		if ($count == 0){
			return false;
		}
		else{
			return true;
		}
		
	}

	/**
	 * 
	 * 如果有注册返回unionUid，如果没注册过，返回false
	 * @param unknown_type $uid
	 */
	public function get_union_uid($uid){
		$query = $this->db->query("select unionId from user where id = $uid");
		$results = $query->result_array();
		
		if(!empty($results)){
			return $results[0]['unionId'];
		}
		return false;
	}
	
	public function update_unionid_by_uid($uid,$unionId){
		
		$this->db->query("update user set unionId='$union_uid' where id=$uid");
		
	}
	
	public function get_dcoupons($uid,$mode='unused',$limit=30,$skip=0){
		
		$this->db->select('A.couponId,count(A.couponId) as number,B.title,B.endDate,C.avatarUrl,C.discountContent');
		$this->db->from('downloadedcoupon as A');
		$this->db->where('uid',$uid);
		if($mode == 'unused'){
			$this->db->where('status','unused');
			$this->db->where('B.endDate <','now()');
		}
		else if($mode == 'used'){
			$this->db->where('status','used');
		}
		else if($mode == 'expired'){
			$this->db->where('status','unused');
			$this->db->where('B.endDate >','now()');
		}
		$this->db->join('coupon as B','A.couponId = B.id','left');
		$this->db->join('couponcontent as C','A.couponId = C.couponId','left');
		$this->db->group_by('A.couponId');
		$this->db->limit($limit,$skip);
		
		$query = $this->db->get();
		
		$results = $query->result_array();
		
		return $results;
	}
	
	
	function login($username,$password){

		$this->db->select('id,username,nickname,avatarUrl,sessionToken')->from('user');
		$this->db->where(array('username'=>$username,'password'=>$password));
		return $this->db->get()->row_array();
	

	}
	
	
	function update_password($username,$password){
		$this->db->query("update user set password = '".$password."' where username = '".$username."'");
		return $this->db->affected_rows();
	}

}