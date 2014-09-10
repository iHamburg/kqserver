<?php

/**
 * @group Model
 */

class AdminTest extends CIUnit_TestCase
{
	/**
	 * 
	 * Enter description here ...
	 * @var Admin_m
	 */
	var $admin;
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
		
		$this->CI->load->model('admin_m','admin');
		$this->admin = $this->CI->admin;
		
		$this->u1 = 'admin';
		$this->pw1 = 'admin';
		$this->pw2 = 'aaaa';
		
	}



	
	function testLogin() {

//		$row = $this->admin->login($this->u1, $this->pw1);		
//		
//		$this->assertArrayHasKey('username',$_SESSION);
//		$this->assertEquals($_SESSION['username'],$this->u1);
//		
//		
//		$row = $this->admin->login($this->u1, $this->pw2);	
//		
//		$this->assertArrayNotHasKey('username',$_SESSION);
	}
	

}
