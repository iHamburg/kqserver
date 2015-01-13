<?php
/*
 * @author qing
 *
 */
require(APPPATH.'libraries/phpmailer/PHPMailerAutoload.php'); 


class Kqtest extends CI_Controller{

	/**
	 * 
	 * Enter description here ...
	 * @var Coupon2_m
	 */
	var $coupon;
  
	
	/**
	 * 
	 * Enter description here ...
	 * @var User2_m
	 */
	var $user;
	
	
	/**
	 * 
	 * Enter description here ...
	 * @var Kqlibrary
	 */
	var $kqlibrary;
	
	/**
	 * 
	 * Enter description here ...
	 * @var Kqsms
	 */
	var $kqsms;
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('user2_m','user');
		$this->load->model('coupon2_m', 'coupon');
		$this->load->library('kqlibrary');

	}
	

	function index() {
	
		header( 'Content-Type:text/html;charset=utf-8 ');
		
		
		$this->load->helper('html');
		
		
		echo 'baseurl #'.current_url();
		
//		$linkPrepend = 'http://localhost/kq/index.php/kqtest/';

		
		$apiLink = array('test','test_dcoupon','test_error_log','test_remote_coupon_accepted','test_coupon_dincrement','test_acoupon_increment','test_accept_coupon','test_bind_card_sms');
		$apiTitle = $apiLink;
		
		
		foreach ($apiLink as $link) {
			$newApiLink[] = current_url().'/'.$link;
		}
		
		$data['title'] = '系统内部测试套装';
		
		$data['titles'] = $apiTitle;
		$data['links'] = $newApiLink;
		
		$this->load->view('vtestsuit', $data);
		
		
	}

	// 其实不用连remote的test函数
		
	function testsuit($servername='localhost'){
		
		header( 'Content-Type:text/html;charset=utf-8 ');
		
		
		$this->load->helper('html');
		
		$host = get_host($servername);
		
		$linkPrepend = 'http://localhost/kq/index.php/kqtest/';

		
		$apiLink = array('test_dcoupon','test_error_log','test_remote_coupon_accepted','test_coupon_dincrement','test_acoupon_increment','test_accept_coupon','test_bind_card_sms');
		$apiTitle = $apiLink;
		
		
		foreach ($apiLink as $link) {
			$newApiLink[] = $linkPrepend.$link.'/'.$servername;
		}
		
		$data['title'] = '系统内部测试套装';
		
		$data['titles'] = $apiTitle;
		$data['links'] = $newApiLink;
		
		$this->load->view('vtestsuit', $data);
		
	}
	
	function test_dcoupon(){
		
		echo $this->user->download_coupon(32,36, '222222');
		
	}
	
	function test_error_log(){
		
		$error = 'blablabla';

		$error = '{"appId":"unionpay","version":"1.0","data":{"mchntId":"937320293990001","couponId":"D00000000000002",
		"cdhdUsrId":"c00000000000","chnlUsrId":"qq382677505","cardNo":"6214***********0025","origTransAt":"000000018000",
		"transAt":"000000010000","transDateTime":"1021165328","sysTraNo":"012088","transAcptInsId":"00001021111","transFwdInsId":"00001020000"}}';
		
		log_message('error', $error);
		
	}
	
	function test_coupon_dincrement(){
		
		echo $this->coupon->dcount_increment(36);
	}
	
	function test_acoupon_increment(){
		echo $this->coupon->increment_acount(36);
	}
	
	function test_remote_coupon_accepted(){
	

		$postJson = '{"appId":"unionpay","version":"1.0","data":{"mchntId":"937320293990001","couponId":"D00000000008333","cdhdUsrId":"c00055685346","chnlUsrId":"57","cardNo":"6214***********0025","origTransAt":"000000018000","transAt":"000000010000","transDateTime":"1021165328","sysTraNo":"012088","transAcptInsId":"00001021111","transFwdInsId":"00001020000"}}';
		$post = json_decode($postJson,true);
		
		$params = array('mchntId','couponId','cdhdUsrId','chnlUsrId','cardNo','origTransAt','transAt','transDateTime','sysTraNo','transAcptInsId','transFwdInsId');
//	{"appId":"unionpay","version":"1.0","data":{"mchntId":"937320293990001","couponId":"D00000000000002","cdhdUsrId":"c00000000000","chnlUsrId":"qq382677505","cardNo":"6214***********0025","origTransAt":"000000018000","transAt":"000000010000","transDateTime":"1021165328","sysTraNo":"012088","transAcptInsId":"00001021111","transFwdInsId":"00001020000"}}
		foreach ($params as $key) {
			$data[$key] = $post['data'][$key];
		}

		echo $postJson;
		echo 'begin post'.'<br>';
		echo post('http://61.153.100.241/kq/index.php/kqunionapi/couponAccepted',$postJson);
	}
	
	function test_accept_coupon(){
		
		echo $this->kqlibrary->accept_coupon(57, 'Z00000000008039');
		
	}
	
	function test_bind_card_sms(){
		
		header( 'Content-Type:text/html;charset=utf-8 ');
		$this->load->library('kqsms');
		echo $this->kqsms->send_bind_card_sms('13166361023', '99999999');
	
	}
	
	function test_coupon(){

		$this->coupon->dcount_increment(38);
	}
	
	 public function message($to = 'World')
	 {
	    echo "Hello {$to}!".PHP_EOL;
	  }

	public function testmail(){
	
	
		$mail = new PHPMailer;
	
		//$mail->SMTPDebug = 3;                               // Enable verbose debug output
		
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'tominfrankfurt@gmail.com';                 // SMTP username
		$mail->Password = 'Qingxin805328';                           // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;                                    // TCP port to connect to
		
		$mail->From = 'tominfrankfurt@gmail.com';
		$mail->FromName = 'tom';
		$mail->addAddress('tominfrankfurt@gmail.com', 'Joe User');     // Add a recipient
		//$mail->addAddress('ellen@example.com');               // Name is optional
		//$mail->addReplyTo('info@example.com', 'Information');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');
		
		$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
		//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML
		
		$mail->Subject = 'Here is the subject';
		$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		
		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Message has been sent';
		}
		
	}
	  
	public function test_header(){
	
		
		$url = 'http://61.153.100.241/kq/index.php/kqapi6/test';
		
//  	$url = 'http://61.153.100.241/kq/index.php/kqtest/testsuit';
    
//		$url = 'http://dev.umeng.com/analytics/ios/sdk-download';
		
//		$url = 'http://www.sina.com';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);    //表示需要response header
//    curl_setopt($ch, CURLOPT_NOBODY, FALSE); //表示需要response body
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    
    $result = curl_exec($ch);
    $curl_errno = curl_errno($ch);  
    $curl_error = curl_error($ch);
	
 	if($curl_errno >0){  
         echo "cURL Error ($curl_errno): $curl_error\n";  
    }
	
	curl_close($ch);
//    echo $result;
    
    list($header, $body) = explode("\r\n\r\n", response, 2);
    
    echo $header;
    
//  	echo get('http://bbs.umeng.com/thread-5458-1-1.html');
	}
	  
	public function returnHeaders(){
		
	} 
	
	
	public function patchMoti(){
	
		
		
		$query = $this->db->query("select B.id,B.username, B.unionId from downloadedcoupon A 
join user B 
on A.uid=B.id
where couponId = 39 
and uid >97
and status = 'unused' 
and A.createdAt < '2014-12-15 11:00:00'
and !ISNULL(B.unionId)");
		
		
		$results = $query->result_array();
		
		foreach ($results as $row) {
			
			//$uid,$mobile,$unionUid,$unionCouponId, $transSeq
			$uid = $row['id'];
			$mobile=$row['username'];
			$unionUid=$row['unionId'];
			$unionCouponId='D00000000010186';
			$transSeq = "C$uid"."D$couponId"."T".now();
		
//			$response =$this->kqlibrary->download_union_coupon($uid, $mobile, $unionUid, $unionCouponId, $transSeq);
			
		}
		
	}
	
	// 
	public function down_users(){
		
		$couponUnionId = 'D00000000010397';

		$mobiles = array('13916664532','15000278920');
		
		$this->kqlibrary->download_union_coupon_with_users($mobiles, $couponUnionId);
		
	}
	
	
	//批量处理摩提的延长的券
	public function download_unioncoupon_for_users(){
	
		$couponUnionId='D00000000010952'; // 摩提新券
		
		//先处理到27号，下个从28开始
		$query = $this->db->query("select B.username
from downloadedcoupon A
join user B
on A.uid=B.id
where couponId=39
and status='unused'
and A.createdAt>'2014-12-30'
and B.`unionId`!=''");
		
		$results = $query->result_array();
		
		foreach ($results as $row) {

			$mobiles[]=$row['username'];
		
		}
		
		
//		var_dump($users);
//		$response = $this->kqlibrary->download_union_coupon_with_users($mobiles, $couponUnionId);
		
		echo $response;
	}
	
	public function testSign(){
	
		$rsa_private_key="-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDE+bUdCKNOHEMG4CHyBdLdRTxSJo77ltQU+Fil0HZEGnKbHczn
6Z4P1RoWAVGgycDH5zD1YuES/W4inbL2bLn9zqnImK3NGvQP+wc1Hmq9zbE6B7RG
HfYpdxpEb72/9PdGaJowbTArmhjtCBs9n7GGsDtw67IlYCp/KJC/KgwMsQIDAQAB
AoGAe+hAwBTQ9a/dkhOoBuEW9k45VcwfobANlWtsCFKMMucYNO+YGELjRT5efH0z
5htEA/ww1gvvXczCXVAqZc2baSwgFz48GmGDUzCMvOjx6x70ugVnj4PyjCDsAGUe
Tye5OTyNCc43b66F9tZQqkyuCvIi6mUq6nQDPm1p89RkTmECQQDydJ+4mTGAtQFh
5oapLTmhEvFsEhDStZ+tLxwb2WNFL8b1oJhjXsEEao8O3ZzpA95hpFaMKrCmrJco
OXQdtmPVAkEAz/qrIJ2Qht+78rvTyuEEP+ThrPLkFj7149lweibUJewUS+CN5Xin
6WPEniXdonHyktXd+jQ2IBPXoOiKyDnfbQJBAOuveM/+gwOFcKmVaROtddbhTjPq
v9XEXksAf4eG45wO3I5LJbd7FZBQcW5W+T/91b/++27X1M7A+VNNvlVfxl0CQQCh
rnlCjbtBXsU52pK3cV5gXYqjbN+r+54kV3F9RJpAMNtGcXdeIQJICetcFovKMVMm
m2RJkjVRkpta1+yr43GxAkBut9dnBafCML7EWeVRvsLpJMPU/E5YHNmNISunSxpD
/sguB2OtD3ol+T0O6Z38zBfTCy7uE53PVJiTIllrtYyf
-----END RSA PRIVATE KEY-----";
		
		$private_key="----BEGIN PRIVATE KEY-----
MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAJ69kBvGvVU8zLfE
0SfbzXwgsnWmGzbbPoAWxfVNAl0wUAPi7xjffWMByyzu2XkuDzHhL7dKaogDd6Hg
iACtWdXOcxSBM5yYna4Fy77idX3eENjY65IIth0PUGUfDa07ymZdtnrf0ZJDEXAK
Xz4RxMGQA9K2ZlEN8zfxTx9VXLjVAgMBAAECgYAsLrTqlkFidR7B030nq+0grHUf
e9E9Tn6x5iTJJtsOlwDeZA6KjMH4iapEYmKTcPd3uaavTH4kR1rH6pfQIG/NO3nu
RN9DwlO7RLmuE/mRe3SvDmfn3/sBVykpL+1rg8XNwv87upzJfgWs9dHlVEk9oQu1
oab8NZWsKu6Owb9cjQJBAM+W25RVOy4rb5Ag7SDTJuDE6Zxlb3/bvgOoyrC9Wuph
YnMZe0DCRbclLj5t1EafqhkYRgmnuLCR5homTdEJN8MCQQDDwmq1L+ILyrxs3lP8
VKOvyGI35KbvmZWYNyQwx15UJHbVDn92S/73sKdMx7N/zPirUctG3FmRNeam4p+F
uluHAkEAu+wVW3LM4D7x/8fO4qhDybZ4xNwO0/BZU3a6BsVkSElgllG7AiTcd69w
7ZL/V++yTIVs4dCzoSRy6blDOLjfgQJAHp9vKeDPr6CLUUyGPtbOtFTYaH3wT1Lr
P+CAXNETRH5fyHx4G/1PaVfNFAm5XqilzccB0ZfuuvR/nGOfKMA6SQJBAJosKW3d
B/GSic9MBIrtIymgLaAjLeaOwyk95vCgvqEp7BtjRpKXWyk8rcg3m3ybTSwpeUCQ
QBD09MmaCZE35V8=
-----END PRIVATE KEY-----";
		
		$rsa_public_key="-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDE+bUdCKNOHEMG4CHyBdLdRTxS
Jo77ltQU+Fil0HZEGnKbHczn6Z4P1RoWAVGgycDH5zD1YuES/W4inbL2bLn9zqnI
mK3NGvQP+wc1Hmq9zbE6B7RGHfYpdxpEb72/9PdGaJowbTArmhjtCBs9n7GGsDtw
67IlYCp/KJC/KgwMsQIDAQAB
-----END PUBLIC KEY-----";
		
		
		$plain = json_encode(array(1,2,3));  // plain是纯文字
		echo 'plain : '.$plain;
		echo '<br>';
		
		openssl_sign($plain, $privated, $rsa_private_key); //用私钥进行签名， 是rsa密钥
		
		$privatedHex = bin2hex($privated);  //转成hex 字符串   
		
		echo 'privated #'.$privatedHex;
		echo '<br>';
		
		$verify = openssl_verify($plain, hex2bin($privatedHex), $rsa_public_key); // 比较原文和签名，看是否一致）
		
//		$signature = bin2hex($signature);  //转成hex 字符串
		
	
		
		echo 'verify #'.$verify;
		echo '<br>';
		
	}
	
	
	public function ip_test($ip,$iprule){  
	   $ipruleregexp=str_replace('.*','ph',$iprule);  
	   $ipruleregexp=preg_quote($ipruleregexp,'/');  
	   $ipruleregexp=str_replace('ph','\.[0-9]{1,3}',$ipruleregexp);  
	  
	   if(preg_match('/^'.$ipruleregexp.'$/',$ip)) return true;  
	   else return false;  
     
	}  
	
	public function dev(){
		echo 'dev';
	}
	public function test(){

//		dev();
		
		
//		echo ip_test('')
		
//		$headers = apache_request_headers();
//		print_r($headers);

//		$query = $this->db->query("select * from user limit 500");
		
//		$this->db->select('id,username,createdAt,updatedAt,avatarUrl')->from('user');	
		
//		$query = $this->db->query();
		
//		$results = $query->result_array();
//		
////		$results = $this->db->get()->result_array();	
//		
//		var_dump($results);
//		header( 'Content-Type:text/html;charset=utf-8 ');
//		$result = $this->coupon->get_complete_title(39);
//		echo 'title '.$result;
	
		
//		    $curr_ip=$_SERVER['REMOTE_ADDR'];  //  获得对方ip地址
////		    echo $curr_ip;
//		    
//		    $white_list=array('127.0.0.*'); //白名单规则  
//		    $test_success=false;  
//		    foreach($white_list as $iprule){  
//		    	
//		       if($this->ip_test($curr_ip,$iprule)){  
//		          $test_success=true;  
//		          break;  
//		       }  
//		    
//		    }  
//		    
//		    if(!$test_success) exit('IP not in white list');  
//			$black_list=array(); //黑名单规则
//		    foreach($black_list as $iprule){  
//		   if($this->ip_test($curr_ip,$iprule)){  
//		      exit('IP in black list');  
//		   }  
//}  

	}

}