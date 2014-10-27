<?php
/*
 * @author qing
 *
 */



class Kqapitest extends CI_Controller{

	/**
	 * 
	 * Enter description here ...
	 * @var Coupon_m
	 */
	var $coupon_m;
  
	
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
	}
	

	function index() {

		echo 'kqtest ';
		
	}

	
	function testsuit($servername='localhost'){
		
		header( 'Content-Type:text/html;charset=utf-8 ');
		
		
		$this->load->helper('html');
		
		$host = get_host($servername);
		
		$linkPrepend = $host.'/kq/index.php/kqapitest/';
		
//		$apiTitle = array('re','用户信息查询','银行卡开通服务','银行卡关闭服务');

		$apiLink = array('test_userinfo','test_edit','testGetUserByMobile','testBindCard','testUnbindCard');
		$apiTitle = $apiLink;
		
		
		foreach ($apiLink as $link) {
			$newApiLink[] = $linkPrepend.$link.'/'.$servername;
		}
		
		
		$data['title'] = '客户端接口测试套装';
		
		$data['titles'] = $apiTitle;
		$data['links'] = $newApiLink;
		
		$this->load->view('vtestsuit', $data);
		
	}
	
	function test_userinfo($servername='localhost'){
		
		$host = get_host($servername);
		
		$url = $host.'/kq/index.php/kqapi4/userinfo/uid/32/sessionToken/ptHKUzWr17FwxVQqjube';
//		echo $url;
		$response = get($url);
		echo $response;
		
	}
	
	function test_edit($servername='localhost'){
		
		$host = get_host($servername);
		
		$url = $host.'/kq/index.php/kqapi4/editUserInfo';
	
		$password = array('oldPassword'=>'abc','newPassword'=>'abcdef');
		
//		$post = array('uid'=>'32','sessionToken'=>"ptHKUzWr17FwxVQqjube",'nickname'=>'ddd');
		
		$post = array('uid'=>'32','sessionToken'=>"ptHKUzWr17FwxVQqjube",'password'=>json_encode($password));
		
		$response = post($url,$post);
		
		echo $response;
	}
	
	function testregister(){
	
		$url = 'localhost/kq/index.php/kqapi4/user';
		$data = array('username'=>'131112','password'=>'222');
		
		$response = post($url,$data);
		echo $response;
	}
	
	
	function testCount(){
		echo $this->user->isSessionValid('24','ZVvW9HygCAsa4RTBQG6t');
	}

	function testDownloadCoupon(){
		$url = 'localhost/kq/index.php/kqapi4/myDownloadedCoupon';
		$data = array('uid'=>'32','sessionToken'=>'ptHKUzWr17FwxVQqjube','couponId'=>'27');
		
		$response = post($url,$data);
		echo $response;
	}
	
	function testFavoriteCoupon(){
		$url = 'localhost/kq/index.php/kqapi4/myFavoritedCoupon';
		$data = array('uid'=>'32','sessionToken'=>'ptHKUzWr17FwxVQqjube','couponId'=>'27');
		
		$response = post($url,$data);
		
		echo $response;
	}
	
	function testDeleteFavoriteCoupon(){
		$url = 'localhost/kq/index.php/kqapi4/deleteMyFavoritedCoupon';
		$data = array('uid'=>'32','sessionToken'=>'ptHKUzWr17FwxVQqjube','couponId'=>'27');
		
		$response = post($url,$data);
		
		echo $response;
	}
	
	
	function testFavoriteShop(){
		$url = 'localhost/kq/index.php/kqapi4/myFavoritedShop';
		$data = array('uid'=>'32','sessionToken'=>'ptHKUzWr17FwxVQqjube','shopId'=>'8');
		
		$response = post($url,$data);
		
		echo $response;
	}
	
	function testDeleteFavoriteShop(){
		$url = 'localhost/kq/index.php/kqapi4/deleteMyFavoritedShop';
		$data = array('uid'=>'32','sessionToken'=>'ptHKUzWr17FwxVQqjube','shopId'=>'8');
		
		$response = post($url,$data);
		
		echo $response;
	}
	
	function testMyCard(){
		$url = 'localhost/kq/index.php/kqapi4/myCard/uid/32/sessionToken/ptHKUzWr17FwxVQqjube';

		
		$response = get($url);
		
		echo $response;
	
	}
	
	function testAddCard(){
		$url = 'localhost/kq/index.php/kqapi4/myCard';
		$data = array('uid'=>'32','sessionToken'=>'ptHKUzWr17FwxVQqjube','card'=>'999999');
		
		$response = post($url,$data);
		
		echo $response;
	}
	
	function testDeleteCard(){
		$url = 'localhost/kq/index.php/kqapi4/deleteMyCard';
		$data = array('uid'=>'32','sessionToken'=>'ptHKUzWr17FwxVQqjube','card'=>'999999');
		
		$response = post($url,$data);
		
		echo $response;
	}
	
	function testResetPassword(){
		$url = 'localhost/kq/index.php/kqapi4/resetPassword';
		$data = array('username'=>'131112','password'=>'333');
		
		$response = post($url,$data);
		
		echo $response;
	}
	
	function testCouponDetails(){
		$url = 'localhost/kq/index.php/kqapi4/couponDetails/id/26/longitude/122';
//		$data = array('uid'=>'32','sessionToken'=>'ptHKUzWr17FwxVQqjube','card'=>'999999');
		
		$response = get($url);
		
		echo $response;
	
	}
	
	function testAroundShopBranches(){
		$url = 'localhost/kq/index.php/kqapi4/aroundShopbranches';
		
		$url.='/districtId/13';
		$url.='/shopTypeId/1';
		$url.='/longitude/121.4/latitude/31.2';
		
		$response = get($url);
		
		echo $response;
		
		
	}
	
	function testSearchCoupons(){
		$url = 'localhost/kq/index.php/kqapi4/searchCoupons';
		
		$url.='/districtId/13';
		$url.='/shopTypeId/1';
		$url.='/longitude/121.4/latitude/31.2';
		$url.='/keyword/85';
		
		$response = get($url);
		
		echo $response;
	
		
	}
	
	
	function testCouponAccepted(){
		$url = 'http://115.29.148.47/kq/index.php/kqunionapi/couponAccepted';

//		$url = 'localhost/kq/index.php/kqunionapi/couponAccepted';
		
//		$data = array('mchntId'=>'32','couponId'=>'999999');

		$data = array('data'=>array('mchntId'=>'32','couponId'=>'999999'));
		$data = json_encode($data);
		$response = post($url,$data);
		
		echo $response;
	}
	
	function testCouponAccepted2(){
		$url = 'http://115.29.148.47/kq/index.php/kqunionapi/couponAccepted2';

//		$url = 'localhost/kq/index.php/kqunionapi/couponAccepted';
		
//		$data = array('mchntId'=>'32','couponId'=>'999999');

		$data = array('data'=>array('mchntId'=>'32','couponId'=>'999999'));
		$data = json_encode($data);
		$data2 = array('params'=>$data);
		$response = post($url,$data2);
		
		echo $response;
	}
	function testresetPassword(){
	
		$url = 'http://localhost/kq/index.php/kqapi4/resetPassword';
		$post = array('username'=>'1111','password'=>'2222');
		
		$response = post($url,$post);
		echo $response;
	
	}
	

	function testCaptcha(){
		$url = 'http://localhost/kq/index.php/kqapi4/captcharegister/mobile/13166361023';
//		$post = array('username'=>'1111','password'=>'2222');
		
		$response = get($url);
		echo $response;
	
	
	}
	

	
function test_send_email(){
		$to = "tominfrankfurt@gmail.com";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "tominfrankfurt@gmail.com";
$headers = "From: $from";
echo "Mail Sent.".mail($to,$subject,$message,$headers);

		
		
	}

	
	function test_bind_card(){
	
		$url = 'http://localhost/kq/index.php/kqapi4/mycard2';
	
		$post = array('uid'=>'32','card'=>'6222021001128509539');
		
//		$post = json_encode($post);
		
		$response = post($url,$post);
		echo $response;
	}
	
	function test_favorietedshops(){
	
	
	}
	
	function test_add_favoriteshop(){

		$url = 'http://localhost/kq/index.php/kqapi4/myFavoritedShopbranch';
	
		$post = array('uid'=>'32','shopbranchId'=>'1','sessionToken'=>"ptHKUzWr17FwxVQqjube");
		
//		$post = json_encode($post);
		
		$response = post($url,$post);
		echo $response;
	}
	
	function test_delete_favoritedshop(){
	
		$url = 'http://localhost/kq/index.php/kqapi4/deleteMyFavoritedShopbranch';
	
		$post = array('uid'=>'32','shopbranchId'=>'1','sessionToken'=>"ptHKUzWr17FwxVQqjube");
		
		$response = post($url,$post);
		echo $response;
	}
	
	
	function test_register(){
		$url = 'http://localhost/kq/index.php/kqapi4/user';
	
//		$post = array('username'=>'13166361024','password'=>"111");
		
		$response = post($url,$post);
		echo $response;
	}
	
	function test_union(){
		
		$this->load->library('unionpay');
		
//		$mobile = '13166361023';
//		$response = $this->unionpay->getUserByMobile($mobile);
//
//		echo $response;

//		echo 'before';
//		$response = $this->unionpay->getUserByMobile('111');
//
//		echo 'after';
//		echo 'ass'.$response;
	
		$response = $this->unionpay->getUserByMobile('13166361023');
   		
   		echo 'resp'.$response;
   		
//   		$response = json_decode($response,true);
//   		
//   		echo 'sss';
	
	}
	
	function test_direct_union(){
	
	
		$url = 'https://120.204.69.183:8090/PreWallet/restlet/outer/regByMobile';
		
		$data = array(
			'infSource'=>$this->infSource,
			'mobile'=>$mobile
		);
	
//		$post = $this->generate_post_json($data);

		$post = json_encode($data);
		
		$response = post($url, $post);
		
		echo $response;
	}
	
	function test_sms(){
		$this->load->library('kqsms');
		
		echo $this->kqsms->send_register_sms('13166361023','333333');
	}
	
	function test_curl(){
	
 		$url = 'http://www.baidu.com';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	
		$output = curl_exec($ch);
		curl_close($ch);
		
		echo $output;
		
	}
	
	function test(){
		$str = '000000';
		
		if ($str == 0){
			echo '=0';
		}
		
		
//		echo randomNumber();
		
//		$url = HOST."/users?keys=phone,username";
//		echo $this->avoslibrary->get($url);
		
//	$data = array('shop'=>avosPointer('Shop', '53bbece4e4b0dea5ac1c8907'));
//		
//		echo $this->updateObject('Coupon','539e8dfce4b023daacbd6fa3',json_encode($data));
	
//		echo $this->addShopBranchesToShop(array('539e8c51e4b0c92f1847dc23','539e8c52e4b0c92f1847dc24'), '539e8c52e4b0c92f1847dc25');

//		echo $this->addCouponToShop('539d8cd9e4b0a98c8733f8dc', '539d8817e4b0a98c8733f287');

//		echo decodeUnicode($this->coupon_m->addInShop('539d8cd9e4b0a98c8733f8dc', '539d8817e4b0a98c8733f287'))	;
	}
	
//	private function get_host($servername){
//		$host = 'http://localhost';
//		if($servername == 'ali'){
//			$host = aliHost;
//		}
//		else if($servername == 'ucloud'){
//			$host = ucloudHost;
//		}
//		
//		return $host;
//	}

}