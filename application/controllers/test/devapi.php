<?php
class Devapi extends CI_Controller{

	function testlatestget(){
    	$ch = curl_init();
		$curl_url = site_url('apis/event/latest');		
		curl_setopt($ch, CURLOPT_URL, $curl_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//不直接输出，返回到变量
		$responsejson = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($responsejson,true);
		
		print_r($response);
    }
    
    function testenroll(){

		
		$post_data = array('username'=>'test user','telephone'=>'11334455','eventid'=>23);
			
		
		$curl_url = site_url('apis/event/enroll');		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $curl_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// 我们在POST数据哦！
		curl_setopt($ch, CURLOPT_POST, 1);
		// 把post的变量加上

		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
		$output = curl_exec($ch);
		curl_close($ch);
		
		$response = json_decode($output,true);
	
		header("Content-Type:text/html;charset=utf-8");
		print_r($response);
    }
    
    function testuserevent() {


    	$row = $this->user_event_m->has_user_event(3,1);
//    	print_r($row);
		echo $row;
    }
    
    function testmenroll(){
    	echo $this->user_event_m->enroll();
    }
    
 	function testeventtest(){
 		
 		$post_data = array('id'=>123);
 		
 		$response = curl('http://localhost/pci/index.php/apis/event/test', $post_data);
 		
 		echo 'response: '.$response;
 	}
 	
 	function getinpost(){
 		$post_data = array('name'=>'zhang');
 		 		
 		echo $this->curl->simple_post(site_url('apis/event/index/id/6'),$post_data);

 	}
}