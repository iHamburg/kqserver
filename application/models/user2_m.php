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
	

	
	
	public function get_dcoupons($uid,$mode='unused',$limit=30,$skip=0){
		
//		echo 'mode'.$mode;
		
			$sql = "SELECT `A`.`couponId`, count(A.couponId) as number, `B`.`title`, `B`.`endDate`, `C`.`avatarUrl`, `C`.`discountContent`,B.isSellOut,B.isEvent,B.active
FROM (`downloadedcoupon` as A)
LEFT JOIN `coupon` as B ON `A`.`couponId` = `B`.`id`
LEFT JOIN `couponcontent` as C ON `A`.`couponId` = `C`.`couponId`
WHERE `uid` =  $uid";
			
			if($mode=="unused"){
				$sql.="
AND `status` =  'unused'
AND `B`.`endDate` > now()";
			}
			else if($mode == "used"){
				$sql.="
AND `status` =  'used'";
			}
			else if($mode == "expired"){
		$sql.="
AND `status` =  'unused'
AND `B`.`endDate` < now()";		
			}
		
		$sql.="
GROUP BY `A`.`couponId`
ORDER BY A.id desc
LIMIT $skip,$limit";
		
		$query = $this->db->query($sql);
		
		$results = $query->result_array();
		
		return $results;
	}
	
	public function get_dcoupons2($uid,$mode='unused',$limit=30,$skip=0){
		
		$this->db->select('A.couponId,count(A.couponId) as number,B.title,B.endDate,C.avatarUrl,C.discountContent,B.isSellOut,B.isEvent, B.active');
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
		
//		$query = " SELECT `A`.`couponId`, count(A.couponId) as number, `B`.`title`, `B`.`endDate`, `C`.`avatarUrl`, `C`.`discountContent`
//FROM (`downloadedcoupon` as A)
//LEFT JOIN `coupon` as B ON `A`.`couponId` = `B`.`id`
//LEFT JOIN `couponcontent` as C ON `A`.`couponId` = `C`.`couponId`";
//		
//$query.="WHERE `uid` =  $uid
//AND `status` =  'unused'
//AND `B`.`endDate` > now()
//GROUP BY `A`.`couponId`
//LIMIT $skip,$limit ";
		
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
		
		//TODO 活动快券的判定
		
		// 如果coupon是event，并且downloadedcoupon里有了，返回false
		
		$query = $this->db->query("select count(*) as num
from downloadedcoupon A
left join coupon B
on A.couponId=B.id
where B.`isEvent`=1
and A.uid=$uid
and A.couponId=$couponId");
		
		$results = $query->result_array();
		$num = $results[0]['num'];
		
		if($num>0){
			//如果用户已经下载过该活动快券，返回false
			return false;
		}
		return true;
	}
	
	
	/**
	 * 服务器插入下载快券
	 * @param unknown_type $uid
	 * @param unknown_type $couponId
	 * @param unknown_type $transSeq
	 * @return 如果成功返回新插入的id, 失败返回false
	 */
	public function download_coupon($uid,$couponId, $transSeq){
		
	
			// 如果用户可以继续下载
	
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




//	
//	/**
//	 * 
//	 * "userId":"c00055685346","mobile":"13166361023","email":"","userName":"","cardList":[{"cardNo":"196222***********9533","issuerName":"\u4e2d\u56fd\u5de5\u5546\u94f6\u884c"}]}
//	 * @param unknown_type $mobile
//	 */
//	public function get_union_user($mobile){
//		
//		$this->load->library("unionpay");
//		
////		echo 'before get union user';
//		$response = $this->unionpay->getUserByMobile($mobile);
//		
////		echo 'resposne'.$response;
//		$response = json_decode($response,true);
//		$respCd = $response['respCd'];
//		
//		if ($respCd == '000000'){
//			return $response['data'];
//		}
//		else {
//			return $respCd;
//		}
//	}
	
//	public function register_union($mobile){
//		
//		$this->load->library("unionpay");
//		
//		$response = $this->unionpay->regByMobile($mobile);
//		
//		$response = json_decode($response,true);
//		$respCd = $response['respCd'];
//		
//		if ($respCd == '000000'){
//			return $response['data'];
//		}
//		else {
//			return $respCd;
//		}
//	}
	
//	public function bind_union_card($unionUid, $cardNo){
//		
////		echo 'begin bind union card';
//
//		$this->load->library("unionpay");
//		
//		$response = $this->unionpay->bindCard($unionUid,$cardNo);
//		
////		echo 'response '.$response;
//		
//		$response = json_decode($response,true);
//		
//		$respCd = $response['respCd'];
//		
//		if ($respCd == '000000'){
//			return $response['data'];
//		}
//		else {
//			return $respCd;
//		}
//	}
	

	
//	/**
//	 * 银联解绑卡
//	 * 成功返回true!!!
//	 * 失败反悔respCd
//	 * @param unknown_type $unionUid
//	 * @param unknown_type $cardNo
//	 */
//	public function unbind_union_card($unionUid, $cardNo){
//		
//		$this->load->library("unionpay");
////		echo 'begin unbind union card';
//		$response = $this->unionpay->unbindCard($unionUid,$cardNo);
////		echo 'response '.$response;
//		$response = json_decode($response,true);
//		
//		$respCd = $response['respCd'];
//		
//		if ($respCd == '000000'){
//			return true;
//		}
//		else {
//			return $respCd;
//		}
//	}
	
	function login($username,$password){

		$this->db->select('id,username,nickname,avatarUrl,sessionToken')->from('user');
		$this->db->where(array('username'=>$username,'password'=>$password));
		return $this->db->get()->row_array();
	

	}
	
	
	function update_password($username,$password){
		$this->db->query("update user set password = '".$password."' where username = '".$username."'");
		return $this->db->affected_rows();
	}
	
	function test(){

		return 'user_m test';		

	}

}