<?php


class Kqumeng{
	 
//	private $host = 'https://120.204.69.183:8090/PreWallet/restlet/outer/';
	private $host = 'http://msg.umeng.com/api/send';
	private $appkey = '5445cf0bfd98c5d70001d213';
	private $appMasterSecret = 'bqalj5hvoltwhiy9gtmnthurulr8woxf';
	
	
	
     public function __construct(){
		
//		echo 'kqsms init';
	}

	public function test(){
		
		return 'kqsms';
		 
	}
	
	public function send_test_notification(){
		
		$timestamp = now();
		$validationToken = $this->appkey.$this->appMasterSecret.$timestamp;
		
		$validationToken = md5($validationToken);
		
		$data['appkey'] = $this->appkey;
		$data['timestamp'] = $timestamp;
		$data['validationToken'] = $validationToken;
		$data['type'] = 'broadcast';
		
		$payload['display_type'] = 'notification';
		$payload['body'] = array('ticker'=>'通知栏提示文字', 'title'=>'通知标题','text'=>'通知文字描述','play_sound'=>'false','after_open'=>'go_app');
		
		$data['payload'] = $payload;
		
		
		return $validationToken;
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
		
		$response = $this->get($url);

		$xml = simplexml_load_string($response);
		
		$code = $xml->code;
		
		if ($code == 2)
			return true;
		else 
			return $code;
	}
	
//	public function mock_send_register_sms($mobile, $captcha){
//		
//		$content = "您的验证码是：【".$captcha."】。请不要把验证码泄露给其他人。";
//		
//		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=$this->account&password=$this->password&mobile=$mobile&content=$content";
//		
//		return $url;
//		
//	}
	
	public function send_forgetpwd_sms($mobile, $captcha){
		
		$content = "您的验证码是：【".$captcha."】。请不要把验证码泄露给其他人。";

		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=$this->account&password=$this->password&mobile=$mobile&content=$content";
		
		$response = $this->get($url);
		
		$xml = simplexml_load_string($response);
		
		$code = $xml->code;
		
		if ($code == 2)
			return true;
		else 
			return $code;
		
	}
	
//	public function mock_send_forgetpwd_sms($mobile, $captcha){
//		
//		$content = "您的验证码是：【".$captcha."】。请不要把验证码泄露给其他人。";
//		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=$this->account&password=$this->password&mobile=$mobile&content=$content";
//		
//		return $url;
//		
//	}
	
	public function send_coupon_accepted_sms($mobile,$coupon){
	
		$content = "您的优惠券刚刚被承兑";
		
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=$this->account&password=$this->password&mobile=$mobile&content=$content";
		
		return $this->get($url);
	}
	
//	public function mock_send_coupon_accepted_sms($mobile,$coupon){
//	
//		$content = "您的优惠券刚刚被承兑";
//		
//		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=$this->account&password=$this->password&mobile=$mobile&content=$content";
//		
//		return $url;
//	}
	
//	public function insert_db(){
//	
//		$query = $this->db->query("insert into s_sms (type,code,mobile) values ('forget',$code,$mobile)");
//	}
	
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

	
}

/* End of file Someclass.php */