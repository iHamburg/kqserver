<?php

define('HOST','https://cn.avoscloud.com/1');


define('Error_Create_Object', -8201);
define('Error_Add_Object_In_Array', -8202);
define('Error_Delete_Object', -8203);
define('Error_Remove_Object_In_Array', -8204);
define('Error_Retrieve_Object', -8205);
define('Error_Update_Object', -8206);
define('Error_Search_Shop',-8207);


define('union_test_private_key','-----BEGIN RSA PRIVATE KEY-----  
MIICXQIBAAKBgQC3//sR2tXw0wrC2DySx8vNGlqt3Y7ldU9+LBLI6e1KS5lfc5jl  
TGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2klBd6h4wrbbHA2XE1sq21ykja/  
Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o2n1vP1D+tD3amHsK7QIDAQAB  
AoGBAKH14bMitESqD4PYwODWmy7rrrvyFPEnJJTECLjvKB7IkrVxVDkp1XiJnGKH  
2h5syHQ5qslPSGYJ1M/XkDnGINwaLVHVD3BoKKgKg1bZn7ao5pXT+herqxaVwWs6  
ga63yVSIC8jcODxiuvxJnUMQRLaqoF6aUb/2VWc2T5MDmxLhAkEA3pwGpvXgLiWL  
3h7QLYZLrLrbFRuRN4CYl4UYaAKokkAvZly04Glle8ycgOc2DzL4eiL4l/+x/gaq  
deJU/cHLRQJBANOZY0mEoVkwhU4bScSdnfM6usQowYBEwHYYh/OTv1a3SqcCE1f+  
qbAclCqeNiHajCcDmgYJ53LfIgyv0wCS54kCQAXaPkaHclRkQlAdqUV5IWYyJ25f  
oiq+Y8SgCCs73qixrU1YpJy9yKA/meG9smsl4Oh9IOIGI+zUygh9YdSmEq0CQQC2  
4G3IP2G3lNDRdZIm5NZ7PfnmyRabxk/UgVUWdk47IwTZHFkdhxKfC8QepUhBsAHL  
QjifGXY4eJKUBm3FpDGJAkAFwUxYssiJjvrHwnHFbg0rFkvvY63OSmnRxiL4X6EY  
yI9lblCsyfpl25l7l5zmJrAHn45zAiOoBrWqpM5edu7c  
-----END RSA PRIVATE KEY-----');

define('union_test_public_key','-----BEGIN PUBLIC KEY-----  
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC3//sR2tXw0wrC2DySx8vNGlqt  
3Y7ldU9+LBLI6e1KS5lfc5jlTGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2kl  
Bd6h4wrbbHA2XE1sq21ykja/Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o  
2n1vP1D+tD3amHsK7QIDAQAB  
-----END PUBLIC KEY-----');

define('union_private_key','-----BEGIN PRIVATE KEY-----
MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBAN6SDIGnM3oL5LOZ
qDcZzn95XO9ICZiiYj/vNlJX9kuVgg4bJ8897lSYFfG0ZVcWY2xofQjz8ePkKQ7/
WtiZigbONo7lHFw/GIcdnhb/7MRsHodk3/XU6wXoi7fuvct3tEFuwIZk4EJLoyC2
TOzkPcaritLtU00QNP9ol0VSFJFdAgMBAAECgYEAouXF3YbgeC0IQCLwKRPsPQQ4
brEMxPfkbOLJoU7b5soQG/7oDhhHvQZq2TKtESZDsm5vRQQ2QBMXsfBXLzyA9cgy
lhWGk/XqhqY4Ykez4am2B8luggLSNM98yiOrlsUjXJF7AUTi//ku4pHUGAg6msrX
6J5v+eg4Crnppuyz/YECQQD8oFTyFnnMhLdwwhUkr4cDY+siV8+hnwVaci7wlY4Z
NIGn4iycw+VK3IVJspJSsIJq0Wnpiy9qOodeekqDDTfxAkEA4Yr2q0cpAyLHYJue
Ha932khzw8YYQLPai7i2EU7mQL0S+lpGRQ/WfEWkdiRkxXqBrN8tsjz0PfKY0f8s
PTl8LQJBAPupoVXVrBpgr/mlbriwH5jyBgCdZ5tDNmsGytoisn9LfkpHl1fIEvjD
vAhR21CCxDkzSwY8AM0bZ1VoECiDl5ECQEqjai4URoY7JC/cT98TCl66S1UmYTBI
VLKYVeg0bA5Qg89FwKtqKljF0z8lnBOeDvvef4jUkx9NATW9dC5ur6ECQQDs135T
sl3scJ9I++rAnBlnPBh7cLfWSqg5i9M3h//GoKdPVxbtjTczyI2uffuZrqiXFQeb
P9q4YCRkEkgYb4ZZ
-----END PRIVATE KEY-----');

class Unionpay{
	
	
	 public $header;
     
	 public $jsonHeader;
     

     public function __construct(){
		
		
//		$appid = 'ezxvldwk94k38d6fki1ks4yq55jkl2t15tttu5ezdqbk8mio';
//		$appkey = 'mtbrztjctplgnho2qf49cs70gd4lfggiayww7u6h4mv5s60t';
//		
//		$this->header =  array(
//			'X-AVOSCloud-Application-Id:'.$appid,
//			'X-AVOSCloud-Application-Key:'.$appkey,
//		);
//		
//		$this->jsonHeader = array(
//			'X-AVOSCloud-Application-Id:'.$appid,
//			'X-AVOSCloud-Application-Key:'.$appkey,
//		  	'Content-Type: application/json;charset=utf-8');
	}
	
	/**
	 * 
	 * 是经过base64转码的，但没有经过url处理
	 * @param unknown_type $plain
	 */
	function private_key_signature($plain){
		$pi_key =  openssl_pkey_get_private(union_private_key);
		
//		print_r($pi_key);echo "\n";
		$encrypted = "";   
		$decrypted = ""; 
		
		openssl_private_encrypt($data,$encrypted,$pi_key);//私钥加密  
	
		$encrypted = base64_encode($encrypted);//加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的  
		
		return $encrypted;
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