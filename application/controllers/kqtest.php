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
		
//		$data['originRequest'] = $postJson;
//		
//		
//		$this->load->model('u_coupon_accepted_m','uCouponAccepted');
//		
//		// 把数据存入数据库中
//		$this->uCouponAccepted->insert($data);
	
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
		
		$couponUnionId = 'D00000000011424'; //五芳斋

		$mobiles = array('13524248066');
		
		$this->kqlibrary->download_union_coupon_with_users($mobiles, $couponUnionId);
		
	}
	
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
	
	public function test_news(){
	
		$query = $this->db->query("select distinct uid
from downloadedcoupon
where couponId=39
and status='unused'
");
		
		$uids = $query->result_array();
		
		$title = "快券到期提醒";
		$text = "您的【摩提工房特价1元】快券还有2天就要到期啦，赶紧前往最近的门店享用快券吧！现在还有牛奶棚满20立减10元的超值优惠，全市129家门店都通用哦！关注快券多一秒，更多优惠带给您！";
		foreach ($uids as $row) {
			$uid = $row['uid'];
			echo 'uid #'.$uid;
			
//			$this->db->query("insert into news (uid,title,text) values($uid,'$title','$text')");
		}
		
	}
	
	public function test(){

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
	}


}