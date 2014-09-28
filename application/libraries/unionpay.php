<?php


class Unionpay{
	
	  
	private $private_key='-----BEGIN PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAO9F1ub3EmcROVb9
TuwbvGEwZaDeldcDtQNYvHpC5Xm+0v32pGCCJ05qK3zEpumz8bpHcBqVw94cZVia
4iVaEWkFnWm710b7NdNeMBFhC/L9NYl0jDsoRhCL/57OxbttvMPi0YbpQc0Qfn80
QnYZYcwic640UVUz5DzJ/sVOrleFAgMBAAECgYBUSTfQmIxE/k5ClGyuw35yhgfm
yUHjQg0LpsCOGO6ZGl1c1PtGe9K4zrGO+/8IKDkos22MD+G1Zi9VLQooujeTJtps
fHsp9DhGgglfhOwH8kkCtgVaH6sovgzIj5plln6la/GDAcRe5kGn1xoTDusnVqw9
OqC27gybn/hM3lFOaQJBAP14rXdpap1EKbigSSEGP0PwiA0c2yu1EknxQ8fRJWS7
DyIRn9K1vsxCbxfLY2PYlPWFz8fCPMRJhqO3BP4OxacCQQDxqOavBS0UT4iqJ1+W
zz7dV6sTd/p3gbVBy5It7wGWnDiBa9Z2beLm1k84oc7mb56Mf6VDCuAeILEs3jJ1
PLbzAkBvVzc7oP7IHk0FYMM+0nOv8FSTDf3ocR2bhXN0rpZybQj0ujEuac9qAjSy
ixEZpuWoBCOFZ/kxb+rIt3hl8S85AkEA6TZEmTb3kBhJHVwuBY4vbtBCCuHIVzhX
wg1BHw7+i2hrp4p4R4Y4aOj9Pvv4fa3OZmxxAkgmjSyjj1dHfph/PQJAbmRVNakH
+18qzzh7budS3A1kPTDx4xeT+Rtt6bhz0nfmuBuUGRa2Mt4CVNVspkAXMU7j+0mF
sp5Ykcw0iwSbUA==
-----END PRIVATE KEY-----';
	 
	private $host = 'https://120.204.69.183:8090/PreWallet/restlet/outer/';
	private $appId = 'ALLPERM';
	private $version = '1.0';
	private $appSecret = '1aabac6d068eef6a7bad3fdf50a05cc8';  //AES加密用
	private $infSource = 'ALLPERM';
	
     public function __construct(){
		
		
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $mobile
	 * respCd":"300304"  用户名被占用 
	 * 成功： {"data":{"mobile":"15166412998","userId":"c00050001982"},"respCd":"000000","msg":""}
	 */
	public function regByMobile($mobile){
		
		//https://120.204.69.183:8090/PreWallet/restlet/outer/regByMobile
		$url = $this->host.'regByMobile';
		
		$data = array('mobile'=>$mobile,
					'infSource'=>$this->infSource);
		
		$data = json_encode($data);
		
		openssl_sign($data, $signToken, $this->private_key); //用私钥进行签名
		
		$signToken = bin2hex($signToken);

		$post = array('appId'=>$this->appId,'version'=>$this->version,'data'=>$data,'signToken'=>$signToken);

		$post = json_encode($post);
		
		$response = $this->post($url, $post);

		
		return $response;
	}
	
	/**
	 * 
	 * 用户信息查询-手机号码方式
	 */
	public function getUserByMobile($mobile){

		$url = $this->host.'getUserByMobile';
		
		$data = array('mobile' => $mobile);
		
		$data = json_encode($data);
		
		openssl_sign($data, $signToken, $this->private_key); //用私钥进行签名
		
		$signToken = bin2hex($signToken);

		$post = array('appId'=>$this->appId,'version'=>$this->version,'data'=>$data,'signToken'=>$signToken);

		$post = json_encode($post);
		
//		var_dump($url);
//		var_dump($post);
		
		
		$response = $this->post($url, $post);

		
		return $response;
	}
	
	/**
	 * 
	 * 银行卡开通服务
	 * respCd: 300500   无效的卡号
	 */
	function bindCard($userId,$cardNo){
	
//	    'https://120.204.69.183:8090/PreWallet/restlet/outer/bindCard';
		$url = $this->host.'bindCard';

		$cardNo = strlen($cardNo).$cardNo; //卡号前带两位长度位
		
		$needAuth = '0';

		$key = $this->generateAESKey($this->appSecret);
		
		$content = $this->pad2Length($cardNo, 16);  //把明文padding
		$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');      
		$iv_size = mcrypt_enc_get_iv_size($cipher);      
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);//ECB模式，iv不同最后的结果也是一样的
		$cipherText = mcrypt_encrypt(MCRYPT_RIJNDAEL_128,$key,$content,MCRYPT_MODE_ECB,$iv); 
		$encrypted = base64_encode($cipherText);

		
		$data = array('userId'=>$userId, 'cardNo'=>$encrypted, 'needAuth'=>$needAuth);
		$data = json_encode($data);
		
		openssl_sign($data, $signToken, $this->private_key); //用私钥进行签名
		$signToken = bin2hex($signToken);
		
		$post = array('appId'=>$this->appId,'version'=>$this->version,'data'=>$data,'signToken'=>$signToken);
		$post = json_encode($post);
		
//		var_dump($url);
//		var_dump($post);
		
		
		$response = $this->post($url, $post);
		return $response;
		
	}
	
	function unbindCard($userId,$cardNo){
	
//	    'https://120.204.69.183:8090/PreWallet/restlet/outer/unBindCard';
		$url = $this->host.'unBindCard';

		$cardNo = strlen($cardNo).$cardNo; //卡号前带两位长度位
		

		$key = $this->generateAESKey($this->appSecret);
		
		$content = $this->pad2Length($cardNo, 16);
		$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');      
		$iv_size = mcrypt_enc_get_iv_size($cipher);      
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		
		$cipherText = mcrypt_encrypt(MCRYPT_RIJNDAEL_128,$key,$content,MCRYPT_MODE_ECB,$iv); 
		
		$encrypted = base64_encode($cipherText);
		
		$data = array('userId'=>$userId, 'cardNo'=>$encrypted);
		
		$data = json_encode($data);
		
		openssl_sign($data, $signToken, $this->private_key); //用私钥进行签名
		
		$signToken = bin2hex($signToken);
		
		$post = array('appId'=>$this->appId,'version'=>$this->version,'data'=>$data,'signToken'=>$signToken);

		$post = json_encode($post);
		
//		var_dump($url);
//		var_dump($post);
		
		
		$response = $this->post($url, $post);
		
		return $response;
		
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
	
	/**
	 * 
	 * 给明文加padding， PKCS5Padding
	 * @param unknown_type $text
	 * @param unknown_type $padlen
	 */
	private  function pad2Length($text, $padlen){    
	    $len = strlen($text)%$padlen;    
	    $res = $text;    
	    $span = $padlen-$len;    
	    for($i=0; $i<$span; $i++){    
	        $res .= chr($span);
	    
	    }    
	    return $res;    
	
	}    
	
	/**
	 * 
	 * 把secret 转成16位的密码
	 * @param unknown_type $key
	 */
	private function  generateAESKey($key){
		
		$md5 = md5($key,TRUE);
		$result = base64_encode($md5);
		
		while (strlen($result)<16) {
			$result.='%';
		}
		
		if(strlen($result)>16){
		
			$nbegin = (strlen($result) - 16) / 2;
			$result = substr($result,$nbegin,16);
		}
		
		return $result;
	}


}

/* End of file Someclass.php */