<?php


class Rent_M extends MY_Model{
	
	public $_table = 'admins';
	protected $return_type = 'array';
	
	public function __construct(){
		parent::__construct();
			$this->table = 'rents';
	}
	
	

}