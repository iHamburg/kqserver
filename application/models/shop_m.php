<?php
/**
 * 
 * 
 * @author qing
 *
 */
class Shop_m extends CI_Model{


	/**
	 * 
	 * Enter description here ...
	 * @var Avoslibrary
	 */
//	var $avoslibrary;
	
	public function __construct(){
		parent::__construct();

	}


	
	public function get($id){
		$json = $this->avoslibrary->retrieveObject('Shop',$id,'shopBranches,coupons');
		
		$result = json_decode($json,true);
		
		if (empty($result['error'])){
   			return $result;
   		}
   		else{
   			return Error_Retrieve_Object;
   		}
   		
		
	}
	
	public function get_all($skip=0,$limit=20){
		$url = HOST."/classes/Shop?skip=$skip&limit=$limit";
		$json = $this->avoslibrary->get($url);
		
		$results = json_decode($json,true);
   	
		if (empty($results['error'])){
   				return Error_Retrieve_Object;
   		}
   		else{
   				return $results;
   		}
	
	}
	
	/**
	 * 
	 * @return int
	 */
	function count_all_headShops(){
		$where = json_encode(avosExists('parent',false));

		$json = $this->avoslibrary->count('Shop',$where);
		
		$result = json_decode($json,true);
		
		if (empty($result['error'])){
   			return $result['count'];
   		}
   		else{
   			return $result;
   		}
	}
	
	
	public function get_all_headShops($skip=0,$limit=20){
		
		$where = json_encode(avosExists('parent',false));
		$url = HOST."/classes/Shop?order=-createdAt&skip=$skip&limit=$limit&where=$where";
		
		
		$json = $this->avoslibrary->get($url);
			
		$results = json_decode($json,true);
		
		if (empty($results['error'])){
   			return $results['results'];
   		}
   		else{
   			return $results;
   		}
	
	}
	
	/**
	 * 返回所有的子类型
	 * @param unknown_type $id
	 * @return array $subtypes
	 */
	public function get_shopBranches($id){
		
		$url = HOST."/classes/Shop/$id?include=shopBranches";
		
		
		$json = $this->avoslibrary->get($url);
			
		$result = json_decode($json,true);
		
//		var_dump($result);
		
		if (empty($result['error'])){
   			return $result['shopBranches'];
   		}
   		else{
   			return $result;
   		}
	}
	
	/**
	 * 
	 * 创建主商户
	 * @param array $data
	 * @return string $objectId
	 */
	public function create($data){
		
		
		$json = $this->avoslibrary->createObject('Shop',json_encode($data));
			
		$result = json_decode($json,true);
		
		if (!empty($result['error'])){
			return Error_Create_Object;
		}
		
		$newId = $result['objectId'];

		return $newId;
	}
	
	
	/**
	 * 
	 * @param string $id
	 * @param array $data
	 * @return true
	 */
	function update($id,$data){
		$json = $this->avoslibrary->updateObject('Shop', $id, json_encode($data));
		
	 	$result = json_decode($json,true);
		 
		if (!empty($result['error'])){
			return Error_Update_Object;
		}
		else{
			return true;
		}
		
	}
	
	/**
	 * 如果
	 * @param unknown_type $id
	 */
	public function delete($id){
		
		
		$json = $this->avoslibrary->deleteObject('Shop',$id);
		
		$result = json_decode($json,true);
		 
		if (!empty($result['error'])){
			return Error_Delete_Object;
		}
		else{
			return true;
		}
	}

	/**
	 * 创建子商户, 主商户加shopBranches array
	 * @param array $data
	 */
	public function createShopBranch($data){
	
		$json = $this->avoslibrary->createObject('Shop',json_encode($data));
	    
		$result = json_decode($json,true);
		 
		if (!empty($result['error'])){
			return Error_Create_Object;
		}
		
		$newId = $result['objectId'];
		
		$parentId = $data['parent']['objectId'];
		
		$json = $this->avoslibrary->addPointerInArray('Shop', $parentId, 'shopBranches', avosPointer('Shop', $newId));

		$result = json_decode($json,true);
		 
		if (!empty($result['error'])){
			return Error_Add_Object_In_Array;
		}
		
	}
	
	public function deleteShopBranch($id,$parentId){
		
		$json = $this->avoslibrary->removePointerInArray('Shop', $parentId, 'shopBranches', avosPointer('Shop', $id));
		
		$result = json_decode($json,true);
		 
		if (!empty($result['error'])){
			return Error_Remove_Object_In_Array;
		}
		
		$json = $this->avoslibrary->deleteObject('Shop',$id);
		
		$result = json_decode($json,true);
		 
		if (!empty($result['error'])){
			return Error_Delete_Object;
		}
		
		return true;
	}
	
	
	function search(){
	
	}
	
}