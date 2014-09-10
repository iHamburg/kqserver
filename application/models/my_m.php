<?php
/**
 * 
 * 
 * @author qing
 *
 */
class My_m extends CI_Model{


	/**
	 * 
	 * Enter description here ...
	 * @var Avoslibrary
	 */
//	var $avoslibrary;
	
	public function __construct(){
		parent::__construct();
//		$this->load->library('avoslibrary');
		
	}


	/**
	 * Enter description here ...
	 * @param unknown_type $uid
	 * @return 	array error,code<br>
	 * 			array of cards
	 */
	public function get_my_cards($uid){
			
			$where = json_encode(array('people'=>avosPointer('_User',$uid)));
			
   			$url = HOST."/classes/Card?where=".$where;
   		
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
	 * Card Table 新建 record
	 * @param unknown_type $uid
	 * @param unknown_type $cardNumber
	 * @return 
	 * array(error,code)<br>
	 * false: 已经有card<br>
	 * str: objectId
	 * 
	 */
	public function add_my_card($uid,$cardNumber){
	
				
		if($this->avoslibrary->isFieldHasValue('Card', 'title', $cardNumber)){
			return -1;
		}
		
		$bankId = '5395616be4b08cd56b62cd43';
		
		$url = HOST.'/classes/Card';
		
		$data = array('people'=>avosPointer('_User',$uid),'bank'=>avosPointer('Bank',$bankId),'title'=>$cardNumber);
		
		/// create Card
		$json = $this->avoslibrary->post($url,json_encode($data));
		
		$result = json_decode($json,true);
		
		if (empty($result['error'])){
   				return $result['objectId'];
   			}
   			else{
   				return Error_Create_Object;
   			}

	}
	
	
	public function get_my_downloaded_coupons($uid){
			
			$where = json_encode(array('people'=>avosPointer('_User',$uid)));
			
   			$url = HOST."/classes/DownloadedCoupon?include=coupon&where=".$where;
   		
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
	 * 
	 * DownloadedCoupon表新增record，Coupon表increment downloadedCount field
	 * @param unknown_type $uid
	 * @param unknown_type $couponId
	 * @return 
	 * 正常: str objectId<br>
	 *
	 */
	function add_my_downloaded_coupon($uid,$couponId){

		$url = HOST."/classes/DownloadedCoupon";
   		
   		$data = array('people'=>avosPointer('_User',$uid),'coupon'=>avosPointer('Coupon',$couponId),'status'=>'unused');
   		$data = json_encode($data);
   		$json = $this->avoslibrary->post($url,$data);
   		
		$result = json_decode($json,true);
		
		if (empty($result['error'])){

		///	Coupon表increment downloadedCount field
			
			$this->avoslibrary->increment('Coupon',$couponId,'downloadedCount');	
			
			return $result['objectId'];
   		}
   		else{
   			
   				return $results;
   		}
	}
	

	function add_my_favorited_coupon($uid,$sessionToken,$couponId){
		
		$json = $this->avoslibrary->addPointerInArrayForUser($uid,$sessionToken,'favoritedCoupons',avosPointer('Coupon',$couponId));

		$result = json_decode($json,true);
		
		if (empty($result['error'])){
			return $result['objectId'];
		}
		else{
			return $results;
		}
//		return $result;
	}
	
	function remove_my_favorited_coupon($uid,$sessionToken,$couponId){
	
		$json = $this->avoslibrary->removePointerInArrayForUser($uid,$sessionToken,'favoritedCoupons',avosPointer('Coupon',$couponId));
	
		$result = json_decode($json,true);
		
		return $result;
	}
	

	function add_my_favorited_shop($uid,$sessionToken,$shopId){
		
		$json = $this->avoslibrary->addPointerInArrayForUser($uid,$sessionToken,'favoritedShops',avosPointer('Shop',$shopId));
		
		$result = json_decode($json,true);
		
		if (empty($result['error'])){
			return $result['objectId'];
		}
		else{
			return $results;
		}
	}
	
	
	function remove_my_favorited_shop($uid,$sessionToken,$shopId){
	
		$json = $this->avoslibrary->removePointerInArrayForUser($uid,$sessionToken,'favoritedShops',avosPointer('Shop',$shopId));

		$result = json_decode($json,true);
		
		return $result;
	}
}