<?php


class News2_m extends MY_Model{
	
	
	public $_table = 'news';
	protected $return_type = 'array';
	
	
	public function __construct(){
		parent::__construct();
	
	}
	
	public function insert_news($title,$text,$uid=-1){
		
	}

	
}