<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller{
	
	/**
	 * 
	 * Enter description here ...
	 * @var My_m
	 */
	var $my;
	
	/**
	 * 
	 * Enter description here ...
	 * @var User_m;
	 */
	var $model;
	
	function __construct(){
		parent::__construct();
		
		session_start();
	
		check_admin_session();
		
		$this->load->model('user_m','model');
		
		$this->load->model('user2_m','model2');
	}
	
	function index($skip=0) {
		$limit = 25;
		
		$this->load->library('pagination');
		
		$models = $this->model->get_all($skip,$limit);
	
		
		$config['base_url'] = site_url('admin/users/index/');
		$config['total_rows'] = $this->model->count_all();
		$config['per_page'] = $limit; 
		
		$this->pagination->initialize($config); 
		
		$data['title'] = '会员管理';
		$data['main'] = 'admin_users_home';
		$data['models'] = $models;
		
		$this->load->view($this->config->item('admin_template'),$data);
		
	}
	
	function edit($uid){

			
			$user = $this->model->get($uid,'favoritedCoupons,favoritedShops');

			$cards = $this->model->get_user_cards($uid);
//			$cards = $this->model->get_user_cards2($uid);

			
			
//			$cards = $this->model2->get_all();
			
			
			if ($cards < 0)
				$cards = 0;
			
			
			$downloadedCoupons = $this->model->get_user_downloaded_coupons($uid);

			
			$data['title'] = '用户';
			$data['main'] = 'admin_users_edit';
			$data['model'] = $user;
			$data['favoritedCoupons'] = $user['favoritedCoupons'];
			$data['favoritedShops'] = $user['favoritedShops'];
			
			$data['cards'] = $cards;
			$data['downloadedCoupons'] = $downloadedCoupons;
			
			
			$this->load->view($this->config->item('admin_template'),$data);;
	}
	
	
	
}