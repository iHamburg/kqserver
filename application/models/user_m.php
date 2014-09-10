<?php


class User_m extends MY_Model{
	
	
	public $_table = 'card';
	protected $return_type = 'array';
	
	/**
	 * 
	 * Enter description here ...
	 * @var Avoslibrary
	 */
//	var $avoslibrary;
	
	public function __construct(){
		parent::__construct();
	
	}
	
	
	public function get($uid,$include='',$keys=''){
	
	
		$json = $this->avoslibrary->retrieveUser($uid,$include,$keys);

		$result = json_decode($json,true);
	
		if (empty($result['error'])){
   			return $result;
   		}
   		else{
   			return Error_Retrieve_Object;
   		}
	}
	
	public function get_all($skip=0,$limit=20,$include=''){

		
		$json = $this->avoslibrary->retrieveUsers('','-createdAt',$include,$limit,$skip);

		
		$results = json_decode($json,true);
   		
//		var_dump($results);
		
		if (!empty($results['error'])){
   				return Error_Retrieve_Object;
   		}
   		else{
   				return $results['results'];
   		}
	
	}
	
	/**
	 * 
	 * @return int
	 */
	function count_all(){
		$json = $this->avoslibrary->countUsers();
			
		$result = json_decode($json,true);
		
		if (empty($result['error'])){
   			return $result['count'];
   		}
   		else{
   			return $result;
   		}
	}
	
	/**
	 * Enter description here ...
	 * @param unknown_type $uid
	 * @return array 包含
	 *  title
	 */
	public function get_user_cards($uid){
			
		
			$where = json_encode(array('people'=>avosPointer('_User',$uid)));

			$json = $this->avoslibrary->retrieveObjects('Card',$where,'','','title');
		
   			$results = json_decode($json,true);
   			
   			
   			if (empty($results['error'])){
   				return $results['results'];
   			}
   			else{
   				return Error_Retrieve_Object;
   			}

   			
	}
	
	public function get_user_cards2($uid){
			
		
//			$where = json_encode(array('people'=>avosPointer('_User',$uid)));
//
//			$json = $this->avoslibrary->retrieveObjects('Card',$where,'','','title');
//		
//   			$results = json_decode($json,true);
//   			
//   			
//   			if (empty($results['error'])){
//   				return $results['results'];
//   			}
//   			else{
//   				return Error_Retrieve_Object;
//   			}

		
		$this->get_all();
		
   			
	} 
	
	
	public function get_user_downloaded_coupons($uid){
			
			$where = json_encode(array('people'=>avosPointer('_User',$uid)));
			

   			$json = $this->avoslibrary->retrieveObjects('DownloadedCoupon',$where,'coupon','','coupon');
   			
   			$results = json_decode($json,true);
   	
			if (empty($results['error'])){


				foreach ($results['results'] as $record) {
					$coupons[]=$record['coupon'];
				}
				return $coupons;
				
   			}
   			else{
   				return $results;
   			}
   			 
	}


	
	function login($username,$password){
		$url = HOST."/login?username=$username&password=$password";
		
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