<?php
/*
 * @author qing
 *
 */




class Kqsms extends CI_Controller{

	
	
	function __construct(){
		parent::__construct();
		
		header("Content-type: text/html; charset=utf-8");
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
//		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
	
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
		
	
	function test(){
//		$url = HOST."/users?keys=phone,username";

	}
	

}