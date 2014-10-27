<?php
/*
 * @author qing
 *
 */



class Kqunionapitest extends CI_Controller{

	/**
	 * 
	 * Enter description here ...
	 * @var Coupon_m
	 */
	var $coupon_m;
  
	
	/**
	 * 
	 * Enter description here ...
	 * @var User2_m
	 */
	var $user;
	
	
//	var $host = 'http://localhost';
	//
	//
	function __construct(){
		parent::__construct();
		
		$this->load->model('user2_m','user');
	}
	

	function index() {

		echo 'kqtest ';
		
	}

	
	function testsuit($servername='localhost'){
		
		header( 'Content-Type:text/html;charset=utf-8 ');
		
		
		$this->load->helper('html');
		
		$host = get_host($servername);
		
		$linkPrepend = $host.'/kq/index.php/kqapitest/';
		

		$apiLink = array('test_userinfo','test_edit','testGetUserByMobile','testBindCard','testUnbindCard');
		$apiTitle = $apiLink;
		
		
		foreach ($apiLink as $link) {
			$newApiLink[] = $linkPrepend.$link.'/'.$servername;
		}
		
		
		$data['title'] = '客户端接口测试套装';
		
		$data['titles'] = $apiTitle;
		$data['links'] = $newApiLink;
		
		$this->load->view('vtestsuit', $data);
		
	}
	
	/**
	 * 
	 * 用户信息查询-手机号码方式
	 */
	function testGetUserByMobile($servername){
	
//		header( 'Content-Type:text/html;charset=utf-8');
//		$mobile = '15166412996';
		
//		$mobile = '13166361023';
//		$response = $this->unionpay->getUserByMobile($mobile);
//
//		echo $response;
		

		$host = get_host($servername);
		
		$url = $host.'/kq/index.php/kqapi4/userinfo/uid/32/sessionToken/ptHKUzWr17FwxVQqjube';
//		echo $url;
		$response = get($url);
		echo $response;
	}
	

	// 原始命令
	function testGetUserByMobile2(){
//		'https://120.204.69.183:8090/PreWallet/restlet/outer/getUserByMobile';
		$url = $this->host.'getUserByMobile';
		
		$data = array('mobile'=>'15166412999');
		
		$data = json_encode($data);
		
		openssl_sign($data, $signToken, $this->private_key); //用私钥进行签名
		
		$signToken = bin2hex($signToken);
		
		$post = array('appId'=>$this->appId,'version'=>$this->version,'data'=>$data,'signToken'=>$signToken);

		$post = json_encode($post);
		
//		var_dump($url);
//		var_dump($post);
		
		$response = $this->post($url, $post);
		
		echo $response;
		}

	
	function testGetUserByMobile3(){
	
		header( 'Content-Type:text/html;charset=utf-8');
		$mobile = '13166361023';
		$response = $this->unionpay->getUserByMobile2($mobile);

		echo $response;
		
	}
		
	
	/**
	 * 
	 * 用户注册-银联生成密码
	 */
	function testRegByMobile(){
		
		header( 'Content-Type:text/html;charset=utf-8 ');
		
		$mobile = '13166361026';
		
		$response = $this->unionpay->regByMobile2($mobile);

		echo $response;
		
		$response = json_decode($response,true);
		
		$respCd = $response['respCd'];
		
		if($respCd == 0){
			//success
			echo 'success';
		
		}
		else if($resCd == 300102){
			// 无效的手机
			echo '无效的手机';
		}
		else if($resCd == 300304){
			// 已经注册
			echo '已经注册';
		}
		
		
	}
	
	/**
	 * 
	 * 银行卡开通服务
	 */
	function testBindCard(){
	
		header( 'Content-Type:text/html;charset=utf-8 ');
		
		$userId = 'c00050001985';
		$cardNo = '6222021001128509530';
		
		$response = $this->unionpay->bindCard($userId, $cardNo);
		echo $response;
	
	}
	
	
	/**
	 * 
	 * 银行卡关闭服务
	 */
	function testUnbindCard(){
	
		
		header( 'Content-Type:text/html;charset=utf-8 ');
		
		
		$userId = 'c00050001985';
		$cardNo = '6222021001128509534';
		
		$response = $this->unionpay->unbindCard($userId, $cardNo);
		echo $response;
		
	}
	
	function testCouponDwnById(){
	
		header( 'Content-Type:text/html;charset=utf-8 ');
	
//		$transSeq = '123456789900';
//		$userId = 'c00050001985';
//		$couponId = 'Z00000000010074';
//		$couponNum = '1';
//		$chnlUsrId = '111';
//		$chnlUsrMobile = '13166361023';
//		$couponSceneId = '000';
		
		$data['chnlUsrId'] = '111';
		$data['chnlUsrMobile'] = '131663610235555';
		$data['couponId'] = 'Z00000000010074';
		
//		$data['couponId'] = 'D00000000008029';
		$data['couponNum'] = '1';
		$data['couponSceneId'] = '000';
		$data['transSeq'] = '123456789900';
		$data['userId'] = 'c00050001986';
	
		
		$response = $this->unionpay->couponDwnById($data);
//		
//		
		echo $response;
	}
	
	function test_verify(){
		
//		if ($this->unionpay->verify_service()){
//			echo '服务器正常运行';
//		}
//		else{
//			echo '服务器出状况了';
//		}
	
		var_dump( $this->unionpay->is_server_alive());
	
		
//		var_dump($this->unionpay->is_server_alive());
	
//		var_dump($this->unionpay->isserveralive());
		
	}
		
	function test_userinfo($servername='localhost'){
		
		$host = get_host($servername);
		
		$url = $host.'/kq/index.php/kqapi4/userinfo/uid/32/sessionToken/ptHKUzWr17FwxVQqjube';
//		echo $url;
		$response = get($url);
		echo $response;
		
	}
	
	function test_edit($servername='localhost'){
		
		$host = get_host($servername);
		
		$url = $host.'/kq/index.php/kqapi4/editUserInfo';
	
		$password = array('oldPassword'=>'abc','newPassword'=>'abcdef');
		
//		$post = array('uid'=>'32','sessionToken'=>"ptHKUzWr17FwxVQqjube",'nickname'=>'ddd');
		
		$post = array('uid'=>'32','sessionToken'=>"ptHKUzWr17FwxVQqjube",'password'=>json_encode($password));
		
		$response = post($url,$post);
		echo $response;
	}
	
	
	function test(){
		$str = '000000';
		
		if ($str == 0){
			echo '=0';
		}
	}
	

}