<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * For superadmin
 * @author qing
 *
 */
class Admins extends CI_Controller{
		
	function __construct(){
		parent::__construct();
		session_start();
	
	}
	
	function index(){
		
		$session_key=$this->config->item('admin_session_key');
		
		if(!isset($_SESSION[$session_key])){
			redirect('admin/dashboard/login','refresh');
		}
	
		redirect('admin/coupons','refresh');
	}
	
	function test(){
	
		$json = $this->curl->simple_get('http://localhost/kq/index.php/kqapi3/headdistricts');
		echo $json;
	}
	
}