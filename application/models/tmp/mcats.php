<?php
require_once('crud_model.php');

class Mcats extends Crud_model{
	
	public function __construct(){
		parent::__construct();

		if(empty($this->table)){
			$this->table = 'categories';
			$this->cols = array('name');
		}
	
	}
	
	/**
	 * 
	 * 顶级category
	 * @return array|false: id->name
	 */
	function getCategoriesNav(){
		
		$this->db->where('parentid <','1');
		$this->db->where('status','active');
		
		$query = $this->db->get('categories');
		
		if($query->num_rows()>0){
			foreach ($query->result() as $row){
				$data[$row->id] = $row->name;
			}
			
			$query->free_result();
			return $data;
		}
		
		return FALSE;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param integer $catid
	 * @return array 
	 * 			array(array(category))
	 */
	function getSubCategories($catid) {
			
		$query = $this->db->get_where('categories',array('parentid'=>$catid,'status'=>'active'));
	
		if($query->num_rows()>0){
			
			foreach ($query->result_array() as $row){
				$data[] = $row;
			}
			
			$query->free_result();
			return $data;
		}
		
		
	
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @return array
	 * 			array(id=>name)
	 */
	function getTopCategories(){
		$query = $this->db->get_where('categories',array('parentid'=>0,'status'=>'active'));
		
		if($query->num_rows()>0){
			
			foreach ($query->result_array() as $row){
				$data[$row['id']] = $row['name'];
			}
			
			$query->free_result();
			return $data;
		}
	}


	
	/**
	 * 
	 * 不是topcategory
	 */
	function getProductCategories(){
		
		$this->db->where('parentid >',0);
		$query= $this->db->get('categories');
		
		if($query->num_rows()>0){
			foreach ($query->result_array() as $row) {
				$data[$row['id']]=$row['name'];
			}
			
			$query->free_result();
			return $data;
		}
	}
	
	
	function testConfig(){
		
		$this->title = 'aaa';
		return $this->title;
		
//		$data = $this->config->item('base_url'); 
//		return $data;
	}
}