<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Districts extends CI_Controller{


	/**
	 * 
	 * Enter description here ...
	 * @var District_m
	 */
	var $model;
	
	function __construct(){
		parent::__construct();
		
		session_start();
	
		check_admin_session();
		
		$this->load->model('district_m','model');
		$this->load->library('pagination');
	}
	
	function index($offset=0) {

		
		$models = $this->model->get_all_headDistrict(); 
		
		$this->load->library('pagination');
//		
		$config['base_url'] = site_url('admin/districts/index/');
		$config['total_rows'] = count($models);

		$config['per_page'] = 20; 
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = '<p>'; 
 		$config['full_tag_close'] = '</p>'; 
	
		$this->pagination->initialize($config); 
		
		$data['title'] = '区域管理';
		$data['main'] = 'admin_districts_home';

		$data['models'] = $models;
	
		$this->load->view($this->config->item('admin_template'),$data);
		
	}

	
	function create($parentId=''){
		
		//处理post的值
		if($this->input->post('title')){
					
			$title = $this->input->post('title');
			$parentId = $this->input->post('parentId');
			$continuous = $this->input->post('continuous');


			if (empty($parentId)){
				//一级类型
				$objectId = $this->model->create(array('title'=>$title));

			}
			else{
				//二级类型
				$objectId = $this->model->create(array('title'=>$title,'parent'=>avosPointer('District',$parentId)));
			}
			
			if (empty($continuous)){
				// redirect to index
				$this->session->set_flashdata('msg','创建成功');			
				redirect('admin/districts/index','refresh');
				
			}
		}
		
			// display form
			$data['title'] = '新建区域';
			$data['main'] = 'admin_districts_create';
			$data['parentId']=$parentId;
			$this->load->view($this->config->item('admin_template'),$data);;
		
	}
	
	function edit($id=0){
		
		if($this->input->post('realname')){
			$data = $this->_processform();
			$this->user->update($this->input->post('id'), $data);
			$this->session->set_flashdata('msg','会员更新成功');
			redirect('admin/users/index','refresh');
		}
		else{
			$data['title'] = '编辑';
			$data['main'] = 'admin_coupontypes_edit';
			$data['model'] = $this->model->get($id);

			var_dump($data);
//			$this->load->view($this->config->item('admin_template'),$data);;
		}
	}
	
	function subdistricts($id){
			$data['title'] = '子区域';
			$data['main'] = 'admin_districts_subtypes';
			$data['models'] = $this->model->get_subDistricts($id);
			$data['parentId']=$id;

			$this->load->view($this->config->item('admin_template'),$data);;
	}
	
	/**
	 * 
	 * 删除会员
	 * @param integer $id
	 */
	function delete($id,$parentId){
		

		$this->model->delete($id);
		
		if(!empty($parentId)){
					
		}
		
//		
//		$this->session->set_flashdata('msg','删除成功');
//		redirect('admin/coupontypes/index','refresh');
	}
	
	function test(){
		
//		$models = $this->model->get_all_headDistrict(); 
//		
//		$array = $models['objectId'];
//		var_dump($array);
		
	}

	
}