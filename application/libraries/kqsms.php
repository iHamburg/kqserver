<?php


class Kqsms{
	 
//	private $host = 'https://120.204.69.183:8090/PreWallet/restlet/outer/';
	private $account = 'cf_yuece';
	private $password = '1234567';
	
	
     public function __construct(){
		
//		echo 'kqsms init';
	}

	public function test(){
		
		return 'kqsms'; 
	}
	
	/**
	 * 
	 * 成功返回值 2 提交成功 33600318 
	 * @param unknown_type $mobile
	 * @param unknown_type $captcha
	 */
	public function send_register_sms($mobile, $captcha){
		
		$content = "您的验证码是：【".$captcha."】。请不要把验证码泄露给其他人。";
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=$this->account&password=$this->password&mobile=$mobile&content=$content";
		
		return $this->get($url);
//		return $url;
		
	}
	
	public function mock_send_register_sms($mobile, $captcha){
		
		$content = "您的验证码是：【".$captcha."】。请不要把验证码泄露给其他人。";
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=$this->account&password=$this->password&mobile=$mobile&content=$content";
		
		return $url;
		
	}
	
	public function send_forgetpwd_sms($mobile, $captcha){
		
		$content = "您的验证码是：【".$captcha."】。请不要把验证码泄露给其他人。";
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=$this->account&password=$this->password&mobile=$mobile&content=$content";
		
		return $this->get($url);

		
	}
	
	public function mock_send_forgetpwd_sms($mobile, $captcha){
		
		$content = "您的验证码是：【".$captcha."】。请不要把验证码泄露给其他人。";
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=$this->account&password=$this->password&mobile=$mobile&content=$content";
		
		return $url;
		
	}
	
	public function send_coupon_accepted_sms($mobile,$coupon){
	
		$content = "您的优惠券刚刚被承兑";
		
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=$this->account&password=$this->password&mobile=$mobile&content=$content";
		
		return $this->get($url);
	}
	
	public function mock_send_coupon_accepted_sms($mobile,$coupon){
	
		$content = "您的优惠券刚刚被承兑";
		
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=$this->account&password=$this->password&mobile=$mobile&content=$content";
		
		return $url;
	}
	/////////////////
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $url
	 */
	private function get($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	
	
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
	}

	private function post($url='',$objJson=''){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
            'Content-Type: application/json; charset=utf-8')  
        );  // 要求用json格式传递参数
		
	
	
		curl_setopt($ch, CURLOPT_POSTFIELDS, $objJson);	
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
	}
	
}

/* End of file Someclass.php */