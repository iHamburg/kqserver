<?php
require(APPPATH.'libraries/REST_Controller.php'); 


/**
 * 
 * 从测试服务器中获取数据
 * @author Forest
 *
 */
class Kqunionapi extends CI_Controller
{

	
	//
	
	function __construct(){
		parent::__construct();
		
		header("Content-type: application/json; charset=utf-8");
		
	}
	
	function index(){
		echo 'Kqunionapi';
	}
	
	
	/**
	 * 
	 * Enter description here ...
	 * 
mchntId 	string 	必填 	商户代码
couponId 	string 	必填 	票券ID
userId 	string 	必填 	持卡人用户标识码
chnlUsrId 	string 	必填 	票券获取时，交易发起方上送的渠道用户标识码
cardNo 	string 	必填 	持卡人使用票券时使用的银行卡卡号（卡号不带长度位），前四位和后四位显示，其他以*代替。
origTransAt 	string 	必填 	持卡人使用优惠券时，代表终端输入的原始交易金额（消费总金额），即实际优惠金额+实际支付金额，持卡人使用电子票时，填写默认值（全0）。 单位：分，前补0，即000000010000,代表100.00元。
transAt 	string 	必填 	持卡人使用优惠券时，代表优惠券的实际优惠金额，持卡人使用电子票时，填写默认值（全0）。 单位：分，前补0。
transDateTime 	string 	必填 	交易发生日期时间
sysTraNo 	string 	必填 	交易流水号
transAcptInsId 	string 	可选 	交易受理机构
transFwdInsId 	string 	可选 	交易发送机构 
	 */
	function couponAccepted(){
	
		$post = file_get_contents("php://input");

//		$post = $this->input->post('params');
		
		$data['originRequest'] = $post;
		
//		var_dump($post);
		if(empty($post)){
			$response = array('respCd'=>'300000','msg'=>'参数不可为空');
			echo json_encode($response);
			return;
		}
		
		$post = json_decode($post,true);
		

			
		$params = array('mchntId','couponId','userId','chnlUsrId','cardNo','origTransAt','transAt','transDateTime','sysTraNo','transAcptInsId','transFwdInsId');

		foreach ($params as $key) {
			$data[$key] = $post['data'][$key];
		}
		
		if(empty($data['mchntId']) ||empty($data['couponId'])){
			$response = array('respCd'=>'300000','msg'=>'参数不可为空');
			echo json_encode($response);
			return;
		}
		
		
		$this->load->model('u_coupon_accepted_m','uCouponAccepted');
		
		$this->uCouponAccepted->insert($data);
		
		$response = array('respCd'=>'000000','msg'=>'');
		echo json_encode($response);
			
//		}
		
//		$this->output->enable_profiler(TRUE);
		
	}
	
	function couponAccepted2(){
	
//		$post = file_get_contents("php://input");

		$post = $this->input->post('params');
		
		$data['originRequest'] = $post;
//		var_dump($post);
		if(empty($post)){
			$response = array('respCd'=>'300000','msg'=>'参数不可为空');
			echo json_encode($response);
			return;
		}
		
		$post = json_decode($post,true);
		
//判断post是否是json值
//		if(json_last_error() != JSON_ERROR_NONE){
//			
//			//'不是json字串';
//			$response = array('respCd'=>'100150','msg'=>'');
//			echo json_encode($response);
//			
//		}
//		else{

//			var_dump($post);
			
			$params = array('mchntId','couponId','userId','chnlUsrId','cardNo','origTransAt','transAt','transDateTime','sysTraNo','transAcptInsId','transFwdInsId');

			foreach ($params as $key) {
				$data[$key] = $post['data'][$key];
			}
			
			if(empty($data['mchntId']) ||empty($data['couponId'])){
				$response = array('respCd'=>'300000','msg'=>'参数不可为空');
				echo json_encode($response);
				return;
			}
			
			
			$this->load->model('u_coupon_accepted_m','uCouponAccepted');
			
			$this->uCouponAccepted->insert($data);
			
			$response = array('respCd'=>'00000','msg'=>'');
			echo json_encode($response);
			
//		}
		
//		$this->output->enable_profiler(TRUE);
		
	}

	
	//----------------------Private----------------------
  
 

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
   

   
   // --------------- TEST -----------------
   public function test_get(){
   		
   		$result = array('1'=>'c');
   		
   		$this->response($result);
   }
   
   public function test_post(){
   		$id = $this->post('id');
   		$response = 'response: '.$id;
   		$this->response($response);
   }

}