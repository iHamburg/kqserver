<?php
class Event_m extends MY_Model{

	public $_table = 'event';
	protected $return_type = 'array';
	
	public function __construct(){
		parent::__construct();
		
	}
	
	
	/**
	 * 
	 * @return array of user records
	 * 
	 * @param integer $id
	 */
	function get_all_participation($id) {
		$query = $this->db->query('SELECT A.*,B.enroll_time FROM weixin_user as A, `user_event` as B where B.eventid='.$id.' and A.id=B.userid');
		
		 if($query->num_rows>0){
			$data = $query->result_array();
			$query->free_result();
			return $data;
		 }
	}
	
	function get_applicants_numbers($eventid){
		
		$data = $this->user_event_m->get_user_number_for_event($eventid);
		
		return $data[0]['count'];
	}
	
	function get_applicants($eventid,$number=20){
		
		$applicants=$this->user_event_m->get_userinfos_for_event($eventid,$number);
		
		return $applicants;
		
	}
	
	/**
	 *  return a single record
	 *  
	 */
	function get_latest_event(){
		
		$query = $this->db->query('SELECT * FROM `event` WHERE `datetime` >= now() order by datetime limit 1');

		 if($query->num_rows>0){

		 	foreach ($query->result_array() as $row) {
		 		$data=$row;
		 	}
		 				
			$query->free_result();
			return $data;
		 }
	}
	
	
	function get_latest_many_event($num){
		$query = $this->db->query('SELECT id,name,datetime,image FROM `event` WHERE `datetime` >= now() order by datetime limit '.$num);

		 if($query->num_rows>0){

		 	foreach ($query->result_array() as $row) {
		 		$data[]=$row;
		 	}
		 				
			$query->free_result();
			return $data;
		 }
	}

	function get_events_by_page($page=0){
	$events_in_page=10;
	$query = $this->db->query('SELECT id,name,datetime,image FROM `event`  order by datetime desc limit '.$events_in_page);

		 if($query->num_rows>0){

		 	foreach ($query->result_array() as $row) {
		 		$data[]=$row;
		 	}
		 				
			$query->free_result();
			return $data;
		 }
	}
	
	
	function get_events_begin_with($offset=0,$limit=10){
	
		$query = $this->db->query('SELECT id,name,datetime,image,tag FROM `event`  order by datetime desc limit '.$offset.','.$limit);

		 if($query->num_rows>0){

		 	foreach ($query->result_array() as $row) {
		 		$data[]=$row;
		 	}
		 				
			$query->free_result();
			return $data;
		 }
	}

}