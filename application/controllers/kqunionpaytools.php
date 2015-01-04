<?php
/*
 * 这里对外界来说应该就是api
 * @author qing
 *
 */




class Kqunionpaytools extends CI_Controller{

	
	/**
	 * 
	 * Enter description here ...
	 * @var Unionpay
	 */
	var $unionpay;
	
	/**
	 * 
	 * Enter description here ...
	 * @var Kqlibrary
	 */
	var $kqlibrary;
	
	function __construct(){
		parent::__construct();
		
	
//		header( 'Content-Type:application/json;charset=utf-8 '); 
		
//		$this->load->library('unionpay');
		$this->load->helper('html');
	
	}
	

	function index() {

		header( 'Content-Type:text/html;charset=utf-8 ');
		echo 'union pay test<br>';
	
	}
	
	
	function toolsuit($servername='localhost'){
		
		header( 'Content-Type:text/html;charset=utf-8 ');
	
		$host = get_host($servername);
		
		$linkPrepend = $host.'/kq/index.php/kqunionpaytools/';
		
//		$apiTitle = array('re','用户信息查询','银行卡开通服务','银行卡关闭服务');

		$apiLink = array('testGetUserByMobile','testRegByMobile','testBindCard','testUnbindCard','testCouponDwnById');
		$apiTitle = $apiLink;
		
		
		foreach ($apiLink as $link) {
			$newApiLink[] = $linkPrepend.$link.'/'.$servername;
		}
		
		
		$data['title'] = '银联接口工具套装';
		
		$data['titles'] = $apiTitle;
		$data['links'] = $newApiLink;
		
		$this->load->view('vtestsuit', $data);
		
	}

	
	// 查询银联快券ID是否有效的接口
	function verifyCouponID($unionCouponId){
		
		$this->load->library('unionpay');
		header( 'Content-Type:text/html;charset=utf-8 ');
	
		$data['chnlUsrId'] = '57';
		$data['chnlUsrMobile'] = '13166361023';
//		$data['couponId'] = 'D00000000010397';
		$data['couponId'] = $unionCouponId;
		
		$data['couponNum'] = '1';
		$data['couponSceneId'] = '000';
		$data['transSeq'] = 'C57D36T1424473970';
		$data['userId'] = 'c00055685346';

		
		$response = $this->unionpay->couponDwnById($data);		
//		
		
		$response = json_decode($response,true);
		$respCd = $response['respCd'];
		
		if($respCd == NULL){
			echo ErrorUnionNotAuthorized;
		}
		else if ($respCd == '000000'){
			echo '银联快券有效';
		}
		else {
			echo $respCd;
		}
	}
	
	
	/**
	 * api, 可以不经过数据库直接下载银联快券
	 * 
	 * @param str $mobile = 13166361111
	 * @param unknown_type $unionCouponId
	 */
	function downloadCouponFromUnion($mobile=0,$unionCouponId=0){
		$this->load->library('kqlibrary');
		
//		$couponUnionId = 'D00000000011149';

		$mobiles = array($mobile);
		
		return $this->kqlibrary->download_union_coupon_with_users($mobiles, $unionCouponId);
	}

	
	
	
		
	function test(){


		header( 'Content-Type:text/html;charset=utf-8');
//		header( 'Content-Type:application/json;charset=utf-8');
		
		if (empty($mobile)){
			$mobile = '13166361023';
//			$mobile = '15166412996';
		}
		$response = $this->unionpay->getUserByMobile2($mobile);

		echo $response;
		
		echo $this->unionpay->test();
	}
	
	
	/////////////////
	
	private function  generateKey($key){
		
		$md5 = md5($key,TRUE);
		$result = base64_encode($md5);
		
		while (strlen($result)<16) {
			$result.='%';
		}
		
		return $result;
	}
	
	private  function pad2Length($text, $padlen){    
    $len = strlen($text)%$padlen;    
    $res = $text;    
    $span = $padlen-$len;    
    for($i=0; $i<$span; $i++){    
        $res .= chr($span);
    
    }    
    return $res;    
}    

private static function pkcs5_pad ($text, $blocksize) {

$pad = $blocksize - (strlen($text) % $blocksize);

return $text . str_repeat(chr($pad), $pad);

}

	function get($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
	
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
	}

	function post($url,$data){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
            'Content-Type: application/json; charset=utf-8')  
        );  // 要求用json格式传递参数

 	
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
		$output = curl_exec($ch);

		curl_close($ch);
		
		return $output;
	}
	
	


}