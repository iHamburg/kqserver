<?php
/*
 * 这里对外界来说应该就是api
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
	
	var $private_key =  '-----BEGIN PRIVATE KEY-----
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
	
	var $host = 'https://120.204.69.183:8090/PreWallet/restlet/outer/';
	var $appId = 'ALLPERM';
	var $version = '1.0';
	var $appSecret = '1aabac6d068eef6a7bad3fdf50a05cc8';
	
	function __construct(){
		parent::__construct();
		
	
//		header( 'Content-Type:application/json;charset=utf-8 '); 
		
		$this->load->library('unionpay');
		$this->load->helper('html');
	}
	

	function index() {

		header( 'Content-Type:text/html;charset=utf-8 ');
		echo 'union pay test<br>';
		
//		$key = '1aabac6d068eef6a7bad3fdf50a05cc8';
		
		$plain = '12';
		
		$content = '6288888888888888';
		$key = 'lvANHSNZCYTZRNmX';
		
		
		$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');      
		$iv_size = mcrypt_enc_get_iv_size($cipher);      
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

		
		echo '自动生成iv的长度:'.strlen($iv).'位:'.bin2hex($iv).'<br>';
		
		if (mcrypt_generic_init($cipher, $key, $iv) != -1)      
		{      
		    // PHP pads with NULL bytes if $content is not a multiple of the block size..      
		    $cipherText = mcrypt_generic($cipher,$content);      
		    mcrypt_generic_deinit($cipher);      
		    mcrypt_module_close($cipher);      
		         
		    // Display the result in hex.      
//		    printf("128-bit encrypted result:\n%s\n\n",bin2hex($cipherText));
//  			 printf("128-bit encrypted result:\n%s\n\n",base64_encode($cipherText));

		    echo base64_encode($cipherText);
		    print("<br />");      
		         
		}      
	}
	
	
	function testsuit($servername='localhost'){
		
		header( 'Content-Type:text/html;charset=utf-8 ');
	
		$host = get_host($servername);
		
		$linkPrepend = $host.'/kq/index.php/kqunionpaytest/';
		
//		$apiTitle = array('re','用户信息查询','银行卡开通服务','银行卡关闭服务');

		$apiLink = array('testGetUserByMobile','testRegByMobile','testBindCard','testUnbindCard');
		$apiTitle = $apiLink;
		
		
		foreach ($apiLink as $link) {
			$newApiLink[] = $linkPrepend.$link.'/'.$servername;
		}
		
		
		$data['title'] = '银联接口测试套装';
		
		$data['titles'] = $apiTitle;
		$data['links'] = $newApiLink;
		
		$this->load->view('vtestsuit', $data);
		
	}

//	function testsuit2($servername='localhost'){
//		
//		header( 'Content-Type:text/html;charset=utf-8 ');
//		
//		$linkPrepend = 'kqunionpaytest/';
//		
//		$apiTitle = array('用户注册','用户信息查询','银行卡开通服务','银行卡关闭服务');
//		$apiLink = array('testRegByMobile','testGetUserByMobile','testBindCard','testUnbindCard');
//		foreach ($apiLink as $link) {
//			$newApiLink[] = $linkPrepend.$link;
//		}
//		
//		
//		$data['title'] = '银联接口测试套装';
//		
//		$data['titles'] = $apiTitle;
//		$data['links'] = $newApiLink;
//		
//		$this->load->view('vUnionPayTest', $data);
//		
//	}
	
	
	/**
	 * 
	 * 测试服务器
	 * https://120.204.69.183:8090/PreWallet/restlet/outer/getUserByMobile
	 * {"appId":"ALLPERM","version":"1.0","data":{"mobile":"13166361023"},"signToken":"48cb3a35ca9bf9338a0058ff46673b082dd1f47e9ed10b157da293f2a1425646a824e8a0c9513c4eb4dab178ab5a8f240c354579016f3ff6a034dbeb956e3553ff5ce7cc0f41db0e2b6fe1eeeb0e8f82aba8e84417d404cb202c7087b591b85b256a3c13b59ebf030b43beb16ff01298d2c62d421ae4b1f46c7bd66a3bd55386"}
	 * 
	 * curl -X POST -H 'Content-Type: application/json' -k -d '{"appId":"ALLPERM","version":"1.0","data":{"mobile":"13166361023"},"signToken":"48cb3a35ca9bf9338a0058ff46673b082dd1f47e9ed10b157da293f2a1425646a824e8a0c9513c4eb4dab178ab5a8f240c354579016f3ff6a034dbeb956e3553ff5ce7cc0f41db0e2b6fe1eeeb0e8f82aba8e84417d404cb202c7087b591b85b256a3c13b59ebf030b43beb16ff01298d2c62d421ae4b1f46c7bd66a3bd55386"}' https://120.204.69.183:8090/PreWallet/restlet/outer/getUserByMobile
	 * ====
	 * 正式服务器
	 * 
	 * 
	 * https://esb.unionpay.com/cardholder/PREWALLET/PREWALLETOuterService/PREWALLETOuterServiceProxy/getUserByMobile
	 * {"appId":"C0000048","version":"1.0","data":{"mobile":"13166361023"},"signToken":"b76448431d852df32afdad028cdfc1036c1a3bb0f16af78f10c535ebe83874373ff44b80110796b98ee772b9dae730bc65be66d4bc60c7d4b26847a540b5bb5c1494ba17e00d8108cc7baa3b16a5711cbf2f6ca8ac41073bfc3c9e801c5500ba39047138158b684e932febfdd152deec34c7a010645bdd1577a35cefb3db1517"}
	 *
	 *curl -v -X POST -H 'Content-Type: application/json' -k -d '{"appId":"C0000048","version":"1.0","data":{"mobile":"13166361023"},"signToken":"b76448431d852df32afdad028cdfc1036c1a3bb0f16af78f10c535ebe83874373ff44b80110796b98ee772b9dae730bc65be66d4bc60c7d4b26847a540b5bb5c1494ba17e00d8108cc7baa3b16a5711cbf2f6ca8ac41073bfc3c9e801c5500ba39047138158b684e932febfdd152deec34c7a010645bdd1577a35cefb3db1517"}' https://esb.unionpay.com/cardholder/PREWALLET/PREWALLETOuterService/PREWALLETOuterServiceProxy/getUserByMobile
	 * 用户信息查询-手机号码方式
	 */
	function testGetUserByMobile(){
	
		header( 'Content-Type:text/html;charset=utf-8');
//		header( 'Content-Type:application/json;charset=utf-8');
		
//		$mobile = '15166412996';
		
		if (empty($mobile)){
			$mobile = '13166361023';
//			$mobile = '15166412996';
		}
		$response = $this->unionpay->getUserByMobile($mobile);

		echo $response;

	}
	

//	// 原始命令
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

	
//	function testGetUserByMobile3(){
//	
//		header( 'Content-Type:text/html;charset=utf-8');
//		$mobile = '13166361023';
//		$response = $this->unionpay->getUserByMobile2($mobile);
//
//		echo $response;
//		
//	}
		
	
	/**
	 * 
	 * 用户注册-银联生成密码
	 */
	function testRegByMobile(){
		
		header( 'Content-Type:text/html;charset=utf-8 ');
		
		$mobile = '13166361023';
		
		$response = $this->unionpay->regByMobile($mobile);

		echo $response;
		
		$response = json_decode($response,true);
		
		$respCd = $response['respCd'];
		
		if($respCd == '000000'){
			//success
			echo 'success';
		
		}
		else if($respCd == 300102){
			// 无效的手机
			echo '无效的手机';
		}
		else if($respCd == 300304){
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
		
	function test(){
//		$url = HOST."/users?keys=phone,username";
//		echo $this->avoslibrary->get($url);
		
//	$data = array('shop'=>avosPointer('Shop', '53bbece4e4b0dea5ac1c8907'));
//		
//		echo $this->updateObject('Coupon','539e8dfce4b023daacbd6fa3',json_encode($data));
	
//		echo $this->addShopBranchesToShop(array('539e8c51e4b0c92f1847dc23','539e8c52e4b0c92f1847dc24'), '539e8c52e4b0c92f1847dc25');

//		echo $this->addCouponToShop('539d8cd9e4b0a98c8733f8dc', '539d8817e4b0a98c8733f287');

//		echo decodeUnicode($this->coupon_m->addInShop('539d8cd9e4b0a98c8733f8dc', '539d8817e4b0a98c8733f287'))	;

			header( 'Content-Type:text/html;charset=utf-8');
//		header( 'Content-Type:application/json;charset=utf-8');
		
//		$mobile = '15166412996';
		
		if (empty($mobile)){
			$mobile = '13166361023';
//			$mobile = '15166412996';
		}
		$response = $this->unionpay->getUserByMobile2($mobile);

		echo $response;
		
		echo $this->unionpay->test();
	}
	
	
	/////////////////
	
	private function  generateKey($key){
		
		$md5 = md5($key,TRUE);
		$result = base64_encode($md5);
		
		while (strlen($result)<16) {
			$result.='%';
		}
		
		return $result;
	}
	
	private  function pad2Length($text, $padlen){    
    $len = strlen($text)%$padlen;    
    $res = $text;    
    $span = $padlen-$len;    
    for($i=0; $i<$span; $i++){    
        $res .= chr($span);
    
    }    
    return $res;    
}    

private static function pkcs5_pad ($text, $blocksize) {

$pad = $blocksize - (strlen($text) % $blocksize);

return $text . str_repeat(chr($pad), $pad);

}

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

	function post($url,$data){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
            'Content-Type: application/json; charset=utf-8')  
        );  // 要求用json格式传递参数

 	
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
		$output = curl_exec($ch);

		curl_close($ch);
		
		return $output;
	}
	
	


}