<?php
class Api_kqapi1_1_test extends CIUnit_TestCase
{
	
	
	/**
	 * 
	 * Enter description here ...
	 * @var CI
	 */
	var $CI;
	
	
	var $api_host;
	
	var $uid;
	
	var $couponId;
	
	var $shopBranchId;
	
	var $shopId;
	public function setUp()
	{
		// Set the tested controller
	
		
//		$this->api = set_controller('kqapi3');
		
		$this->CI = &get_instance();
		
		$this->api_host = 'http://localhost/kq/index.php/kqapi1_1';

		$this->uid = '57';
		$this->couponId = '36';
		$this->shopBranchId = '139';
		$this->shopId = '1';
		$this->sessionToken='7QhiuZsjBJFAPEC1WXrT';
		
	}
	
	public function tearDown(){
		
	}
	
	
	
	public function test(){

		$this->assertSame(1,1);

	}

	

	// 
//	public function test_login(){
//	
//		$host = ($this->api_host).'/login/username/13166361023/password/698d51a19d8a121ce581499d7b701668';
//		
//		 
//		$response = get($host); 
//		
//		$response = json_decode($response,true);
//		
//		$status = $response['status'];
//		$this->assertEquals($status,1);
//	
//	}
	
	public function test_userInfo(){
		
		$uid = $this->uid;
		$sessionToken = $this->sessionToken;
		
		$host = ($this->api_host).'/userInfo';
		
		$host = $host."/uid/$uid";
		$host.= "/sessionToken/$sessionToken";
		 
		$response = get($host); 
		
		$response = json_decode($response,true);
		
		$status = $response['status'];
		$this->assertEquals($status,1);
//		$this->assertNotNull($response);
	}
	
	
	public function test_myNews(){
		
		$uid = $this->uid;
		
		
		$host = ($this->api_host).'/myNews';
		
		$host = $host."/uid/$uid";
	
		 
		$response = get($host); 
		
		$response = json_decode($response,true);
		
		$status = $response['status'];
		$this->assertEquals($status,1);

	}
	
	public function test_myDownloadedCoupon(){
		
		$uid = $this->uid;
		
		
		$host = ($this->api_host).'/myDownloadedCoupon';
		
		$host = $host."/uid/$uid";
	
		 
		$response = get($host); 
		
		$response = json_decode($response,true);
		
		$status = $response['status'];
		$this->assertEquals($status,1);

	}


	public function test_myFavoritedCoupon(){
		
		$uid = $this->uid;
		
		
		$host = ($this->api_host).'/myFavoritedCoupon';
		
		$host = $host."/uid/$uid";
	
		 
		$response = get($host); 
		
		$response = json_decode($response,true);
		
		$status = $response['status'];
		$this->assertEquals($status,1);

	}
	
	public function test_isFavoritedCoupon(){
		
		$uid = $this->uid;
		
		
		$host = ($this->api_host).'/isFavoritedCoupon';
		
		$host = $host."/uid/$uid";
		$host.="/couponId/36";
		 
		$response = get($host); 
		
		$response = json_decode($response,true);
		
		$status = $response['status'];
		$this->assertEquals($status,1);

	}
	
	public function test_myFavoritedShopBranch(){
		
		$uid = $this->uid;
		
		
		$host = ($this->api_host).'/myFavoritedCoupon';
		
		$host = $host."/uid/$uid";
		
		 
		$response = get($host); 
		
		$response = json_decode($response,true);
		
		$status = $response['status'];
		$this->assertEquals($status,1);

	}
	
	public function test_isFavoritedShopBranchSuccess(){
		
		$uid = $this->uid;
		
		
		$host = ($this->api_host).'/isFavoritedShopbranch';
		
		$host = $host."/uid/$uid";
		$host.="/shopbranchId/36";
		 
		$response = get($host); 
		
		$response = json_decode($response,true);
		
		$status = $response['status'];
		$this->assertEquals($status,1);

	}
	
	
	public function test_hotestCoupons(){
		
		$host = ($this->api_host).'/hotestCoupons';
		
		 
		$response = get($host); // 可以直接用post
		
		$response = json_decode($response,true);

		$status = $response['status'];
		$this->assertEquals($status,1);
	
	}
	
	public function test_shopType(){
		$host = ($this->api_host).'/shopType';
		
		 
		$response = get($host); // 可以直接用post
		
		$response = json_decode($response,true);

		$status = $response['status'];
		$this->assertEquals($status,1);
	}
	
	public function test_district(){
			
		$host = ($this->api_host).'/district';
		
		 
		$response = get($host); // 可以直接用post
		
		$response = json_decode($response,true);

		$status = $response['status'];
		$this->assertEquals($status,1);
	}
	
	public function test_aroundShopbranches(){
			
		$host = ($this->api_host).'/aroundShopbranches';
		
		 
		$response = get($host); // 可以直接用post
		
		$response = json_decode($response,true);

		$status = $response['status'];
		$this->assertEquals($status,1);
	}
	
	public function test_searchCoupons(){
			
		$host = ($this->api_host).'/searchCoupons';
		
		 
		$response = get($host); // 可以直接用post
		
		$response = json_decode($response,true);

		$status = $response['status'];
		$this->assertEquals($status,1);
	}
	
	public function test_couponDetails(){
			
		$couponId = $this->couponId;
		$host = ($this->api_host).'/couponDetails';
		$host = $host."/id/$couponId";
		
		$response = get($host); // 可以直接用post
		
		$response = json_decode($response,true);

		$status = $response['status'];
		$this->assertEquals($status,1);
	}
	
	public function test_shopbranchDetails(){
			
		$shopBranchId = $this->shopBranchId;
		
		$host = ($this->api_host).'/shopbranchDetails';
		$host = $host."/id/$shopBranchId";
		
		$response = get($host); // 可以直接用post
		
		$response = json_decode($response,true);

		$status = $response['status'];
		$this->assertEquals($status,1);
	}
	
	public function test_allShopBranches(){
			
		$shopId = $this->shopId;
		
		$host = ($this->api_host).'/allShopbranches';
		$host = $host."/id/$shopId";
		
		$response = get($host); // 可以直接用post
		
		$response = json_decode($response,true);

		$status = $response['status'];
		$this->assertEquals($status,1);
	}
	

}