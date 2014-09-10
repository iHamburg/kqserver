<?php
/**
 * 
 * 做为微信公众号的管理员（客户）的登录后主Controller
 * @author qing
 *
 */
class Dashboard extends CI_Controller{
	
	
	function __construct(){
		parent::__construct();

		session_start();		
	
		$this->load->model('admin_m');
	}
	
	function index(){
		// 如果没有session，需要login
		//check_admin_session();
	
		
		redirect('admin/coupons','refresh');
	}
	
	function login(){

		
		
		if($this->input->post('username')){
			$u = $this->input->post('username');
			$pw = $this->input->post('password');
	
			$admin = $this->admin_m->login($u,$pw);		

			if(!empty($admin)){
			// 成功登录
					
				$_SESSION['username']=$admin['username'];
				
				redirect('admin/users/index','refresh');

			}
			else{
			// 登录失败
		
				unset($_SESSION['username']);
			
				$this->session->set_flashdata('error','抱歉，用户名或密码错误');
			}
		
		}
		
		$data['title'] = '快券后台管理平台登陆';
		$data['main'] = 'admin_login';

		$this->load->view('templates/bootstrap',$data);
	}
	
	function logout(){
		
		unset($_SESSION['weixinid']);
		unset($_SESSION['username']);
		
		$this->session->set_flashdata('error','您已经登出系统');
		redirect('admin/dashboard/login','refresh');
	}
	

}