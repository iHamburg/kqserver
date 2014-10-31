<?php


class User2_m extends MY_Model{
	
	
	public $_table = 'user';
	protected $return_type = 'array';
	
	
	public function __construct(){
		parent::__construct();
	}

	
	/**
	 * 
	 * 如果成功返回user， 否则返回NULL
	 * @param unknown_type $uid
	 * @param unknown_type $sessionToken
	 */
	public function isSessionValid($uid,$sessionToken){

		
		$query = $this->db->query(" SELECT * FROM (`user`)
WHERE `id` =  $uid
AND sessionToken = '$sessionToken'
AND `expireDate` > now()");
		$results = $query->result_array();
		
		$result = $results[0];  // array or NULL
		

		return $result;
	
	}
	


	/**
	 * 返回true 或 false 
	 * 
	 * @param unknown_type $uid
	 * @param unknown_type $unionId
	 */
	public function update_unionid_by_uid($uid,$unionId){
		
		$this->db->query("update user set unionId='$unionId' where id=$uid");
		
		if($this->db->affected_rows()>0){
			return true;
		}
		else 
			return false;
	}
	
	/**
	 * 当银联通知票券承兑，修改数据库， 把downloadedcoupon的
	 * 
	 * @param unknown_type $uid
	 * @param unknown_type $unionUid
	 * @param unknown_type $unionCouponId
	 */
	public function accept_coupon($uid, $unionCouponId){
		
		$this->db->query("");
		
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
	
	
	/**
	 * 
	 * 如果coupon是event，并且用户已经下载过了返回no，
	 * coupon已经sellOut= 》no
	 * 否则返回true
	 * @param unknown_type $uid
	 * @param unknown_type $couponId
	 */
	public function can_user_dcoupon($uid,$couponId){
		
		return true;
	}
	
	
	/**
	 * 
	 * 服务器写入下载快券， 如果成功返回新插入的id
	 * @param unknown_type $uid
	 * @param unknown_type $couponId
	 * @param unknown_type $transSeq
	 */
	public function download_coupon($uid,$couponId, $transSeq){
		
	
			// 如果用户可以继续下载
	
//			$query = $this->db->query("insert into downloadedcoupon (uid,couponId,transSeq) values ($uid,$couponId,'$transSeq')");

			$query = $this->db->query("insert into downloadedcoupon (uid,couponId,transSeq,createdAt) values ($uid,$couponId,'$transSeq',null)");
		
			if ($this->db->affected_rows() == 0){
			/// 如果下载失败
				return false;

			}
			else{
//				
				//调用内部服务器的数据库更新
				
				$id =  $this->db->insert_id();

				return $id;
			}

	}



	public function download_union_coupon($uid,$mobile,$unionUid,$unionCouponId, $transSeq){
		
		
		$data['chnlUsrId'] = $uid;
		$data['chnlUsrMobile'] = $mobile;
		$data['couponId'] = $unionCouponId;
		$data['couponNum'] = '1';
		$data['couponSceneId'] = '000';
		$data['transSeq'] = $transSeq;
		$data['userId'] = $unionUid;
		
//		print_r($data);
		
		$response = $this->unionpay->couponDwnById($data);
	
		$response = json_decode($response,true);
		$respCd = $response['respCd'];
		
		if ($respCd == '000000'){
			return $response['data'];
		}
		else {
			return $respCd;
		}
		
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $uid
	 */
	public function download_batch_coupons($uid, $mobile, $unionUid, $coupons){
		
		foreach ($coupons as $coupon) {
			$couponId = $coupon['id'];
			$unionCouponId = $coupon['unionCouponId'];
//			$transSeq = $coupon['transSeq'];
	// transSeq 要从
			
			// 如果没有unioncouponid， 跳出
			if (empty($unionCouponId) )
				continue;
			
			$response = $this->download_union_coupon($uid, $mobile, $unionUid, $unionCouponId, $transSeq);
		}
	}
	
	/**
	 * 
	 * "userId":"c00055685346","mobile":"13166361023","email":"","userName":"","cardList":[{"cardNo":"196222***********9533","issuerName":"\u4e2d\u56fd\u5de5\u5546\u94f6\u884c"}]}
	 * @param unknown_type $mobile
	 */
	public function get_union_user($mobile){
		
		$response = $this->unionpay->getUserByMobile($mobile);
		
		$response = json_decode($response,true);
		$respCd = $response['respCd'];
		
		if ($respCd == '000000'){
			return $response['data'];
		}
		else {
			return $respCd;
		}
	}
	
	public function register_union($mobile){
		$response = $this->unionpay->regByMobile($mobile);
		
		$response = json_decode($response,true);
		$respCd = $response['respCd'];
		
		if ($respCd == '000000'){
			return $response['data'];
		}
		else {
			return $respCd;
		}
	}
	
	public function bind_union_card($unionUid, $cardNo){
		$response = $this->unionpay->bindCard($unionUid,$cardNo);
		
		$response = json_decode($response,true);
		
		$respCd = $response['respCd'];
		
		if ($respCd == '000000'){
			return $response['data'];
		}
		else {
			return $respCd;
		}
	}
	

	
	/**
	 * 
	 * 返回true，表示成功
	 * @param unknown_type $unionUid
	 * @param unknown_type $cardNo
	 */
	public function unbind_union_card($unionUid, $cardNo){
		$response = $this->unionpay->unbindCard($unionUid,$cardNo);
		
		$response = json_decode($response,true);
		
		$respCd = $response['respCd'];
		
		if ($respCd == '000000'){
			return true;
		}
		else {
			return $respCd;
		}
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