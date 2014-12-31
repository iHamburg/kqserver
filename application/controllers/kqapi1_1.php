<?php
require(APPPATH.'libraries/REST_Controller.php'); 




/**
 * 
 * 从测试服务器中获取数据, iOS
 * @author Forest
 *
 */
class Kqapi1_1 extends REST_Controller
{
	
	var $apiName = "/kqapi1_1";
	
	/**
	 * 
	 * Enter description here ...
	 * @var User2_m
	 */
	var $user;


	
	/**
	 * 
	 * Enter description here ...
	 * @var Card2_m
	 */
	var $card;
	
	
	/**
	 * 
	 * Enter description here ...
	 * @var Kqlibrary
	 */
	var $kqlibrary;
	
	
	
	/**
	 * 
	 * Enter description here ...
	 * @var Coupon2_m
	 */
	var $coupon;
	
	
	function __construct(){
		parent::__construct();
		
		header("Content-type: text/html; charset=utf-8");
		
		$this->load->library('kqlibrary');
		$this->load->model('user2_m','user');
		$this->load->model('card2_m','card');
		$this->load->model('coupon2_m','coupon');
	
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
		$device = $this->get('device');

		if(empty($device)){
			$device = 'Android';
		}
		
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
	
		$data = array('sessionToken'=>$sessionToken,'expireDate'=>$expireDate);
		$alt_device = $results['device'];
		
		if ($device!=$alt_device){
			$data['device'] = $device;
		}
		
		$this->user->update($id,$data);
		
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
   		
   		if(empty($username) ||empty($password)){
	   		
	   		return $this->output_error(ErrorEmptyUsernamePwd);
   		}

   		$count = $this->user->count_by('username',$username);

   		// 如果用户已经有了
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
   		
   		if (empty($id)){
   			// 如果没有注册成功，报出错
   			return $this->output_error(ErrorDBInsert);
   		}
   		
   		$this->db->select('id,username,nickname,avatarUrl,sessionToken');
   		$user = $this->user->get($id);
   		
   		
   		// 发送站内信
   		unset($data);
   		$data['uid'] = $id;
   		$data['title'] = '注册成功';
   		$data['text'] = '您已成功注册快券，多来这里看看哦，关注快券多一秒，更多优惠带给您';
   		
   		$this->load->model('news2_m','news');
   		$newsId = $this->news->insert($data);
   		
   		if (empty($newsId)){
   		// 如果没有insert成功
   			log_message('error','Register insert news error, uid #'.$id);
   		}
  		
   		return $this->output_results($user);
		
   }
   
   /**
    * 
    * 每次客户端启动时调用，判断用户是否依然有效
    * 如果uid的session没有过期就自动延长session的时间，返回如果过期，
    */
	public function verifyUser_post(){
	
		$uid = $this->post('uid');
		if(empty($uid)){
   			return $this->output_error(ErrorEmptyUid);
   		}

   			$query = $this->db->query(" SELECT * FROM (`user`)
WHERE `id` =  $uid
AND `expireDate` > now()");
			
   		$results = $query->result_array();
		
//		return $this->output_results($results);
		
		if (empty($results)){
				
			return $this->output_results(array('result'=>'0'));
		}
		else{
			$user = $results[0];
			
			//TODO: 更新sessionToken
			
			unset($user['password']);
			return $this->output_results(array('result'=>$user));
			
			
		}
		
		
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
   		
   		
//		$query = $this->db->query("select count(*) as num from `downloadedcoupon` where uid = $uid");
		$query = $this->db->query("select count(*) as num
from `downloadedcoupon` A 
left join coupon B on A.couponId=B.id 
where uid = $uid
and status='unused'
AND B.`endDate` >= curdate()");
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

   	
   	if(!$user=$this->user->isSessionValid($uid,$sessionToken)){
			
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
		
		$timestamp = now();
		$filePath = "public/uploads/avatar_".$uid."_".$timestamp.".jpg";

		$data = file_put_contents($filePath, $img);
		
		
		if(!empty($data)){
			$avatarurl = base_url($filePath);
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
	
   
   public function myNews_get(){
   	
   		$uid = $this->get('uid');
   		$lastNewsId = $this->get('lastNewsId');
   		
   		if (empty($lastNewsId))
   			$lastNewsId = 0;
   
		$limit = intval($this->get('limit'));
		$skip = intval($this->get('skip'));
		
		if (empty($skip))
 	  		$skip = 0;
	  	
 	  	if (empty($limit))
 	  		$limit = 30;
   		

   		// 返回
   		if (empty($uid))
   			return $this->output_error(ErrorEmptyUid);
   			
   			
   		$query = $this->db->query("select count(*) as num from news 
where  (uid=$uid or uid is null or uid ='')
and id>$lastNewsId");	
   		
   		$results = $query->result_array();
   		$count = $results[0]['num'];
   		
   		// 只能根据id进行排序， 发出的news不应该改变
   		$query = $this->db->query("select * from news where (uid=$uid or uid is null or uid ='') order by id desc limit $skip,$limit");
   		
   		$results = $query->result_array();
   		
   		return $this->output_results(array('news'=>$results, 'count'=>$count));
   }
   
   
   /**
    * 
    * 返回用户绑定的银行卡
    * @param string uid
    * @return array
    */
     public function myCard_get(){
   		
     	$this->load->model('user2_m','user');
     	
		$uid = $this->get('uid');

	
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
    * 用户绑卡
    */
 	public function myCard_post(){
   	
	$uid = $this->post('uid');
		$card = $this->post('card');	
		$sessionToken = $this->post('sessionToken');
		
   		$this->load->model('user2_m','user');
   		$this->load->model('card2_m','card');
   		
		if(empty($uid) || empty($card) || empty($sessionToken)){
		
			return $this->output_error(ErrorEmptyParameter);
		}
		
		if(!$user = $this->user->isSessionValid($uid,$sessionToken)){
			
			return $this->output_error(ErrorInvalidSession);
		}
   		

		$data['userId'] = $uid;
		$data['title'] = $card;
		$cardNo = $card;

		$card = $this->card->get_by($data);	
		
		
		if(!empty($card)){
			///如果数据库里已经绑定了这张卡,报错
			
			return $this->output_error(ErrorCardExists);
		
		}
	
		//如果本地数据库没有卡号记录，先判断用户是否已经银联注册

		//获得unionUId
		$unionUid = $user['unionId'];
		$username = $user['username'];
		$couponCopyUnion = false;
				
		//凡事数据库没有unionUid，说明没有绑定银联用户，如果成功注册或是登录，需要把之前下载的快券登记到银联中去
		if(empty($unionUid)){
			//如果用户没有unionId，先查询再注册, 获得unionUid
		
			
			// 把需要重新copy本地coupon到银联的flag设为true
			$couponCopyUnion = true;
			
			
			$unionUser = $this->kqlibrary->get_union_user($username); //获得用户的银联 id
			

		 	if($unionUser == ErrorUnionEmptyUser || $unionUser == ErrorUnionGetUserNoUser){
			//如果银联查询用户时，没有找到该用户，需要进行用户注册
			
		 		$response = $this->kqlibrary->register_union($username);
		 		
		 		if (!is_array($response)){
		 			// 如果注册没有成功，报错

					log_message('error','绑卡-》get_union_user->register_union # '.$response.'; uid # '.$uid);
					
		 			return $this->output_error($response);
		 		}
		 		else{
		 			// 如果注册成功，赋值unionUid
		 			$unionUid = $response['userId'];
		 		}
		
			}
			else if(!is_array($unionUser)){
			// 其他union查询用户的错误

				log_message('error','绑卡-》get_union_user # '.$unionUser.'; uid # '.$uid);
				return $this->output_error($unionUser);
			
			}
			else{
			// 查询用户返回data，成功登录说明手机已经银联注册可以获得unionUid
				$unionUid = $unionUser['userId'];			
			}

		
	
		}

		// --- End of 用户已经绑定银联帐号， 获得$unionUid
		
		
		// 开始绑卡
//		echo "unionId $unionUid, cardno # $cardNo";
		
		$response = $this->kqlibrary->bind_union_card($unionUid,$cardNo);
		
//		return $this->output_results('aaa');
		
		 if(!is_array($response)){
		//绑卡其他错误
//			
			log_message('error','绑卡-》bind_union_card'.$response.'; uid # '.$uid);
			return $this->output_error($response);

		}

		
		///-------- Endof 银联绑卡成功
		
		
		/// user表更新unionId，必须在绑卡成功之后
		//把银联的Uid更新到服务器中
		$this->user->update_unionid_by_uid($uid,$unionUid);
		
		
		//------ 获得发卡行信息
		$issuerName = $response['issuerName'];  // 银行名称
		
		//把issuerName加到bank数据库中, 获得银行logoUrl
		$this->load->model('bank2_m','bank');
		
		$bank = $this->bank->get_by('title',$issuerName);

		
//		return $this->output_results($card);
		
		if (!empty($bank)){
			//如果发卡行已经在bank中了， 获得发卡行的id和图片地址， 
			$logoUrl = $bank['logoUrl'];
			$bankId = $bank['id'];
		}
		else{
			// 如果发卡行不在bank中，bank新增一个record
			
			$this->bank->insert(array('title'=>$issuerName));
			$bankId = $this->db->insert_id();
			$logoUrl  = 'http://www.quickquan.com/images/banks/unknownbank.jpg';
			
		}
		
		//-----End of 获得发卡行信息
		
		// -- 服务器绑卡 -- 
		
		 $this->db->query("insert into card (userId, title, bankTitle, bankId) values ($uid,'$cardNo','$issuerName',$bankId)"); // return 1
	
		 //-----End of 服务器绑卡
		 
		 // -- Copy 已下载的快券到银联
		 if ($couponCopyUnion){
		 	// 如果需要copy快券给银联
		 
		 	$url = site_url($this->apiName."/batchDownloadUnionCoupon/uid/".$uid);
			// echo $url;
			 asyn_get($url);
		 }

		 
		 // -- End:  Copy 已下载的快券到银联
		 
		 ///-----发送短信
	    $this->load->library('kqsms');
	    
	    $endCardNo =substr($cardNo,-4);
	    
		$smsResp = $this->kqsms->send_bind_card_sms($username, $endCardNo);
		 
		// 发送的结果
 		if ($smsResp === true){
		// 发送成功
			$this->db->query("insert into s_sms (type,code,mobile) values ('bindcard',1,$username)");
			
		}
		else{
		//	echo 'failure'; 
		
			log_message('error','SMS Bindcard error #'.$response.', mobile # '.$username);
		}
		
		///-----End of 发送短信
		 
		
		/// --- 发送站内信
   		unset($data);
   		$data['uid'] = $uid;
   		$data['title'] = '绑定银联卡';
   		$data['text'] = "阁下已成功添加尾号".$endCardNo."的银联卡！精致生活怎能没有下午茶？我们向您呈上风靡全球的美味点心——价值18元摩提工房美味摩提！关注快券多一秒，更多优惠带给您！";
   		
   		$this->load->model('news2_m','news');
   		$newsId = $this->news->insert($data);
   		
   		if (empty($newsId)){
   		// 如果没有insert成功
   			log_message('error','bind card insert news error, uid #'.$uid);
   		}
		
		/// --- Endof发送站内信
		
		// 返回银行卡的信息
		
		$query = $this->db->query("select * from card where title = '$cardNo'");
		$results = $query->result_array();
		$response = $results[0];
		$response['logoUrl'] = $logoUrl;
		
		
		return $this->output_results($response);
 		 		
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
	
//		echo "id: # $uid, card # $card, session # $sessionToken";
		
		if(empty($uid) || empty($card) || empty($sessionToken)){
		
			return $this->output_error(ErrorEmptyParameter);
		}

		if(!$user = $this->user->isSessionValid($uid,$sessionToken)){

			return $this->output_error(ErrorInvalidSession);
		
		}
   		
		$data['userId'] = $uid;
		$data['title'] = $card;
	
		$this->load->model('card2_m','card');
		
		$cardNo = $card;
		
		$card = $this->card->get_by($data);	
		
		
		if(empty($card)){
			///如果数据库里没有这张卡,报错
			return $this->output_error(ErrorEmptyCard);
			
		}

	
		$unionUid = $user['unionId'];
		
		
		if (empty($unionUid)){
			// 如果用户没有银联帐号却有银行卡
			return  $this->output_error(ErrorEmptyUnionUid);
		}
		
		
		// 银联解绑

		
		$response = $this->kqlibrary->unbind_union_card($unionUid, $cardNo);

		if($response === true){
			// 银联解绑成功
//			echo '解绑成功';
			
			// 服务器删除银行卡
			$this->card->delete_by($data);
				
			if ($this->db->affected_rows() < 1){
				return $this->output_error(ErrorDBDelete);
			}
			else{
				return $this->output_success();
			}
		}
		else {
			// 如果其他未知错误

			log_message('error','银联解绑银行卡 error #'.$response.', uid # '.$uid.', card #'.$cardNo);
			return $this->output_error($response);
		}
		
		
		
	}
	
	/**
	 * 
	 * 获得用户所有downloadedcoupon信息, join Table: DownloadedCoupon
	 * 如果
	 * 
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
	
		
//		echo 'mode'.$mode;
		$results = $this->user->get_dcoupons($uid,$mode,$limit,$skip);
		
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
		$debug = $this->post('debug');

		if(empty($uid) || empty($couponId) || empty($sessionToken)){
		
			return $this->output_error(ErrorEmptyParameter);
		}
		
		if(!$user = $this->user->isSessionValid($uid,$sessionToken)){
			
			return $this->output_error(ErrorInvalidSession);
		}

		
		$data['uid'] = $uid;
		$data['couponId'] = $couponId;
		
		
		//如果不是 debug 模式就本地判断是否能下载
		if (empty($debug)){
					
			/// 数据库判断user是否能下载coupon
			$code = $this->user->can_user_dcoupon($uid,$couponId);
			
			if ($code !== true){
				
				return $this->output_error($code);
			}
			// --- End of 判断用户能否下载
		}

//		
		/**
		 * 如果unionUid不存在，只要存在本地数据库就行
		 * 如果unionUid存在，那么必须要先存在银联数据库，再存在本地。
		 */
		
		
		$unionUid = $user['unionId'];
		$transSeq = "C$uid"."D$couponId"."T".now();  //C+uid+ unionCouponId + datetime
		
		// 如果用户绑定银联钱包，先从银联下载优惠券
		if(!empty($unionUid)){
			
			$coupon = $this->coupon->get($couponId);

			$unionCouponId = $coupon['unionCouponId'];
		
			if(empty($unionCouponId)){
				log_message('error','下载快券 数据库没有unionCouponId, uid #'.$uid.' couponId #',$couponId);
				return $this->output_error(ErrorEmptyUnionCouponId);
			}
		
			// 从银联下载优惠券
			$result = $this->kqlibrary->download_union_coupon($uid,$user['username'],$unionUid, $unionCouponId, $transSeq);


			if(!is_array($result)){
				// 其他union下载的错误
				log_message('error','下载快券 从银联下载失败: code #'.$result.', uid #'.$uid.' couponId #',$couponId);
				return $this->output_error($result);
			}
			
			//成功从银联下载了优惠券
			
		}
	
		
		// 服务器下载快券, 如果银联下载快券失败，就不会调用本地下载

		$dCouponId = $this->kqlibrary->download_coupon($uid,$couponId, $transSeq);
		

		if($dCouponId === false){
			
			return $this->output_error(ErrorDBInsert);
		}
	
		// 发送站内信和短信
	
		
   		
		if(empty($unionUid)){ //如果未绑定银联账户， 发送站内信
			
			// 发送站内信
	   		unset($data);
	   		$data['uid'] = $uid;
	   		$data['title'] = '下载快券';
	   		// 要获得优惠券的完整title
	   		$completeTitle = $this->coupon->get_complete_title($couponId);
	   		
	   		$data['text'] = "您已成功下载".$completeTitle."快券，添加任意一张银联卡就可以开始享受快券的优惠咯！";
	   		
	   		$this->load->model('news2_m','news');
	   		$newsId = $this->news->insert($data);
	   		
	   		if (empty($newsId)){
	   		// 如果没有insert成功
	   			log_message('error','download coupon insert news error, uid #'.$uid);
	   		}

		}
		else{ //已经绑定银联，发送站内信和短信

			unset($data);
	   		$data['uid'] = $uid;
	   		$data['title'] = '下载快券';
	   		// 要获得优惠券的完整title
	   		$completeTitle = $this->coupon->get_complete_title($couponId);
	   		//您已成功下载xxx(摩提工房满30立减5元)快券，前往最近的门店刷任意一张绑定的银联卡消费即可享受快券的服务咯！
	   		$data['text'] = "您已成功下载".$completeTitle."快券，前往最近的门店刷任意一张绑定的银联卡消费即可享受快券咯！";
	   		
	   		$this->load->model('news2_m','news');
	   		$newsId = $this->news->insert($data);
	   		
	   		if (empty($newsId)){
	   		// 如果没有insert成功
	   			log_message('error','download coupon insert news error, uid #'.$uid);
	   		}
	   		
	   		
	   		
	   		// 短信： 您已成功下载【变量】快券，前往最近的门店刷任意一张绑定的银联卡消费即可享受快券的服务咯！
	   	    $this->load->library('kqsms');
    
 			$username = $user['username'];
 			
			$smsResp = $this->kqsms->send_downloadcoupon_sms($username,$completeTitle);
			 
			// 发送的结果
	 		if ($smsResp === true){
			// 发送成功
				$this->db->query("insert into s_sms (type,code,mobile) values ('downloadcoupon',$smsResp,$username)");
			}
			else{
			//	echo 'failure'; 
				
				log_message('error','发送短信错误: '.$apiName.' - myDownloadedCoupon error #'.$smsResp.', mobile # '.$username);
			}
		
		///-----End of 发送短信
	   		
		}		
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
		
			return $this->output_error(ErrorEmptyUid);
		}
	
		 	
		
		$this->db->select('A.couponId,B.title,B.endDate,C.avatarUrl,C.discountContent,B.isSellOut,B.isEvent,B.active');
		$this->db->from('favoritedcoupon as A');
		$this->db->where('A.userId',$uid);
		$this->db->join('coupon as B','A.couponId = B.id','left');
		$this->db->join('couponcontent as C','A.couponId = C.couponId','left');
		$this->db->order_by('A.id','desc');
		$this->db->limit($limit,$skip);
		
		$query = $this->db->get();
		
		$results = $query->result_array();
	  	
//		$this->output->enable_profiler(TRUE);
		
//		$this->output->cache(10);
		
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
		
		
		$query = $this->db->query("select B.*,C.title as district 
		from favoritedshopbranch as A 
		left join shopbranch as B 
		on A.shopbranchId = B.id 
		left join district as C
		on B.districtId = C.id
		where userId=$uid 
		order by A.id desc
		limit $skip,$limit");
	
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
	
		
			$query = $this->db->query("insert into favoritedshopbranch (userId,shopbranchId) values ($uid,$shopbranchId)");
			
		}
	
		
		
		return $this->output_success();
	}

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
   		
		
		$this->db->query("delete from favoritedshopbranch where userId = $uid AND shopbranchId = $shopbranchId");
		
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
  
//   
//   /**
//    * 
//    * 返回最新的快券
//    * @param skip
//    * @param limit optional
//    */
//	function newestCoupons_get(){
//
//	  	
//		$this->load->model('coupon2_m','coupon');
//		
//		$skip = intval($this->get('skip'));
//	  	$limit = intval($this->get('limit'));
//	  	
//	  	if (empty($skip))
// 	  		$skip = 0;
//	  	
// 	  	if (empty($limit))
// 	  		$limit = 30;
//	  	
//		
//		$query = $this->db->query("SELECT `A`.`id`, A.`title`, A.`downloadedCount`, B.`avatarUrl`, B.`discountContent`
//FROM (`coupon` A) 
//JOIN `couponcontent` B
//ON `A`.`id` = `B`.`couponId`
//Where A.active = 1
//ORDER BY A.`createdAt` desc
//LIMIT $skip,$limit");
//		
//		$results = $query->result_array();
//		
//		
////		$this->output->enable_profiler(TRUE);
//	  	return $this->output_results(array('coupons'=>$results));
//	  	
//	 
//	  }
	  
 /**
    * 
    * 返回最新的快券
    * @param skip
    * @param limit optional
    */
	function hotestCoupons_get(){


		
		$skip = intval($this->get('skip'));
	  	$limit = intval($this->get('limit'));

	  	
	  	if (empty($skip))
 	  		$skip = 0;
	  	
 	  	if (empty($limit))
 	  		$limit = 30;
	  	
 	  	$this->db->cache_on(60*10); // 10分钟缓存
 	  		
 	  	$query = $this->db->query("SELECT `A`.`id`, A.`title`,A.isEvent,A.isSellOut, A.`displayedDCount` as downloadedCount, B.`avatarUrl`, B.`discountContent`, B.slogan
FROM (`coupon` A) 
JOIN `couponcontent` B
ON `A`.`id` = `B`.`couponId`
Where A.active = 1
ORDER BY A.`displayedDCount` desc
LIMIT $skip,$limit");
		
		$results = $query->result_array();
		
//		$this->output->enable_profiler(TRUE);

	  	return $this->output_results(array('coupons'=>$results));
	 
	  }
  

	
	public function shopType_get(){
	
		$this->load->model('shoptype2_m','shopType');

		
		$this->db->cache_on(60*10); // 10分钟缓存
		
		$results = $this->shopType->get_all();
		
		return $this->output_results(array('types'=>$results));
		
	}
	
	public function district_get(){
	
		$this->load->model('district2_m','district');
		
		$this->db->cache_on(60*10); // 10分钟缓存
		
		$this->db->select('id,title');

		$results = $this->district->get_all();
		
		return $this->output_results(array('districts'=>$results));
		
	}
	
	
	public function aroundShopbranches_get(){

//		$this->output->cache(10);
		
		$shopTypeId = $this->get('shopTypeId');
		$districtId = $this->get('districtId');
		$longitude = $this->get('longitude');
		$latitude =  $this->get('latitude');
		$order =  $this->get('order');
		
		if(empty($order)){ // 默认排序是距离
			$order = 'distance';
		}
		
		$skip = intval($this->get('skip'));
	  	$limit = intval($this->get('limit'));
	  	
	  	if (empty($skip))
 	  		$skip = 0;
	  	
 	  	if (empty($limit))
 	  		$limit = 30;
 	  		
 	  	$this->db->cache_on(60*10); // 10分钟缓存
 	  		
		if(empty($latitude) || empty($longitude)){
			$this->db->select('A.id,shopId,A.address,A.openTime,A.logoUrl,A.title,A.logoUrl,A.phone,A.averagePreis,latitude,longitude,districtId,typeId, C.title as district');
		}
		else{
			$this->db->select("A.id,shopId,A.address,A.openTime,A.logoUrl,A.title,A.logoUrl,A.phone,A.averagePreis,latitude,longitude,districtId,typeId,  C.title as district,
			ACOS(SIN((latitude * 3.1415) / 180 ) *SIN(($latitude * 3.1415) / 180 ) + COS((latitude * 3.1415) / 180 ) * COS(($latitude * 3.1415) / 180 ) *COS((longitude * 3.1415) / 180 - ($longitude * 3.1415) / 180 ) ) * 6380 as distance");
		}
		
		
 	  	$this->db->from('shopbranch as A');
		$this->db->join('shop as B', 'A.shopId = B.id');
		$this->db->join('district as C', 'A.districtId = C.id');
		
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
		else if($order == 'ai'){ // 智能
			$this->db->order_by('rand()');
		}
		else if($order == 'preisup'){ //人均最高
			$this->db->order_by('A.averagePreis');
		}
		else if($order == 'preisdown'){
			$this->db->order_by('A.averagePreis','desc');
		}
 	  	$this->db->limit($limit,$skip);
 	  	
 	  	$query = $this->db->get();
		
		$results = $query->result_array();	
		
//		$this->output->enable_profiler(TRUE);
		
		return $this->output_results(array('shopbranches'=>$results));
		
	}

	public function searchCoupons_get(){
	
//		$this->output->cache(10);
		
  	 	$shopTypeId = $this->get('shopTypeId');
		$districtId = $this->get('districtId');
		$longitude = $this->get('longitude');
		$latitude =  $this->get('latitude');
		$order =  $this->get('order');
		$keyword = $this->get('keyword');
		
		//默认是人气
		if(empty($order)){
			$order = 'hot';
		}
		
		$skip = intval($this->get('skip'));
	  	$limit = intval($this->get('limit'));
	  	
	  	if (empty($skip))
 	  		$skip = 0;
	  	
 	  	if (empty($limit))
 	  		$limit = 30;
   	
 	  		
 	  	$this->db->cache_on(60*10); // 10分钟缓存
 	  		
 	  	$query = "A.id,A.shopId,A.title,D.discountContent,D.avatarUrl,A.displayedDCount as downloadedCount,C.address, A.isSellOut, A.isEvent, C.title as shopbranchTitle, C.longitude, C.latitude"; 	  		

 	  	if(!empty($latitude) && !empty($longitude)){
 	  		$query.=",ACOS(SIN((latitude * 3.1415) / 180 ) *SIN(($latitude * 3.1415) / 180 ) +COS((latitude * 3.1415) / 180 ) * COS(($latitude * 3.1415) / 180 ) *COS((longitude * 3.1415) / 180 - ($longitude * 3.1415) / 180 ) ) * 6380 as distance";
 	  	}
 	  	
		$this->db->select($query);
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
		$this->db->where('C.active','1');

		if(!empty($longitude) && !empty($latitude) && $order=='distance'){
			
			$this->db->order_by('distance');
		
		}
		else if($order == 'hot'){

			$this->db->order_by('A.displayedDCount','desc');
			
		}
		else{
			$this->db->order_by('rand()');  // 随机排序
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
		
		$this->db->cache_on(60*10); // 10分钟缓存
		
		
 	  	$this->db->select('A.id,A.title,A.shopId, A.startDate, A.endDate, A.displayedDCount as downloadedCount,A.isEvent,A.isSellOut,A.active,B.avatarUrl, B.discountContent, B.short_desc, B.description, B.message,B.slogan, B.usage');
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
		$this->db->where('A.active',1);
		
		$query = $this->db->get();
		$results = $query->result_array();	
		
		$coupon['shopCoupons'] = $results;
		
		/// otherCoupons

		$query = $this->db->query("SELECT A.id, A.title,  B.avatarUrl, B.discountContent
FROM (coupon as A)
JOIN couponcontent as B ON A.id = B.couponId
where A.active = 1
and A.id!=$cid
ORDER BY RAND()
limit 3");
		$results = $query->result_array();
		$coupon['otherCoupons'] = $results;

		
			$this->db->cache_off();
		///----------------nearestShop
		if(empty($longitude) || empty($latitude)){
		
			$query = $this->db->query("SELECT id,shopId,title,address,districtId,longitude,latitude,

			openTime,phone,logoUrl FROM (`shopbranch` as A) WHERE `A`.`shopId` = $shopId and A.active=1");

		}
		else{
			
			$query = $this->db->query("SELECT *,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*($latitude -`latitude`)/360),2)+COS(PI()*$latitude/180)* COS(`latitude` * PI()/180)*POW(SIN(PI()*($longitude-`longitude`)/360),2)))) as distance FROM (`shopbranch` as A) WHERE `A`.`shopId` = $shopId and A.active=1 ORDER BY `distance`");
		}
	
		$results = $query->result_array();	
		
		$nearestShop =  $results[0];
			
		$coupon['nearestShop'] =$nearestShop;

		$shopCount = $this->shop->countBranches($shopId);
		
		$coupon['shopCount'] = $shopCount;
//		$this->output->enable_profiler(TRUE);
		
	  	return $this->output_results($coupon);
	  	
	 
	  }
	  
	  
	  public function shopbranchDetails_get(){
	 
//	  		$this->output->cache(10);
	  	
	  		$shopbranchId = $this->get('id');
		
	  		if(empty($shopbranchId)){
	  			return $this->output_error(ErrorEmptyShopId);
	  		}
	  		
	  		
	  			$this->db->cache_on(60*10); // 10分钟缓存
	  		
	  		$query = $this->db->query("select id,shopId,title,openTime,phone,address,longitude,latitude,logoUrl,districtId, active,averagePreis
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
			$query = $this->db->query("SELECT `A`.`id`, A.`title`, A.`downloadedCount`, B.`avatarUrl`, B.`discountContent`,A.isSellOut,A.isEvent, B.slogan
FROM (`coupon` A) 
JOIN `couponcontent` B
ON `A`.`id` = `B`.`couponId`
Where A.active = 1
AND A.shopId = $shopId "
);
		
			$response['shopCoupons'] =  $query->result_array();;

	  		
	  		return $this->output_results($response);
	  
	  }
	
	  
	  public function allShopbranches_get(){
	  
	  	$shopId = $this->get('id');
		$longitude = $this->get('longitude');
		$latitude =  $this->get('latitude');
	  	
	  	if(empty($shopId)){
	  		return $this->output_error(ErrorEmptyShopId);
	  	}
	  	
	  	
	  	$this->db->cache_on(60*10); // 10分钟缓存
	  	
	  	$sql = "select A.id,shopId,A.title,openTime,phone,address,longitude,latitude,logoUrl,averagePreis,B.title as district
from shopbranch A
left join district B
on A.districtId=B.id
where shopId = $shopId
and active=1";
	  	
	  	if (!empty($longitude) && !empty($latitude)){
//	  		$sql.=" order by ((latitude-$latitude) * (latitude-$latitude) + (longitude-$longitude) * (longitude-$longitude))";
	  		$sql.=" order by ACOS(SIN((latitude * 3.1415) / 180 ) *SIN(($latitude * 3.1415) / 180 ) + COS((latitude * 3.1415) / 180 ) * COS(($latitude * 3.1415) / 180 ) *COS((longitude * 3.1415) / 180 - ($longitude * 3.1415) / 180 ) ) * 6380";
	  	}
//	  	
	  	$query = $this->db->query($sql);

	  	
	  
  		$results = $query->result_array();	

  		
  		$response['shopbranches'] = $results;
  	
  		
  		return $this->output_results($response);
	  	
	  }
	
	///---------- Capcha -------------
	
	public function captcharegister_get(){
		
		$this->load->library('kqsms');
		
		$mobile = $this->get('mobile');

		$captcha = random_number();

		$response = $this->kqsms->send_register_sms($mobile,$captcha);
		
		if ($response === true){

			$this->db->query("insert into s_sms (type,code,mobile) values ('register',$response,$mobile)");
			
			$captchaMd5 = md5($captcha);
		
			return $this->output_results(array('captcha'=>$captchaMd5));
			
		}
		else{
//			echo 'failure';
			
			log_message('error','SMS Register error #'.$response.', mobile # '.$mobile);
			
			if ($response == ErrorSMSZero || $response == ErrorSMSCaptchaLimit){
				return $this->output_error($response);
			}
			else{
				return $this->output_error(ErrorSMSUnknown);
			}
		}
		
	
		
		
	
	}
	
	public function captchaforgetpwd_get(){
		
		$this->load->library('kqsms');
		
		$mobile = $this->get('mobile');
	
		$captcha = random_number();
	
		$response = $this->kqsms->send_forgetpwd_sms($mobile,$captcha);

		if ($response === true){
			$query = $this->db->query("insert into s_sms (type,code,mobile) values ('forget',$response,$mobile)");

			$captchaMd5 = md5($captcha);
		
			return $this->output_results(array('captcha'=>$captchaMd5));
		}
		else{
			
//			echo 'failure';
	
			log_message('error','SMS Forget error #'.$response.', mobile # '.$mobile);
			
			if ($response == ErrorSMSZero || $response == ErrorSMSCaptchaLimit){
				return $this->output_error($response);
			}
			else{
				return $this->output_error(ErrorSMSUnknown);
			}
		
		}
		
	}
	
	public function feedback_post(){
	
		$uid = $this->post('uid');
		$sessionToken = $this->post('sessionToken');
		$cardNumber = $this->post('cardNumber');
		$text = $this->post('text');	
		$photo = $this->post('photo'); 
		
	 	if (empty($uid) || empty($sessionToken)){
   			return $this->output_error(ErrorEmptyParameter);
   		}
	
   		
   	
		
	}
	
	public function event_get(){
		
			if(ENVIRONMENT == 'rtesting' || ENVIRONMENT == 'testing'){ // 测试情况
				// 测试服务器
				$event['id'] = '60';
	
				$event['imgUrl'] = 'http://www.quickquan.com/app/image/guide_350_04.png';
				$event['buttonUrl'] = 'http://www.quickquan.com/app/image/guide_finish.png';
				$event['type']='coupon';
				
				$event['registerBannerText']='哈哈哈哈哈啊只要注册快券，就可以1元获得原价18元的美味摩提哦！';
				$event['registerSuccessText']='哈哈哈哈哈哈前往领取免费美味摩提快券';
			
				
				$banners[0] = array('imgUrl'=>'http://www.quickquan.com/app/image/banner_coupon_39.jpg','type'=>'coupon','id'=>'39');
				$banners[1] = array('imgUrl'=>'http://www.quickquan.com/app/image/banner_tutorial_2.jpg','type'=>'tutorial');
				$banners[2] = array('imgUrl'=>'http://www.quickquan.com/app/image/banner_coupon_60_2.jpg','type'=>'coupon','id'=>'60');
				
				$response['updatedAt'] = '2014-12-25 14:37:21';
				$response['event'] = $event;
				$response['banners'] = $banners;
			}
		
			else{
				// 正式服务器
				$event['id'] = '39';
				$event['imgUrl'] = 'http://www.quickquan.com/app/image/event_bg.jpg';
				$event['buttonUrl'] = 'http://www.quickquan.com/app/image/eventBtn.png';
				$event['type']='coupon';
				$event['registerBannerText']='只要注册快券，就可以1元获得原价18元的美味摩提哦！';
				$event['registerSuccessText']='前往领取免费美味摩提快券';

				
				$banners[0] = array('imgUrl'=>'http://www.quickquan.com/app/image/banner_tutorial_2.jpg','type'=>'tutorial');
				$banners[1] = array('imgUrl'=>'http://www.quickquan.com/app/image/banner_coupon_39.jpg','type'=>'coupon','id'=>'39');
				$banners[2] = array('imgUrl'=>'http://www.quickquan.com/app/image/banner_coupon_60_2.jpg','type'=>'coupon','id'=>'60');
				
		
				
				$response['updatedAt'] = '2014-12-17 14:37:21';
				$response['event'] = $event;
				$response['banners'] = $banners;
			}
	
		
		$this->output_results($response);
		
		
	}
	
	
	
	
	/**
	 * 
	 * 批量从银联下载优惠券，只有第一次和银联绑定成功（绑卡后）才会异步调用一次
	 */
	public function batchDownloadUnionCoupon_get(){
		
		$uid = $this->get('uid');
		
			// 用户下载并且没过期的优惠券
			$query = $this->db->query("select A.couponId as id, A.transSeq, B.username mobile, B.unionId, C.unionCouponId
		from downloadedcoupon A
		left join user B
		on A.uid=B.id
		left join coupon C
		on C.id=A.couponId
		where B.id=$uid
		AND `C`.`endDate` > now()");
		
			$coupons = $query->result_array();
			
			if (!empty($coupons)){
				$coupon = $coupons[0];
				$mobile = $coupon['mobile'];
				$unionUid = $coupon['unionId'];
				
				$response =$this->kqlibrary->download_batch_coupons($uid, $mobile, $unionUid, $coupons);	
			
				//记录批量下载的结果
				log_message('error',"Batch Download Coupon Response # $response");
			}
		 	
		
	}
	
	
//	public function 
	
	public function sleep_dcoupon_get(){
		
		sleep(5);
		
		$this->coupon->dcount_increment(36);
		
		return $this->output_results('10s后的返回');
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
   		
   	$this->output_results('sddsf');
   
   }
   
 	public function test_headers_get(){
 		
 		$headers = apache_request_headers();
 		
 		$this->output_results($headers);
 	}
   
   public function test_post(){
   		$id = $this->post('id');
   		$response = 'response: '.$id;
   		$this->response($response);
   }

}