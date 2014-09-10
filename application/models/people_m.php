<?php
/**
 * 
 * @deprecated
 * @author qing
 *
 */
class People_m extends CI_Model{


	/**
	 * 
	 * Enter description here ...
	 * @var Avoslibrary
	 */
//	var $avoslibrary;
	
	public function __construct(){
		parent::__construct();
		$this->load->library('avoslibrary');
	}

	function login($username,$password){
		$url = HOST."/login?username=$username&password=$password";
		
		$json = $this->avoslibrary->get($url);	

		return $json;
	}
	
	function get($id){
			$url = HOST."/users/$id";
   			
   			$json = $this->avoslibrary->get($url);
   			
   			return $json;
   		
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param array $data
	 */
	function create($data){
	
			$json = $this->avoslibrary->createUser(json_encode($data));
			
			return $json;
	}
	
}