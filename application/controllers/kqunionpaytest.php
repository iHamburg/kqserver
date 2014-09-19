<?php
/*
 * @author qing
 *
 */




class Kqunionpaytest extends CI_Controller{

	
	/**
	 * 
	 * Enter description here ...
	 * @var Unionpay
	 */
	var $unionpay;
	
	function __construct(){
		parent::__construct();
		
	
		header( 'Content-Type:text/plain;charset=utf-8 '); 
		
		$this->load->library('unionpay');
		$this->load->library('rsa');
		
	}
	

	function index() {

		echo 'union pay test';
		
	}
	
	function testSignature(){
		
		$public_key = '-----BEGIN PUBLIC KEY-----  
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC3//sR2tXw0wrC2DySx8vNGlqt  
3Y7ldU9+LBLI6e1KS5lfc5jlTGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2kl  
Bd6h4wrbbHA2XE1sq21ykja/Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o  
2n1vP1D+tD3amHsK7QIDAQAB  
-----END PUBLIC KEY-----';  
		
//	
//	$plain = '111';
		
		$plain = '+X4c15qsPe4WmkuswtWCI32abzR62wrLBZx/OjWBwVQjSFZVMJf1oz8LWgtLA47S2zJsWtoahcPfRxe4kJn5';
		
		$encrypted = $this->unionpay->private_key_signature($plain);	
		
		echo 'encrypted :'.$encrypted;
		echo "\n";
		$encrypted2 = $this->rsa->sign($plain);
		
		echo '    encrypted :'.$encrypted;
		echo "\n";
		echo 'sss';
		$decrypted='';
			$pu_key = openssl_pkey_get_public($public_key);//这个函数可用来判断公钥是否是可用的 
		openssl_public_decrypt(base64_decode($encrypted),$decrypted,$pu_key);//私钥加密的内容通过公钥可用解密出来  
		echo $decrypted,"\n";  
	}
	
	
	
	function testRSA(){
		$private_key = '-----BEGIN RSA PRIVATE KEY-----  
MIICXQIBAAKBgQC3//sR2tXw0wrC2DySx8vNGlqt3Y7ldU9+LBLI6e1KS5lfc5jl  
TGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2klBd6h4wrbbHA2XE1sq21ykja/  
Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o2n1vP1D+tD3amHsK7QIDAQAB  
AoGBAKH14bMitESqD4PYwODWmy7rrrvyFPEnJJTECLjvKB7IkrVxVDkp1XiJnGKH  
2h5syHQ5qslPSGYJ1M/XkDnGINwaLVHVD3BoKKgKg1bZn7ao5pXT+herqxaVwWs6  
ga63yVSIC8jcODxiuvxJnUMQRLaqoF6aUb/2VWc2T5MDmxLhAkEA3pwGpvXgLiWL  
3h7QLYZLrLrbFRuRN4CYl4UYaAKokkAvZly04Glle8ycgOc2DzL4eiL4l/+x/gaq  
deJU/cHLRQJBANOZY0mEoVkwhU4bScSdnfM6usQowYBEwHYYh/OTv1a3SqcCE1f+  
qbAclCqeNiHajCcDmgYJ53LfIgyv0wCS54kCQAXaPkaHclRkQlAdqUV5IWYyJ25f  
oiq+Y8SgCCs73qixrU1YpJy9yKA/meG9smsl4Oh9IOIGI+zUygh9YdSmEq0CQQC2  
4G3IP2G3lNDRdZIm5NZ7PfnmyRabxk/UgVUWdk47IwTZHFkdhxKfC8QepUhBsAHL  
QjifGXY4eJKUBm3FpDGJAkAFwUxYssiJjvrHwnHFbg0rFkvvY63OSmnRxiL4X6EY  
yI9lblCsyfpl25l7l5zmJrAHn45zAiOoBrWqpM5edu7c  
-----END RSA PRIVATE KEY-----';  
  
	$public_key = '-----BEGIN PUBLIC KEY-----  
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC3//sR2tXw0wrC2DySx8vNGlqt  
3Y7ldU9+LBLI6e1KS5lfc5jlTGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2kl  
Bd6h4wrbbHA2XE1sq21ykja/Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o  
2n1vP1D+tD3amHsK7QIDAQAB  
-----END PUBLIC KEY-----';  

//	echo 'private key '.$private_key;
//	echobr();
//	echo 'public key '.$public_key;
		
	$pi_key =  openssl_pkey_get_private($private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id  
	$pu_key = openssl_pkey_get_public($public_key);//这个函数可用来判断公钥是否是可用的  
	//print_r($pi_key);echo "\n";  
	//print_r($pu_key);echo "\n";  

	$data = "aassssasssddd";//原始数据  
	$encrypted = "";   
	$encrypted2 = "";
	$decrypted = ""; 
	
	echo "source data:",$data."\n";  
  
	
	echo "private key encrypt:\n";  
  
	openssl_private_encrypt($data,$encrypted,$pi_key);//私钥加密  
	
	$encrypted = base64_encode($encrypted);//加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的  
	echo 'pi_key after base64'.$encrypted,"\n";

	
	openssl_sign($data,$encrypted2,$pi_key);
	$encrypted2 = base64_encode($encrypted2);
	echo 'pi_key after sign'.$encrypted2,"\n";
	
	
	
	echo "public key decrypt:\n";  
  
	openssl_public_decrypt(base64_decode($encrypted),$decrypted,$pu_key);//私钥加密的内容通过公钥可用解密出来  
	echo $decrypted,"\n";  
	
//	openssl_verify(base64_decode($encrypted2), $signature, $pub_key_id)

	}
	
	/*
	 * 增值服务查询：
	 *	https://202.101.25.188:10385/cardholder/qryacctsvcWSProxy
	 * */
	function testQueryService(){
	
		$url = 'https://202.101.25.188:10385/cardholder/qryacctsvcWSProxy';
		
		echo $this->get($url);
	
	}
	
	/**
	 * 用户信息查询
	 * https://202.101.25.188:10385/cardholder/UC/UCUserService/UCUserServiceProxy/outer/user/getuserbylogin
	 */
	function testUser(){
		
		$private_key = '-----BEGIN PRIVATE KEY-----
MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBAN6SDIGnM3oL5LOZ
qDcZzn95XO9ICZiiYj/vNlJX9kuVgg4bJ8897lSYFfG0ZVcWY2xofQjz8ePkKQ7/
WtiZigbONo7lHFw/GIcdnhb/7MRsHodk3/XU6wXoi7fuvct3tEFuwIZk4EJLoyC2
TOzkPcaritLtU00QNP9ol0VSFJFdAgMBAAECgYEAouXF3YbgeC0IQCLwKRPsPQQ4
brEMxPfkbOLJoU7b5soQG/7oDhhHvQZq2TKtESZDsm5vRQQ2QBMXsfBXLzyA9cgy
lhWGk/XqhqY4Ykez4am2B8luggLSNM98yiOrlsUjXJF7AUTi//ku4pHUGAg6msrX
6J5v+eg4Crnppuyz/YECQQD8oFTyFnnMhLdwwhUkr4cDY+siV8+hnwVaci7wlY4Z
NIGn4iycw+VK3IVJspJSsIJq0Wnpiy9qOodeekqDDTfxAkEA4Yr2q0cpAyLHYJue
Ha932khzw8YYQLPai7i2EU7mQL0S+lpGRQ/WfEWkdiRkxXqBrN8tsjz0PfKY0f8s
PTl8LQJBAPupoVXVrBpgr/mlbriwH5jyBgCdZ5tDNmsGytoisn9LfkpHl1fIEvjD
vAhR21CCxDkzSwY8AM0bZ1VoECiDl5ECQEqjai4URoY7JC/cT98TCl66S1UmYTBI
VLKYVeg0bA5Qg89FwKtqKljF0z8lnBOeDvvef4jUkx9NATW9dC5ur6ECQQDs135T
sl3scJ9I++rAnBlnPBh7cLfWSqg5i9M3h//GoKdPVxbtjTczyI2uffuZrqiXFQeb
P9q4YCRkEkgYb4ZZ
-----END PRIVATE KEY-----';
		
		$url = 'https://202.101.25.188:10385/cardholder/UC/UCUserService/UCUserServiceProxy/outer/user/getuserbylogin';
		
//		$venderId = 'T00000000000159';
//		$onlTransPwd = '12345678998765432111111100000099';

		$venderId = 'kuaiquanwang';
		$onlTransPwd = '2014091600';
		
		$data = array('mobile'=>'13123456789');
		$data = json_encode($data); // 打成JSON串
		openssl_sign($data, $signToken, $private_key); //用私钥进行签名
//		$signToken = base64_encode($signToken);
		$post = array('venderId'=>$venderId,'$onlTransPwd'=>$onlTransPwd,'data'=>$data,'signToken'=>$signToken);
		//
//	  $response = $this->post($url,$post);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);	
		
		$output = curl_exec($ch);

		curl_close($ch);
		
     	echo 'response get user:'.$output;	

		
	}
	
	
	
	
	function testSign(){
		$this->unionpay->testSign();
	}
	
	
	//https://202.101.25.188:10385/cardholder/UC/UCUserService/UCUserServiceProxy/outer/user/mobileregister
	function testRegister(){
			$private_key = '-----BEGIN PRIVATE KEY-----
MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBAN6SDIGnM3oL5LOZ
qDcZzn95XO9ICZiiYj/vNlJX9kuVgg4bJ8897lSYFfG0ZVcWY2xofQjz8ePkKQ7/
WtiZigbONo7lHFw/GIcdnhb/7MRsHodk3/XU6wXoi7fuvct3tEFuwIZk4EJLoyC2
TOzkPcaritLtU00QNP9ol0VSFJFdAgMBAAECgYEAouXF3YbgeC0IQCLwKRPsPQQ4
brEMxPfkbOLJoU7b5soQG/7oDhhHvQZq2TKtESZDsm5vRQQ2QBMXsfBXLzyA9cgy
lhWGk/XqhqY4Ykez4am2B8luggLSNM98yiOrlsUjXJF7AUTi//ku4pHUGAg6msrX
6J5v+eg4Crnppuyz/YECQQD8oFTyFnnMhLdwwhUkr4cDY+siV8+hnwVaci7wlY4Z
NIGn4iycw+VK3IVJspJSsIJq0Wnpiy9qOodeekqDDTfxAkEA4Yr2q0cpAyLHYJue
Ha932khzw8YYQLPai7i2EU7mQL0S+lpGRQ/WfEWkdiRkxXqBrN8tsjz0PfKY0f8s
PTl8LQJBAPupoVXVrBpgr/mlbriwH5jyBgCdZ5tDNmsGytoisn9LfkpHl1fIEvjD
vAhR21CCxDkzSwY8AM0bZ1VoECiDl5ECQEqjai4URoY7JC/cT98TCl66S1UmYTBI
VLKYVeg0bA5Qg89FwKtqKljF0z8lnBOeDvvef4jUkx9NATW9dC5ur6ECQQDs135T
sl3scJ9I++rAnBlnPBh7cLfWSqg5i9M3h//GoKdPVxbtjTczyI2uffuZrqiXFQeb
P9q4YCRkEkgYb4ZZ
-----END PRIVATE KEY-----';
		
		$url = 'https://202.101.25.188:10385/cardholder/UC/UCUserService/UCUserServiceProxy/outer/user/mobileregister';
		
		$venderId = 'kuaiquanwang';
		$onlTransPwd = '2014091600';
		
		$mobile = '1312345678';
		$openService = '208';
		$data = array('mobile'=>$mobile,'openService'=>$openService);
		$data = json_encode($data);
		
		openssl_sign($data, $signToken, $private_key); //用私钥进行签名
//		$signToken = base64_encode($signToken);
		$post = array('venderId'=>$venderId,'$onlTransPwd'=>$onlTransPwd,'data'=>$data,'signToken'=>$signToken);
	
		
		$response = $this->post($url,$post);
		 
			echo 'response register:'.$response;	
	}
	
	function test(){
//		$url = HOST."/users?keys=phone,username";
//		echo $this->avoslibrary->get($url);
		
//	$data = array('shop'=>avosPointer('Shop', '53bbece4e4b0dea5ac1c8907'));
//		
//		echo $this->updateObject('Coupon','539e8dfce4b023daacbd6fa3',json_encode($data));
	
//		echo $this->addShopBranchesToShop(array('539e8c51e4b0c92f1847dc23','539e8c52e4b0c92f1847dc24'), '539e8c52e4b0c92f1847dc25');

//		echo $this->addCouponToShop('539d8cd9e4b0a98c8733f8dc', '539d8817e4b0a98c8733f287');

//		echo decodeUnicode($this->coupon_m->addInShop('539d8cd9e4b0a98c8733f8dc', '539d8817e4b0a98c8733f287'))	;
	}
	
	
	/////////////////
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $url
	 */
	function get($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
	
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
	}

	function post($url='',$data=''){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	
		
		$output = curl_exec($ch);

		curl_close($ch);
		
		return $output;
	}
	
	function vpost($url,$data){ // 模拟提交数据函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
//    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
//    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
//    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回

    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
       echo 'Errno:'.curl_error($curl);//捕抓异常
    }
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据
}
	
	
	function put($url='',$objJson='',$header=''){
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		
		if(empty($header)){
			$header = $this->jsonHeader;
		}
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	
		curl_setopt($ch, CURLOPT_POSTFIELDS, $objJson);	
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
	}
	

	function delete($url='',$header=''){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		
		if(empty($header)){
			$header = $this->jsonHeader;
		}
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
	}
	

}