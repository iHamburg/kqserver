<?php
require_once('crud_model.php');

class Mproducts extends Crud_model{


	
	public function __construct(){
		parent::__construct();
		$this->table = 'products';
	}
	
//	public function getProduct($id=FALSE){
//	
//		if($id===FALSE){
//			return $this->getAllProducts();
//		}
//		
//		 $query = $this->db->get_where('products', array('id' => $id));
//		 
//		 $data = $query->row_array(); 
//		 $query->free_result();
//	     return $data;
//	}
//	
//	public function getAllProducts(){
//	
//		$query = $this->db->get('products');
//			
//			$data = $query->result_array();
//			$query->free_result();
//			return $data;
//	}
	
	/**
	 * 
	 * 现在只返回row_array
	 * @return array
	 */
	public function getMainFeature(){
		
		
		
		$this->db->select("id,name,shortdesc,image");
//		$this->db->where('featured','true');
//		$this->db->where('status','active');

		$this->db->where(array('featured'=>'true','status'=>'active'));
		$this->db->order_by("rand()");
		$this->db->limit(1);
		
		$query = $this->db->get('products');
		
		if($query->num_rows()>0){
//			foreach ($query->result_array() as $row){
//				$data = $row;
//			}
			$data = $query->row_array();
		}
		
		return $data;
	}
	
	/**
	 * 
	 * get random products 
	 * @param integer $limit
	 * @param integer $skip
	 * @return array of array
	 * Array ( [id] => 12 [name] => Pants 1 [thumbnail] => /images/dummy-thumb.jpg [category_id] => 3 ) 
	 */
	
	public function getRandomProducts($limit, $skip){

		if($limit == 0)
			$limit = 3;
			
		$this->db->select("id,name,thumbnail,category_id");
		$this->db->where('id !=',$skip);
		$this->db->where('status','active');
//		$this->db->order_by("category_id","asc");
//		$this->db->limit(100);
		$this->db->order_by("rand()");
		$this->db->limit($limit);
		
		$query = $this->db->get('products');
		
		if($query->num_rows()>0){
			foreach ($query->result_array() as $row){
				$data[] = $row;
			}
			
		}
		
		return $data;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param integer $catid
	 * @return array array(array(product))
	 */
	function getProductsByCatid($catid){
		
		$this->db->select("id,name,thumbnail,category_id,shortdesc");
		$this->db->where('category_id',$catid);
		$this->db->where('status','active');
		
		$query = $this->db->get('products');
		
		
		if($query->num_rows()>0){
			
			return $query->result_array();
		}		

	}
	
//	function addProduct($data){
//		
//		$this->db->insert('products',$data);
//	}
	
	function producttest(){
//		$this->mock = 'mock';
//		return $this->mock;
	}
	
}