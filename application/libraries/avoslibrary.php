<?php

define('HOST','https://cn.avoscloud.com/1');


define('Error_Create_Object', -8201);
define('Error_Add_Object_In_Array', -8202);
define('Error_Delete_Object', -8203);
define('Error_Remove_Object_In_Array', -8204);
define('Error_Retrieve_Object', -8205);
define('Error_Update_Object', -8206);
define('Error_Search_Shop',-8207);


class Avoslibrary{
	
	
	 public $header;
     
	 public $jsonHeader;
     

     public function __construct(){
		
		
		$appid = 'ezxvldwk94k38d6fki1ks4yq55jkl2t15tttu5ezdqbk8mio';
		$appkey = 'mtbrztjctplgnho2qf49cs70gd4lfggiayww7u6h4mv5s60t';
		
		$this->header =  array(
			'X-AVOSCloud-Application-Id:'.$appid,
			'X-AVOSCloud-Application-Key:'.$appkey,
		);
		
		$this->jsonHeader = array(
			'X-AVOSCloud-Application-Id:'.$appid,
			'X-AVOSCloud-Application-Key:'.$appkey,
		  	'Content-Type: application/json;charset=utf-8');
	}
	

	/**
	 * 
	 * 用户表单的数组字段增加元素
	 * @param  $uid
	 * @param  $sessionToken
	 * @param  $field
	 * @param array $pointer
	 * @return json
	 */
	function addPointerInArrayForUser($uid,$sessionToken,$field,$pointer){
		$data = json_encode(array($field=>array('__op'=>'AddUnique','objects'=>array($pointer))));
		return $this->updateUser($uid,$sessionToken,$data);
	}
	
	/**
	 * 
	 * 用户表单的数组字段删除元素
	 * @param unknown_type $uid
	 * @param unknown_type $sessionToken
	 * @param unknown_type $field
	 * @param unknown_type $pointer
	 */
	function removePointerInArrayForUser($uid,$sessionToken,$field,$pointer){
		$data = json_encode(array($field=>array('__op'=>'Remove','objects'=>array($pointer))));
		return $this->updateUser($uid,$sessionToken,$data);
	}
	
/**
 * 
 * 表单的数组字段增加元素
 * @param  $className
 * @param  $objectId
 * @param  $field
 * @param array $pointer
 */
	function addPointerInArray($className,$objectId,$field,$pointer){
		$data = json_encode(array($field=>array('__op'=>'AddUnique','objects'=>array($pointer))));
		return $this->updateObject($className,$objectId,$data);
	}
	
	/**
	 * 表单的数组字段增加多个元素
	 * @param string $className 
	 * @param string $objectId
	 * @param string $field
	 * @param string $pointerClassName: 新元素的Class
	 * @param array $pointers: 新元素Id数组;
	 * @return json;
	 */
	function addPointersInArray($className,$objectId,$field,$pointerClassName,$pointerIds){
	
		foreach ($pointerIds as $id) {
			$array[] = avosPointer($pointerClassName,$id);
		}
		$data = json_encode(array($field=>array('__op'=>'AddUnique','objects'=>$array)));
		
		return $this->updateObject($className,$objectId,$data);
	}
	
	/**
	 * 
	 * 表单的数组字段删除元素
	 * @param str $className
	 * @param str $objectId
	 * @param str $field
	 * @param array $pointer
	 */
	function removePointerInArray($className,$objectId,$field,$pointer){
		$data = json_encode(array($field=>array('__op'=>'Remove','objects'=>array($pointer))));
		return $this->updateObject($className,$objectId,$data);
	}
	
	/**
	 * 
	 * 给A的key增加relationB
	 * @param unknown_type $fatherClassName
	 * @param unknown_type $fatherId
	 * @param unknown_type $relationName
	 * @param unknown_type $sonClassName
	 * @param unknown_type $sonId
	 */
	function addRelation($fatherClassName,$fatherId,$relationName,$sonClassName,$sonId){
		
		$url =  HOST.'/classes/'.$fatherClassName.'/'.$fatherId;
		
		$data = array($relationName=>array('__op'=>'AddRelation','objects'=>array(avosPointer($sonClassName,$sonId))));
		
		return $this->put($url,json_encode($data));

	}
	
	function removeRelation($fatherClassName='',$fatherId='',$relationName='',$sonClassName='',$sonId=''){
		$url =  HOST.'/classes/'.$fatherClassName.'/'.$fatherId;
	
		$data = array($relationName=>array('__op'=>'RemoveRelation','objects'=>array(avosPointer($sonClassName,$sonId))));
		
		return $this->put($url,json_encode($data));
	}
	

		
//		$url = 'https://cn.avoscloud.com/1/classes/Logo?where={"$relatedTo":{"object":{"__type":"Pointer","className":"UserStatus","objectId":"5370171de4b0fd29fa265c91"},"key":"unlockedLogos"}}';
//		$url = HOST.'/classes/'.$sonClassName.'?where={"$relatedTo":{"object":{"__type":"Pointer","className":"'.$fatherClassName.'","objectId":"'.$fatherId.'"},"key":"'.$relationName.'"}}';
	/**
	 * 
	 * 获得fatherClass的relate的所有sonClass, 不能是_User 
	 * @param unknown_type $fatherClassName
	 * @param unknown_type $fatherId
	 * @param unknown_type $key
	 * @param unknown_type $sonClassName
	 */
	function retrieveRelation($fatherClassName,$fatherId,$key,$sonClassName){
		
		$where = json_encode(array('$relatedTo'=>array('object'=>avosPointer($fatherClassName,$fatherId),'key'=>$key)));
		
		$url = HOST.'/classes/'.$sonClassName.'?where='.$where;
		
		return $this->get($url);
	}
	
	function increment($className,$objectId,$field,$increment=1){
	
		$url = HOST.'/classes/'.$className.'/'.$objectId;

		$data = array($field=>array('__op'=>'Increment','amount'=>intval($increment)));
		
		return $this->put($url,json_encode($data));
	}
	

	function count($className,$whereJson=''){
		
		$url = HOST.'/classes/'.$className.'?count=1&limit=0';
		
		if (!empty($whereJson)){
			$url.='&where='.$whereJson;
		}
   		
   		$json = $this->get($url);
   		
   		return $json;
	}
	
	function countUsers($whereJson=''){
		$url = HOST.'/users?count=1&limit=0';
		
		if (!empty($whereJson)){
			$url.='&where='.$whereJson;
		}
   		
   		$json = $this->get($url);
   		
   		return $json;
	}
	
	/**
	 * 返回判断field是否有xxvalue
	 * @param unknown_type $className
	 * @param unknown_type $field
	 * @param id $value
	 */
	function isFieldHasValue($className,$field,$value){
		$where = array($field=>$value);
		$json = $this->retrieveObjects($className,json_encode($where));
		
		$results = resultsWithJson($json);
		if (empty($results))
			return false;
		else 
			return true;
	}
	
//----------------------Intern -------------------
	/**
	 * 
	 * Enter description here ...
	 * @param string $objJson
	 */
	function createUser($objJson){
		
		$url = HOST.'/users';
		
		return $this->post($url,$objJson);
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $userId
	 * @param string $include
	 */
	function retrieveUser($userId,$include='',$keys=''){
		
		$url = HOST."/users/$userId?limit=1";
		
		if(!empty($include)){
			$url.="&include=$include";
		}
		
		if(!empty($keys)){
			$url.="&keys=$keys";
		}
		
		return $this->get($url);

	}
	
	
	/**
	 * 
	 * 
	 * @param string $where 
	 * @param unknown_type $order
	 * @param unknown_type $limit
	 * @param unknown_type $skip
	 */
	function retrieveUsers($where='',$order='',$include='',$limit=100,$skip=0){
				
		$url = HOST.'/users?limit='.$limit.'&skip='.$skip;;
		
		if(!empty($where)){
			$url .="&where=$where";
		}
		
		if(!empty($order)){
			$url = $url.'&order='.$order;
		}
		
		if(!empty($include)){
			$url.="&include=$include";
		}

		
		return $this->get($url);
	
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $userId
	 * @param unknown_type $session
	 * @param string $objJson
	 */
	function updateUser($userId,$session,$objJson){
			
		
		$url = HOST.'/users/'.$userId;
		$header = $this->jsonHeader;
		$header[]='X-AVOSCloud-Session-Token:'.$session;
		
		return $this->put($url,$objJson,$header);

	}
	
	function deleteUser($userId,$session){
	
		$url = HOST.'/users/'.$userId;
		$header = $this->jsonHeader;
		$header[]='X-AVOSCloud-Session-Token:'.$session;
	
		return $this->delete($url,$header);
	}

	
	/**
	 * 
	 * @param unknown_type $className
	 * @param string $objJson
	 */
	function createObject($className,$objJson){
	
		$url = HOST.'/classes/'.$className;

		return $this->post($url,$objJson);
	}

	
	function retrieveObject($className,$objectId,$include=''){
		
		$url = HOST.'/classes/'.$className.'/'.$objectId;
		
		if(!empty($include)){
			$url.="?include=$include";
		}
		return $this->get($url);
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $className
	 * @param string $where 
	 * @param unknown_type $order
	 * @param unknown_type $limit
	 * @param unknown_type $skip
	 */
	function retrieveObjects($className,$where='',$include='',$order='',$keys='',$skip=0,$limit=30){
		
		$url = HOST.'/classes/'.$className.'?limit='.$limit.'&skip='.$skip;
		
		if(!empty($where)){
			$url = $url.'&where='.$where;
		}
		
		if(!empty($include)){
			$url.="&include=$include";
		}
		
		if(!empty($order)){
			$url = $url.'&order='.$order;
		}
		
		if(!empty($keys)){
			$url.= "&keys=$keys";
		}

		
		return $this->get($url);
	}
	
	
	/**
	 * 更新Object
	 * @param string $className
	 * @param string $objectId
	 * @param string $objJson
	 */
	function updateObject($className,$objectId,$objJson){

		$url = HOST.'/classes/'.$className.'/'.$objectId;
		
		$output = $this->put($url,$objJson);
		
		return patchUpdateLast1($output);

	}
	
	function deleteObject($className,$objectId){

		$url = HOST.'/classes/'.$className.'/'.$objectId;
		return $this->delete($url);
	}

	
	/////////////////
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $url
	 */
	function get($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
	
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
	}

	function post($url='',$objJson=''){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->jsonHeader);
	
		curl_setopt($ch, CURLOPT_POSTFIELDS, $objJson);	
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
	}
	
	function put($url='',$objJson='',$header=''){
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		
		if(empty($header)){
			$header = $this->jsonHeader;
		}
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	
		curl_setopt($ch, CURLOPT_POSTFIELDS, $objJson);	
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
	}
	

	function delete($url='',$header=''){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		
		if(empty($header)){
			$header = $this->jsonHeader;
		}
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
	}
	
	/**
	 * 执行Batch命令
	 * @param array $requests
	 */
	function batch($requests=''){
	   	 $requestsJson = json_encode(array('requests'=>$requests));

         return $this->post('https://cn.avoscloud.com/1/batch',$requestsJson);
	}
}

/* End of file Someclass.php */