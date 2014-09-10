<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	/**
	 * 
	 * Enter description here ...
	 * @var User_event_m
	 */
	var $user_event_m;
	
	function __construct() {
		parent::__construct();
		header("Content-Type:text/html;charset=utf-8");
	
		session_start();
		
		// test
	}
	
	function testwxsession(){
		if(!isset($_SESSION['tree'])){
				$_SESSION['tree'] = 0;
			}
			$_SESSION['tree']++;
		echo "tree: ".$_SESSION['tree'];
	}
	
	function index(){
		echo "apppath: ".APPPATH;
	}
	public function show(){
		echo 'show test';
	}
	
	function testtinymce() {
//		echo 'tinymce';
		$this->load->view('tinymce');
	}
	
	
	function test_request_event() {
		
//		$response = ;
		
			$ch = curl_init();
		$curl_url= site_url('api/request_event');
		curl_setopt($ch, CURLOPT_URL, $curl_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//不直接输出，返回到变量
		$curl_result = curl_exec($ch);
		$result = explode(',', $curl_result);
		curl_close($ch);

		print_r($result);
	}
	

	function testsession(){
			echo 'begin test<br>';
			print_r($_SESSION);
			
			if(isset($_SESSION['count'])){
				
				$_SESSION['count'] = $_SESSION['count']+1;
				
				if($_SESSION['count']>3){
					unset($_SESSION['count']);

				}
		
			}
			else{
				echo 'session unset<br>';
				$_SESSION['count'] = 1;
				$_SESSION['mileston'] = 'here';
			}
			
			echo 'session_cache_limiter: '.session_cache_limiter().'<br>';
			$this->session->set_flashdata('abc','sdlkfjelkfj');
	}

	function test_file_get_contents(){
		$file_contents = file_get_contents('http://localhost/pci/index.php/api/request_event');
		echo $file_contents;
	}
	
	function test_curl_post(){
		$url =site_url('api/request_event');
		$post_data = array (
 			"eventid"=>'1',
    		"openid"=>'adsfssd'
		);

		$json = curl($url, $post_data);
		
		$response = json_decode($json,true);
		
//		echo $response;
		print_r($response);
	}
	
	function test_from_wx_3g() {
//		print_r($_SERVER);

		$array = getallheaders();
		
//		print_r($array);
		print_array($array);
	}
	
	function test_db_cache(){
		$this->db->cache_on();
		$query = $this->db->query("SELECT * FROM event");
		print_r($query->result_array());
	}
	
	function test_delete_cache(){
		$this->db->cache_delete('/test', 'test');
	}
	
	function wysiwyg(){
		
		echo 'html:'.$this->input->post('html').'<br>';
		
		$this->load->view('test/wysiwyg');
	}

	/**
	 * 
	 * show api
	 */
	function testCurl(){
		$responsejson = $this->curl->simple_get('http://115.29.148.47/htw_test/index.php/apis/event/index/id/7/name/hh');
		$response = json_decode($responsejson,true);
		print_r($response);
	}
	
	function testconfig(){
//		$template = $this->config->load
	}
	
	// 时间戳
	function time_ago($cur_time){
		$agoTime = time() - $cur_time;    
		if ( $agoTime <= 60 ) {       
			 return $agoTime.'秒前';   
		 }elseif( 
		 $agoTime <= 3600 && $agoTime > 60 ){  
		 	      return intval($agoTime/60) .'分钟前';   
		  }elseif ( date('d',$cur_time) == date('d',time()) && $agoTime > 3600){	
		  	return '今天 '.date('H:i',$cur_time);    
		 }elseif( date('d',$cur_time+86400) == date('d',time()) && $agoTime < 172800){	
		 	return '昨天 '.date('H:i',$cur_time);   
		  }else{       
		  	 return date('Y年m月d日 H:i',$cur_time);    }}
		  	 
	function testsprintf(){
		 $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            <FuncFlag>0</FuncFlag>
                            </xml>";          
		 
		 $response = sprintf($textTpl,'to','from',time(),'a','b');
		 
		 echo $response;
	}
	
	function testsessionkey(){
		echo $this->config->item('admin_session_key');
	}
}