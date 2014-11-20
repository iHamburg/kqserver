<?php

require_once(APPPATH.'libraries/unionpay.php');
require_once(APPPATH.'libraries/umengpush.php');
require_once(APPPATH.'models/user2_m.php'); 
require_once(APPPATH.'models/coupon2_m.php'); 
require_once(APPPATH.'models/news2_m.php');

class Kqlibrary{
	
	
	
	/**
	 * 
	 * 
	 * @var Unionpay
	 */
	var $unionpay;
	
	/**
	 * 
	 * Enter description here ...
	 * @var User2_m
	 */
	var $user;
	
	/**
	 * 
	 * Enter description here ...
	 * @var Coupon2_m
	 */
	var $coupon;
	
	
	
	
     public function __construct(){
		
//		echo 'kqsms init';

     	$this->unionpay = new Unionpay();
     	
     	$this->coupon = new Coupon2_m();
     	
	}


	
	
	/**
	 * 
	 * "userId":"c00055685346","mobile":"13166361023","email":"","userName":"","cardList":[{"cardNo":"196222***********9533","issuerName":"\u4e2d\u56fd\u5de5\u5546\u94f6\u884c"}]}
	 * @param unknown_type $mobile
	 * @return 如果成功返回array， 如果失败返回状态码
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
	 * 银联解绑卡
	 * 成功返回true!!!
	 * 失败反悔respCd
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
	
	
	/**
	 * 从银联下载优惠券
	 * @param  $uid
	 * @param  $mobile
	 * @param  $unionUid
	 * @param unknown_type $unionCouponId
	 * @param unknown_type $transSeq
	 * @return 成功返回data数组， 失败返回respCd
	 */
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
	 * 服务器插入下载快券
	 * @param unknown_type $uid
	 * @param unknown_type $couponId
	 * @param unknown_type $transSeq
	 * @return 如果成功返回新插入的id, 失败返回false
	 */
	public function download_coupon($uid,$couponId, $transSeq){
			$CI =& get_instance();
	
			// 如果用户可以继续下载
	
			$query = $CI->db->query("insert into downloadedcoupon (uid,couponId,transSeq,createdAt) values ($uid,$couponId,'$transSeq',null)");
		
			if ($CI->db->affected_rows() == 0){
			/// 如果下载失败
				log_message('error','Insert DownloadedCoupon: uid# '.$uid.', couponId #'.$couponId);
				return false;

			}
			else{
//				
				//调用内部服务器的数据库更新
				
			
				$id =  $CI->db->insert_id();

				if($this->coupon->dcount_increment($couponId) != true){
					//如果自增没有完成，log
					
					log_message('error','DCount Increment: uid # '.$uid,', couponId #',$couponId,',downloadedCouponId #'.$id);
				}
				
				return $id;
			}

	}
	


	/**
	 * 
	 * 批量从银联下载coupons， 参数coupons应该包括 id，unionCouponId，transSeq
	 * @param unknown_type $uid
	 */
	public function download_batch_coupons($uid, $mobile, $unionUid, $coupons){
		$CI =& get_instance();

//		echo 'before download batch';
		//TODO: Test用
		$msg = '';
		foreach ($coupons as $coupon) {
			$couponId = $coupon['id'];
			$unionCouponId = $coupon['unionCouponId'];
			$transSeq = $coupon['transSeq'];
	
			
			//如果没有unioncouponid， 不用复制
			if (empty($unionCouponId)){
				continue;
			
			}
//			echo 'begin download union';
			$response = $this->download_union_coupon($uid, $mobile, $unionUid, $unionCouponId, $transSeq);
//			$json = json_encode($response);
			
			if (is_array($response)){
//				$str = implode(",", $response);
				$str = json_encode($response);	
			}
			else{
				$str = $response;
			}
			$msg = $msg.$str;
//			var_dump($response);

			//TODO: 需要确认是否删除没能复制到银联的本地快券
			if (!is_array($response)){
			// 如果下载银联的快券出错, 就必须把用户下载的快券从数据库中删除！ 
				$msg.='delete '.$couponId;
				//把transSeq的服务器记录删除
				$CI->db->query("delete from downloadedcoupon where transSeq='$transSeq'");
				
//				if($CI->db->affected_rows == 0){
//				// 服务器删除出错
//					log_message('error',"Batch Download Coupon, delete server record error. transSeq # $transSeq");
//				}
				
				
				
			}
			
			// 返回array，下载成功
			
		}
		
		return $msg;
	}
	
	/**
	 * 当银联通知票券承兑
	 * 
	 * @param unknown_type $uid
	 * @param unknown_type $unionUid
	 * @param unknown_type $unionCouponId
	 */
	public function accept_coupon($uid, $unionCouponId){
		
		$CI =& get_instance();
		
		
		// 改变downloadedcoupon中的记录,吧unused变成used
		//先获得couponId
		$query = $CI->db->query("select id from coupon where unionCouponId='$unionCouponId' limit 1");
		$results = $query->result_array();
		$couponId = $results[0]['id'];
		
		if (empty($couponId)){
		//  如果没有从unionCouponId获得couponId， 就log error 
		
			log_message("error","Kqlibrary.accept_coupon: Empty couponId -- uid # $uid, unionCouponId # $unionCouponId");
			return;
		}
		
		
//		echo 'couponId'.$couponId;
//		echo 'uid'.$uid;
		
		//改变downloadedcoupon中的记录,吧unused变成used
		$CI->db->query("update downloadedcoupon 
set status='used'
where status='unused'
and couponId=$couponId
and uid=$uid
limit 1");
		
//		echo 'after update';
		
		// 增加优惠券的承兑量
//		echo 'couponId'.$couponId;
		
		if(!$this->coupon->increment_acount($couponId)){
//			echo 'increment error';
		}
		else{
//			echo 'increment sucess';
		}
		
//		echo 'after increment acount';
		
		$umengpush = new UmengPush();
		$completeTitle = $this->coupon->get_complete_title($couponId);
		$title = '优惠券承兑完成';
		$text = "您的".$completeTitle."快券已使用,更多优惠在等着你哦！";		

		$umengpush->send_customized_notification($uid,$title, $text);
		
		/// --- 发送站内信
		
//   		unset($data);
//   		$data['uid'] = $uid;
//   		$data['title'] = '票券承兑成功';
//   		$data['text'] = $text;
//   		
//   		$news = new News2_m();
//   		$newsId = $news->insert($data);
//   		
//   		if (empty($newsId)){
//   		// 如果没有insert成功
//   			log_message('error','bind card insert news error, uid #'.$uid);
//   		}
		
		/// --- Endof发送站内信
//		
	}
	

	
	
	public function test(){
		
//		echo 'kqlibrary test';
		
//		echo $this->unionpay->test();
//		return $this->user->test();
		
//		$this->load->library('umengpush');
			
//		$this->umengpush->send_customized_notification(84,'','');
		
		$umengpush = new UmengPush();
		echo $umengpush->test();
		
	}
	
}

/* End of file Someclass.php */