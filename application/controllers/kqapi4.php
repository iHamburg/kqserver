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
	 * @var User2_m;
	 */
	var $user;
	
	
	
	/**
	 * 
	 * Enter description here ...
	 * @var Kqsms
	 */
	var $kqsms;
	
	
	
	/**
	 * 
	 * 
	 * @var Unionpay
	 */
	var $unionpay;
	
	/**
	 * 
	 * Enter description here ...
	 * @var Card2_m
	 */
	var $card;
	
	
	function __construct(){
		parent::__construct();
		
		header("Content-type: text/html; charset=utf-8");
		
		$this->load->library('unionpay');
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

			return $this->output_error(ErrorEmptyUsernamePwd);
		}
	
		$results = $this->user->get_by(array('username'=>$username,'password'=>$password));
		
		//用户名或密码错误
		if(empty($results)){
	
			return $this->output_error(ErrorInvalidUsernamePwd);
		}
		
	
		//重设session和expireDate
		$id = $results['id'];
		$sessionToken = randomCharacter(20);
		$expireDate = date('Y-m-d H:i:s',strtotime('+2 week')); // session有效期2周
	
		$this->user->update($id,array('sessionToken'=>$sessionToken,'expireDate'=>$expireDate));
		
		
		$results['sessionToken'] = $sessionToken;

		unset($results['password']);
		
		return $this->output_results($results);
		
		
	}

   
   /**
    * 
    * 注册新用户， 要保证用户是要有银联帐号的
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
	   		
	   		return $this->output_error(ErrorEmptyUsernamePwd);
   		}

   		$count = $this->user->count_by('username',$username);

   		if($count>0){

   			return $this->output_error(ErrorUsernameExists);
   		
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
		
   		
   		if(empty($uid)){
   			return $this->output_error(ErrorEmptyUid);
   		}

   		if(!$this->user->isSessionValid($uid,$sessionToken)){
			
			return $this->output_error(ErrorInvalidSession);
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
		
		$query = $this->db->query("select count(*) as num from `favoritedshopbranch` where userId = $uid");
		$results = $query->result_array();	
		
		$response['fShopNum'] = $results[0]['num'];
		
		return $this->output_results($response);
   }
   
   public function editUserInfo_post(){
   	
//   	$this->output->enable_profiler(TRUE);
   	
   	$uid = $this->post('uid');
   	
   	$sessionToken = $this->post('sessionToken');
   	
   	$nickname = $this->post('nickname');
   	$pwd = $this->post('password'); //dict
   	$avatar = $this->post('avatar');
   	
   	$this->load->model('user2_m','user');
   		
   	if (empty($uid) || empty($sessionToken)){
   		return $this->output_error(ErrorEmptyParameter);
   	}

   	
   	if(!$this->user->isSessionValid($uid,$sessionToken)){
			
		return $this->output_error(ErrorInvalidSession);
	}
	
	if (!empty($pwd)){

		$pwd = json_decode($pwd,true);
		
		$oldPassword = $pwd['oldPassword'];
		$newPassword = $pwd['newPassword'];
		
		$query = $this->db->query("select * from user where id = $uid and password = '$oldPassword'");
		$results = $query->result_array();

		if(empty($results)){
			return $this->output_error(ErrorInvalidPassword);
		}
		
		$this->db->query("update user set password= '$newPassword' where id=$uid");
	
	}
	
	if(!empty($nickname)){
		$this->db->query("update user set nickname='$nickname' where id=$uid");
	}
	
	if(!empty($avatar)){

		$img = base64_decode($avatar);
		
		$data = file_put_contents("public/uploads/avatar_$uid.jpg", $img);
		
		if(!empty($data)){
			$avatarurl = base_url("public/uploads/avatar_$uid.jpg");
			$this->db->query("update user set avatarUrl='$avatarurl' where id=$uid");
		}
		
	}
  	
	$query = $this->db->query("select id,username,avatarUrl,nickname from user where id=$uid");
	$results = $query->result_array();
	$this->output_results($results[0]);
	
   }
   
   /**
    * 
    * 用户重置密码（忘记密码后）
    */
   public function resetPassword_post(){
   		$username = $this->post('username');
   		$password = $this->post('password');
   		
   		if(empty($username) ||empty($password)){
	   	
	   		return $this->output_error(ErrorEmptyUsernamePwd);
   		}
   		
		$this->load->model('user2_m','user');
		
		$count = $this->user->count_by('username', $username);
		
		if($count == 0){
			
	   		return $this->output_error(ErrorInvalidUsername);
		}
		$updateId = $this->user->update_by(array('username'=>$username),array('password'=>$password));

		return $this->output_success();
		
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

//		$sessionToken = $this->get('sessionToken');
	
		if(empty($uid)){
		
			return $this->output_error(ErrorEmptyUid);
		
		}
	

		
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
//   public function myCard_post(){
//   	
//  		$uid = $this->post('uid');
//		$card = $this->post('card');	
//		$sessionToken = $this->post('sessionToken');
//		
//   		$this->load->model('user2_m','user');
//   		
//		if(empty($uid) || empty($card) || empty($sessionToken)){
//		
//			return $this->output_error(ErrorEmptyParameter);
//		}
//		
//		if(!$this->user->isSessionValid($uid,$sessionToken)){
//			
//			return $this->output_error(ErrorInvalidSession);
//		}
//   		
//
//		$data['userId'] = $uid;
//		$data['title'] = $card;
//		
//		$this->load->model('card2_m','card');
//
//		$card = $this->card->get_by($data);
//		
//		//如果没有卡，加上一条记录
//		if(empty($card)){
//			$data['bankId'] = '2';
//			$cardId = $this->card->insert($data);
//		
//		
//		}
//		else{
//			$cardId = $card['id'];
//		}
//		
//		
//		
//		
//		$result = $this->card->get_id($cardId);
//		return $this->output_results($result);
//
//  		
//   }
   
   
   
 	public function myCard_post(){
   	
  		$uid = $this->post('uid');
		$card = $this->post('card');	
		$sessionToken = $this->post('sessionToken');
		
   		$this->load->model('user2_m','user');
   		$this->load->model('card2_m','card');
   		
		if(empty($uid) || empty($card) || empty($sessionToken)){
		
			return $this->output_error(ErrorEmptyParameter);
		}
		
		if(!$this->user->isSessionValid($uid,$sessionToken)){
			
			return $this->output_error(ErrorInvalidSession);
		}
   		

		$data['userId'] = $uid;
		$data['title'] = $card;
		$cardNo = $card;
	

		$card = $this->card->get_by($data);
		
		
		if(!empty($card)){
			///如果数据库里已经绑定了这张卡, 直接获得卡号ID
			$cardId = $card['id'];
		}
		else{
			//如果本地数据库没有卡号记录
			//先从uid获得unionId
			$unionUid = $this->user->get_union_uid($uid);
			
			if(empty($unionUid)){
			
				//如果用户没有unionId
				//----- 银联注册， 按理说应该先注册，如果已经注册过了，再查询的
   		
		   		$response = $this->unionpay->getUserByMobile($username);
		   		
//		   		echo 'response'.$response;
		   		$response = json_decode($response,true);
		   		$respCd = $response['respCd'];
		//   		echo 'respCd '.$respCd;
	
		   		if ($respCd == '000000'){
		   		///手机号已经在银联注册
		   			
		   			$data = $response['data'];
		   			
		   			$unionUid = $data['userId'];
		
		   			//把银联的id登记到本地的数据库中去
		   			$this->user->update_unionid_by_uid($id,$unionUid);
		   			
		   		}
		   		else if($respCd == 300200){
		   			//不存在手机，需要注册
		   			
		   	 	  	$response = $this->unionpay->regByMobile($username);
			   		$response = json_decode($response,true);
					$respCd = $response['respCd'];
					
			  	 	if($respCd == '000000' ){
						$data = $response['data'];
			   			$unionUid = $data['userId'];

						$this->user->update_unionid_by_uid($id,$unionUid);
			
					}
					else{
						// 银联注册的其他错误，不用反应，
						// 用户不注册不能绑卡的
						return $this->output_error(ErrorUnionRegister);
						
					}
		
		   		}
		   		else{
		   			//TODO: 银联查找用户的其他错误， 也不用反应了
		   			// 不确定用户是否能查询到, 返回未知银联错误
		   			return $this->output_error(ErrorUnionGetUser);
		   			
		   		}
			
			}
		
			//--------绑卡----------
			// 确保有unionUid
			$response = $this->unionpay->bindCard($unionUid, $cardNo); //13166361023				
			
			$response = json_decode($response,true);
				
			$respCd = $response['respCd'];
	
			
			/// 同一个账户可以多次绑定一张卡
			if($respCd == '000000' ){
				//success
//				这里要获得bank

				$data = $response['data'];				
				$issuerName = $data['issuerName'];  // 银行名称
				
				//TODO: 要存到bank里去
				
				 $this->db->query("insert into card (userId, title, bankTitle) values ($uid,'$cardNo','$issuerName')"); // return 1
				 $cardId = $this->db->insert_id();

			}
			else if($respCd == ErrorUnionInvalidCard ||$respCd == ErrorUnionExistCard || $respCd == ErrorUnionLimitCardNumber){
				// 对于绑卡的错误判定
				
				return $this->output_error($respCd);
			
			}
			else{

				return $this->output_error(ErrorUnionBindCard);

			}
			
			//------ 绑卡成功 ----- 
			//TODO 用户如果有已经下载的优惠券，需要批量从银联下载
			
			
		}
	
		
		$query = $this->db->query("select * from card where id = $cardId");
		$results = $query->result_array();
//		$result = $this->card->get_id($cardId);
		$response = $results[0];
		$response['logoUrl'] = '';
		return $this->output_results($response);

//		return $this->output_results($response);
		
  		
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
	
		
		$this->load->model('user2_m','user');
		
		if(empty($uid) || empty($card) || empty($sessionToken)){
		
			return $this->output_error(ErrorEmptyParameter);
		}
		
		if(!$this->user->isSessionValid($uid,$sessionToken)){

			return $this->output_error(ErrorInvalidSession);
		
		}
   		
		$data['userId'] = $uid;
		$data['title'] = $card;
		
		$this->load->model('card2_m','card');

		$unionUid = $this->user->get_union_uid($uid);
		
		if (!empty($unionUid)){
			// 用户应该在银联注册过，能找到银联id
			$response = $this->unionpay->unbindCard($unionUid, $card); //13166361023				
		
			$response = json_decode($response,true);
			$respCd = $response['respCd'];
		
				/// 同一个账户可以多次绑定一张卡
			if($respCd == '000000' ){
				//success
				$result = $this->card->delete_by($data);
			
				return $this->output_success();
	
			}
			else{
				//TODO
	//			return $this->output_results($response);
				return $this->output_error(ErrorUnionUnbindCard);
	
			}
		}
		else{
			// 如果没有银联uid， 报出错
			
			return $this->output_error(ErrorUnionEmptyUID);
			
		}
		

		
	
		
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
		
			return $this->output_error(ErrorEmptyUid);
		}
	
		$this->load->model('user2_m','user');
		
		$results = $this->user->get_dcoupons($uid);
		
	  	return $this->output_results(array('coupons'=>$results));
	
//		$this->output->enable_profiler(TRUE);
			
	
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
	
		
		$this->load->model('user2_m','user');
		$this->load->model('coupon2_m','coupon');

		if(empty($uid) || empty($couponId) || empty($sessionToken)){
		
			return $this->output_error(ErrorEmptyParameter);
		}
		
		if(!$this->user->isSessionValid($uid,$sessionToken)){
			
			return $this->output_error(ErrorInvalidSession);
		}



		$data['uid'] = $uid;
		$data['couponId'] = $couponId;
		
		
		/**
		 * 如果unionUid不存在，只要存在本地数据库就行
		 * 如果unionUid存在，那么必须要先存在银联数据库，再存在本地。
		 */
		
		$unionUid = $this->user->get_union_uid($uid);
		
	
		if (empty($unionUid)){
			// 如果还没有银联uid，直接存在数据库中
			
			$result = $this->user->download_coupon($uid,$couponId);

			if ($result === true){
				return $this->output_success();
			}
			else{
				return $this->output_error($result);
			}
		}
		else{
			
			//如果有银联uid，需要先从银联下载, 银联下载成功了再下载到服务器
			
			$data['chnlUsrId'] = $uid;
			$data['chnlUsrMobile'] = '131663610235555';
			$data['couponId'] = 'Z00000000010074';
			$data['couponNum'] = '1';
			$data['couponSceneId'] = '000';
			$data['transSeq'] = '123456789900';
			$data['userId'] = 'c00050001986';
			
			$response = $this->unionpay->couponDwnById($data);
			
			
			
			
			return $this->output_results('有银联id');
			
		}

		
		return $this->output_results('回到最后');
//		return $this->output_success();
		
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
		
			return $this->output_error(ErrorEmptyUid);
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
		
  
	
		$this->load->model('user2_m','user');

		if(empty($uid) || empty($couponId) || empty($sessionToken)){
		
			return $this->output_error(ErrorEmptyParameter);
		}
		
		if(!$this->user->isSessionValid($uid,$sessionToken)){
		
			return $this->output_error(ErrorInvalidSession);
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
		
   		
	
	
		$this->load->model('user2_m','user');

		if(empty($uid) || empty($couponId) || empty($sessionToken)){
		
			return $this->output_error(ErrorEmptyParameter);
		}
		
		if(!$this->user->isSessionValid($uid,$sessionToken)){
		
			return $this->output_error(ErrorInvalidSession);
		}
   		

		$data['userId'] = $uid;
		$data['couponId'] = $couponId;
		
		$this->load->model('favoritedcoupon2_m','favoritedcoupon');

		$result = $this->favoritedcoupon->delete_by($data);
		
		return $this->output_success();
	}
	
	public function isFavoritedCoupon_get(){
	
		$uid = $this->get('uid');
		$couponId = $this->get('couponId');
	
		
	
		if(empty($uid) || empty($couponId)){
		
			return $this->output_error(ErrorEmptyParameter);
		}
	
		$query = $this->db->query("select * from favoritedcoupon where userId = $uid and couponId = $couponId");
		
		$results = $query->result_array();

//		$this->output->enable_profiler(TRUE);
		if(empty($results)){
			return $this->output_results(array('result'=>'0'));
		}
		else{
			return $this->output_results(array('result'=>'1'));
		}
	
	}

	public function myFavoritedShopbranch_get(){
	
		$uid = $this->get('uid');

		$limit = intval($this->get('limit'));
		$skip = intval($this->get('skip'));
		
		if (empty($skip))
 	  		$skip = 0;
	  	
 	  	if (empty($limit))
 	  		$limit = 30;
		
	
		if(empty($uid)){
	
			return $this->output_error(ErrorEmptyUid);
		}
		
//		$this->db->select('A.shopId,B.title,B.logoUrl');
//		$this->db->from('favoritedshop as A');
//		$this->db->where('userId',$uid);
//		$this->db->join('shop as B','A.shopId = B.id','left');
//		$this->db->limit($limit,$skip);
//		
//		$query = $this->db->get();
		
		$query = $this->db->query("select B.* from favoritedshopbranch as A left join shopbranch as B on A.shopbranchId = B.id where userId=$uid");
		
		
		
		$results = $query->result_array();
	  	
//		$this->output->enable_profiler(TRUE);
		
	  	return $this->output_results(array('shopbranches'=>$results));
	}
	
	
	public function myFavoritedShopbranch_post(){
	
		$uid = $this->post('uid');
		$shopbranchId = $this->post('shopbranchId');	
		$sessionToken = $this->post('sessionToken');
		
   		
		if(empty($uid) || empty($shopbranchId) || empty($sessionToken)){
					
			return $this->output_error(ErrorEmptyParameter);
		}

	
		$this->load->model('user2_m','user');
		if(!$this->user->isSessionValid($uid,$sessionToken)){
			
			return $this->output_error(ErrorInvalidSession);
		}
   		

		
		$query = $this->db->query("select * from favoritedshopbranch where userId = $uid and shopbranchId = $shopbranchId");
		$results = $query->result_array();
		
		
		///如果还没有收藏的门店
		if (empty($results)){
			$data['userId'] = $uid;
			$data['shopbranchId'] = $shopId;
		
			$query = $this->db->query("insert into favoritedshopbranch (userId,shopbranchId) values ($uid,$shopbranchId)");
			
		}
	
		
		
		return $this->output_success();
	}
	
//	/**
//	 * 
//	 * 返回用户收藏的商户
//	 * @param string uid
//	 * 	@return array: shop
//	 */
//	public function myFavoritedShop_get(){
//		$uid = $this->get('uid');
//
//		$limit = intval($this->get('limit'));
//		$skip = intval($this->get('skip'));
//		
//		if (empty($skip))
// 	  		$skip = 0;
//	  	
// 	  	if (empty($limit))
// 	  		$limit = 30;
//		
//	
//		if(empty($uid)){
//		
//		
//			return $this->output_error(ErrorEmptyUid);
//		}
//
//		
//		$this->db->select('A.shopId,B.title,B.logoUrl');
//		$this->db->from('favoritedshop as A');
//		$this->db->where('userId',$uid);
//		$this->db->join('shop as B','A.shopId = B.id','left');
//		$this->db->limit($limit,$skip);
//		
//		$query = $this->db->get();
//		
//		$results = $query->result_array();
//	  	
////		$this->output->enable_profiler(TRUE);
//		
//	  	return $this->output_results(array('shops'=>$results));
//	}
//	
//	
//	/**
//	 * 
//	 *  用户收藏优惠券
//	 */
//	public function myFavoritedShop_post(){
//	
//		$uid = $this->post('uid');
//		$shopId = $this->post('shopId');	
//		$sessionToken = $this->post('sessionToken');
//		
//   		
//		if(empty($uid) || empty($shopId) || empty($sessionToken)){
//					
//			return $this->output_error(ErrorEmptyParameter);
//		}
//
//	
//		$this->load->model('user2_m','user');
//		if(!$this->user->isSessionValid($uid,$sessionToken)){
//			
//			return $this->output_error(ErrorInvalidSession);
//		}
//   		
//
//		$data['userId'] = $uid;
//		$data['shopId'] = $shopId;
//		
//		$this->load->model('favoritedshop2_m','favoritedshop');
//
//		$count = $this->favoritedshop->count_by($data);
//		
//		//当没有收藏的时候才添加记录
//		if($count==0){
//			$result = $this->favoritedshop->insert($data);
//		}
//		
//		return $this->output_success();
//	}
//
///**
//	 * 
//	 * 用户取消收藏快券
//	 * 
//	 * @return
//	 * 正常： status:1
//	 * 异常： status: -1, input 不全
//	 */
//	public function deleteMyFavoritedShop_post(){
//		$uid = $this->post('uid');
//		$shopId = $this->post('shopId');	
//		$sessionToken = $this->post('sessionToken');
//		
//   		
//		if(empty($uid) || empty($shopId) || empty($sessionToken)){
//					
//			return $this->output_error(ErrorEmptyParameter);
//		}
//	
//		$this->load->model('user2_m','user');
//		if(!$this->user->isSessionValid($uid,$sessionToken)){
//			
//			return $this->output_error(ErrorInvalidSession);
//		}
//   		
//
//		$data['userId'] = $uid;
//		$data['shopId'] = $shopId;
//		
//		$this->load->model('favoritedshop2_m','favoritedshop');
//
//		$result = $this->favoritedshop->delete_by($data);
//		
//		return $this->output_success();
//		
//	}
	
	public function deleteMyFavoritedShopbranch_post(){
		$uid = $this->post('uid');
		$shopbranchId = $this->post('shopbranchId');	
		$sessionToken = $this->post('sessionToken');
		
   		
		if(empty($uid) || empty($shopbranchId) || empty($sessionToken)){
					
			return $this->output_error(ErrorEmptyParameter);
			
		}
	
		$this->load->model('user2_m','user');
		if(!$this->user->isSessionValid($uid,$sessionToken)){
			
			return $this->output_error(ErrorInvalidSession);
		}
   		
		
		$this->db->query("delete from favoritedshopbranch where userId = $uid");
		
		return $this->output_success();
		
	}
	
	public function isFavoritedShopbranch_get(){
	
		$uid = $this->get('uid');
		$shopbranchId = $this->get('shopbranchId');
	
		
	
		if(empty($uid) || empty($shopbranchId)){
		
			return $this->output_error(ErrorEmptyParameter);
		}
	
		$query = $this->db->query("select * from favoritedshopbranch where userId = $uid and shopbranchId = $shopbranchId");
		
		$results = $query->result_array();

//		$this->output->enable_profiler(TRUE);

		
		if(empty($results)){
			return $this->output_results(array('result'=>'0'));
		}
		else{
			return $this->output_results(array('result'=>'1'));
		}

	
	}
  
   
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
	  	
// 	  	$this->db->select('coupon.id,title,downloadedCount,avatarUrl,discountContent');
// 	  	$this->db->limit($limit,$skip);
// 	  	$this->db->order_by('createdAt','desc');
// 	  	$this->db->from('coupon');
//		$this->db->join('couponcontent', 'coupon.id = couponcontent.couponId');
// 	  	
//		$query = $this->db->get();
//		
//		$results = $query->result_array();	
	  	
		
		$query = $this->db->query("SELECT `A`.`id`, A.`title`, A.`downloadedCount`, B.`avatarUrl`, B.`discountContent`
FROM (`coupon` A) 
JOIN `couponcontent` B
ON `A`.`id` = `B`.`couponId`
Where A.active = 1
ORDER BY A.`createdAt` desc
LIMIT $skip,$limit");
		
		$results = $query->result_array();
		
		
//		$this->output->enable_profiler(TRUE);
	  	return $this->output_results(array('coupons'=>$results));
	  	
	 
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
	  	
// 	  	$this->db->select('coupon.id,title,downloadedCount,avatarUrl,discountContent');
// 	  	$this->db->limit($limit,$skip);
// 	  	$this->db->order_by('createdAt','desc');
// 	  	$this->db->from('coupon');
//		$this->db->join('couponcontent', 'coupon.id = couponcontent.couponId');
// 	  	
//		$query = $this->db->get();
//		
//		$results = $query->result_array();	
//		
//	  	return $this->output_results(array('coupons'=>$results));
	  	
 	  	$query = $this->db->query("SELECT `A`.`id`, A.`title`, A.`downloadedCount`, B.`avatarUrl`, B.`discountContent`
FROM (`coupon` A) 
JOIN `couponcontent` B
ON `A`.`id` = `B`.`couponId`
Where A.active = 1
ORDER BY A.`downloadedCount` desc
LIMIT $skip,$limit");
		
		$results = $query->result_array();
		
		
//		$this->output->enable_profiler(TRUE);
	  	return $this->output_results(array('coupons'=>$results));
	 
	  }
  
	
	/**
	 * 
	 * 返回总店的所有分店信息
	 * param: parentId
	 */
	public function shopbranch_get(){
		
		$shopId = $this->get('id');
		
	 	if(empty($shopId)){
 	  		
	   		return $this->output_error(ErrorEmptyShopId);
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
	
		$this->db->where('A.active','1');
		$this->db->where('B.active','1');
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
		
		$this->db->where('A.active','1');
		$this->db->where('B.active','1');

		if(!empty($longitude) && !empty($latitude) && $order=='distance'){
			
				$this->db->order_by('distance');
		}
 	  	$this->db->limit($limit,$skip);
 	  	
 	  	$query = $this->db->get();
		
		$results = $query->result_array();	
		
//		$this->output->enable_profiler(TRUE);
		
		return $this->output_results(array('coupons'=>$results));
	}
   


	function couponDetails_get(){

	  	
		$this->load->model('coupon2_m','coupon');
		$this->load->model('shop2_m','shop');
		
		
		$cid = $this->get('id');
		$longitude = $this->get('longitude');
		$latitude =  $this->get('latitude');

	
		if(empty($cid)){
		
			return $this->output_error(ErrorEmptyCouponId);
		}
		
 	  	$this->db->select('A.id,A.title,A.shopId, A.startDate, A.endDate, A.downloadedCount,B.avatarUrl, B.discountContent, B.short_desc, B.description, B.message, B.usage');
 	  	$this->db->from('coupon as A');
		$this->db->join('couponcontent as B', 'A.id = B.couponId');
		$this->db->where('A.id',$cid);

		$query = $this->db->get();
		
		$results = $query->result_array();	
	  	
		$coupon = $results[0];
		
		if(empty($coupon)){
		
			return $this->output_error(ErrorInvalidCouponId);
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
		
		$coupon['shopCoupons'] = $results;
		
		/// otherCoupons

		$query = $this->db->query(" SELECT A.id, A.title,  B.avatarUrl, B.discountContent
FROM (coupon as A)
JOIN couponcontent as B ON A.id = B.couponId
limit 3");
		$results = $query->result_array();
		$coupon['otherCoupons'] = $results;

		
		
		///----------------nearestShop
		if(empty($longitude) || empty($latitude)){
		
			$query = $this->db->query("SELECT id,shopId,title,address,districtId,longitude,latitude,

			openTime,phone,logoUrl FROM (`shopbranch` as A) WHERE `A`.`shopId` = $shopId");

		}
		else{
			$query = $this->db->query("SELECT *,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*($longitude-`latitude`)/360),2)+COS(PI()*$latitude/180)* COS(`latitude` * PI()/180)*POW(SIN(PI()*($latitude-`longitude`)/360),2)))) as distance FROM (`shopbranch` as A) WHERE `A`.`shopId` = $shopId ORDER BY `distance`");
			
		}
	
		$results = $query->result_array();	
		
		$nearestShop =  $results[0];

//		$query = $this->db->query("select description from shop where id=$shopId");
//		$results = $query->result_array();
//
//		$nearestShop['description'] = $results[0]['description'];
			
		$coupon['nearestShop'] =$nearestShop;

		$shopCount = $this->shop->countBranches($shopId);
		
		$coupon['shopCount'] = $shopCount;
//		$this->output->enable_profiler(TRUE);
		
	  	return $this->output_results($coupon);
	  	
	  	//print_r($results);exit;
	 
	  }
	  
	  
	  public function shopbranchDetails_get(){
	  
//	  		$this->load->model('shop2_m','shop');
	  		
	  		$shopbranchId = $this->get('id');
		
	  		if(empty($shopbranchId)){
	  			return $this->output_error(ErrorEmptyShopId);
	  		}
	  		
	  		$query = $this->db->query("select id,shopId,title,openTime,phone,address,longitude,latitude,logoUrl,districtId
from shopbranch
where id = $shopbranchId
AND active = 1");
	  
	  		
	  		$results = $query->result_array();
	  		$response = $results[0];

		  if(empty($response)){
		
			return $this->output_results(NULL);
			
		  }
	  		
	  		$shopId = $response['shopId'];
	  		
	  		// ----- details ------
	  		$query = $this->db->query("select description, typeId
from shop
where id = $shopId
AND active = 1");
	  
	  		$results = $query->result_array();
	  		$response['description'] = $results[0]['description'];
	  		$response['typeId'] = $results[0]['typeId'];
	  		
	  		
	  		//------- shopCount
	  		$this->load->model('shop2_m','shop');
	  		
	  		$shopCount = $this->shop->countBranches($shopId);
		
			$response['shopCount'] = $shopCount;
			
			
			/// ----------shopCoupons
			$query = $this->db->query("SELECT `A`.`id`, A.`title`, A.`downloadedCount`, B.`avatarUrl`, B.`discountContent`
FROM (`coupon` A) 
JOIN `couponcontent` B
ON `A`.`id` = `B`.`couponId`
Where A.active = 1
AND A.shopId = $shopId "
);
		
	$response['shopCoupons'] =  $query->result_array();;
//		$coupons = $query->result_array();
	  		
	  		return $this->output_results($response);
	  
	  }
	
	  
	  public function allShopbranches_get(){
	  
	  	$shopId = $this->get('id');
	  	
	  	if(empty($shopId)){
	  		return $this->output_error(ErrorEmptyShopId);
	  	}
	  	
	  	$this->load->model('shopbranch2_m','shopbranch');
	  	
	  	$query = $this->db->query("select id,shopId,title,openTime,phone,address,longitude,latitude,logoUrl
from shopbranch
where shopId = $shopId
AND active = 1");
	  
  		$results = $query->result_array();	
//  		
//  		$query = $this->db->query("select description from shop where id=$shopId");
//  		
//  		$description = $query->result_array();
//  		
  		
  		$response['shopbranches'] = $results;
  	
  		
  		return $this->output_results($response);
	  	
	  }
	
	
	///---------- Capcha -------------
	
	public function captcharegister_get(){
		
		$this->load->library('kqsms');
		
		$mobile = $this->get('mobile');
		
		$captcha = random_number();
	
//		$response = $this->kqsms->mock_send_register_sms($mobile,$captcha);
		$response = $this->kqsms->send_register_sms($mobile,$captcha);
		
		$xml = simplexml_load_string($response);
		
		$code = $xml->code;

		$this->db->query("insert into s_sms (type,code,mobile) values ('register',$code,$mobile)");
		
		if ($code == 2){
//			echo 'success';

			$captchaMd5 = md5($captcha);
		
			return $this->output_results(array('captcha'=>$captchaMd5));
		}
		else{
//			echo 'failure';

			return $this->output_error(ErrorFailureSMS);
		}
		
	
		
		
	
	}
	
	public function captchaforgetpwd_get(){
		
		$this->load->library('kqsms');
		
		$mobile = $this->get('mobile');
	
		$captcha = random_number();
	
//		$response = $this->kqsms->mock_send_forgetpwd_sms($mobile,$captcha);
		$response = $this->kqsms->send_forgetpwd_sms($mobile,$captcha);
		
		$xml = simplexml_load_string($response);
		
		$code = $xml->code;

		$query = $this->db->query("insert into s_sms (type,code,mobile) values ('forget',$code,$mobile)");
		
		if ($code == 2){
//			echo 'success';

			$captchaMd5 = md5($captcha);
		
			return $this->output_results(array('captcha'=>$captchaMd5));
		}
		else{
			
//			echo 'failure';

			return $this->output_error(ErrorFailureSMS);
		}
		
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
   	
   			$msg = msg_with_error($status);
   			
  			$error = array('status'=>$status,'msg'=>$msg);
   			$response = json_encode($error);
			echo $response;
			return $response;
   }

   
   // --------------- TEST -----------------
   public function test_get(){
   		
   	echo 'acbcd';
   	
   		$result = array('1'=>'c');
   		
//   		$this->user->g
//   		$this->card->ge
//   		$this->response($result);

   		$this->output_results($result);
   		
   }
   
   public function test_post(){
   		$id = $this->post('id');
   		$response = 'response: '.$id;
   		$this->response($response);
   }

}