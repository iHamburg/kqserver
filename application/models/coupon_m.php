<?php
/**
 * 
 * 
 * @author qing
 *
 */
class Coupon_m extends CI_Model{


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


	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $id
	 * @param unknown_type $include
	 * @param unknown_type $keys
	 */
	public function get($id,$include='',$keys=''){
			$url = HOST.'/classes/Coupon/'.$id.'?limit=1';
   			
			if (!empty($include)){
				$url .= "&include=$include";
			}
			
			if(!empty($keys)){
				$url .="&keys=$keys";
			}
					
   			$json = $this->avoslibrary->get($url);
   			
   			$result = json_decode($json,true);
   			
   			
		if(!empty($result['error'])){
			return Error_Retrieve_Object;
		 }
		else{
		 return $result;
		}
	}
	
	
	/**
	 * 
	 * Enter description here ...
	 * @return int;
	 */
	function count_all(){
			
		$json = $this->avoslibrary->count('Coupon');
		
		$result = json_decode($json,true);
		
		if (empty($result['error'])){
   			return $result['count'];
   		}
   		else{
   			return $result;
   		}
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @return array (coupons)
	 */
	public function get_all($skip=0,$limit=20){
		
		$url = HOST."/classes/Coupon?order=-createdAt&skip=$skip&limit=$limit";
		$json = $this->avoslibrary->get($url);
		
	
		$results = json_decode($json,true);
   	
		if (empty($results['error'])){
   				return $results['results'];
   			}
   			else{
   				return Error_Retrieve_Object;
   			}
	
	}
	


	/**
	 * 
	 * 创建优惠券, shop的coupons 加上coupon
	 * @param array $data
	 * @return 
	 * string $objectId
	 * 
	 * 
	 * 
	 */
	public function create($data){
			
		
		$json = $this->avoslibrary->createObject('Coupon',json_encode($data));
		
		$result = json_decode($json,true);

		if(!empty($result['error'])){
		 	return Error_Create_Object; 
		 }
		 
		 $newId = $result['objectId'];
		
		///shop的coupons 加上coupon
		
		 $shopId = $data['shop']['objectId'];
		 
		$json = $this->avoslibrary->addPointerInArray('Shop', $shopId, 'coupons', avosPointer('Coupon', $newId));
		 
		$result = json_decode($json,true);
		
//		var_dump($result);
		
		if(!empty($result['error'])){
			
		 	return Error_Add_Object_In_Array; 
		 }
		 
		return $newId;
	}
	
/**
	 * 
	 * @param string $id
	 * @param array $data
	 * @return true
	 */
	function update($id,$data){
		$json = $this->avoslibrary->updateObject('Coupon', $id, json_encode($data));
		
	 	$result = json_decode($json,true);
		 
		if (!empty($result['error'])){
			return Error_Update_Object;
		}
		else{
			return true;
		}
		
	}
	
	/**
	 * 删除coupon
	 * @param unknown_type $id
	 * 
	 * @return 
	 * true
	 * 
	 * 
	 */
	public function delete($id){
		
		$json = $this->avoslibrary->retrieveObject('Coupon',$id);
		
		$result = json_decode($json,true);
		if(!empty($result['error'])){
			return Error_Retrieve_Object;
		 }
		
		 $shopId = $result['shop']['objectId'];
		 
		$json = $this->avoslibrary->removePointerInArray('Shop', $shopId, 'coupons', avosPointer('Coupon', $id));
		$result = json_decode($json,true);
		
		if(!empty($result['error'])){
						
			return Error_Remove_Object_In_Array;
		 }
		
		
		 $json = $this->avoslibrary->deleteObject('Coupon',$id);
		
		 $result = json_decode($json,true);
		 
		if(!empty($result['error'])){
		 	return Error_Delete_Object;
		 }
		 return true;
	}

	/**
	 * 
	 * 返回搜索的coupon
	 * @param string $whereJson
	 * @param unknown_type $skip
	 * @param unknown_type $limit
	 */
	function search($whereJson,$skip=0,$limit=50){
		
		$url = HOST."/classes/Shop?skip=$skip&limit=$limit&where=$whereJson&keys=parent,location&include=parent,parent.coupons";
   		
//   		echobr($url);
		
   		$json = $this->avoslibrary->get($url);

   		$results = json_decode($json,true);
   		
//   		var_dump($results);
   		
		if (!empty($results['error']))
			return Error_Search_Shop;
		
		$results = $results['results'];			
			
		///遍历所有的shopbranch，把主商户的coupons加入coupons数组中
		foreach ($results as $shopBranch) {
			
			if (!empty($shopBranch['parent']['coupons'])){
				
				/// 给coupon加上位置信息
				foreach ($shopBranch['parent']['coupons'] as $coupon) {	
					$coupon['location'] = $shopBranch['location'];
					$coupons[]=$coupon;
					
				}		
			}

			
		}
		
		return $coupons;
	}
	
	function get_newest_coupons($skip=0,$limit=30){
	
		$json = $this->avoslibrary->retrieveObjects('Coupon','','','-createdAt','',$skip,$limit);
		
		$results = json_decode($json,true);
   	
		if (empty($results['error'])){
   				return $results['results'];
   		}
   		else{
   				return Error_Retrieve_Object;
   		}
		
	}
	
	function addInShop($couponId,$shopId){
		$json = $this->avoslibrary->addPointerInArray('Shop', $shopId, 'coupons', avosPointer('Coupon', $couponId));
		 
		$result = json_decode($json,true);
		if(!empty($result['error'])){
			return $json;
		 	return Error_Add_Object_In_Array; 
		 }
		 
		return true;
	}
	
}