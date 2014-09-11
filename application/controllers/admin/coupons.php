<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Coupons extends CI_Controller{


	/**
	 * 
	 * Enter description here ...
	 * @var Coupon_m
	 */
	var $model;

	
	/**
	 * 
	 * Enter description here ...
	 * @var Coupon2_m
	 */
	var $model2;

	/**
	 * 
	 * Enter description here ...
	 * @var Shop_m
	 */
	var $shop_m;
	
	function __construct(){
		parent::__construct();
		
		session_start();
	
		check_admin_session();
		
		$this->load->model('coupon_m','model');
		
		$this->load->model('coupon2_m','model2');
		
		$this->load->library('pagination');
	}
	
	function index($skip=0) {

		$limit = 20;
		
//		$models = $this->model->get_all($skip,$limit); 

		$models = $this->model2->get_all();
		
		$total_rows = $this->model->count_all();
		
		
		$this->load->library('pagination');
//		
		$config['base_url'] = site_url('admin/coupons/index/');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $limit; 
		
	
		$this->pagination->initialize($config); 
		
		$data['title'] = '优惠券管理';
		$data['main'] = 'admin_coupons_home';
		$data['models'] = $models;
	
		$this->load->view($this->config->item('admin_template'),$data);
		
	}

	/**
	 * 创建主商户
	 */
	function create($shopId=''){
		
		//处理post的值
		if($this->input->post('title')){

//			var_dump($_POST);
			
			$keys = array('title','discountContent','validate','usage','avatarUrl');
			foreach ($keys as $key) {
				$data[$key] = $this->input->post($key);
			}
			
			$shopId = $this->input->post('shopId');
			
			$data['shop'] = avosPointer('Shop', $shopId);
			
			$objectId = $this->model->create($data,$shopId);
			
			if ($objectId<0){
				echo $objectId;
			}
			else{
				$this->session->set_flashdata('msg','创建成功');			
				redirect('admin/coupons/index','refresh');
			}
		}
		else{
			// display form
			
			$shops = $this->shop_m->get_all_headShops(0,200);
			if ($shops<0)
				var_dump($shops);
			
			$data['title'] = '新建优惠券';
			$data['main'] = 'admin_coupons_create';
			$data['shopId']=$shopId;
			$data['shops'] = $shops;
			
			
			$this->load->view($this->config->item('admin_template'),$data);
		
		}
	}
	
	
	
	function edit($id){
		
		if($this->input->post('title')){

//			var_dump($_POST);
			
			$keys = array('title','discountContent','validate','usage','avatarUrl');
			foreach ($keys as $key) {
				$data[$key] = $this->input->post($key);
			}
			
			$shopId = $this->input->post('shopId');
			
			$data['shop'] = avosPointer('Shop', $shopId);
			
			$id = $this->input->post('id');
			
//			echobr($id);
//			var_dump($data);
			
			$objectId = $this->model->update($id,$data);
			
			if ($objectId<0){
				echo $objectId;
			}
			else{
				$this->session->set_flashdata('msg','修改优惠券成功');			
				redirect('admin/coupons/index','refresh');
			}
		}
		else{
			// display form
			
			$coupon = $this->model->get($id);
			$shopId = $coupon['shop']['objectId'];
			$shops = $this->shop_m->get_all_headShops(0,200);
			if ($shops<0)
				var_dump($shops);
			
			$data['title'] = '编辑优惠券';
			$data['main'] = 'admin_coupons_edit';
			$data['shopId']=$shopId;
			$data['shops'] = $shops;
			$data['model'] = $coupon;
			
			
			$this->load->view($this->config->item('admin_template'),$data);
		
		}
	}
	

	
	/**
	 * 
	 * 删除Coupon, 也从shop的coupons 移除
	 * @param integer $id
	 *
	 */
	function delete($id){

		
		
		$result = $this->model->delete($id);
//		var_dump($result);
		if ($result<0){
			var_dump($result);
		}
		else{
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			echo "<script>alert('删除成功')</script>";
		$this->session->set_flashdata('msg','删除成功');
		redirect('admin/coupons/index','refresh');
		}
	}

	
}