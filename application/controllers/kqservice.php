<?php
/*
 * @author qing
 *
 */




class Kqservice extends CI_Controller{

	/**
	 * 
	 * Enter description here ...
	 * @var Coupon_m
	 */
	var $coupon_m;
  
	
	
	
	function __construct(){
		parent::__construct();
		
	header("Content-type: text/html; charset=utf-8");
		
	$this->load->model('couponcontent2_m','couponContent');
	$this->load->model('coupon2_m','coupon');
	$this->load->model('user2_m','user');
	$this->load->model('card2_m','card');
	}
	

	function index() {

		echo 'kqservice';
		
	}
	
	function testRegister(){
	
		$url = 'localhost/kq/index.php/kqapi4/user';
		$data = array('username'=>'131112','password'=>'222');
		
		$response = post($url,$data);
		echo $response;
	}
	
	function testRelation(){
		
		
//		$response = $this->couponContent->with('coupon')->get(1);
		
		$response = $this->coupon->with('couponcontent')->get(22);
		
		print_r($response);
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
//		$data = array('uid'=>'32','sessionToken'=>'ptHKUzWr17FwxVQqjube','card'=>'999999');
		
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
	
	function testKeys(){
		$url = HOST."/users?keys=phone,username";
		$json = $this->avoslibrary->get($url);
		echobr($url);
		echo $json;
	}
	
	
	function testAddShopBranchesToShop(){
	
		//大家乐总店：539d8817e4b0a98c8733f287
		//大家乐分店： 539d8817e4b0a98c8733f285, 539d8817e4b0a98c8733f284, 539d8817e4b0a98c8733f283
		
//		$branches = array('539d8817e4b0a98c8733f285','539d8817e4b0a98c8733f284','539d8817e4b0a98c8733f283');
//		
//		echo $this->addShopBranchesToShop($branches, '539d8817e4b0a98c8733f287');
//		$this->addShopBranchesToShop($branches, $headShopId);
		
		
	
	}
	
	function test(){

		print_r($this->card->get_id(296));
	}
	

}