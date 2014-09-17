<?php

define('HOST','https://cn.avoscloud.com/1');


define('Error_Create_Object', -8201);
define('Error_Add_Object_In_Array', -8202);
define('Error_Delete_Object', -8203);
define('Error_Remove_Object_In_Array', -8204);
define('Error_Retrieve_Object', -8205);
define('Error_Update_Object', -8206);
define('Error_Search_Shop',-8207);


define('union_test_private_key','-----BEGIN RSA PRIVATE KEY-----  
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
-----END RSA PRIVATE KEY-----');

define('union_test_public_key','-----BEGIN PUBLIC KEY-----  
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC3//sR2tXw0wrC2DySx8vNGlqt  
3Y7ldU9+LBLI6e1KS5lfc5jlTGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2kl  
Bd6h4wrbbHA2XE1sq21ykja/Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o  
2n1vP1D+tD3amHsK7QIDAQAB  
-----END PUBLIC KEY-----');

define('union_private_key','-----BEGIN PRIVATE KEY-----
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
-----END PRIVATE KEY-----');

class Unionpay{
	
	
	 public $header;
     
	 public $jsonHeader;
     

     public function __construct(){
		
		
//		$appid = 'ezxvldwk94k38d6fki1ks4yq55jkl2t15tttu5ezdqbk8mio';
//		$appkey = 'mtbrztjctplgnho2qf49cs70gd4lfggiayww7u6h4mv5s60t';
//		
//		$this->header =  array(
//			'X-AVOSCloud-Application-Id:'.$appid,
//			'X-AVOSCloud-Application-Key:'.$appkey,
//		);
//		
//		$this->jsonHeader = array(
//			'X-AVOSCloud-Application-Id:'.$appid,
//			'X-AVOSCloud-Application-Key:'.$appkey,
//		  	'Content-Type: application/json;charset=utf-8');
	}
	
	/**
	 * 
	 * 是经过base64转码的，但没有经过url处理
	 * @param unknown_type $plain
	 */
	function private_key_signature($plain){
		$pi_key =  openssl_pkey_get_private(union_private_key);
		
//		print_r($pi_key);echo "\n";
		$encrypted = "";   
		$decrypted = ""; 
		
		openssl_private_encrypt($data,$encrypted,$pi_key);//私钥加密  
	
		$encrypted = base64_encode($encrypted);//加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的  
		
		return $encrypted;
	} 

	function sign($plain){
		
	}
	
	function verify($plain){
		
	}
	
	function testSign(){
		$data = "Beeeeer is really good.. hic...";
		$binary_signature = "";
		openssl_sign($data, $binary_signature, union_test_private_key);
		
		echo 'binary signature:'.$binary_signature;
		echo "\n";
		
		$signature = base64_encode($binary_signature);
		
		echo 'signature:'.$signature;
		echo "\n";
		
//		$ok = openssl_verify($data, $binary_signature, union_test_public_key);
//		
//		echo 'ok: '.$ok;
	
	$ok = openssl_verify($data, $binary_signature, union_test_public_key);
echo "check #1: ";
if ($ok == 1) {
    echo "signature ok (as it should be) ";
} elseif ($ok == 0) {
    echo "bad (there's something wrong) ";
} else {
    echo "ugly, error checking signature ";
}

//$ok = openssl_verify('tampered'.$data, $binary_signature, union_test_public_key);
$ok = openssl_verify($data.'a', $binary_signature, union_test_public_key);
echo "check #2: ";
if ($ok == 1) {
    echo "ERROR: Data has been tampered, but signature is still valid! Argh! ";
} elseif ($ok == 0) {
    echo "bad signature (as it should be, since data has beent tampered) ";
} else {
    echo "ugly, error checking signature ";
}
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
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
	
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
	}

	function post($url='',$objJson=''){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->jsonHeader);
	
		curl_setopt($ch, CURLOPT_POSTFIELDS, $objJson);	
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
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
	
	/**
	 * 执行Batch命令
	 * @param array $requests
	 */
	function batch($requests=''){
	   	 $requestsJson = json_encode(array('requests'=>$requests));

         return $this->post('https://cn.avoscloud.com/1/batch',$requestsJson);
	}
}

/* End of file Someclass.php */