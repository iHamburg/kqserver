<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Shops extends CI_Controller{


	/**
	 * 
	 * Enter description here ...
	 * @var Shop_m
	 */
	var $model;
	
	/**
	 * 
	 * Enter description here ...
	 * @var Ctype_m
	 */
	var $ctype_m;
	
	/**
	 * 
	 * Enter description here ...
	 * @var District_m
	 */
	var $district_m;
	
	
	function __construct(){
		parent::__construct();
		
		session_start();
	
		check_admin_session();
		
		$this->load->model('shop_m','model');
		
	}
	
	function index($skip=0) {

		$limit = 20;
		
				
		$models = $this->model->get_all_headShops($skip,$limit); 
		
		$total_rows = $this->model->count_all_headShops();
		
		
		$this->load->library('pagination');
		
		$config['base_url'] = site_url('admin/shops/index/');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $limit; 
	
		$this->pagination->initialize($config); 
		
		$data['title'] = '商户管理';
		$data['main'] = 'admin_shops_home';

		$data['models'] = $models;
	
		$this->load->view($this->config->item('admin_template'),$data);
		
		
	}
	

	
	/**
	 * 创建主商户
	 */
	function create(){
		
		//处理post的值
		if($this->input->post('title')){

//			var_dump($_POST);
			
			$keys = array('title','desc','posterUrl');
			foreach ($keys as $key) {
				$data[$key] = $this->input->post($key);
			}
			
			$data['couponType'] = avosPointer('CouponType', $this->input->post('couponTypeId'));
			$data['subType'] = avosPointer('CouponType', $this->input->post('subTypeId'));
			
			
			$result = $this->model->create($data);
			
			if ($result<0){
				echo $result;
			}
			else{
				$this->session->set_flashdata('msg','创建成功');			
				redirect('admin/shops/index','refresh');
			}
			
		}
		
		$headTypes = $this->ctype_m->get_all_headType();
		$subTypes = array();
		foreach ($headTypes as $type) {

			$subTypes = array_merge($subTypes,$type['subTypes']);
		}
		
		
			// display form
			$data['title'] = '新建总商户';
			$data['main'] = 'admin_shops_create';

			$data['parentId']=$parentId;
			$data['couponTypes'] = $headTypes;
			$data['subTypes'] = $subTypes;

			$this->load->view($this->config->item('admin_template'),$data);
	}
	
	
	
	function edit($id){
		
		if($this->input->post('title')){
			
			$id = $this->input->post('id');
			
			$keys = array('title','desc','posterUrl');
			foreach ($keys as $key) {
				$data[$key] = $this->input->post($key);
			}
			$data['couponType'] = avosPointer('CouponType', $this->input->post('couponTypeId'));
			$data['subType'] = avosPointer('CouponType', $this->input->post('subTypeId'));
			
			$result = $this->model->update($id, $data);
			
			if ($result<0){
				echo $result;
			}
			else{
				$this->session->set_flashdata('msg','修改成功');			
				redirect('admin/shops/index','refresh');
			}
			
			
		}
		else{
			$headTypes = $this->ctype_m->get_all_headType();
			$subTypes = array();
			foreach ($headTypes as $type) {
	
				$subTypes = array_merge($subTypes,$type['subTypes']);
			}
		
			$shop = $this->model->get($id);
			
			
			$data['title'] = '编辑主商户';
			$data['main'] = 'admin_shops_edit';
			$data['model'] = $shop;
			$data['shopBranches'] = $shop['shopBranches']; 
			$data['coupons'] = $shop['coupons'];
			$data['couponTypes'] = $headTypes;
			$data['subTypes'] = $subTypes;
			
			$this->load->view($this->config->item('admin_template'),$data);;
		}
	}
	

	
	/**
	 * 
	 * 删除主商铺（是否也删除子商铺？）
	 * @param integer $id
	 * @param bool $shopBranchesFlag
	 */
	function delete($id,$shopBranchesFlag=""){

		$result = $this->model->delete($id);
		
		if ($result<0){
			echo $result;
		}
		else{
			$this->session->set_flashdata('msg','删除成功');
			redirect('admin/shops/index','refresh');
		}
		
	}
	
	function createShopBranch($parentId){
		
		//处理post的值
		if($this->input->post('title')){

//			var_dump($_POST);
			
			$keys = array('title','openTime','phone','address');
			foreach ($keys as $key) {
				$data[$key] = $this->input->post($key);
			}
			
			$data['district'] = avosPointer('District', $this->input->post('districtId'));
			$data['subDistrict'] = avosPointer('District', $this->input->post('subDistrictId'));
			
			$parentId = $this->input->post('parentId');			
			$parent = $this->model->get($parentId);			
			
			if($parent<0){
				echo $parent;
				return;
			}
			
			$data['couponType'] = $parent['couponType'];
			$data['subType'] = $parent['subType'];
			$data['parent'] = avosPointer('Shop', $parentId);
			
			$latitude =  doubleval($this->input->post('latitude'));
			$longitude = doubleval($this->input->post('longitude'));
			$data['location'] = avosGeoPoint($latitude,$longitude);
			
			$continuous = $this->input->post('continuous');
			
			
			$result = $this->model->createShopBranch($data);
		
			if ($result<0){
				echo $result;
				return;
			}
			else{
				$this->session->set_flashdata('msg','创建成功');
				if(empty($continuous)){
					//回到shop主业
								
					redirect('admin/shops/index','refresh');
				}
		
				
			}

		}
		
			$headDistricts = $this->district_m->get_all_headDistrict();
			$subDistricts = array();
			foreach ($headDistricts as $district) {
				$subDistricts = array_merge($subDistricts,$district['subDistricts']);
			}	
	
			
			$data['title'] = '新建子商户';
			$data['main'] = 'admin_shops_createbranch';
			$data['parentId']=$parentId;
			$data['headDistricts'] = $headDistricts;
			$data['subDistricts'] = $subDistricts;		
		
			$this->load->view($this->config->item('admin_template'),$data);
	}
	
	function editShopbranch($id){
		if($this->input->post('title')){

//			var_dump($_POST);
			
			$keys = array('title','openTime','phone','address');
			foreach ($keys as $key) {
				$data[$key] = $this->input->post($key);
			}
			
			$data['district'] = avosPointer('District', $this->input->post('districtId'));
			$data['subDistrict'] = avosPointer('District', $this->input->post('subDistrictId'));

			$latitude =  doubleval($this->input->post('latitude'));
			$longitude = doubleval($this->input->post('longitude'));
			$data['location'] = avosGeoPoint($latitude,$longitude);
			
			
			$result = $this->model->update($id, $data);
		
			if ($result<0){
				echo $result;
			}
			else{
				$this->session->set_flashdata('msg','创建成功');			
				redirect('admin/shops/index','refresh');
			}

			return;
		}
		
			$headDistricts = $this->district_m->get_all_headDistrict();
			$subDistricts = array();
			foreach ($headDistricts as $district) {
				$subDistricts = array_merge($subDistricts,$district['subDistricts']);
			}	
	
			
			$data['title'] = '子商户';
			$data['main'] = 'admin_shops_editshopbranch';
			$data['model'] = $this->model->get($id);
		
			$data['headDistricts'] = $headDistricts;
			$data['subDistricts'] = $subDistricts;		
		
	
			$this->load->view($this->config->item('admin_template'),$data);;
	}
	function deleteShopBranch($id,$parentId){

		$result = $this->model->deleteShopBranch($id, $parentId);
		
//		var_dump($result);
		if ($result<0){
			echo $result;
		}
		else{
			$this->session->set_flashdata('msg','删除成功成功');			
			redirect('admin/shops/edit/'.$parentId,'refresh');
		}
	}

	
}