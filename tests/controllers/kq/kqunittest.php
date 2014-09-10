<?php
class Kqunittest extends CIUnit_TestCase
{
	
	/**
	 * 
	 * Enter description here ...
	 * @var Kqavos
	 */
	var $CI;
	
	
	public function setUp()
	{
		// Set the tested controller
	
		
		$this->CI = set_controller('kqavos');
		
	}
	
	public function tearDown(){
		
	}
	
	public function test(){
		$this->assertSame(1,1);
	}
	
//	public function testLoginSuccessful(){
//		
//		$json = $this->CI->login('1358965658','111');
//
//		$response = json_decode($json,true);
//		$status = $response['status'];
////		
////		
//		$this->assertSame($status,'1');
//	}
//	
//	public function testRegister(){
//	
//	}
//	
//	function testQueryUserList(){
//		$uids = array('539560f2e4b08cd56b62cb98','539560f2e4b08cd56b62cb99');
//		$_POST['uids']= $uids;
//		$json = $this->CI->queryUserList();
//		$response = json_decode($json,true);
//		$status = $response['status'];
//		$this->assertSame($status,'1');
//	}
//	
//	function testQueryCards(){
//	
//		$json = $this->CI->queryCards('539560f2e4b08cd56b62cb98');
//		$response = json_decode($json,true);
//		$status = $response['status'];
//		$this->assertSame($status,'1');
//	}
//	
//	function testIsCardUsedSuccessful(){
//		
////		$this->assertFalse($this->CI->isCardNumberUsed('111222333'));
//	
//		$this->assertTrue($this->CI->isCardNumberUsed('111222333'));
//	}
//	
//	function testIsCardNotUsed(){
//		
//	
//		$this->assertFalse($this->CI->isCardNumberUsed('1112223332'));
//	}
//	
//	function testUserHasFavoritedShop(){
//		$this->assertTrue($this->CI->isShopFavorited('539676b4e4b09baa2ad7ac78','539d8817e4b0a98c8733f287'));
//	}
//	
//	function testUserHasNotFavoritedShop(){
//		$this->assertFalse($this->CI->isShopFavorited('539676b4e4b09baa2ad7ac78','539d8817e4b0a98c8733f287111'));
//	}
}