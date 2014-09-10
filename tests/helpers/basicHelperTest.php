<?php

/**
 * @group Helper
 */

class BasicHelperTest extends CIUnit_TestCase
{
	public function setUp()
	{
		$this->CI->load->helper('basic');
	}
	
	public function testSampleFunction()
	{
		//$this->assertEquals('Hi!', say('Hi!'));
	}
	
	public function test_date_with_datetime(){
		
		$datetime="2014-1-25 12:12:00";
		$date = date_with_datetime($datetime);
		$this->assertEquals('2014-01-25',$date);
	}
}
