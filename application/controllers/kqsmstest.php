<?php
/*
 * @author qing
 *
 */




class Kqsmstest extends CI_Controller{

	/**
	 * 
	 * Enter description here ...
	 * @var Kqsms
	 */
	var $kqsms;
	
	function __construct(){
		parent::__construct();
		
		header("Content-type: text/plain; charset=utf-8");
		
		$this->load->library('kqsms');
	}
	

	function index() {

		echo 'kqsms';
		
	}
	
	function testGet(){
		$captcha = '1245';
		
//		$url = 'http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=cf_yuece&password=1234567&mobile=18001616376&content=您的验证码是：【123456】。请不要把验证码泄露给其他人。';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	
		$output = curl_exec($ch);
		curl_close($ch);
		

		var_dump($output);
	} 
	
	
	function testPost(){
		$captcha = '1245';
		$url = 'http://106.ihuyi.cn/webservice/sms.php?method=Submit';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	
		
		$output = curl_exec($ch);

		curl_close($ch);

		var_dump($output);
	}
		

	
	/**
	 * 
	 *  2 提交成功 33745434 
	 *   406 手机格式不正确 0 
	 */
	function test_register(){
		
		$response = $this->kqsms->send_register_sms('13166361023', '456789');
		
//		echo ($response);
		
		$xml = simplexml_load_string($response);
		
		$code = $xml->code;

		
		if ($code == 2){
			echo 'success';
		}
		else{
			echo 'failure';
		}
		
		$query = $this->db->query("insert into s_sms (type,code) values ('register',$code)");

	}
	
	function test_coupon_accepted(){
		
		$result = $this->kqsms->mock_send_coupon_accepted_sms('13166361023',null);
		echo $result;
		
	}
	
	
	
	function test(){
//		$url = HOST."/users?keys=phone,username";

		$this->load->library('kqsms');
		
		echo $this->kqsms->test();
		
		echo 'abc';

	}
	

}