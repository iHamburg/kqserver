<?php
require(APPPATH.'libraries/REST_Controller.php'); 


/**
 * 
 * 从测试服务器中获取数据
 * @author Forest
 *
 */
class Kqapi4 extends REST_Controller
{

	
	/**
	 * 
	 * Enter description here ...
	 * @var District_m
	 */
	var $district_m;
	
	/**
	 * Enter description here ...
	 * @var Ctype_m
	 */
	var $ctype_m;
	
	/**
	 * Enter description here ...
	 * @var My_m
	 */
	
	var $my_m;


	/**
	 * 
	 * Enter description here ...
	 * @var Shop_m
	 */
	var $shop_m;
	
	/**
	 * 
	 * Enter description here ...
	 * @var Coupon_m
	 */
	var $coupon_m;
	
	/**
	 * 
	 * Enter description here ...
	 * @var User2_m;
	 */
	var $user;
	
	/**
	 * 
	 * Enter description here ...
	 * @var User2_m
	 */
	var $user2_m;
	
	function __construct(){
		parent::__construct();
		
		header("Content-type: text/html; charset=utf-8");
		
	}
	
	function index(){
	
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
		$password = $this->get('password'); //md5加密
		
		
		$this->load->model('user2_m','user');
		
		//用户名或密码不能为空
		if(empty($username) || empty($password)){
			$status = 401;
			$msg = '用户名或密码不能为空';
			return $this->output_error($status,$msg);
		}
		
	
		$results = $this->user->get_by(array('username'=>$username,'password'=>$password));
		//用户名或密码错误
		if(empty($results)){
			$status = 1001;
			$msg = '用户名或密码错误';
			return $this->output_error($status,$msg);
		}
		
	
		//重设session和expireDate
		$id = $results['id'];
		$sessionToken = randomCharacter(20);
		$expireDate = date('Y-m-d H:i:s',strtotime('+2 week')); // session有效期2周
	
		$this->user->update($id,array('sessionToken'=>$sessionToken,'expireDate'=>$expireDate));
		
		
		$results['sessionToken'] = $sessionToken;
		
		return $this->output_results($results);
		

		
	}

   
   /**
    * 
    * 注册新用户
    * 
    * @param string username
    * @param string password
    * 
    *  @return
    *  status: 1: 成功
    *  data: objectId, sessionToken
    *  
    *  status: 202
    *  msg: username is taken
    */
   public function user_post(){


 	  	$username = $this->post('username');
   		$password = $this->post('password');
   		
   		 
		$this->load->model('user2_m','user');
		
   		
   		if(empty($username) ||empty($password)){
	   		$status = 401;
	   		$msg = '用户名或密码不能为空';
	   		return $this->output_error($status,$msg);
   		}

   		$count = $this->user->count_by('username',$username);

   		if($count>0){
   			$status = 1002;
   			$msg = '用户名已存在';
   			return $this->output_error($status,$msg);
   		}
   		
   		
		$data['username'] = $username;
		$data['password'] = $password;
		$data['sessionToken'] = randomCharacter(20);
		$data['expireDate'] = date('Y-m-d H:i:s',strtotime('+2 week')); // session有效期2周
		$data['nickname'] ='KQ_'.randomCharacter(8);
		$data['createdAt'] = NULL;
		
   		$id = $this->user->insert($data);
   		
   		$this->db->select('id,username,nickname,avatarUrl,sessionToken');
   		$user = $this->user->get($id);
   		return $this->output_results($user);
		
   }
   
   
   public function userInfo_get(){
   
     	$uid = $this->get('uid');
   		$sessionToken = $this->get('sessionToken');
   		
   		$this->load->model('user2_m','user');
  	 
   		if(!$this->user->isSessionValid($uid,$sessionToken)){
			$status = 403;
			$msg = '无效的session';
			return $this->output_error($status,$msg);
		}
   		
		$query = $this->db->query("select count(*) as num from `downloadedcoupon` where uid = $uid");
		$results = $query->result_array();	
		
		$response['dCouponNum'] = $results[0]['num'];
		
		$query = $this->db->query("select count(*) as num from `card` where userId = $uid");
		$results = $query->result_array();	
		
		$response['cardNum'] = $results[0]['num'];
		
		$query = $this->db->query("select count(*) as num from `favoritedcoupon` where userId = $uid");
		$results = $query->result_array();	
		
		$response['fCouponNum'] = $results[0]['num'];
		
		$query = $this->db->query("select count(*) as num from `favoritedshop` where userId = $uid");
		$results = $query->result_array();	
		
		$response['fShopNum'] = $results[0]['num'];
		
		return $this->output_results($response);
   }
   
   public function editUserInfo_post(){
   
   	$uid = $this->post('uid');
   	$sessionToken = $this->post('sessionToken');
   	$nickname = $this->post('nickname');
//   	$pwd = $this->post('password'); //dict
   	$pwd = $this->input->post('password');
   	$avatar = $this->post('avatar');
   	
   		$this->load->model('user2_m','user');
   	if(!$this->user->isSessionValid($uid,$sessionToken)){
			$status = 403;
			$msg = '无效的session';
			return $this->output_error($status,$msg);
	}
	
	if (!empty($pwd)){

//		$pwd = array('oldPassword'=>'sss','newPassword'=>'ssss');
		var_dump($pwd);
		echo $pwd;
		
		$oldPassword = $pwd['oldPassword'];
		$newPassword = $pwd['newPassword'];
		
		echo 'old'.$oldPassword;
		echo 'new'.$newPassword;
//		$query = $this->db->query("select * from user where username = '$username'");
//		$results = $query->result_array();	
//		$pwd = $results[0]['password'];
//		if($oldPassword!=$pwd){
//			$status = 777;
//			$msg = '原来的密码错误';
//			return $this->output_error($status,$msg);
//		}
		
	}
	
   	
   }
   
   /**
    * 
    * 用户重置密码（忘记密码后）
    */
   public function resetPassword_post(){
   		$username = $this->post('username');
   		$password = $this->post('password');
   		
   		if(empty($username) ||empty($password)){
	   		$status = 401;
	   		$msg = '用户名或密码不能为空';
	   		return $this->output_error($status,$msg);
   		}
		$this->load->model('user2_m','user');
		
		$count = $this->user->count_by('username', $username);
		
		if($count == 0){
			$status = 410;
	   		$msg = '用户名不存在';
	   		return $this->output_error($status,$msg);
		}
		$updateId = $this->user->update_by(array('username'=>$username),array('password'=>$password));

//		$affected = $this->db->affected_rows();
		
		return $this->output_success();
		
   }
   
   
	function couponDetails_get(){

	  	
		$this->load->model('coupon2_m','coupon');
		
		$cid = $this->get('id');
		$longitude = $this->get('longitude');
		$latitude =  $this->get('latitude');

		
		
 	  	$this->db->select('A.id,A.title,A.shopId, A.startDate, A.endDate, A.downloadedCount,B.avatarUrl, B.discountContent, B.short_desc, B.description, B.message, B.usage');
 	  	$this->db->from('coupon as A');
		$this->db->join('couponcontent as B', 'A.id = B.couponId');
		$this->db->where('A.id',$cid);

		$query = $this->db->get();
		
		$results = $query->result_array();	
	  	
		$coupon = $results[0];
		
		if(empty($coupon)){
			$status = 1011;
			$msg = '无效的couponId';
			return $this->output_error($status,$msg);
		}
		
		///shopCoupons
		$shopId = $coupon['shopId'];
		$this->db->select('A.id,A.title,B.avatarUrl,B.discountContent');
 	  	$this->db->from('coupon as A');
		$this->db->join('couponcontent as B', 'A.id = B.couponId');
		$this->db->where('A.shopId',$shopId);
		$this->db->where('A.id !=',$cid);
		
		$query = $this->db->get();
		$results = $query->result_array();	
//		if(empty($results))
//			$results = (object)array();
		
		$coupon['shopCoupons'] = $results;
		
		/// otherCoupons
//		$coupon['otherCoupons'] = array();
		$query = $this->db->query(" SELECT A.id, A.title,  B.avatarUrl, B.discountContent
FROM (coupon as A)
JOIN couponcontent as B ON A.id = B.couponId
limit 3");
		$results = $query->result_array();
		$coupon['otherCoupons'] = $results;
		
		///nearestShop
		if(empty($longitude) || empty($latitude)){
		
			$query = $this->db->query("SELECT * FROM (`shopbranch` as A) WHERE `A`.`shopId` = 8");

		}
		else{
			$query = $this->db->query("SELECT *,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*($longitude-`latitude`)/360),2)+COS(PI()*$latitude/180)* COS(`latitude` * PI()/180)*POW(SIN(PI()*($latitude-`longitude`)/360),2)))) as distance FROM (`shopbranch` as A) WHERE `A`.`shopId` = 8 ORDER BY `distance`");
			
		}
	
			$results = $query->result_array();	
		
			$coupon['nearestShop'] = $results[0];
//		$this->output->enable_profiler(TRUE);
		
	  	return $this->output_results($coupon);
	  	
	  	//print_r($results);exit;
	 
	  }
	  
	  
	  public function shopDetails_get(){
	  
	  		$this->load->model('shop2_m','shop');
	  		
	  	$id = $this->get('id');
		$longitude = $this->get('longitude');
		$latitude =  $this->get('latitude');
	  
	  }
   
//   /** 
//    * 返回优惠券的详情, 包括shop和shopBranches
//    * @param id
//    * 
//    * @return coupon: coupon的数据
//    * 
//    * 
//   */
//   public function coupon_get(){
//   		$id = $this->get('id');
//
//   		
//   		if(!empty($id)){
//		//优惠券id不为空
//   			
//   			$result = $this->coupon_m->get($id,'shop,shop.shopBranches');
//   		
//  			return $this->output_results($result,'获得对象失败');
//   		}
//   		else{
//		//优惠券id为空
//  			
//   			return $this->output_results(-1,'确实优惠券id');
//  		
//  		}
//
//   }
   
   /**
    * 
    * 返回最新的快券
    * @param skip
    * @param limit optional
    */
	function newestCoupons_get(){

	  	
		$this->load->model('coupon2_m','coupon');
		
		$skip = intval($this->get('skip'));
	  	$limit = intval($this->get('limit'));
	  	
	  	if (empty($skip))
 	  		$skip = 0;
	  	
 	  	if (empty($limit))
 	  		$limit = 30;
	  	
 	  	$this->db->select('coupon.id,title,downloadedCount,avatarUrl,discountContent');
 	  	$this->db->limit($limit,$skip);
 	  	$this->db->order_by('createdAt','desc');
 	  	$this->db->from('coupon');
		$this->db->join('couponcontent', 'coupon.id = couponcontent.couponId');
 	  	
		$query = $this->db->get();
		
		$results = $query->result_array();	
	  	
	  	return $this->output_results(array('coupons'=>$results));
	  	
	  	//print_r($results);exit;
	 
	  }
	  
 /**
    * 
    * 返回最新的快券
    * @param skip
    * @param limit optional
    */
	function hotestCoupons_get(){

	  	
		$this->load->model('coupon2_m','coupon');
		
		$skip = intval($this->get('skip'));
	  	$limit = intval($this->get('limit'));

	  	
	  	if (empty($skip))
 	  		$skip = 0;
	  	
 	  	if (empty($limit))
 	  		$limit = 30;
	  	
 	  	$this->db->select('coupon.id,title,downloadedCount,avatarUrl,discountContent');
 	  	$this->db->limit($limit,$skip);
 	  	$this->db->order_by('createdAt','desc');
 	  	$this->db->from('coupon');
		$this->db->join('couponcontent', 'coupon.id = couponcontent.couponId');
 	  	
		$query = $this->db->get();
		
		$results = $query->result_array();	
		
	  	return $this->output_results(array('coupons'=>$results));
	  	
	  	
	  	//print_r($results);exit;
	 
	  }
  
  
//   
//   /**
//    * 
//    * APP没有使用shop
//    */
//   public function shop_get(){
//   		
//   	
//   		$id = $this->get('id');
//   		
//   		if(!empty($id)){
//
////   			$url = HOST.'/classes/Shop/'.$id;
////   			
////   			$json = $this->kq->get($url);
////   			
////   			$error = checkResponseError($json);
////			if(!empty($error))
////				return $error;
////   				/// 只返回一个obj 
////
////   			$result = json_decode($json,true);
////
////   			$result = array_slice_keys($result, array('title','objectId','phone','address','openTime','location'));
////   				
////   			if (!isLocalhost())
////				$this->output->cache(CacheTime);
////   			
////			return $this->output_results($result);
//
//   		}
//   		else{
//   			$url = HOST."/classes/Shop?";
//   		
//   			$json = $this->jsonWithGETUrl($url);
//
//   			$error = checkResponseError($json);
//			if(!empty($error))
//				return $error;
//   			
//   			$results = resultsWithJson($json);
//		
//  		   foreach ($results as $result) {
//				$array[] = array_slice_keys($result, array('title','objectId','phone','address','openTime','location'));
//			
//  		   }		
//   			
//   			
//			if (!isLocalhost())
//				$this->output->cache(CacheTime);
//			
//			return $this->output_results($array);
//
//	   		
//   		}
//	}

	
	/**
	 * 
	 * 返回总店的所有分店信息
	 * param: parentId
	 */
	public function shopbranch_get(){
		
		$shopId = $this->get('id');
		
	 	if(empty($shopId)){
 	  		$status = '602';
	   		$msg = '总商户Id不能为空';
	   		return $this->output_error($status,$msg);
 	  	}
		
		$this->load->model('shopbranch2_m','shopBranch');
		
		$results = $this->shopBranch->get_by('shopId',$shopId);
		
		
		
		return $this->output_results(array('shopbranches'=>$results));
	}
	
	public function shopType_get(){
	
		$this->load->model('shoptype2_m','shopType');
		$results = $this->shopType->get_all();
		
		return $this->output_results(array('types'=>$results));
		
	}
	
	public function district_get(){
	
		$this->load->model('district2_m','district');
		$this->db->select('id,title');
		$results = $this->district->get_all();
		
		return $this->output_results(array('districts'=>$results));
		
	}
	
	public function aroundShopbranches_get(){

		$shopTypeId = $this->get('shopTypeId');
		$districtId = $this->get('districtId');
		$longitude = $this->get('longitude');
		$latitude =  $this->get('latitude');
		$order =  $this->get('order');

		if(empty($order)){
			$order = 'distance';
		}
		
		$skip = intval($this->get('skip'));
	  	$limit = intval($this->get('limit'));
	  	
	  	if (empty($skip))
 	  		$skip = 0;
	  	
 	  	if (empty($limit))
 	  		$limit = 30;
 	  		
// 	  	
		if(empty($latitude) || empty($longitude)){
			$this->db->select('A.id,shopId,A.address,A.openTime,A.logoUrl,A.title,A.logoUrl,latitude,longitude,districtId,typeId');
		}
		else{
			$this->db->select("A.id,shopId,A.address,A.openTime,A.logoUrl,A.title,A.logoUrl,latitude,longitude,districtId,typeId,ACOS(SIN((latitude * 3.1415) / 180 ) *SIN(($latitude * 3.1415) / 180 ) +COS((latitude * 3.1415) / 180 ) * COS(($latitude * 3.1415) / 180 ) *COS((longitude * 3.1415) / 180 - ($longitude * 3.1415) / 180 ) ) * 6380 as distance");
		}
		
		
 	  	$this->db->from('shopbranch as A');
		$this->db->join('shop as B', 'A.shopId = B.id');
		if (!empty($districtId)){
			$this->db->where('districtId',$districtId);
		}
		if(!empty($shopTypeId)){
			$this->db->where('typeId',$shopTypeId);
		}
	
		if(!empty($longitude) && !empty($latitude) && $order=='distance'){
//			$this->db->order_by("ACOS(SIN((31.2 * 3.1415) / 180 ) *SIN(($latitude * 3.1415) / 180 ) +COS((31.2 * 3.1415) / 180 ) * COS(($latitude * 3.1415) / 180 ) *COS((121.4 * 3.1415) / 180 - ($longitude * 3.1415) / 180 ) ) * 6380");

				$this->db->order_by('distance');
		}
 	  	$this->db->limit($limit,$skip);
 	  	
 	  	$query = $this->db->get();
		
		$results = $query->result_array();	
		
//		$this->output->enable_profiler(TRUE);
		
		return $this->output_results(array('shopbranches'=>$results));
		
	}

	 
   /**
    * 返回快券: dictionary: location -> array of coupons 
    * 先搜子商户
    * 返回的快券是有重复的，（因为不同的子商户会有同样的主商户，因此会返回重复的快券，需要客户端处理）
    * @param districtId
    * @param subDistrictId
    * @param couponTypeId
    * @param subTypeId
    * @param districtKeyword
    * @param couponTypeKeyword
    * @param latitude
    * @param longitude
    * @param skip
    * @param limit
    */
	public function searchCoupons_get(){
	
  	 	$shopTypeId = $this->get('shopTypeId');
		$districtId = $this->get('districtId');
		$longitude = $this->get('longitude');
		$latitude =  $this->get('latitude');
		$order =  $this->get('order');
		$keyword = $this->get('keyword');
		if(empty($order)){
			$order = 'distance';
		}
		
		$skip = intval($this->get('skip'));
	  	$limit = intval($this->get('limit'));
	  	
	  	if (empty($skip))
 	  		$skip = 0;
	  	
 	  	if (empty($limit))
 	  		$limit = 30;

// 	  	if(empty($keyword)){
// 	  		$status = 601;
//	   		$msg = '关键词不能为空';
//	   		return $this->output_error($status,$msg);
// 	  	}
 	  		
 	  		
 	  	
		if(empty($latitude) || empty($longitude)){
			$this->db->select('A.id,A.shopId,A.title,D.discountContent,D.avatarUrl,A.downloadedCount,C.address');
		}
		else{
			$this->db->select("A.id,A.shopId,A.title,D.discountContent,D.avatarUrl,A.downloadedCount,C.address,(ACOS(SIN((31.2 * 3.1415) / 180 ) *SIN((latitude * 3.1415) / 180 ) +COS((31.2 * 3.1415) / 180 ) * COS((latitude * 3.1415) / 180 ) *COS((121.4 * 3.1415) / 180 - (longitude * 3.1415) / 180 ) ) * 6380) as distance,ACOS(SIN((latitude * 3.1415) / 180 ) *SIN(($latitude * 3.1415) / 180 ) +COS((latitude * 3.1415) / 180 ) * COS(($latitude * 3.1415) / 180 ) *COS((longitude * 3.1415) / 180 - ($longitude * 3.1415) / 180 ) ) * 6380 as distance");
		}
		
		
 	  	$this->db->from('coupon as A');
		$this->db->join('shop as B', 'A.shopId = B.id','left');
		$this->db->join('shopbranch as C', 'A.shopId = C.shopId','left');
		$this->db->join('couponcontent as D', 'A.id = D.couponId','left');
		
		if(!empty($keyword)){
			$this->db->like('A.title',$keyword);
		}	
		if (!empty($districtId)){
			$this->db->where('districtId',$districtId);
		}
		if(!empty($shopTypeId)){
			$this->db->where('typeId',$shopTypeId);
		}
	
		if(!empty($longitude) && !empty($latitude) && $order=='distance'){
			
				$this->db->order_by('distance');
		}
 	  	$this->db->limit($limit,$skip);
 	  	
 	  	$query = $this->db->get();
		
		$results = $query->result_array();	
		
//		$this->output->enable_profiler(TRUE);
		
		return $this->output_results(array('coupons'=>$results));
	}
   

	
	
	/**
	 * *************        My     ****************
	 */
	
	
	/**
    * 
    * 返回用户绑定的银行卡
    * @param string uid
    * @return array
    */
     public function myCard_get(){
   		
     	$this->load->model('user2_m','user');
     	
		$uid = $this->get('uid');

		$sessionToken = $this->get('sessionToken');
	
		if(empty($uid)){
		
			$status = 402;
			$msg = '用户id不能为空';
			return $this->output_error($status,$msg);
		}
	
		if(!$this->user->isSessionValid($uid,$sessionToken)){
			$status = 403;
			$msg = '无效的session';
			return $this->output_error($status,$msg);
		}
		 	// 
		
		$this->db->select('A.id as cardId,A.title,logoUrl,B.title as bankTitle');
		$this->db->from('card as A');
		$this->db->join('bank as B','A.bankId = B.id','left');
		$this->db->where('A.userId',$uid);
		
		$query = $this->db->get();
		
		$results = $query->result_array();
		
//		$this->output->enable_profiler(TRUE);
		
	  	return $this->output_results(array('cards'=>$results));
   }
   
   /**
    * 
    * 用户绑定银行卡
    */
   public function myCard_post(){
   	
  		$uid = $this->post('uid');
		$card = $this->post('card');	
		$sessionToken = $this->post('sessionToken');
		
   		
		if(empty($uid)){
		
			$status = 402;
			$msg = '用户id不能为空';
			return $this->output_error($status,$msg);
		}
		
		if(empty($card)){
		
			$status = 407;
			$msg = '卡号不能为空';
			return $this->output_error($status,$msg);
		}
	
		$this->load->model('user2_m','user');
		if(!$this->user->isSessionValid($uid,$sessionToken)){
			$status = 403;
			$msg = '无效的session';
			return $this->output_error($status,$msg);
		}
   		

		$data['userId'] = $uid;
		$data['title'] = $card;
		
		$this->load->model('card2_m','card');

		$card = $this->card->get_by($data);
		
		//如果没有卡，加上一条记录
		if(empty($card)){
			$data['bankId'] = '2';
			$cardId = $this->card->insert($data);
		}
		else{
			$cardId = $card['id'];
		}
		
		$result = $this->card->get_id($cardId);
		return $this->output_results($result);

  		
   }
   
   /**
	 * 
	 * 用户取消收藏快券
	 * 
	 * @return
	 * 正常： status:1
	 * 异常： status: -1, input 不全
	 */
	public function deleteMyCard_post(){
		$uid = $this->post('uid');
		$card = $this->post('card');	
		$sessionToken = $this->post('sessionToken');
		
   		
		if(empty($uid)){
		
			$status = 402;
			$msg = '用户id不能为空';
			return $this->output_error($status,$msg);
		}
		
		if(empty($card)){
		
			$status = 409;
			$msg = 'card不能为空';
			return $this->output_error($status,$msg);
		}
	
		$this->load->model('user2_m','user');
		if(!$this->user->isSessionValid($uid,$sessionToken)){
			$status = 403;
			$msg = '无效的session';
			return $this->output_error($status,$msg);
		}
   		

		$data['userId'] = $uid;
		$data['title'] = $card;
		
		$this->load->model('card2_m','card');

		$result = $this->card->delete_by($data);
		
		return $this->output_success();
		
	}
	
   
	/**
	 * 
	 * 获得用户所有downloadedcoupon信息, join Table: DownloadedCoupon
	 * 如果
	 * 
	 * 
select  count(A.couponId) as number,B.*,C.*
from downloadedcoupon as A
inner join coupon B
on A.`couponId` = B.id 
left join couponcontent as C
on A.`couponId` = C.couponId
where uid='22'
group by A.couponId
	 * @return 
	 */
	public function myDownloadedCoupon_get(){

		
		$uid = $this->get('uid');

		$limit = intval($this->get('limit'));
		$skip = intval($this->get('skip'));
		
		if (empty($skip))
 	  		$skip = 0;
	  	
 	  	if (empty($limit))
 	  		$limit = 30;
		
		$mode = $this->get('mode');
		if(empty($mode)){
			$mode = 'unused';
		}
	
		if(empty($uid)){
		
			$status = 402;
			$msg = '用户id不能为空';
			return $this->output_error($status,$msg);
		}
	
		
		$this->db->select('A.couponId,count(A.couponId) as number,B.title,B.endDate,C.avatarUrl,C.discountContent');
		$this->db->from('downloadedcoupon as A');
		$this->db->where('uid',$uid);
		if($mode=='unused'){
			$this->db->where('status','unused');
			$this->db->where('B.endDate <','now()');
		}
		else if($mode == 'used'){
			$this->db->where('status','used');
		}
		else if($mode == 'expired'){
			$this->db->where('status','unused');
			$this->db->where('B.endDate >','now()');
		}
		$this->db->join('coupon as B','A.couponId = B.id','left');
		$this->db->join('couponcontent as C','A.couponId = C.couponId','left');
		$this->db->group_by('A.couponId');
		$this->db->limit($limit,$skip);
		
		$query = $this->db->get();
		
		$results = $query->result_array();
	
	  	
//		$this->output->enable_profiler(TRUE);
		
	  	return $this->output_results(array('coupons'=>$results));
	

			
	
	}
	
	
	/**
	 * 
	 * uid新增downloadedcoupon
	 * 即使uid和couponId是错误的也会新建，所以这里需要对uid和couponid做一个validate，是否是有效的
	 * 
	 */
	public function myDownloadedCoupon_post(){
		$uid = $this->post('uid');
		$couponId = $this->post('couponId');	
		$sessionToken = $this->post('sessionToken');
		
   		
		if(empty($uid)){
		
			$status = 402;
			$msg = '用户id不能为空';
			return $this->output_error($status,$msg);
		}
		
		if(empty($couponId)){
		
			$status = 404;
			$msg = 'couponId不能为空';
			return $this->output_error($status,$msg);
		}
	
		$this->load->model('user2_m','user');

		if(!$this->user->isSessionValid($uid,$sessionToken)){
			$status = 403;
			$msg = '无效的session';
			return $this->output_error($status,$msg);
		}
   		

		$data['uid'] = $uid;
		$data['couponId'] = $couponId;
		
		$this->load->model('downloadedcoupon2_m');

		$result = $this->downloadedcoupon2_m->insert($data);
		
		
		
		return $this->output_success();
	}
	
	
	
	/**
	 * 
	 * 返回用户收藏的优惠券
	 * @return array: (coupon)
	 */
	public function myFavoritedCoupon_get(){
	
		$uid = $this->get('uid');

		$limit = intval($this->get('limit'));
		$skip = intval($this->get('skip'));
		
		if (empty($skip))
 	  		$skip = 0;
	  	
 	  	if (empty($limit))
 	  		$limit = 30;
		
	
		if(empty($uid)){
		
			$status = 402;
			$msg = '用户id不能为空';
			return $this->output_error($status,$msg);
		}
	
		 	
		
		$this->db->select('A.couponId,B.title,B.endDate,C.avatarUrl,C.discountContent');
		$this->db->from('favoritedcoupon as A');
		$this->db->where('A.userId',$uid);
		$this->db->join('coupon as B','A.couponId = B.id','left');
		$this->db->join('couponcontent as C','A.couponId = C.couponId','left');
		$this->db->limit($limit,$skip);
		
		$query = $this->db->get();
		
		$results = $query->result_array();
	  	
//		$this->output->enable_profiler(TRUE);
		
	  	return $this->output_results(array('coupons'=>$results));
	
	
	
	}
	
	
	/**
	 * 
	 *  用户收藏优惠券, _User.favoritedCoupons
	 *  
	 *  @return 
	 *  
	 */
	public function myFavoritedCoupon_post(){
		$uid = $this->post('uid');
		$couponId = $this->post('couponId');	
		$sessionToken = $this->post('sessionToken');
		
   		
		if(empty($uid)){
		
			$status = 402;
			$msg = '用户id不能为空';
			return $this->output_error($status,$msg);
		}
		
		if(empty($couponId)){
		
			$status = 404;
			$msg = 'couponId不能为空';
			return $this->output_error($status,$msg);
		}
	
		$this->load->model('user2_m','user');

		if(!$this->user->isSessionValid($uid,$sessionToken)){
			$status = 403;
			$msg = '无效的session';
			return $this->output_error($status,$msg);
		}
   		

		$data['userId'] = $uid;
		$data['couponId'] = $couponId;
		
		$this->load->model('favoritedcoupon2_m','favoritedcoupon');

		$count = $this->favoritedcoupon->count_by($data);
		
		//当没有收藏的时候才添加记录
		if($count==0){
			$result = $this->favoritedcoupon->insert($data);
		}
		
		return $this->output_success();
		
	}
	
	/**
	 * 
	 * 用户取消收藏快券
	 * 
	 * @return
	 * 正常： status:1
	 * 异常： status: -1, input 不全
	 */
	public function deleteMyFavoritedCoupon_post(){
		$uid = $this->post('uid');
		$couponId = $this->post('couponId');	
		$sessionToken = $this->post('sessionToken');
		
   		
		if(empty($uid)){
		
			$status = 402;
			$msg = '用户id不能为空';
			return $this->output_error($status,$msg);
		}
		
		if(empty($couponId)){
		
			$status = 404;
			$msg = 'couponId不能为空';
			return $this->output_error($status,$msg);
		}
	
		$this->load->model('user2_m','user');
		if(!$this->user->isSessionValid($uid,$sessionToken)){
			$status = 403;
			$msg = '无效的session';
			return $this->output_error($status,$msg);
		}
   		

		$data['userId'] = $uid;
		$data['couponId'] = $couponId;
		
		$this->load->model('favoritedcoupon2_m','favoritedcoupon');

		$result = $this->favoritedcoupon->delete_by($data);
		
		return $this->output_success();
	}
	

	/**
	 * 
	 * 返回用户收藏的商户
	 * @param string uid
	 * 	@return array: shop
	 */
	public function myFavoritedShop_get(){
		$uid = $this->get('uid');

		$limit = intval($this->get('limit'));
		$skip = intval($this->get('skip'));
		
		if (empty($skip))
 	  		$skip = 0;
	  	
 	  	if (empty($limit))
 	  		$limit = 30;
		
	
		if(empty($uid)){
		
			$status = 402;
			$msg = '用户id不能为空';
			return $this->output_error($status,$msg);
		}

		
		$this->db->select('A.shopId,B.title,B.logoUrl');
		$this->db->from('favoritedshop as A');
		$this->db->where('userId',$uid);
		$this->db->join('shop as B','A.shopId = B.id','left');
		$this->db->limit($limit,$skip);
		
		$query = $this->db->get();
		
		$results = $query->result_array();
	  	
//		$this->output->enable_profiler(TRUE);
		
	  	return $this->output_results(array('shops'=>$results));
	}
	
	
	/**
	 * 
	 *  用户收藏优惠券
	 */
	public function myFavoritedShop_post(){
	
		$uid = $this->post('uid');
		$shopId = $this->post('shopId');	
		$sessionToken = $this->post('sessionToken');
		
   		
		if(empty($uid)){
		
			$status = 402;
			$msg = '用户id不能为空';
			return $this->output_error($status,$msg);
		}
		
		if(empty($shopId)){
		
			$status = 405;
			$msg = 'shopId不能为空';
			return $this->output_error($status,$msg);
		}
	
		$this->load->model('user2_m','user');
		if(!$this->user->isSessionValid($uid,$sessionToken)){
			$status = 403;
			$msg = '无效的session';
			return $this->output_error($status,$msg);
		}
   		

		$data['userId'] = $uid;
		$data['shopId'] = $shopId;
		
		$this->load->model('favoritedshop2_m','favoritedshop');

		$count = $this->favoritedshop->count_by($data);
		
		//当没有收藏的时候才添加记录
		if($count==0){
			$result = $this->favoritedshop->insert($data);
		}
		
		return $this->output_success();
	}

/**
	 * 
	 * 用户取消收藏快券
	 * 
	 * @return
	 * 正常： status:1
	 * 异常： status: -1, input 不全
	 */
	public function deleteMyFavoritedShop_post(){
		$uid = $this->post('uid');
		$shopId = $this->post('shopId');	
		$sessionToken = $this->post('sessionToken');
		
   		
		if(empty($uid)){
		
			$status = 402;
			$msg = '用户id不能为空';
			return $this->output_error($status,$msg);
		}
		
		if(empty($shopId)){
		
			$status = 405;
			$msg = 'shopId不能为空';
			return $this->output_error($status,$msg);
		}
	
		$this->load->model('user2_m','user');
		if(!$this->user->isSessionValid($uid,$sessionToken)){
			$status = 403;
			$msg = '无效的session';
			return $this->output_error($status,$msg);
		}
   		

		$data['userId'] = $uid;
		$data['shopId'] = $shopId;
		
		$this->load->model('favoritedshop2_m','favoritedshop');

		$result = $this->favoritedshop->delete_by($data);
		
		return $this->output_success();
		
	}

	
	public function captcharegister_get(){
		
		$this->load->library('kqsms');
		
		$mobile = $this->get('mobile');
		
		$captcha = '123456';
		
		$this->kqsms->mock_send_register_sms($mobile,$captcha);
		
		$captchaMd5 = md5($captcha);
		
		return $this->output_results(array('captcha'=>$captcha));
	}
	
	public function captchaforgetpwd_get(){
		
		$this->load->library('kqsms');
		
		$mobile = $this->get('mobile');
		
		$captcha = '123456';
		
		$this->kqsms->mock_send_forgetpwd_sms($mobile,$captcha);
		
		$captchaMd5 = md5($captcha);
		
		return $this->output_results(array('captcha'=>$captcha));
	}
	
	
	//----------------------Private----------------------
  
 

   /**
    * 负责echo 和return error<br>
    * 如果有error，output error<br>
    * 如果没有error，就load到view里
    * 
    * 如果error： status & msg
    * 如果成功:   status & data
    * @param id $results
    */
   private function output_results($results,$errorMsg=''){
   	
   	if ($results<0){
   			$error = array('status'=>$results,'msg'=>$errorMsg);
   			$response = json_encode($error);
			echo $response;
			return $response;
   	}
   	else{
   		    $array = array('status'=>1,'data'=>$results);
			$response = json_encode($array);
			
			$data['response']=$response;
			$this->load->view('response',$data);
			
			return $response;
   	}
   	
   }
   
   //
   private function output_success(){
   		 $array = array('status'=>1,'data'=>(object)array());
			$response = json_encode($array);
			
			$data['response']=$response;
			$this->load->view('response',$data);
			
			return $response;
   }
   
   private function output_error($status,$errorMsg=''){
  			 $error = array('status'=>$status,'msg'=>$errorMsg);
   			$response = json_encode($error);
			echo $response;
			return $response;
   }

   
   // --------------- TEST -----------------
   public function test_get(){
   		
   		$result = array('1'=>'c');
   		
   		$this->response($result);
   }
   
   public function test_post(){
   		$id = $this->post('id');
   		$response = 'response: '.$id;
   		$this->response($response);
   }

}