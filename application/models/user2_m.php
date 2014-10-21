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

	public function get_username($username){
		
	}
	
	

	public function user_Relanding($username,$password,$data){
		$this->db->update('user',$data,array('username'=>$username,'password'=>$password));
		return $this->db->affected_rows();
	}
	public function update_UserInfo($username,$data){
		$this->db->update('user',$data,array('username'=>$username));
		return $this->db->affected_rows();
	}
	
	
	/**
	 * 获取用户收藏的优惠券的数量
	 */
	
	
	public function count_my_all($uid){
		$query = $this->db->query("select count(*) as cardNum,(select count(*) from downloadedcoupon where uid = ".$uid.") as dCouponNum,(select count(*) from favoritedshop where userId = ".$uid.") as fShopNum,(select count(*) from favoritedcoupon where userId = ".$uid.") as fCouponNum from card where userId = ".$uid);
		return $query->result_array();
	}
	public function count_fcoupon($id){
		$this->db->select('count(*) as fCouponNum')->from('favoritedcoupon');
		$this->db->where(array('userId'=>$id ));
		return $this->db->get()->row_array();
	}
	/**
	 * 获取用户收藏的商户的数量
	 */
	public function count_fshop($id){
		$this->db->select('count(*) as fShopNum')->from('favoritedshop');
		$this->db->where(array('userId'=>$id ));
		return $this->db->get()->row_array();
	}
	/**
	 * 获取用户绑定银行卡的数量
	 */
	public function count_card($id){
		$this->db->select('count(*) as cardNum')->from('card');
		$this->db->where(array('userId'=>$id ));
		return $this->db->get()->row_array();
	}
	/**
	 * 获取用户下载的优惠券的数量
	 */
	public function count_downloadedcoupon($id){
		$this->db->select('count(*) as dCouponNum')->from('downloadedcoupon');
		$this->db->where(array('uid'=>$id ));
		return $this->db->get()->row_array();
	}
	/**
	 * Enter description here ...
	 * @param unknown_type $uid
	 * @return array 包括
	 *  title
	 */
	public function get_user_cards($uid){
		$this->db->select('id,title,peopleid')->from('card');
		$this->db->where(array('peopleid'=>$uid));
		return $this->db->get()->result_array();
		
			
			/*$where = json_encode(array('people'=>avosPointer('_User',$uid)));

			$json = $this->avoslibrary->retrieveObjects('Card',$where,'','','title');
		
   			$results = json_decode($json,true);
   			
   			
   			if (empty($results['error'])){
   				return $results['results'];
   			}
   			else{
   				return Error_Retrieve_Object;
   			}*/

   			
	}
	
	
	public function get_user_downloaded_coupons($uid){
		$query = $this->db->query('select couponid,downloadedcoupon.id,coupon.title,status from downloadedcoupon left join coupon on downloadedcoupon.couponid = coupon.id && downloadedcoupon.user = '.$uid);
		return  $query->result_array();

	}
	function get_user_favorited_coupons($uid){
		$query = $this->db->query('select couponid,favoritedcoupon.id,coupon.title from favoritedcoupon left join coupon on favoritedcoupon.couponid = coupon.id && favoritedcoupon.user = '.$uid);
		return  $query->result_array();
	}

	function get_user_favorited_shop($uid){
		$query = $this->db->query('select shopid,favoritedshop.id,shop.title from favoritedshop left join shop on favoritedshop.shopid = shop.id && favoritedshop.userid = '.$uid);
		return  $query->result_array();
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