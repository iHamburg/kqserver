<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once('kqavos.php');
class Coupontypes extends CI_Controller{


	/**
	 * 
	 * Enter description here ...
	 * @var Ctype_m
	 */
	var $model;
	
	function __construct(){
		parent::__construct();
		
		session_start();
	
		check_admin_session();
		
		$this->load->model('ctype_m','model');
		$this->load->library('avoslibrary');
			$this->load->library('pagination');
	}
	
	function index($offset=0) {

		
		$models = $this->model->get_all_headType(); 
		
		$this->load->library('pagination');
//		
		$config['base_url'] = site_url('admin/coupontypes/index/');
		$config['total_rows'] = count($models);

		$config['per_page'] = 20; 
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = '<p>'; 
 		$config['full_tag_close'] = '</p>'; 
	
		$this->pagination->initialize($config); 
		
		$data['title'] = '优惠券类型管理';
		$data['main'] = 'admin_coupontypes_home';

		$data['models'] = $models;
	
//		var_dump($data['models']);
		$this->load->view($this->config->item('admin_template'),$data);
		
	}

	
	function create($parentId=''){
		
		//处理post的值
		if($this->input->post('title')){
//			var_dump($_POST);

			
			$title = $this->input->post('title');
			$parentId = $this->input->post('parentId');
			$continuous = $this->input->post('continuous');


			if (empty($parentId)){
				//一级类型
				$objectId = $this->model->create(array('title'=>$title));

			}
			else{
				//二级类型
				$objectId = $this->model->create(array('title'=>$title,'parent'=>avosPointer('CouponType',$parentId)));
			}
			
			if (empty($continuous)){
				// redirect to index
				$this->session->set_flashdata('msg','创建成功');			
				redirect('admin/coupontypes/index','refresh');
				
			}
		}
		
		// display form
		$data['title'] = '新建类型';
		$data['main'] = 'admin_coupontypes_create';

		if (!empty($parentId)){
			$data['parentId']=$parentId;
		}
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
	
	function subtypes($id){
			$data['title'] = '子类型';
			$data['main'] = 'admin_coupontypes_subtypes';
			$data['models'] = $this->model->get_subTypes($id);
			$data['parentId']=$id;

			$this->load->view($this->config->item('admin_template'),$data);;
	}
	
	/**
	 * 
	 * 删除
	 * @param integer $id
	 */
	function delete($id,$parentId=''){
		
		
		if($this->model->delete($id,$parentId)){
			
			
			$this->session->set_flashdata('msg','删除成功');
			redirect('admin/coupontypes/index','refresh');
		}
				
		
	}
	

	
}