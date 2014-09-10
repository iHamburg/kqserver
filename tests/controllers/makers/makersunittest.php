<?php

/**
 * @group Controller
 */

class Makersunittest extends CIUnit_TestCase
{
	
	/**
	 * 
	 * Enter description here ...
	 * @var Makers
	 */
	var $CI;
	
	
	public function setUp()
	{
		// Set the tested controller
	
		
		$this->CI = set_controller('makers');
		
	}
	
	public function tearDown(){
		
	}
	
	public function testLoginSuccessful(){
		
		$data = array('user_name'=>'forest','user_pass'=>'111111');
		$json = $this->CI->login($data);
		
		$this->assertNotEmpty($json,'hh');
		
		
		$response = json_decode($json,true);

		$status = $response['status'];
		
		
		$this->assertSame($status,1);
	}
	
	public function testLoginWrong(){
		
		$data = array('user_name'=>'forest','user_pass'=>'1111112');
		$json = $this->CI->login($data);
		
		$this->assertNotEmpty($json);
		
		
		$response = json_decode($json,true);

		$status = $response['status'];
		
		
		$this->assertSame($status,-1);
	}

	public function testLoginEmpty(){
		
		$data = array('user_name'=>'forest','user_pass'=>'');
		$json = $this->CI->login($data);
		
		$this->assertNotEmpty($json);
		
		
		$response = json_decode($json,true);

		$status = $response['status'];
		
		$this->assertSame($status,0);
	}
}
