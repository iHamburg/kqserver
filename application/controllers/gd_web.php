<?php



if (! defined ( 'BASEPATH' ))

	exit ( 'No direct script access allowed' );



class Gd_web extends CI_Controller{

	
	//TODO: test
	//@todo lsdjf
	//!!!: sdlkfj
	
	function __construct(){

		parent::__construct();
		

		$this->load->library('kqlibrary');

		$this->load->model('gd_web_m',"model");

	}

	

	

	public function index(){

		$data['title'] = '388份掼奶油限量大放送！';

		$this->load->view('GD_home_page',$data);

		

	}

	public function beforeLogin(){
		
		$data['uid'] = 'notNull';
		$data['uids'] = 'notNull';
		$data['title'] = '388份掼奶油限量大放送！';
		
		$this->load->view('tiaozhuan2',$data);
	}

	

	public function login(){

		
		//TODO: blabala
		

		if($this->input->post('username')){

			$key = array('username','verificationCode','verificationCode2','agree');

			

			foreach ($key as $v){

				$data[$v] = $this->input->post($v);

			}
			
			//print_r(strlen($data['username']));exit;
			
			if(strlen($data['username']) !== 11){
				echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
				
				echo "<script>alert('请输入正确的手机号')</script>";
				
				//redirect('gd_web/login','refresh');
				$this->load->view('GD_logo');return;
			}
			
			
			

			if(empty($data['agree'])){

				echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

				echo "<script>alert('请阅读《快券注册协议》')</script>";

				//redirect('gd_web/login','refresh');
				$this->load->view('GD_logo');return;

			}
			
			
			if($data['verificationCode2'] == "m"){
				echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
				
				echo "<script>alert('请获取验证码')</script>";
				
				//redirect('gd_web/login','refresh');
				$this->load->view('GD_logo');return;
			}
			

			if(empty($data['verificationCode'])){
				echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
				
				echo "<script>alert('请输入验证码')</script>";
				
				//redirect('gd_web/login','refresh');
				$this->load->view('GD_logo');return;
			}
			
			

			if($data['verificationCode'] !==$data['verificationCode2'] || $data['verificationCode2'] == "m"){
				
				echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

				echo "<script>alert('验证码错误')</script>";

				//redirect('gd_web/login','refresh');
				$this->load->view('GD_logo');return;

			}

			

			$num = $this->model->get_user($data['username']);

			
			//print_r($num);exit;
			if($num['id'] > 0){

				$date = date('Y-m-d H:i:s');
				
				if($num['expireDate'] < $date){
					
					$updata['sessionToken'] = $this->randomCharacter(20);
					$updata['expireDate'] = date('Y-m-d H:i:s',strtotime('+2 week'));
					
					$update = $this->model->updateUser('user',$num['id'],$updata);
				}
				
				$card = $this->model->get_user_card_number($num['id']);

				

				if($card <= 0){

					$data['uid'] = $num['id'];

					$data['title'] = '388份掼奶油限量大放送！';

					$this->load->view('tiaozhuan',$data);return;

				}else{

					$data['uid'] = $num['id'];

					$data['title'] = '388份掼奶油限量大放送！';

					$this->load->view('tiaozhuan1',$data);return;

				}

			}

			

			unset($data['verificationCode']);

			unset($data['verificationCode2']);

			unset($data['agree']);

			unset($data['uid']);

			unset($data['title']);

			

			$password = $this->randomCharacter(6);

			

			$mobile = $data['username'];

			

			$this->load->library('kqsms');

			//print_r($);exit;

			$response = $this->kqsms->send_register_sms($mobile,$password);

			if ($response == true){

				

				$data['password'] = md5($password);

				$data['sessionToken'] = $this->randomCharacter(20);

				$data['expireDate'] = date('Y-m-d H:i:s',strtotime('+2 week')); // session有效期2周

				$data['nickname'] ='KQ_'.randomCharacter(8);

				$data['createdAt'] = NULL;

				//print_r($data);exit;

				$result = $this->model->insert_all('user',$data);

				

				if($result < 0){

					echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

					echo "<script>alert('注册失败，请稍后再试')</script>";

					//redirect('gd_web/login','refresh');
					$this->load->view('GD_logo');return;

				}

			}else{

				echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

				echo "<script>alert('注册失败，请稍后再试')</script>";

				//redirect('gd_web/login','refresh');
				$this->load->view('GD_logo');return;

			}

			$data['uid'] = $result;

			$data['title'] = '388份掼奶油限量大放送！';

			$this->load->view('tiaozhuan',$data);

		}else if($this->input->post('username2') && $this->input->post('username3')){
			
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			
			echo "<script>alert('请输入手机号')</script>";
		
			$data['uid'] = $this->input->post('username2');
			
			//redirect('gd_web/login','refresh');
			$this->load->view('GD_logo');return;
			
 		}else {
		
 			$uid = $this->input->post('username2');
			
 			
 			if(empty($uid)){
 					
 				redirect('gd_web/index','refresh');
 					
 			}
 				
 			$data['uid'] = $uid;
 			
 			$data['title'] = '388份掼奶油限量大放送！';
 				
 			//$data['verificationCodetrue'] = $this->random_number(6);
 				
 			$this->load->view('GD_logo',$data);
 			
 			

		}

	}

	

	

	public function bind_card(){


		if($this->input->post('cardNumber')){

			$card = $this->input->post('cardNumber');

			$uid =  $this->input->post('uid');

			

			//print_r($uid);exit;

			$session = $this->model->get_user_details($uid);

			//print_r($session);exit;

			$sessionToken = $session['sessionToken'];

			
			
 			//echo '绑卡的session';
 			//print_r($sessionToken);
			

 			$cardVerification = $this->cardVerification($card);

			

 			if($cardVerification === false){

 				echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

 				echo "<script>alert('请输入光大银行62开头信用卡卡号')</script>";

 				//redirect('gd_web/bind_card','refresh');

 				$data['uid'] = $uid;

 				//print_r($data['uid']);exit;

 				$data['title'] = '388份掼奶油限量大放送！';

 				$this->load->view('tiaozhuan',$data);return;

 			}

			
			
			
			//绑卡开始
			//echo '绑卡的uid';
			//echo $uid;
			$url = "http://61.153.100.241/kqapitest/index.php/kqapi1_1/myCard";

			

			$arr = array('uid'=>$uid,"card"=>$card,"sessionToken"=>$sessionToken);

			

			$data = json_encode($arr);

			

			//print_r($data);exit;

			

			$result = $this->post($url,$data);

			

			$results = json_decode($result,true);

			

			//print_r($results['status']);

			
			if($results['status'] !== 1){
				
				$error = $this->output_error($results['status']);
				
				$msg = json_decode($error,true);
				
				if($msg['status'] == 300500 ){
					$msg['msg'] = '您输入的卡号有误';
				}
				
				
				echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

				echo "<script>alert('".$msg['msg']."')</script>";

				$data1['uid'] = $uid;

				$data1['title'] = '388份掼奶油限量大放送！';

				$this->load->view('tiaozhuan',$data1);return;
			}
			//绑卡结束
 			//echo '准备下券的session';
 			//print_r($sessionToken);

			//echo '下券的uid';
			//echo $uid;
			//下载券开始
			$couponurl = "http://61.153.100.241/kqapitest/index.php/kqapi1_1/myDownloadedCoupon";
				
			$arr = array('uid'=>$data1['uid'] = $uid,"couponId"=>'96',"sessionToken"=>$sessionToken);
				
			$data = json_encode($arr);
				
			
			//print_r($data);exit;
			$result2 = $this->post($couponurl,$data);
				
			$results2 = json_decode($result2,true);
			//print_r($results2);exit;
			
			//下券结束
			$data1['uid'] = $results['data']['userId'];

			//print_r($data1['uid']);exit;
			$data1['title'] = '388份掼奶油限量大放送！';

			$this->load->view('tiaozhuan1',$data1);


		}else if($this->input->post('username2') && $this->input->post('username3')){
			
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
				
			echo "<script>alert('请输入光大银行62开头信用卡卡号')</script>";
			
			$data['uid'] = $this->input->post('username2');
				
			//redirect('gd_web/login','refresh');
			$this->load->view('GD_bind_card',$data);return;
			
		}else{

			$uid = $this->input->post('username');


			if(empty($uid)){

				redirect('gd_web/index','refresh');

			}


			$data['uid'] = $uid;

			$data['title'] = '388份掼奶油限量大放送！';

			$this->load->view("GD_bind_card" , $data);

		}

	}

	

	

	

	

	

	

	

	

	public function gd_download(){

		

		$uid = $this->input->post('username');

		

		if(empty($uid)){

			redirect('gd_web/index','refresh');

		}

		

		$data['card'] = $this->model->getUserCardByUid($uid);

		//print_r($card);exit;
		
		//echo ErrorUsernameExists;exit;
		
		$data['title'] = '388份掼奶油限量大放送！';

		$this->load->view("GD_download" , $data);

	}

	

//------------------------------------------------	private --------------------------------------------------

	

	

	private function randomCharacter($number) {

	$m = '0123456789abcdefghijkpqrstuvwxyzABCDEFGHIJKPQRSTUVWXYZ';

	$s = str_shuffle ( $m );

	$str = substr ( $s, 1, $number );

	return $str;

}

	

	/**

	 *

	 * 返回6位随机数

	 */

	private function random_number(){

		$m = '0123456789';

		$s = str_shuffle($m);

		$str = substr($s,1,6);

		return $str;

	}

	

	

	private function post($url='',$data=''){

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_SSLVERSION, 1);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8') );  // 要求用json格式传递参数

	

	

		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		$output = curl_exec($ch);

	

		if(!$output){

					    echo "cURL error number:" .curl_errno($ch);

			  			echo " and url is $url and cURL error:" . curl_error($ch);

				

		}

		curl_close($ch);

	

		return $output;

	}

	

	

	private function cardVerification($card){

		$cardsix = substr($card ,0,6);

		

		

		if($cardsix == '622161' ||$cardsix == '622162' ||$cardsix == '622570' ||$cardsix == '622650' ||$cardsix == '622655' ||$cardsix == '622657' ||$cardsix == '622658' ||$cardsix == '622659' ||$cardsix == '622685' ||$cardsix == '622687' ||$cardsix == '625976'|| $cardsix == '625979' ||$cardsix == '628201' ||$cardsix == '628202' ){

			return true;

		}

		

		return false;

	}

	
	private function output_error($status,$errorMsg=''){
	
	
	
		$msg = msg_with_error($status);
	
	
	
		$error = array('status'=>$status,'msg'=>$msg);
	
		$response = json_encode($error);
	
		//echo $response;
	
		return $response;
	
	}
	

	

	/**

	 * Redirect with POST data.

	 *

	 * @param string $url URL.

	 * @param array $post_data POST data. Example: array('foo' => 'var', 'id' => 123)

	 * @param array $headers Optional. Extra headers to send.

	 */

	private function redirect_post($url, array $data, array $headers = null) {

		$params = array(

				'http' => array(

						'method' => 'POST',

						'content' => http_build_query($data)

				)

		);

		if (!is_null($headers)) {

			$params['http']['header'] = '';

			foreach ($headers as $k => $v) {

				$params['http']['header'] .= "$k: $v\n";

			}

		}

		$ctx = stream_context_create($params);

		$fp = @fopen($url, 'rb', false, $ctx);

		if ($fp) {

			echo @stream_get_contents($fp);

			die();

		} else {

			// Error

			throw new Exception("Error loading '$url', $php_errormsg");

		}

	}

	

}

