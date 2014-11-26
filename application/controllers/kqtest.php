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
//		$this->load->library('kqsms');
	}
	

	function index() {

		echo 'kqtest ';
		
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
	
	function test_dcoupon($servername){
		
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
			
//		$query = $this->db->query('select * from user where id>10');
//		var_dump($query);
//		
//		echo '<br>';
//		
//		$query->free_result();
//		var_dump($query);

//		$query = $this->db->query("insert into bank (title) values ('浦发银行')");
	
//		var_dump($query);
//		
//		echo 'aaa';

		$postJson = '{"appId":"unionpay","version":"1.0","data":{"mchntId":"937320293990001","couponId":"D00000000000002","cdhdUsrId":"c00000000000","chnlUsrId":"qq382677505","cardNo":"6214***********0025","origTransAt":"000000018000","transAt":"000000010000","transDateTime":"1021165328","sysTraNo":"012088","transAcptInsId":"00001021111","transFwdInsId":"00001020000"}}';
		$post = json_decode($postJson,true);
		
		$params = array('mchntId','couponId','cdhdUsrId','chnlUsrId','cardNo','origTransAt','transAt','transDateTime','sysTraNo','transAcptInsId','transFwdInsId');
//	{"appId":"unionpay","version":"1.0","data":{"mchntId":"937320293990001","couponId":"D00000000000002","cdhdUsrId":"c00000000000","chnlUsrId":"qq382677505","cardNo":"6214***********0025","origTransAt":"000000018000","transAt":"000000010000","transDateTime":"1021165328","sysTraNo":"012088","transAcptInsId":"00001021111","transFwdInsId":"00001020000"}}
		foreach ($params as $key) {
			$data[$key] = $post['data'][$key];
		}
		
		$data['originRequest'] = $postJson;
		
		
		$this->load->model('u_coupon_accepted_m','uCouponAccepted');
		
		// 把数据存入数据库中
		$this->uCouponAccepted->insert($data);
	}
		
	function test_accept_coupon(){
		
		echo $this->kqlibrary->accept_coupon(57, 'Z00000000008039');
		
	}
	
	function test_bind_card_sms(){
		header( 'Content-Type:text/html;charset=utf-8 ');
		$this->load->library('kqsms');
		echo $this->kqsms->send_bind_card_sms('13166361023', '99999999');
	}
	
	function test_user(){
		
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
	public function test(){

		$headers = apache_request_headers();
		print_r($headers);
	}


}