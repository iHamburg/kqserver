<?php
/**
 * 
 * District
 * @author qing
 *
 */



class District_m extends MY_Model{


	
	/**
	 * 
	 * Enter description here ...
	 * @var Avoslibrary
	 */

	
	public function __construct(){
		parent::__construct();
		$this->load->library('avoslibrary');
		
	}
	
	
	public function get($id){
		$json = $this->avoslibrary->retrieveObject('District',$id);
			
		return json_decode($json,true);
	}
	
	public function get_all(){
		$url = HOST.'/classes/District';
		$json = $this->avoslibrary->get($url);
		
		$results = json_decode($json,true);

		if (empty($results['error'])){
			return $results['results'];
		}
		else		
			return $results;
	
	}
	
	/**
	 * 
	 * 返回所有一级类型
	 */
	public function get_all_headDistrict(){
		
		$where = json_encode(avosExists('parent',false));
		$url = HOST.'/classes/District?include=subDistricts&where='.$where;
		
		$json = $this->avoslibrary->get($url);
			
		$results = json_decode($json,true);
   	
		if (empty($results['error'])){
   			return $results['results'];
   		}
   		else{
//   			return $results;
			return Error_Retrieve_Object;
   		}
   	
	}
	
	/**
	 * 返回所有的子类型
	 * @param unknown_type $id
	 * @return array $subtypes
	 */
	public function get_subDistricts($id){
		
		$url = HOST."/classes/District/$id?include=subDistricts";
		
		
		$json = $this->avoslibrary->get($url);
			
	
		$result = json_decode($json,true);
		
		if (empty($result['error'])){
			return $result['subDistricts'];
		}
		else{
			return Error_Retrieve_Object;
		}
		
	}
	
	/**
	 * 
	 * 创建类型
	 * @param array $data
	 * @return string $objectId
	 */
	public function create($data){
		
		
		$json = $this->avoslibrary->createObject('District',json_encode($data));
			
		$error = checkResponseError($json);
		if (!empty($error)) return false;
		
		 $result = json_decode($json,true);
		 $newId = $result['objectId'];
		
		 if (!empty($data['parent'])){
			$parentId = $data['parent']['objectId'];
		 
			$this->avoslibrary->addPointerInArray('District',$parentId,'subDistricts',avosPointer('District',$newId));
			
			$error = checkResponseError($json);
			if (!empty($error)) return false;
		}
		
		
		return $newId;
	}
	
	/**
	 * 如果
	 * @param unknown_type $id
	 */
	public function delete($id){
		
		
		$json = $this->avoslibrary->deleteObject('District',$id);
		$error = checkResponseError($json);
		if (!empty($error)) return false;
		return true;
	}
}