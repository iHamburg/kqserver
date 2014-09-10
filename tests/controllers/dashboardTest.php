<?php

/**
 * @group Controller
 */

class DashboardTest extends CIUnit_TestCase
{
	public function setUp()
	{
		// Set the tested controller
		$this->CI = set_controller('admin/dashboard');
	}
	
	public function testIndex()
	{
		// Call the controllers method
		$this->CI->index();
		
		// Fetch the buffered output
		$out = output();
		
		// Check if the content is OK 没有error or notice
		$this->assertSame(0, preg_match('/(error|notice)/i', $out));
	}
	
	public function testLogin()
	{
		
//		echo 'show me the money';
//		var_dump($this->CI);
		// Call the controllers method
		$this->CI->login();
		
		// Fetch the buffered output
		$out = output();
		
		// Check if the content is OK 没有error or notice
		$this->assertSame(0, preg_match('/(error|notice)/i', $out));
		$this->assertNotEmpty($out);
		
		$this->assertSame(1, preg_match('/(登陆)/i', $out));
		
	}
	
	
}
