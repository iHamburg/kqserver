<?php

/**
 * @group Controller
 */

class GzhsTest extends CIUnit_TestCase
{
	/**
	 * 
	 * Enter description here ...
	 * @var Gzhs
	 */
	var $CI;
	public function setUp()
	{
		// Set the tested controller
		$this->CI = set_controller('admin/gzhs');
	}
	
	public function test_get_weixin_right()
	{

		$weixin = $this->CI->_get_weixin(1);
		
		$this->assertNotEmpty($weixin);
		$this->assertSame($weixin->url,'weixins/message/1');
		
	}
	
	
}
