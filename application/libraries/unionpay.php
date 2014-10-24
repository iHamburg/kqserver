<?php


class Unionpay{
	
	  
	
	 
//	private $host = 'https://120.204.69.183:8090/PreWallet/restlet/outer/';
//	private $host = 'https://esb.unionpay.com/cardholder/PREWALLET/PREWALLETOuterService/PREWALLETOuterServiceProxy/';
	
	private $host;
	private $appId;
	private $appSecret;  	//AES加密用
	private $infSource;  //业务来源，接入机构需向运营方申请 
	private $version ;
	private $private_key;
	
    public function __construct(){
		
//		echo 'unionpay construct';

//     	echo 'ENVIRONMENT'.ENVIRONMENT;
     	
     	switch (ENVIRONMENT) {
     		case 'testing':
     		case 'rtesting':
     		
     			$this->host = 'https://120.204.69.183:8090/PreWallet/restlet/outer/';
     			$this->appId = 'ALLPERM';
     			$this->appSecret = '1aabac6d068eef6a7bad3fdf50a05cc8';
     			$this->infSource = 'ALLPERM';
     			$this->version = '1.0';
     			$this->private_key='-----BEGIN PRIVATE KEY-----
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
     			;
     		break;
     		case 'production':
     			$this->host = 'https://esb.unionpay.com/cardholder/PREWALLET/PREWALLETOuterService/PREWALLETOuterServiceProxy/';
     			$this->appId = 'C0000048';
     			$this->appSecret = '12345678998765432111111100000099';
     			$this->infSource = 'C0000048';
     			$this->version = '1.0';
     			$this->private_key='-----BEGIN PRIVATE KEY-----
MIICdQIBADANBgkqhkiG9w0BAQEFAASCAl8wggJbAgEAAoGBAPK846+hVVxsCLyN
Blo7wuBivFI3F4ASbgBH+pRL7kJgfS2Q/OzHeSRF/jlktUcK/dSzd6tGn6mtdtUb
dc6zSPA+f2nKS458N+jGFyv6Fj78h1oUXDClm3rLpvnx+qJmqLyaxcm1bpKTNslq
T/2ODdQzu58gZYejZzoAVirOGx1pAgMBAAECgYAxsMlLYtN+n/8J2jS6tBEorg2v
JugAp8Us+Y8qXIDhxa7abRvZvNvnuQxZ42vYpz9fE34j6ck1ivUQmxZ6wejkH1IC
LaXcn4crcba64sROG0q/15Ifep8CmSrhPgbdk/ZoG0ldZMRDCI+QaUHLs3PPxopg
y6SShru8Hyjc0VhKIQJBAP5mxwI3MiTuyMpM66hF9bVor+4cHdr6mICJYsIiVO7U
EJesOQLSlkwjkbY5+ox6iUrsmBUhmeDNDQUQSel3Fi8CQQD0Q1mqxPABui87Z7Oy
dXDSoPiRrk6xn0IA+V2ehEY9SdULKZSzzIh5ZrNWUIk9uuvC6NawysG7nQWKrBSZ
vjfnAkBIQH5i1bRLIvop4oDHcN8g35Ofx6J/D88CKoK+6is/DUGNIh+q+o4vH6cB
nyPWg/K8McfbsIhYfUQmXQLw6J6HAkBe+GS/ocyTT1mX5k0W4NSaAF5E/hm4s+wM
xufgfxt0LuW3blZTxf11/jlSIQQLTUbnRHJc0KickoOaFCf6UtwXAkB2xLv6jpiU
2FqMD85MolL0uqZwsbTkNFw6/TcTlPPit8k2LVIMZNHV05SFkbrLHUnWFIegZ/6E
NVuI+eXtaUQW
-----END PRIVATE KEY-----';
     		break;
     		default:
     			;
     		break;
     	}
     	
		
	}

	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $mobile
	 * respCd":"300304"  用户名被占用 
	 * 成功： {"data":{"mobile":"15166412998","userId":"c00050001982"},"respCd":"000000","msg":""}
	 * 		 {"data":{"mobile":"15166412996","userId":"c00050001984"},"respCd":"000000","msg":""}
	 * 		 {"data":{"mobile":"13166361023","userId":"c00050001985"},"respCd":"000000","msg":""}
	 * 
	 * 已经注册
	 * {"data":null,"respCd":"300304","msg":""}
	 * 
	 * 无效的手机, 应该不会出现，因为我们的用户会通过短信验证
	 * {"data":null,"respCd":"300102","msg":""}
	 */
	public function regByMobile($mobile){
		
		//https://120.204.69.183:8090/PreWallet/restlet/outer/regByMobile
		
		$url = $this->host.'regByMobile';
		
		$data = array(
			'infSource'=>$this->infSource,
			'mobile'=>$mobile
		);
	
		$post = $this->generate_post_json($data);
					
		$response = $this->post($url, $post);
		
		return $response;
	}
	
	public function regByMobile2($mobile){
		
		//https://120.204.69.183:8090/PreWallet/restlet/outer/regByMobile
		$url = $this->host.'regByMobile';
		
		$data = array(
			'infSource'=>$this->infSource,
			'mobile'=>$mobile
					);
		
		$dataJson = json_encode($data);
		
		openssl_sign($dataJson, $signToken, $this->private_key); //用私钥进行签名
		
		$signToken = bin2hex($signToken);

		$post = array('appId'=>$this->appId,'version'=>$this->version,'data'=>$data,'signToken'=>$signToken);

		$post = json_encode($post);
		
//		echo $dataJson;
//		echo $post;
		
		$response = $this->post($url, $post);

		
		return $response;
	}
	

	
	/**
	 * 
	 * 用户信息查询-手机号码方式
	 * 正确： {"data":{"userId":"c00050001985","mobile":"13166361023","email":"","userName":"","cardList":null},"respCd":"000000","msg":""}
	 * {"data":{"userId":"c00050001985","mobile":"13166361023","email":"","userName":"","cardList":[{"cardNo":"196222***********9533","issuerName":"中国工商银行"}]},"respCd":"000000","msg":""}
	 * 用户不存在： {"data":null,"respCd":"300200","msg":""}
	 */
	public function getUserByMobile($mobile){

		$url = $this->host.'getUserByMobile';
		
		$data = array('mobile' => $mobile);
		
		$post = $this->generate_post_json($data);
		
		$response = $this->post($url, $post);

		return $response;
	}

	public function getUserByMobile2($mobile){
 
	
		$url = $this->host.'getUserByMobile';
		
		$data = array('mobile' => $mobile);
		
		$dataJson = json_encode($data);

//		echo 'data '.$data;
		openssl_sign($dataJson, $signToken, $this->private_key); //用私钥进行签名
		
		$signToken = bin2hex($signToken);

		$post = array('appId'=>$this->appId,'version'=>$this->version,'data'=>$data,'signToken'=>$signToken);

		$post = json_encode($post);
		
//		echo 'post '.$post;
		
		$response = $this->post($url, $post);

		
		return $response;
	}
	
	/**
	 * 
	 * 银行卡开通服务
	 * respCd: 300500   无效的卡号
	 * {"data":null,"respCd":"300002","msg":"解密出错"}
	 * 
	 * 300513: 用户绑卡及解绑卡次数超限
	 * 300519  钱包服务绑定异常，报重复绑卡  // 有另一个账户已经绑了这个卡, 如果原账户解除绑定了，就能再绑定
	 * 300500   无效的卡号
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
	
		$data = array('cardNo'=>$encrypted, 'needAuth'=>$needAuth,'userId'=>$userId);
		$dataJson = json_encode($data);
		$dataJson2 = str_replace('\\','',$dataJson);
		
		
		openssl_sign($dataJson2, $signToken, $this->private_key); //用私钥进行签名
		$signToken = bin2hex($signToken);
		
		$post = array('appId'=>$this->appId,'version'=>$this->version,'data'=>$data,'signToken'=>$signToken);
		
		$post = json_encode($post);
		
		
		$response = $this->post($url, $post);
		return $response;
//		
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
		
		
		$data = array('cardNo'=>$encrypted,'userId'=>$userId);
		
		$dataJson = json_encode($data);
		$dataJson2 = str_replace('\\','',$dataJson);
		
		openssl_sign($dataJson2, $signToken, $this->private_key); //用私钥进行签名
		
		$signToken = bin2hex($signToken);
		
		$post = array('appId'=>$this->appId,'version'=>$this->version,'data'=>$data,'signToken'=>$signToken);

		$post = json_encode($post);
		
//		echo $dataJson;
//		echo $post;
		
//		var_dump($url);
//		var_dump($post);
		
		$response = $this->post($url, $post);
		
		return $response;
		
	}
	
	
	/**
	 * 
transSeq 	string 	必填 	接入机构侧的交易主键   //没做判断是否唯一
userId 	string 	必填 	持卡人用户ID
couponId 	string 	必填 	用户下载的票券ID
couponNum 	string 	必填 	用户下载的票券数量，必须为正整数
							注：不能超过票券配置的单用户最大获取张数
chnlUsrId 	string 	可选 	用户在接入机构侧的用户ID（主键），用于票券承兑通知交易供交易接收方识别用户
chnlUsrMobile 	string 	可选 	用户在接入机构侧留存的手机号码，用于票券承兑通知交易供交易接收方识别用户	//即使是错误的mobile，也能下载
couponSceneId 	string 	必填 	票券场景标识，目前仅支持如下两种场景
									000：普通场景，包含普通优惠券、普通电子票
									001：电影票场景 .
	 * @param unknown_type $data
	 * @param unknown_type $couponSceneId
	 * {"data":{"transSeq":"123456789900","couponNum":1.0},"respCd":"000000","msg":""}
	 * 
	 * 500048： 票券下载张数超过单用户下载限制


		$data['chnlUsrId'] = '111';
		$data['chnlUsrMobile'] = '131663610235555';
		$data['couponId'] = 'Z00000000010074';
		$data['couponNum'] = '1';
		$data['couponSceneId'] = '000';
		$data['transSeq'] = '123456789900';
		$data['userId'] = 'c00050001986';

	 */
	public function couponDwnById($data){
	
		$url = $this->host.'couponDwnById';
		
		$post = $this->generate_post_json($data);

		
		$response = $this->post($url, $post);
		return $response;
		
	}
	
	function couponDwnById2($data){
	
		$url = $this->host.'couponDwnById';
		
		$dataJson = json_encode($data);
		
		openssl_sign($dataJson, $signToken, $this->private_key); //用私钥进行签名
		
		$signToken = bin2hex($signToken);

		$post = array('appId'=>$this->appId,'version'=>$this->version,'data'=>$data,'signToken'=>$signToken);

		$post = json_encode($post);

//		echo $post;
		
		$response = $this->post($url, $post);
		return $response;
		
	}
	
	public function is_server_alive(){

		$mobile = '111';
		
		$url = $this->host.'getUserByMobile';
		
		$data = array('mobile' => $mobile);
		
		$dataJson = json_encode($data);

//		echo 'data '.$data;
		openssl_sign($dataJson, $signToken, $this->private_key); //用私钥进行签名
		
		$signToken = bin2hex($signToken);

		$post = array('appId'=>$this->appId,'version'=>$this->version,'data'=>$data,'signToken'=>$signToken);

		$post = json_encode($post);
		
//		echo 'post '.$post;
		
		$response = $this->post($url, $post);

		
		return $response;	
	}
	
	public function test(){
		
		echo 'unionpay->test()'.$this->host;
		return 'unionpay->test()'.$this->host;
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
	
	private function generate_post_json($data){
	
		
		
		$dataJson = json_encode($data);

//		echo 'data '.$data;
		openssl_sign($dataJson, $signToken, $this->private_key); //用私钥进行签名
		
		$signToken = bin2hex($signToken);

		$post = array('appId'=>$this->appId,'version'=>$this->version,'data'=>$data,'signToken'=>$signToken);

		$post = json_encode($post);
		
		return $post;
	}

}

/* End of file Someclass.php */