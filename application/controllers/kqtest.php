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
//		$linkPrepend = $host.'/kq/index.php/kqapitest/';
		
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
		
		echo $this->kqlibrary->accept_coupon(84, 'Z00000000008039');
		
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
	  
	  
	public function test(){
			header( 'Content-Type:text/html;charset=utf-8 ');
//	
//		$this->db->query("insert into downloadedcoupon (uid,couponId,transSeq,createdAt) values ('sdfsdf',1,1,null) ");
//		
//		echo $this->db->insert_id();

		// 调用这个接口，echo 'sss'之后，调用api 或 lib？
		
		
//	$fp = fsockopen("www.baidu.com",
//     80, $errno, $errstr, 30);   
//    if (!$fp) {   
//    	echo "$errstr ($errno)<br />\n";   
//    } else {   
//	    $out = "GET / HTTP/1.1\r\n";   
//	    $out .= "Host: www.baidu.com\r\n";   
//	    $out .= "Connection: Close\r\n\r\n";   
//     
//   		 fwrite($fp, $out);   
//    while (!feof($fp)) {   
//   		 echo fgets($fp, 128);   
//    }   
//  		  fclose($fp);   
//    }  
		
//		$str_bh='123456789';
//		$abc=substr($str_bh,-4);
//
//		echo $abc;

		
//		if(1 == ErrorUnionInvalidParameter){
//			// 如果参数不对错误
//			echo 'invalid';
////			return $this->output_error($response);
//		}
//		else{
//			echo 'success';		
//		}

//		echo $this->coupon->get_complete_title(36);

//			$this->load->library('umengpush');
//			
//			echo $this->umengpush->send_customized_notification(84,'hahah','lksldkfjsdkl');
			
//			echo $this->umengpush->sendAndroidCustomizedcast();
			
//			$demo = new Demo("5445cf0bfd98c5d70001d213", "bqalj5hvoltwhiy9gtmnthurulr8woxf");
//$demo->sendAndroidCustomizedcast();

//			$this->kqlibrary->test();

//		$this->db->select('A.couponId,count(A.couponId) as number,B.title,B.endDate,C.avatarUrl,C.discountContent,B.isSellOut,B.isEvent, B.active');
//		$this->db->from('downloadedcoupon as A');
//		$this->db->where('uid',$uid);
//		if($mode == 'unused'){
//			$this->db->where('status','unused');
//			$this->db->where('B.endDate <','now()');
//		}
//		else if($mode == 'used'){
//			$this->db->where('status','used');
//		}
//		else if($mode == 'expired'){
//			$this->db->where('status','unused');
//			$this->db->where('B.endDate >','now()');
//		}
//		$this->db->join('coupon as B','A.couponId = B.id','left');
//		$this->db->join('couponcontent as C','A.couponId = C.couponId','left');
//		$this->db->group_by('A.couponId');
//		$this->db->limit($limit,$skip);
//		
//		$query = $this->db->get();
		
//		$sql = "SELECT `A`.`couponId`, count(A.couponId) as number, `B`.`title`, `B`.`endDate`, `C`.`avatarUrl`, `C`.`discountContent`,B.isSellOut,B.isEvent,B.active
//FROM (`downloadedcoupon` as A)
//LEFT JOIN `coupon` as B ON `A`.`couponId` = `B`.`id`
//LEFT JOIN `couponcontent` as C ON `A`.`couponId` = `C`.`couponId`";
//		$sql.="
//WHERE `uid` =  $uid
//AND `status` =  'unused'
//AND `B`.`endDate` > now()";
//		$sql.="
//GROUP BY `A`.`couponId`
//LIMIT $skip,$limit";	
//			
//		$results = $query->result_array();
//		
//		
//		print_r($results);
//		$this->output->enable_profiler(TRUE);
		
			
			echo 'now '.now().'now string'.strtolower(now());
	}


}