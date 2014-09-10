<?php

/**
 * @group Model
 */

class Wx_msg_repsonseTest extends CIUnit_TestCase
{
	
	
	/**
	 * 
	 * Enter description here ...
	 * @var Wx_msg_response_m
	 */
	var $msg_response;
	
	protected $tables = array(
		//'group'		 => 'group',
		//'user'		  => 'user',
		//'user_group'	=> 'user_group'
	);
	
	public function __construct($name = NULL, array $data = array(), $dataName = '')
	{
		parent::__construct($name, $data, $dataName);
	}
	
	public function setUp()
	{
		parent::tearDown();
		parent::setUp();
		
		/*
		* this is an example of how you would load a product model,
		* load fixture data into the test database (assuming you have the fixture yaml files filled with data for your tables),
		* and use the fixture instance variable
		
		$this->CI->load->model('Product_model', 'pm');
		$this->pm=$this->CI->pm;
		$this->dbfixt('users', 'products')
		
		the fixtures are now available in the database and so:
		$this->users_fixt;
		$this->products_fixt;
		
		*/

		$this->CI->load->model('wx_msg_response_m','msg_response');
		$this->msg_response = $this->CI->msg_response;
		
	}

	function test() {
		
		$this->asserttrue(true);
	}
	
	function testGetResponseByMsgKey(){
		
		$response = $this->msg_response->getResponseByMsgKey(1, 'EK_1');
		
//		var_dump($response);
		$this->assertSame('4',$response['responseid']);
	}

}
