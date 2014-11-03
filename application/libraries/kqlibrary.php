<?php

require_once(APPPATH.'libraries/unionpay.php'); 
//require_once(APPPATH.'libraries/kqsms.php');
require_once(APPPATH.'models/user2_m.php'); 
require_once(APPPATH.'models/coupon2_m.php'); 

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

//     	$this->load->library('unionpay');

     	$this->unionpay = new Unionpay();
     	$this->user = new User2_m();
     	$this->coupon = new Coupon2_m();
     	
//     	$this->load->model('user2_m','user');
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
		foreach ($coupons as $coupon) {
			$couponId = $coupon['id'];
			$unionCouponId = $coupon['unionCouponId'];
			$transSeq = $coupon['transSeq'];
	
			
			//TODO  如果没有unioncouponid，应该服务器删除记录
			if (empty($unionCouponId)){
				continue;
			
			}
			
			$response = $this->download_union_coupon($uid, $mobile, $unionUid, $unionCouponId, $transSeq);
			
			if (!is_array($response)){
			//如果下载银联的快券出错, 就必须把用户下载的快券从数据库中删除！ dCouponCount也应该减小

				//把transSeq的服务器记录删除
				$CI->db->query("delete from downloadedcoupon where transSeq='$transSeq'");
				
				if($CI->db->affected_rows == 0){
				// 服务器删除出错
					log_message('error',"Batch Download Coupon, delete server record error. transSeq # $transSeq");
				}
				
			}
			
		}
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
		
		//改变downloadedcoupon中的记录,吧unused变成used
		$CI->db->query("update downloadedcoupon 
set status='used'
where status='unused'
and couponId=$couponId
limit 1");
		
		// 增加优惠券的承兑量
//		echo 'couponId'.$couponId;
		
		if(!$this->coupon->increment_acount($couponId)){
//			echo 'increment error';
		}
		else{
//			echo 'increment sucess';
		}
		
	}
	

	
	
	public function test(){
		
//		echo 'kqlibrary test';
		
//		echo $this->unionpay->test();
		return $this->user->test();
		
	}
	
}

/* End of file Someclass.php */