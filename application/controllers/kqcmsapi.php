<?php
require(APPPATH.'libraries/REST_Controller.php'); 

/**
 * 
 * 从测试服务器中获取数据, iOS
 * @author Forest
 *
 */
class Kqcmsapi extends REST_Controller
{

	/**
	 * 
	 * Enter description here ...
	 * @var Coupon2_m
	 */
	var $coupon;
	
	/**
	 * 
	 * Enter description here ...
	 * @var News2_m
	 */
	var $news;
	
	function __construct(){
		parent::__construct();
		
		header("Content-type: text/html; charset=utf-8");
		
//		$this->load->library('kqlibrary');
		$this->load->model('user2_m','user');
		$this->load->model('card2_m','card');
		$this->load->model('coupon2_m','coupon');
		$this->load->model('news2_m','news');
	
	}
	
	public function sendNews_get(){
	
		
		$response = $this->news->insert_news('dddd', 'dfef');
		
		$this->output_results($response);
		
	}

	public function sendExpiringNews_get(){
	
		$couponId = $this->get('couponId');
		
		if(empty($couponId)){
		
			return $this->output_error(ErrorEmptyParameter);
		
		}
		
		$title = $this->coupon->get_complete_title($couponId);
		
		$query = $this->db->query("select B.id
from downloadedcoupon A
join user B
on A.uid=B.id
where A.couponId=$couponId
and status='unused'
");
		
		$results = $query->result_array();
		
		foreach ($results as $row) {
			$id = $row['id'];

//			$this->news->insert_news('快券到期提醒', "您的【".$title."】快券还有2天就要到期啦，赶紧前往最近的门店享用快券吧！现在还有牛奶棚满20立减10元的超值优惠，全市129家门店都通用哦！关注快券多一秒，更多优惠带给您！",$id);
		
		}
		
		
		$this->output_results($results);
		
	}
	
//public function sendExpiringNotification_get(){
//	
//		$this->load->library('umengpush');
//	
//		$couponId = $this->get('couponId');
//		
//		if(empty($couponId)){
//		
//			return $this->output_error(ErrorEmptyParameter);
//		
//		}
//		
//		$title = $this->coupon->get_complete_title($couponId);
//		
//		//and B.id in (84,106)
//		$query = $this->db->query("select B.id
//from downloadedcoupon A
//join user B
//on A.uid=B.id
//where A.couponId=$couponId
//and status='unused'
//and B.device='Android'
//"); 
//		
//		$results = $query->result_array();
//		
////		$results = array(array('id'=>5263));
//		
//		foreach ($results as $row) {
//			$id = $row['id'];
////			$this->news->insert_news('快券到期提醒', "您的【".$title."】快券还有2天就要到期啦，赶紧前往最近的门店享用快券吧！现在还有牛奶棚满20立减10元的超值优惠，全市129家门店都通用哦！关注快券多一秒，更多优惠带给您！",$id);
//
////			$this->umengpush->send_customized_notification($id,'快券到期通知', "您的【".$title."】快券还有2天就要到期啦，赶紧前往最近的门店享用快券吧！现在还有牛奶棚满20立减10元的超值优惠，全市129家门店都通用哦！关注快券多一秒，更多优惠带给您！");
//		}
//		
//		
//		$this->output_results($results);
//		
//	}
	
  /**
    * 负责echo 和return error<br>
    * 如果有error，output error<br>
    * 如果没有error，就load到view里
    * 
    * 如果error： status & msg
    * 如果成功:   status & data
    * @param id $results
    */
   private function output_results($results,$errorMsg=''){
   	
   	if ($results<0){
   			$error = array('status'=>$results,'msg'=>$errorMsg);
   			$response = json_encode($error);
			echo $response;
			return $response;
   	}
   	else{
   		    $array = array('status'=>1,'data'=>$results);
			$response = json_encode($array);
			
			$data['response']=$response;
			$this->load->view('response',$data);
			
			return $response;
   	}
   	
   }
   
   //
   private function output_success(){
   		 $array = array('status'=>1,'data'=>(object)array());
			$response = json_encode($array);
			
			$data['response']=$response;
			$this->load->view('response',$data);
			
			return $response;
   }
   
   
   
   private function output_error($status,$errorMsg=''){
   	
   			$msg = msg_with_error($status);
   	
  			$error = array('status'=>$status,'msg'=>$msg);
   			$response = json_encode($error);
			echo $response;
			return $response;
   }
}