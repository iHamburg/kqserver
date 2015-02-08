<?php


class Gd_web_m extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		
	}
	
	
	public function get_user($username){
		$this->db->select('id,sessionToken,expireDate')->from('user');
		$this->db->where(array('username'=>$username));
		$num =  $this->db->get()->row_array();
// 		$number = $num['id'];
		return $num;
		
	}
	
	public function get_user_details($uid){
		$this->db->select("id,username,unionId,sessionToken")->from('user');
		$this->db->where(array('id'=>$uid));
		return $this->db->get()->row_array();
	}
	public function insert_all($table,$data){
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	
	
	public function get_user_card_number($uid){
		$sql = "select count(*) as number from card where userId = $uid and (title like '622161%' 
		or title like '622162%'
		or title like '622650%'
		or title like '622655%'
		or title like '622657%'
		or title like '622658%'
		or title like '622659%'
		or title like '622685%'
		or title like '622687%'
		or title like '625976%'
		or title like '625979%'
		or title like '628201%'
		or title like '628202%')
		";
		
		$query = $this->db->query($sql);
		$num = $query->row_array();
		$number = $num['number'];
 		return $number;
		
	}
	
	public function get_user_card_number_byCardNumber($card){
		$this->db->select('count(*) as number')->from('card');
		$this->db->where(array('title'=>$card));
		$num = $this->db->get()->row_array();
		$number = $num['number'];
		return $number;
	}
	
	
	public function updateUser($table,$uid,$data){
		$this->db->update($table,$data,array('id'=>$uid));
		return $this->db->affected_rows();
	}
	
	
	public function getBank($title){
		$this->db->select('*')->from('bank');
		$this->db->where(array('title'=>$title));
		return $this->db->get()->row_array();
	}
	
	public function getUserCardByUid($uid){
		$sql = "select c.title,c.bankTitle,b.logoUrl from card c left join bank b on c.bankId = b.id where userId = $uid and (c.title like '622161%' 
		or c.title like '622162%'
		or c.title like '622650%'
		or c.title like '622655%'
		or c.title like '622657%'
		or c.title like '622658%'
		or c.title like '622659%'
		or c.title like '622685%'
		or c.title like '622687%'
		or c.title like '625976%'
		or c.title like '625979%'
		or c.title like '628201%'
		or c.title like '628202%')
		";
		
		$query = $this->db->query($sql);
		$num = $query->result_array();
		return $num;
	}
	
	
	
	
	
	
	
	
	
	
	
}