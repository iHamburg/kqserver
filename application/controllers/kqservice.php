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
  
	
	/**
	 * 
	 * Enter description here ...
	 * @var Avoslibrary
	 */
	var $avoslibrary;
	
	
	function __construct(){
		parent::__construct();
		
	
	}
	

	function index() {

		echo 'kqservice';
		
	}
	
	/**
	 * Shop发行新的Coupon <br>
	 * coupon.shop = shop;
	 * shop.coupons add coupon 
	 * @param $couponId
	 * @param $shopId
	 */
	function addCouponToShop($couponId, $shopId){
		
		// coupon.shop = shop;
		
		$data = array('shop'=>avosPointer('Shop',$shopId));
		$this->updateObject('Coupon',$couponId,json_encode($data));
		
		
		$where = array('parent'=>avosPointer('Shop',$shopId));
		$json = $this->retrieveObjects('Shop',json_encode($where));
		
		$error = checkResponseError($json);
		if(!empty($error))
				return $error;
				
		//shop.coupons add coupon 		
		
		$json = $this->addPointerInArray('Shop',$shopId,'coupons',avosPointer('Coupon',$couponId));
		$error = checkResponseError($json);
		if(!empty($error))	return $error;
		
	}
	
	/**
	 * 把分店和总店连起来 <br>
	 * shopBranch.parent = headShop
	 * headShop.shopBranches add shopBranch
	 * @param array $shopBranchIds: 分店的Id数组
	 * @param string $shopId
	 * 
	 * 
	 */
	function addShopBranchesToShop($shopBranchIds,$headShopId){
	
		//batch: shopBranch.parent = headShop

          foreach ($shopBranchIds as $id) {
               $requests[]=avosBatch('PUT',"/1/classes/Shop/$id",array('parent'=>avosPointer('Shop',$headShopId)));
          }

          $json = $this->batch($requests);
          
          $error = checkResponseError($json);
	      if(!empty($error))	return $error;
		
	      
		///headShop.shopBranches add shopBranch
		
	    $json = $this->addPointersInArray('Shop',$headShopId,'shopBranches','Shop',$shopBranchIds);
	    
	       $error = checkResponseError($json);
	      if(!empty($error))	return $error;
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