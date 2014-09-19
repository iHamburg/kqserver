<?php
class apiunittest extends CIUnit_TestCase
{
	
	
	/**
	 * 
	 * Enter description here ...
	 * @var CI
	 */
	var $CI;
	
	
	var $api_host;
	
	var $uid;
	
	public function setUp()
	{
		// Set the tested controller
	
		
//		$this->api = set_controller('kqapi3');
		
		$this->CI = &get_instance();
		$this->api_host = 'http://localhost/kq/index.php/kqapi3';

		$this->uid = '539676b4e4b09baa2ad7ac78';
	}
	
	public function tearDown(){
		
	}
	
	
	
	public function test(){

		$this->assertSame(1,1);
	
	}

	public function testLogin(){
		$host = ($this->api_host).'/login';
		
		$json = $this->CI->curl->simple_get($host, array('username'=>'222','password'=>'111'));
		
		$results = json_decode($json,true);
		
		$this->assertSame($results['status'],1);
	}
	
	function testSearchCoupons(){
	
	}
	
	public function testHeadDistricts(){
	
		$host = ($this->api_host).'/headDistricts';
		
		$json = $this->CI->curl->simple_get($host);
		
		$results = json_decode($json,true);
		
		$this->assertSame($results['status'],1);
	}
	
	function testHeadCouponTypes(){
		
		$host = $this->api_host.'/headCouponTypes';
		
		$json = $this->CI->curl->simple_get($host);
		
		$results = json_decode($json,true);
		
		$this->assertSame($results['status'],1);
	}
	
	function testQueryMyCards(){
		$host = $this->api_host.'/mycard';
		
		$json = $this->CI->curl->simple_get($host,array('uid'=>$this->uid));
		
		$results = json_decode($json,true);
		
		$this->assertSame($results['status'],1);
	}
	
	function testQueryNewestCoupons(){
		$host = $this->api_host.'/newestCoupons';
		
		$json = $this->CI->curl->simple_get($host);
		
		$results = json_decode($json,true);
		
		$this->assertSame($results['status'],1);
	}
	
	/// GET + Params
	function testQueryMyFavoritedCoupon(){
		$host = $this->api_host.'/myFavoritedCoupon';
		
		
		$json = $this->CI->curl->simple_get($host,array('uid'=>$this->uid));
		
		$results = json_decode($json,true);
		
		$this->assertSame($results['status'],1);
	}
	
	function testQueryMyFavoritedShop(){
		$host = $this->api_host.'/myFavoritedShop';
		
		$json = $this->CI->curl->simple_get($host,array('uid'=>$this->uid));
		
		$results = json_decode($json,true);
		
		$this->assertSame($results['status'],1);
	}

	function testQueryMyDownloadedCoupon(){
		$host = $this->api_host.'/myDownloadedCoupon';
		
		$json = $this->CI->curl->simple_get($host,array('uid'=>$this->uid));
		
		$results = json_decode($json,true);
		
		$this->assertSame($results['status'],1);
	}
}