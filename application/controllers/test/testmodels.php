<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testmodels extends CI_Controller {

	/**
	 * 
	 * Enter description here ...
	 * @var User_event_m
	 */
	var $user_event_m;
	
	function __construct() {
		parent::__construct();
		$this->load->model('wx_msg_response_m','msg_response');
		$this->load->model('weixin_m');
		$this->load->model('user_m');
		header("Content-Type:text/html;charset=utf-8");
	}
	
	function index(){
		echo "apppath: ".APPPATH;
	}
	
	function msg_response() {
		
		$response = $this->msg_response->get_response_by_keyword(1,'test');

		print_r($response);
		
	}
	
	function test_request_event() {
		
		
		$ch = curl_init();
		$curl_url= site_url('api/request_event');
		curl_setopt($ch, CURLOPT_URL, $curl_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//不直接输出，返回到变量
		$curl_result = curl_exec($ch);
		$result = explode(',', $curl_result);
		curl_close($ch);

		print_r($result);
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


	/**
	 * 
	 * show api
	 */
	function testCurl(){
		$responsejson = $this->curl->simple_get('http://115.29.148.47/htw_test/index.php/apis/event/index/id/7/name/hh');
		$response = json_decode($responsejson,true);
		print_r($response);
	}
	
	/**
	 * 
	 * show model
	 */
	function showLatestManay(){
		
		$data = $this->event_m->get_latest_many_event(5);
		
		print_r($data);

	}
	
	function show_user_event_m(){
		
		$userids = $this->user_event_m->get_userinfos_for_event(5,3);
		
		print_r($userids);
	}
	
	function show_event_get_applicants_numbers(){
		$data = $this->event_m->get_applicants_numbers(1);
		
		print_r($data);
	}	
	
	function event_get_applicants(){
		$applicants=$this->event_m->get_applicants(1);
		
		print_r($applicants);
	}
	
	function user_event_enrolled(){
		$count = $this->user_event_m->count_by(array('userid'=>28,'eventid'=>5));
		echo 'count: '.$count;
	}
	
	function event_get_latest_event(){
		$event= $this->event_m->get_latest_event();
		print_r($event);
	}
	
	function user_all(){
		$this->load->model('user_m');
		$query = $this->user_m->get_all();
		
		print_r($query);
	}
	
	function weixin_user(){

		$users = $this->weixin_m->responses(1);
		print_r($users);
	}
	
	
}