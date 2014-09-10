<?php


class Mrents extends Crud_model{
	
	public function __construct(){
		parent::__construct();
			$this->table = 'rents';
	}
	
	
	
	function testConfig(){
		
		$this->title = 'aaa';
		return $this->title;
		
//		$data = $this->config->item('base_url'); 
//		return $data;
	}
}