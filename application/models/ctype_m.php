<?php
/**
 * 
 * CouponType
 * @author qing
 *
 */



class Ctype_m extends CI_Model{


	
	/**
	 * 
	 * Enter description here ...
	 * @var Avoslibrary
	 */
//	var $avoslibary;
	
	public function __construct(){
		parent::__construct();
		$this->load->library('avoslibrary');
	}

	public function test(){

		$url = HOST.'/classes/Card';
		$json = $this->avoslibrary->get($url);
		return $json;
	
	} 
	
	public function get($id){
		$json = $this->avoslibrary->retrieveObject('CouponType',$id);
		
		checkResponseError($json);
		
		return json_decode($json,true);
	}
	
	public function get_all(){
		$url = HOST.'/classes/CouponType';
		$json = $this->avoslibrary->get($url);
		
		checkResponseError($json);
		$results = resultsWithJson($json);
		return $results;
	
	}
	
	public function get_all_headType(){
		
		$where = json_encode(avosExists('parent',false));
		$url = HOST.'/classes/CouponType?include=subTypes&where='.$where;
		
		
		$json = $this->avoslibrary->get($url);
			
		$results = json_decode($json,true);
   	
		if (empty($results['error'])){
   				return $results['results'];
   		}
   			else{
   				return $results;
   		}
	}
	
	function get_all_subTypes(){
		$where = json_encode(avosExists('parent',true));
		$url = HOST.'/classes/CouponType?where='.$where;
		
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
	public function get_subTypes($id){
		
		$url = HOST."/classes/CouponType/$id?include=subTypes";
		
		
		$json = $this->avoslibrary->get($url);
			
		$error = checkResponseError($json);
		if (!empty($error)) return false;
		
		$result = json_decode($json,true);
		
//		var_dump($result);
		
		return $result['subTypes'];
	}
	
	/**
	 * 
	 * 创建类型
	 * @param array $data
	 * @return string $objectId
	 */
	public function create($data){
		
		
		
		$json = $this->avoslibrary->createObject('CouponType',json_encode($data));
			
		$error = checkResponseError($json);
		if (!empty($error)) return false;
		
		 $result = json_decode($json,true);
		 $newId = $result['objectId'];
		
		 if (!empty($data['parent'])){
			$parentId = $data['parent']['objectId'];
		 
			$this->avoslibrary->addPointerInArray('CouponType',$parentId,'subTypes',avosPointer('CouponType',$newId));
			$error = checkResponseError($json);
			if (!empty($error)) return false;
		}
		
		
		return $newId;
	}
	
	/**
	 * 如果
	 * @param unknown_type $id
	 */
	public function delete($id,$parentId){
		
		if (!empty($parentId)){
			$this->avoslibary->removePointerInArray('CouponType', $parentId, 'subType', avosPointer('CouponType',$id));
			$error = checkResponseError($json);
			if (!empty($error)) return false;
		}
		
		
		$json = $this->avoslibrary->deleteObject('CouponType',$id);
		
		
		$error = checkResponseError($json);
		if (!empty($error)) return false;
		return true;
	}
}