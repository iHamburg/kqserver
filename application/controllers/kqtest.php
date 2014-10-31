<?php
/*
 * @author qing
 *
 */



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
	
	
//	var $host = 'http://localhost';
	//
	//
	function __construct(){
		parent::__construct();
		
		$this->load->model('user2_m','user');
		$this->load->model('coupon2_m', 'coupon');
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
		
		$apiLink = array('test_dcoupon','test_error_log','test_coupon_dincrement','test_acoupon_increment');
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
	
	function test_coupon_accepted(){
			
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
		
	
	 public function message($to = 'World')
	  {
	    echo "Hello {$to}!".PHP_EOL;
	  }

	
	public function test(){
//	
//		$this->db->query("insert into downloadedcoupon (uid,couponId,transSeq,createdAt) values ('sdfsdf',1,1,null) ");
//		
//		echo $this->db->insert_id();

		// 调用这个接口，echo 'sss'之后，调用api 或 lib？
		
		
	$fp = fsockopen("www.baidu.com",
     80, $errno, $errstr, 30);   
    if (!$fp) {   
    	echo "$errstr ($errno)<br />\n";   
    } else {   
	    $out = "GET / HTTP/1.1\r\n";   
	    $out .= "Host: www.baidu.com\r\n";   
	    $out .= "Connection: Close\r\n\r\n";   
     
   		 fwrite($fp, $out);   
    while (!feof($fp)) {   
   		 echo fgets($fp, 128);   
    }   
  		  fclose($fp);   
    }  
		
	}


}