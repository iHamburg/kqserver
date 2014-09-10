<?php

/**
 * @group Controller
 */

class EventAPITest extends CIUnit_TestCase
{
	public function setUp()
	{
		// Set the tested controller
		$this->CI = set_controller('apis/event');

	}
	
	
	function tearDown(){

	}
	
	function test() {
		$this->assertTrue(true);	
	}
	
//	public function test_latest_get()
//	{
//		
//		$ch = curl_init();
//		$curl_url = site_url('apis/event/latest');		
//		curl_setopt($ch, CURLOPT_URL, $curl_url);
//		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//不直接输出，返回到变量
//		$responsejson = curl_exec($ch);
//		curl_close($ch);
//		$response = json_decode($responsejson,true);
//
//		//	print_r($response);
//	
//		$this->assertEquals($response['status'],'ok');
//	}
//	
//	function test_enroll_post() {
//		
//
//		$post_data = array('username'=>'test user','telephone'=>'334455','eventid'=>23);
//			
//		$curl_url = site_url('apis/event/enroll');		
//		$ch = curl_init();
//		
//		curl_setopt($ch, CURLOPT_URL, $curl_url);
//		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//		// 我们在POST数据哦！
//		curl_setopt($ch, CURLOPT_POST, 1);
//		// 把post的变量加上
//
//		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
//		$output = curl_exec($ch);
//		curl_close($ch);
//		
//		$response = json_decode($output,true);
////		echo 'output '.$output;
////		print_r($response);
//	
//		$this->assertEquals($response['status'],'ok');
//	}
//	
	
}
