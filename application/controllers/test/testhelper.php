<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testhelper extends CI_Controller {

	/**
	 * 
	 * Enter description here ...
	 * @var User_event_m
	 */
	var $user_event_m;
	
	function __construct() {
		parent::__construct();
		header("Content-Type:text/html;charset=utf-8");
	}
	
	function index(){
		echo "apppath: ".APPPATH;
	}
	public function show(){
		echo 'show test';
	}
	
	function transTime() {
		
//		echo transTime(1376018066);
		echo transTime(1390039369);
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
}