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
	 * @return 如果session没过期返回user数组，否则返回null
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
	 * 
	 * @param unknown_type $uid
	 * @param unknown_type $unionId
	 *  
	 */
	public function update_unionid_by_uid($uid,$unionId){
		
		$this->db->query("update user set unionId='$unionId' where id=$uid");
		
//		if($this->db->affected_rows()>0){
//			return true;
//		}
//		else 
//			return false;
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
AND `B`.`endDate` >= curdate()";
			}
			else if($mode == "used"){
				$sql.="
AND `status` =  'used'";
			}
			else if($mode == "expired"){
		$sql.="
AND `status` =  'unused'
AND `B`.`endDate` < curdate()";		
			}
		
		$sql.="
GROUP BY `A`.`couponId`
ORDER BY A.id desc
LIMIT $skip,$limit";
		
		$query = $this->db->query($sql);
		
		$results = $query->result_array();
		
		return $results;
	}
	
	
	
	public function can_user_dcoupon($uid,$couponId){
		
		
		// 如果coupon是event，并且downloadedcoupon里有了，返回false
		
		if ($couponId == 39 || $couponId == 60 || $couponId == 79){
		// 如果是活动券（牛奶棚和摩提）
			$query = $this->db->query("select B.isEvent, B.unusedLimit
from downloadedcoupon A
left join coupon B
on A.couponId=B.id
where  A.uid=$uid
and A.couponId=$couponId
limit 1");
		
			
		}
		else{
			// 如果不是活动券， 就搜索未使用的优惠券的数量
	$query = $this->db->query("select B.isEvent, B.unusedLimit
from downloadedcoupon A
left join coupon B
on A.couponId=B.id
where  A.uid=$uid
and A.couponId=$couponId
and A.status='unused'
limit 1");
		}
		
			
		
		$results = $query->result_array();
		
		// 查到记录了
		if(!empty($results)){
			$record = $results[0];
			$isEvent = $record['isEvent'];
			$unusedLimit = $record['unusedLimit'];
			
			if ($isEvent == 1){
				return ErrorDownloadEventCouponLimit;
			}
			
			if($unusedLimit > 0){
				return ErrorDownloadCouponLimit;
			}
			
		}
		
		
		return true;
	}
	
	/**
	 * 
	 * 如果coupon是event，并且用户已经下载过了返回no，
	 * coupon已经sellOut= 》no
	 * 否则返回true
	 * @param unknown_type $uid
	 * @param unknown_type $couponId
	 */
	public function can_user_dcoupon2($uid,$couponId){
		
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