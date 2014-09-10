<?php

/**
 * @group Controller
 */

class AvosUnitTest extends CIUnit_TestCase
{
	
	/**
	 * 
	 * Enter description here ...
	 * @var Avos
	 */
	var $CI;
	
	
	public function setUp()
	{
		// Set the tested controller
	
		
		$this->CI = set_controller('avos');
		
	}
	
	public function tearDown(){
		
	}
	
	public function testLogin(){
		
		$outputJson = $this->CI->login('a@b.com','111');
		$output = json_decode($outputJson);

		$this->assertObjectNotHasAttribute('error',$output,'wrong pw is error');

	}
	
	public function testLoginWrongPW(){
		
		$outputJson = $this->CI->login('tominfrankfurt@gmail.com','111ss');
		
		$output = json_decode($outputJson);

		$this->assertObjectHasAttribute('error',$output,'wrong pw is error');
	}
	


	public function testRetriveObject(){
		
		$outputJson = $this->CI->retrieveObject('UserStatus','536c4533e4b01d15a0e5d9ca');
		
		$this->assertNotEmpty($outputJson);
		
		$output = json_decode($outputJson);

		$this->assertObjectNotHasAttribute('error',$output,$outputJson);
	}
	
	public function testRetrieveObjects(){
		$outputJson = $this->CI->retrieveObjects('UserStatus',json_encode(array('energy'=>array('$exists'=>true))));
		
		$output = json_decode($outputJson);

		$this->assertObjectNotHasAttribute('error',$output,$outputJson);
	}
	
	public function testRetrieveObjectsOrder(){
		$outputJson = $this->CI->retrieveObjects('UserStatus',json_encode(array('energy'=>array('$exists'=>true))),'energy');
		
		$output = json_decode($outputJson);

		$this->assertObjectNotHasAttribute('error',$output,$outputJson);
	}
	
	public function testUpdateUser(){
//		$outputJson = $this->CI->updateUser('536b2ba4e4b0bc545bb45f77','eyiztk4bd8lzmg638zk5ce3cb',json_encode(array('firstName'=>'ddd')));
//		
//		$output = json_decode($outputJson);
//
//		$this->assertObjectNotHasAttribute('error',$output,$outputJson);
	}
	
	public function testDeleteObj(){
		
//		536b8d24e4b098d841dd01c4
		$outputJson = $this->CI->deleteObject('UserStatus','536b8d24e4b098d841dd01c4');
		
		$this->assertNotEmpty($outputJson);
		
		$output = json_decode($outputJson);

		$this->assertObjectNotHasAttribute('error',$output,$outputJson);
	}
	
	public function testAddRemoveRelation(){
		
//		UserStatus/536b8d83e4b098d841dd028d/unlockedLogos/Logo/536c1febe4b098d841ddb333
		$outputJson = $this->CI->addRelation('UserStatus','536b8d83e4b098d841dd028d','unlockedLogos','Logo','536c1febe4b098d841ddb333');
		
		$output = json_decode($outputJson);

		$this->assertObjectNotHasAttribute('error',$output,$outputJson);
		
		$outputJson = $this->CI->removeRelation('UserStatus','536b8d83e4b098d841dd028d','unlockedLogos','Logo','536c1febe4b098d841ddb333');
		
		$output = json_decode($outputJson);

		$this->assertObjectNotHasAttribute('error',$output,$outputJson);
		
	}
	
	public function testIncrement(){
		$outputJson = $this->CI->increment('UserStatus','536b8d83e4b098d841dd028d','energy',2);
		
		$output = json_decode($outputJson);

		$this->assertObjectNotHasAttribute('error',$output,$outputJson);
	}

}
