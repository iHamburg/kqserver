<?php
require(APPPATH.'libraries/REST_Controller.php'); 
require_once('kqavos.php');

//define(CacheTime,10);

class Kqapi extends REST_Controller
{

	/**
	 * 
	 * Enter description here ...
	 * @var Kqavos
	 */
	public $kq;

	function __construct(){
		parent::__construct();
		
		header("Content-type: text/html; charset=utf-8");
		
//		header("Content-type: application/json; charset=utf-8");
		
		
		$this->kq = new Kqavos();
		
	}
	
	/**
	 * 
	 * 用户登录, 用的是login命令
	 * 
	 * @param
	 * username
	 * password
	 * 
	 * @return
	 * objectId
	 * sessionToken
	 * 
	 */
	public function login_get(){
		$username = $this->get('username');
		$password = $this->get('password');
		
		if(empty($username) || empty($password)){

   			return output_response('-1','没有用户名或密码');
		}
		
		$url = HOST."/login?username=$username&password=$password";
		
		$json = $this->kq->get($url);
		

		$error = checkResponseError($json);
		if (!empty($error)){
			return $error;
		}


		$this->outputArray(json_decode($json));
		return output_response('1','',$json_decode($json));
	}
	/**
	 * 
	 * 返回用户信息，如果是多用户会有Cache
	 */
   public function user_get(){

   		$id = $this->get('id');
   		
   		if(!empty($id)){

   			$url = HOST.'/users/'.$id;
   			
   			$json = $this->kq->get($url);
   			
   			$error = checkResponseError($json);
			if (!empty($error)){
				return $error;
			}

			$result = json_decode($json,true);
				
   			$result = array_slice_keys($result,array('objectId', 'username','phone','nickname','sessionToken'));
   			
   			$this->outputArray($result);
   			

   		}
   		else{
   			$url = HOST."/users?";
   		
   			$json = $this->jsonWithGETUrl($url);

	   		$error = checkResponseError($json);
			if (!empty($error)){
				return $error;
			}
	   			
			$results = resultsWithJson($json);
			
  		   foreach ($results as $result) {

  		   	$array[] = array_slice_keys($result, array('objectId', 'username','phone','avatarUrl','nickname','avatar'));
				
  		   }		
   
   			if (!isLocalhost())
				$this->output->cache(CacheTime);
			
			return $this->outputArray($array);
	   		
   		}
   }
   
   /**
    * 
    * 注册新用户
    * 
    * @param string username
    * @param string password
    * phone
    * nickname
    * 
    *  @return
    *  status: 1: 成功
    *  data: objectId, sessionToken
    *  
    *  status: 202
    *  msg: username is taken
    */
   public function user_post(){
   		$url = HOST."/users";
   		
   		$inputKeys = array('username','password','phone','nickname');
   		
   		foreach ($inputKeys as $key) {
   			$inputs[$key] = $this->post($key);
   		}

   		
   		$json = $this->kq->createUser(json_encode($inputs));
   		
   		$error = checkResponseError($json);
		if (!empty($error)){
			return $error;
		}
   
   		return output_success_response(json_decode($json,true));
   }
   
   
   /** 
    * coupon: coupon的数据
    * branches: 所有分店
   */
   public function coupon_get(){
   		$id = $this->get('id');
   		
   		if(!empty($id)){
   			
   			$url = HOST.'/classes/Coupon/'.$id.'?include=shop';
   			
   			$json = $this->kq->get($url);
   			
   			$error = checkResponseError($json);
			if(!empty($error))
				return $error;
   				/// 只返回一个obj 

   			$result = json_decode($json,true);
			$response['coupon']=$result;
				
			///--- branches: 分店信息
			$where = array('coupon'=>avosPointer('Coupon',$id));
			$where = json_encode($where);
				
			$url = HOST."/classes/CouponShop?include=shop,shop.parent&where=$where";
			$json = $this->kq->get($url);
			
		
			$error = checkResponseError($json);
			if (empty($error)){
				$results = resultsWithJson($json);
		
				foreach ($results as $result) {
					$shop = $result['shop'];
					$parentId = $shop['parent']['objectId'];
					$shop = array_slice_keys($shop, array('objectId','openTime','title','phone','address','location'));
					$shop['parentId']=$parentId;
					$response['branches'][]=$shop;
				}
			}
			
  			return $this->outputArray($response);
   		}
   		else{
   			$url = HOST."/classes/Coupon?";
   		
   			$json = $this->jsonWithGETUrl($url);

			$error = checkResponseError($json);
			if(!empty($error))
				return $error;
	   			
			$results = resultsWithJson($json);
	
			if (!isLocalhost())
				$this->output->cache(CacheTime);
			
			
			
			return $this->outputArray($results);
	   		
   		}
   }
   
   

   /**
    * 
    * 返回最近的优惠券，返回的已经没有顺序了，要客户端根据shop的location来重新排序
    * 
    * param: 
    * couponTypeId
    * districtId
    * 
    * @return 
    * coupon: dict 优惠券的内容
    * 		  location: geopoint： 优惠券的位置
    * 
    */
   public function nearestCoupon_get(){
   
   	
  	 	$districtId = $this->get('districtId');
   		$couponTypeId = $this->get('couponTypeId');
   		$latitude = doubleval($this->get('latitude'));
   		$longitude = doubleval($this->get('longitude'));
   		 
   	   	$where = array('location'=>array('$nearSphere'=>avosGeoPoint($latitude,$longitude)));

   		if (!empty($districtId)){
   			$where['district'] = avosPointer('District',$districtId);
   		}
   		
   		if(!empty($couponTypeId)){
   			$where['couponType'] = avosPointer('CouponType',$couponTypeId);
   		}
   		
   		$url = HOST.'/classes/Shop?where='.json_encode($where);
   		
   
   		$json = $this->kq->get($url);
//   		echobr($url);
//   		echobr($json);
//   		return;
   		
  		$error = checkResponseError($json);
		if(!empty($error))
			return $error;
			
   		$results = resultsWithJson($json);
   		
   		
   		
		$shopParentIds = array();
				
   		///获得ShopIds	
   		foreach ($results as $result) {

   				/// 获得shopIds，去除parentId是一样的,
   			$parentId = trim($result['parent']['objectId']);
   	
   			if(!in_array($parentId, $shopParentIds)){
   				$shopId = trim($result['objectId']);
   				$shopIds[]= $shopId;
   				$shopPointers[]= avosPointer('Shop',$shopId);
   				$shopParentIds[]=$parentId;				
   			}
		}
     			
		///根据ShopIds，查询CouponShop，获得Coupon
		
		$where = json_encode(array('shop'=>array('$in'=>$shopPointers)));
		$url = HOST.'/classes/CouponShop?include=coupon,shop,coupon.shop&where='.$where;
		
		$json = $this->kq->get($url);

		$error = checkResponseError($json);
		if(!empty($error))
			return $error;
			
		$results = resultsWithJson($json);
		
		///返回coupon
		foreach ($results as $result) {
			$record['coupon'] = $result['coupon'];
			$record['location'] = $result['shop']['location'];
			$response[] = $record;
		}
		
		if (!isLocalhost())
			$this->output->cache(CacheTime);

		return  $this->outputArray($response);
   }
   
   
	public function searchCoupon_get(){
	
  	 	$districtId = $this->get('districtId');
   		$couponTypeId = $this->get('couponTypeId');
   		$latitude = doubleval($this->get('latitude'));
   		$longitude = doubleval($this->get('longitude'));
   		$keyword = $this->get('keyword');
	
   		
   		
	}
   
   /**
    * 
    * 返回最近的店铺
    * @param
    */
   public function nearestShop_get(){
   		$districtId = $this->get('districti=Id');
   		$couponTypeId = $this->get('couponTypeId');
   		 $latitude = $this->get('latitude');
   		 $longitude = $this->get('longitude');
   		 
   	   	$where = array('location'=>array('$nearSphere'=>avosGeoPoint($latitude,$longitude)));

   		if (!empty($districtId)){
   			$where[] = array('district'=>avosPointer('District',$districtId));
   		}
   		
   		if(!empty($couponTypeId)){
   			$where[] = array('couponType'=>avosPointer('CouponType',$couponTypeId));
   		}
   		
   		$url = HOST.'/classes/Shop?where='.json_encode($where);
   		
//   		echo $url;
   		$json = $this->kq->get($url);
   		
   		$error = checkResponseError($json);
		if(!empty($error))
			return $error;
			
   		$results = resultsWithJson($json);
		$shopParentIds = array();
				
   		///获得ShopIds	
   		foreach ($results as $result) {

   				/// 获得shopIds，去除parentId是一样的,
   			$parentId = trim($result['parent']['objectId']);
   					

   			if(!in_array($parentId, $shopParentIds)){
   				
   				$shopIds[]=trim($result['objectId']);
   				$shopParentIds[]=$parentId;
   					
   			}
   				
		}
     			
		
		
		if (!isLocalhost())
			$this->output->cache(CacheTime);

		return  $this->outputArray($shopIds);
   		
   }
   
   /**
    * 
    * 返回优惠券和商铺的位置
    */
   public function couponFromNearestShop_get(){
   
   		$shopId = $this->get('shopId');
   		
   		if(empty($shopId)){
			return outputError(-1,'没有商户信息');
   		}
   		
   		$where = array('shop'=>avosPointer('Shop',$shopId));

   		$url = HOST.'/classes/CouponShop?include=coupon,coupon.shop&where='.json_encode($where);
   		
   		$json = $this->kq->get($url);
   	
   		$error = checkResponseError($json);
		if(!empty($error))
			return $error;
   			
		$results = resultsWithJson($json);
   			
   		foreach ($results as $result) {
			$coupons[]=$result['coupon'];   				
   		}
     			
		if (!isLocalhost())
			$this->output->cache(CacheTime);

   		return 	$this->outputArray($coupons);
   }
   
   /**
    * 
    * 返回所有的type（现在只有一级type，没有二级)
    */
  	public function couponType_get(){
   		
   		$url = HOST."/classes/CouponType?";

	    $json = $this->jsonWithGETUrl($url);


  	 	$error = checkResponseError($json);
		if(!empty($error))
			return $error;

		$results = resultsWithJson($json);
  		foreach ($results as $result) {
			$array[] = array_slice_keys($result, array('title','objectId'));	
  	   }
	   			
	   			
   		if (!isLocalhost()){
			$this->output->cache(CacheTime);
   		}
		return $this->outputArray($array);
   		
   		
   }
   
   /**
    * 
    * 返回用户绑定的银行卡
    * @param string uid
    */
     public function card_get(){
   		

   			$url = HOST."/classes/Card?";
   		
   			$json = $this->jsonWithGETUrl($url);

   			$error = checkResponseError($json);
			if(!empty($error))
				return $error;
				
   			$results = resultsWithJson($json);
   			
			return 	$this->outputArray($results);
     	
   }
   
   
   
   
   
   public function shop_get(){
   		
   	
   		$id = $this->get('id');
   		
   		if(!empty($id)){

   			$url = HOST.'/classes/Shop/'.$id;
   			
   			$json = $this->kq->get($url);
   			
   			$error = checkResponseError($json);
			if(!empty($error))
				return $error;
   				/// 只返回一个obj 

   			$result = json_decode($json,true);

   			$result = array_slice_keys($result, array('title','objectId','phone','address','openTime','location'));
   				
   			if (!isLocalhost())
				$this->output->cache(CacheTime);
   			
			return $this->outputArray($result);
   		}
   		else{
   			$url = HOST."/classes/Shop?";
   		
   			$json = $this->jsonWithGETUrl($url);

   			$error = checkResponseError($json);
			if(!empty($error))
				return $error;
   			
   			$results = resultsWithJson($json);
		
  		   foreach ($results as $result) {
				$array[] = array_slice_keys($result, array('title','objectId','phone','address','openTime','location'));
			
  		   }		
   			
   			
			if (!isLocalhost())
				$this->output->cache(CacheTime);
			
			return $this->outputArray($array);
	   		
   		}
	}

	
	/**
	 * 不标准的REST，不是table
	 * 返回 总店的所有分店信息
	 * param: parentId
	 */
	public function shopbranches_get(){
			$url = HOST."/classes/Shop?";
   		
   			$parentId = $this->get('parentId');
   			
   			if(empty($parentId)){
				outputError(-1,'没有总店信息');
   			}
   	
   			
   			$where = array('parent'=>avosPointer('Shop',$parentId));

   			$url.='where='.json_encode($where);
   			
   			$json = $this->kq->get($url);
   			
   			$error = checkResponseError($json);
			if(!empty($error))
				return $error;

			$results = resultsWithJson($json);
		
  		   foreach ($results as $result) {
				$array[] = array_slice_keys($result, array('title','objectId','phone','address','openTime','location'));
			
  		   }		

   			
   			
			if (!isLocalhost())
				$this->output->cache(CacheTime);
				
			return $this->outputArray($array);

	}
	
	public function district_get(){
		$url = HOST."/classes/District?include=city&";
		
		$json = $this->jsonWithGETUrl($url);

		$error = checkResponseError($json);
		
		if(!empty($error))
			return $error;
		
		
   		$results = resultsWithJson($json);

   			
  		   foreach ($results as $result) {
				$array[] = array_slice_keys($result, array('title','objectId'));
			
  		   }		
   		   
   			
   			if(!isLocalhost())
				$this->output->cache(CacheTime);
   	
			return $this->outputArray($array);
	}

	/**
	 * 
	 * 返回最热的搜索
	 */
	public function hotSearch_get(){
		
	}
	/**
	 * 
	 * 获得用户所有downloadedcoupon信息
	 */
	public function downloadedCoupon_get(){
		
		
		$url = HOST."/classes/DownloadedCoupon?";
		
   		$json = $this->jsonWithGETUrl($url);

   			
		$error = checkResponseError($json);
		if ($error!=false){
			return $error;
		}
		
	   	$results = resultsWithJson($json);
			
		foreach ($results as $result) {
			$array[] = $result['coupon'];
		
  	   }		

//
//		if (!isLocalhost())
//			$this->output->cache(CacheTime);
   			
		return $this->outputArray($array);
	   			
	
   		
	}
	
	
	/**
	 * 
	 * uid新增downloadedcoupon
	 * 即使uid和couponId是错误的也会新建，所以这里需要对uid和couponid做一个validate，是否是有效的
	 * 
	 */
	public function downloadedCoupon_post(){
		$uid = $this->post('uid');
		$couponId = $this->post('couponId');	
		
		if(empty($uid) || empty($couponId)){

   			return outputError(-1,'没有用户信息或优惠券信息');
   		}
   		
   		$url = HOST."/classes/DownloadedCoupon";
   		
   		$data = array('people'=>avosPointer('_User',$uid),'coupon'=>avosPointer('Coupon',$couponId),'status'=>'unused');
   		$data = json_encode($data);
   		$json = $this->kq->post($url,$data);
   		
//   		echo $json;

   		$error = checkResponseError($json);
		if(!empty($error))
			return $error;
	   	
		$array = json_decode($json,true);
			
   		return $this->outputArray($array);
	   			
	
   		
	}
	
	/**
	 * 
	 * 返回Coupon被download的数量
	 * param: coupon
	 */
   public function downloadedCouponCount_get(){
   	
   		$url = HOST."/classes/DownloadedCoupon?";
		
   		$json = $this->jsonWithGETUrl($url);

//   		echo $json;
   			
		$error = checkResponseError($json);
		if ($error!=false){
			return $error;
		}
			
   		$results = json_decode($json,true);

   		return output_success_response($results['count']);
   		
   		
   }
	
	/**
	 * 
	 * 返回用户收藏的优惠券
	 */
	public function favoritedCoupon_get(){
		$uid = $this->get('uid');
		
		if(empty($uid)){
			return outputError(-1,'没有用户信息');
   		}
		
   		
   		$where = array('people'=>avosPointer('_User',$uid));
		$url = HOST."/classes/FavoritedCoupon?include=coupon&where=".json_encode($where);
		$json = $this->kq->get($url);
   			
		$error = checkResponseError($json);
		if(!empty($error))
			return $error;
   		
	   	$results = resultsWithJson($json);
			
//	   		var_dump($results);
		foreach ($results as $result) {
			$array[] = $result['coupon'];
			
  		  }		
		
		return $this->outputArray($array);
   	
	}
	
	/**
	 * 
	 * 返回用户是否收藏优惠券信息
	 * data 0 (string): 没收藏
	 * 		1 ：收藏
	 */
	public function isFavoritedCoupon_get(){
		$uid = $this->get('uid');
		$couponId = $this->get('couponId');

		if(empty($uid) || empty($couponId)){
			return outputError(-1,'没有用户信息或优惠券信息');
		}
		
		$result = $this->isCouponFavorited($uid,$couponId);
		
		if ($result == false){
			return output_success_response('0');
		}else{
			return output_success_response('1');
		}
		
//		
//		$where = array('people'=>avosPointer('_User',$uid),'coupon'=>avosPointer('Coupon',$couponId));
//		
//		$json = $this->kq->retrieveObjects('FavoritedCoupon',json_encode($where));
//		
//		
//		$error = checkResponseError($json);
//		if(!empty($error))
//			return $error;
//			
//		$results = resultsWithJson($json);
//		
//		if (empty($results)){
//			return output_success_response('0');
//		}else{
//			return output_success_response('1');
//		}
   		
	}
	
	/**
	 * 
	 *  用户收藏优惠券
	 */
	public function favoriteCoupon_post(){
	
		$uid = $this->post('uid');
		$couponId = $this->post('couponId');
		if(empty($uid) || empty($couponId)){

   			return output_response(-1,'没有用户信息或优惠券信息');
		}

   		if($this->isCouponFavorited($uid,$couponId)){

			return output_success_response('1');
   		}
   		
		$url = HOST."/classes/FavoritedCoupon";
   		
   		$data = array('people'=>avosPointer('_User',$uid),'coupon'=>avosPointer('Coupon',$couponId));
   		$data = json_encode($data);
   		$json = $this->kq->post($url,$data);
   		
//   		echo $json;
		$error = checkResponseError($json);
		if(!empty($error))
			return $error;

   		return output_success_response('1');
	}
	
	public function unfavoriteCoupon_delete(){

		$uid = $this->get('uid');
		$couponId = $this->get('couponId');
//
		if(empty($uid) || empty($couponId)){

			return outputError(-1,'没有用户信息或优惠券信息');
   		
		}
		
		// 获得recordId
	
		$value = array('people'=>avosPointer('_User',$uid),'coupon'=>avosPointer('Coupon',$couponId));
		$json = $this->kq->retrieveObjects('FavoritedCoupon',json_encode($value));

		$error = checkResponseError($json);
		if(!empty($error))
			return $error;
			
		$results = resultsWithJson($json);

		foreach ($results as $result) {
			$recordId = $result['objectId'];

			$this->kq->deleteObject('FavoritedCoupon',$recordId);
		}
		

		return output_success_response('1');
	
		
	}
	
	/**
	 * 
	 * 返回用户收藏的商户
	 * @param 
	 * 	uid
	 */
	public function favoritedShop_get(){
		$uid = $this->get('uid');
		
		if(empty($uid)){
			return outputError(-1,'没有用户信息');
   		}
		
   		
   		$where = array('people'=>avosPointer('_User',$uid));
		$url = HOST."/classes/FavoritedShop?include=shop&where=".json_encode($where);
		$json = $this->kq->get($url);
   			
		$error = checkResponseError($json);
		if(!empty($error))
			return $error;
   		
	   	$results = resultsWithJson($json);
			
//	   		var_dump($results);
		foreach ($results as $result) {
			$array[] = $result['shop'];
			
  		  }		
		
		return $this->outputArray($array);
   	
	}
	
	
	/**
	 * 
	 *  用户收藏优惠券
	 */
	public function favoriteShop_post(){
	
		$uid = $this->post('uid');
		$shopId = $this->post('shopId');
		if(empty($uid) || empty($shopId)){

			return outputError(-1,'没有用户信息或商户信息');
   		
		}

   		if($this->isShopFavorited($uid,$shopId)){

			return output_success_response('1');
   		}
   		
		$url = HOST."/classes/FavoritedShop";
   		
   		$data = array('people'=>avosPointer('_User',$uid),'shop'=>avosPointer('Shop',$shopId));
   		$data = json_encode($data);
   		$json = $this->kq->post($url,$data);
   		
//   		echo $json;
		$error = checkResponseError($json);
		if(!empty($error))
			return $error;

		return output_success_response('1');
   		
	}

	public function unfavoriteShop_delete(){

		$uid = $this->get('uid');
		$shopId = $this->get('shopId');
//
		if(empty($uid) || empty($shopId)){

			return outputError(-1,'没有用户信息或商户信息');
   		
		}
		
		// 获得recordId
	
		$value = array('people'=>avosPointer('_User',$uid),'shop'=>avosPointer('Shop',$shopId));
		$json = $this->kq->retrieveObjects('FavoritedShop',json_encode($value));

		$error = checkResponseError($json);
		if(!empty($error))
			return $error;
			
		$results = resultsWithJson($json);

		foreach ($results as $result) {
			$recordId = $result['objectId'];

			$this->kq->deleteObject('FavoritedShop',$recordId);
		}
		

		return output_success_response('1');
	
		
	}
	
/**
	 * 
	 * 返回用户是否收藏商户信息
	 * data 0 (string): 没收藏
	 * 		1 ：收藏
	 */
	public function isFavoritedShop_get(){
		$uid = $this->get('uid');
		$shopId = $this->get('shopId');
//
		if(empty($uid) || empty($shopId)){

			return outputError(-1,'没有用户信息或商户信息');
   		
		}
		
		
		$result = $this->isShopFavorited($uid,$shopId);
		
		if ($result == false){
			return output_success_response('0');
		}else{
			return output_success_response('1');
		}

	}
	
	
	private function isShopFavorited($uid='',$shopId=''){
		$value = array('people'=>avosPointer('_User',$uid),'shop'=>avosPointer('Shop',$shopId));
		$json = $this->kq->retrieveObjects('FavoritedShop',json_encode($value));
		$results = resultsWithJson($json);
		if (empty($results))
			return false;
		else
			return true;
	}
	
	private  function isCouponFavorited($uid='',$couponId=''){
		$value = array('people'=>avosPointer('_User',$uid),'coupon'=>avosPointer('Coupon',$couponId));
		$json = $this->kq->retrieveObjects('FavoritedCoupon',json_encode($value));
		
		
		$results = resultsWithJson($json);
		if (empty($results))
			return false;
		else
			return true;
	}
	
   private function jsonWithGETUrl($url=''){
   		$where = $this->get('where');
   		$include = $this->get('include');
   		$limit = intval($this->get('limit'));
   		$skip = intval($this->get('skip'));
   		$count = intval($this->get('count'));
   		
   		
   		if (!empty($where)){
   			$where = json_encode($where);
   			$url.='where='.$where.'&';
   		}
   		if(!empty($skip)){
   			$url.='skip='.$skip.'&';
   		}
   		
   		if(!empty($include)){
   			$url.='include='.$include.'&';
   		}
   		
   		/// 如果是count，那么limit就和普通的get不同，特殊处理
   		if($count == 1){
   			$url.='count=1&limit=0';
   			$json = $this->kq->get($url);
   			return $json;
   		}
   		
   		
   		if (!empty($limit)){
   			$url.='limit='.$limit;
   		}
   		else{
   			$url.='limit=20';
   		}

//   		echo $url;
 		
   		$json = $this->kq->get($url);
   		return $json;
   }
   
   /**
    * 
    * 在网页上显示Cache
    * @param unknown_type $array
    */
   private function outputArray($array){
  		    $array = array('status'=>'1','data'=>$array);
			$response = json_encode($array);
			$data['response']=$response;
			$this->load->view('response',$data);
			
			return $response;
   }

   // --------------- TEST -----------------
   public function test_get(){
   		$result = $this->avosResponse('shop', 3);
   		
   		$this->response($result);
   }
   
   public function test_post(){
   		$id = $this->post('id');
   		$response = 'response: '.$id;
   		$this->response($response);
   }
	
	

}