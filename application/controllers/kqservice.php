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
//		$url = HOST."/users?keys=phone,username";
//		echo $this->avoslibrary->get($url);
		
//	$data = array('shop'=>avosPointer('Shop', '53bbece4e4b0dea5ac1c8907'));
//		
//		echo $this->updateObject('Coupon','539e8dfce4b023daacbd6fa3',json_encode($data));
	
//		echo $this->addShopBranchesToShop(array('539e8c51e4b0c92f1847dc23','539e8c52e4b0c92f1847dc24'), '539e8c52e4b0c92f1847dc25');

//		echo $this->addCouponToShop('539d8cd9e4b0a98c8733f8dc', '539d8817e4b0a98c8733f287');

//		echo decodeUnicode($this->coupon_m->addInShop('539d8cd9e4b0a98c8733f8dc', '539d8817e4b0a98c8733f287'))	;
	}
	

}