<?php
class Crud_model extends CI_Model{
	
	/**
	 * 
	 * 确定操作哪个table
	 * @var string
	 */
	static public $table;
	/**
	 * 
	 * colums names
	 * @var array
	 */
	static public $cols;
	
	function create($data) {
		$this->db->insert($this->table,$data);
	}
	
	function retrieve_all(){
//		$this->db->cache_on();
		$query = $this->db->get($this->table);
			
		 if($query->num_rows>0){
			$data = $query->result_array();
			$query->free_result();
			return $data;
		 }
	}
	
	function retrieve($id){

		$query = $this->db->get_where($this->table, array('id' => $id));
		 
		 if($query->num_rows>0){
		 	$data = $query->row_array(); 
		 	$query->free_result();
	     	return $data;
		 }
	}
	
	
	function update($data){
		$this->db->where('id',$data['id']);
		$this->db->update($this->table,$data);
	}
	
	function delete($id) {
		$this->db->delete($this->table, array('id' => $id)); 
	}
}