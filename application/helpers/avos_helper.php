<?php

class A{

	function display(){
		return 'aaa';
	}
}

function avosHelper(){
	echo 'avos helper';
}


/**
 * 
 * now -> 2014-04-07T22:28:02.000Z
 */
function avosDateISONow(){
	
	//{"iso":"2014-04-07T22:28:02.000Z","__type":"Date"}
	
	$date =  date('Y-m-d');
	$time = date('H:i:s');
	return $date.'T'.$time.'.000Z';
}


function avosDate($date=''){

	if (empty($date))
		return avosDateNow();
	
	$avosDateString = $date.'T'.'00:00:00.000Z';
	
	return array("iso"=>$avosDateString,"__type"=>"Date");
}



/**
 * 
 * {"iso":"2014-04-07T22:28:02.000Z","__type":"Date"}
 */
function avosDateNow(){

//	return '{"iso":"'.avosDateISONow().'","__type":"Date"}';

	return array("iso"=>avosDateISONow(),"__type"=>"Date");
}
/**
 * 返回where 判定field是否有值
 * @param string $field
 * @param bool $flag 
 * @return array
 */
function avosExists($field,$flag=true){
	return array($field=>array('$exists'=>$flag));
}

function avosWhereExists($field,$flag=true){
	return array($field=>array('$exists'=>$flag));
}


/**
 * 返回AvosPointer 
 * @param unknown_type $className
 * @param unknown_type $objectId
 */
function avosPointer($className,$objectId){
	return array('__type'=>'Pointer','className'=>$className,'objectId'=>$objectId);
}

function avosGeoPoint($latitude=30,$longitude=121){
	
	return array('__type'=>'GeoPoint','latitude'=>doubleval($latitude),'longitude'=>doubleval($longitude));
}

function avosAddRelation($field='',$point){

	return avosAddRelations($field,array($point));
}

function avosAddRelations($field='',$points=array()){

	return array($field=>array('__op'=>'AddRelation','objects'=>$points));
}

function avosRemoveRelation($field='',$point){

	return avosRemoveRelations($field,array($point));
}

function avosRemoveRelations($field='',$points=array()){

	return array($field=>array('__op'=>'RemoveRelation','objects'=>$points));
}

function avosAddPointerInArray($field,$point){
	return array($field=>array('__op'=>'AddUnique','objects'=>array($pointer)));
}

///$requests[]=array('method'=>'POST','path'=>'/1/classes/CouponShop','body'=> array('coupon'=>avosPointer('Coupon',$couponId),'shop'=>avosPointer('Shop',$id)));
/**
 * Batch
 * @param string $method: POST/PUT/DELETE
 * @param string $path: /1/classes/Shop/xxxxx 或者 /1/classes/Shop
 * @param json $body  json
 * @return array
 */
function avosBatch($method='',$path='',$body=array()){
	return array('method'=>$method,'path'=>$path,'body'=>$body);
		
}

/**
 * 
 * 如果有错误 echo出来
 * @param string $json
 */
function checkResponseError($json){

	$response = json_decode($json,true);
	
	if(empty($response['error'])){
		return false;
	}
	else{
		$error = array('status'=>$response['code'],'msg'=>$response['error']);
		
		$error = json_encode($error);
		echo $error;
		
		return $error;
	}
}




/**
 * 
 * 返回错误的信息
 * @param string $code
 * @param string $error
 */
function outputError($code='4500',$error='Unknown Error'){

		$data = array('status'=>$code,'msg'=>$error);
		$json = json_encode($data);		
		echo $json;
		return $json;
		
}


/**
 * 
 * 返回成功或是失败的信息和数据
 * @param string $status
 * @param string $msg
 * @param id $data
 */
function output_response($status='1', $msg='', $data=''){
	$array = array('status'=>$status,'msg'=>$msg,'data'=>$data);
	$response = json_encode($array); 
	echo $response;
	return $response;
}


/**
 * 
 * 返回由get（除了id）之外产生的json的results数组
 * 
 * @param string $json
 * @return ArrayObject
 */
function resultsWithJson($json){
		$results = json_decode($json,true);
		
		$users = $results['results'];
		
		return $users;
}

function isLocalhost(){	

	return true;
	
	$base = base_url();
		$base = substr($base, 0,16);
		if ($base == 'http://localhost'){
			return true;
		}
		else{
			return false;
		}
	
	
}
