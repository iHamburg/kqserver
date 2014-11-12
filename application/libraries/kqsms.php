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
		
//		$content = "您的验证码是：【".$captcha."】。请不要把验证码泄露给其他人。";
		$content = "注册验证码：【".$captcha."】，请完成验证。如非本人操作，千万提高警惕，一定有人在惦记着你！";
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
		
//		$content = "您的验证码是：【".$captcha."】。请不要把验证码泄露给其他人。";
		$content = "找回密码验证码：【".$captcha."】，请完成验证。如非本人操作，千万提高警惕，一定有人在惦记着你！";
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=$this->account&password=$this->password&mobile=$mobile&content=$content";
		
		$response = $this->get($url);
		
		$xml = simplexml_load_string($response);
		
		$code = $xml->code;
		
//		var_dump($code);
		
		if ($code == 2)
			return true;
		else 
			return $code;
		
	}
	
	public function send_bind_card_sms($mobile,$endCardNo){
	
		
	
		
//		
		$content = "尾号【".$endCardNo."】的银联卡已在快券添加成功，您会同时收到来自银联的相关服务通知！精致生活怎能没有下午茶？我们向您呈上风靡全球的美味点心——价值18元摩提工房美味摩提！关注快券多一秒，更多优惠带给您！";
		
		
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