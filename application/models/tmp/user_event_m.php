<?php
class User_event_m extends MY_Model{

	public $_table = 'user_event';
	protected $return_type = 'array';
	
	public function __construct(){
		parent::__construct();
		
	}

	public function has_user_event($userid=0,$eventid=0){
		$row = $this->get_by(array('userid'=>$userid,'eventid'=>$eventid));
		
		if(empty($row))
			return 0;
		else 	
			return 1;
	}
	
	/**
	 * 
	 * 报名成功 return 1, else -1
	 * @param unknown_type $userid
	 * @param unknown_type $eventid
	 * @return integer 
	 */
	public function enroll($userid=0, $eventid=0){
		
		if($userid==0 || $eventid==0){
			return -1;
		}
		
		//获得当前时间
		$currenttime = time();
		$data = array('userid'=>$userid,'eventid'=>$eventid,'enroll_time'=>$currenttime);

		$this->insert($data);
		$insertid = $this->db->insert_id();
		$affectedrows = $this->db->affected_rows();
		
//		echo "insert: $insertid, affected: $affectedrows";
		if($insertid>0){
			return $insertid;
		}
		else{
			return -1;
		}
	}
	
	/**
	 * 
	 * 
	 * @param integer $eventid
	 * @param integer $num_of_user
	 * @return array of userid,username,enrolltime
	 */
	public function get_userinfos_for_event($eventid=0,$num_of_user=10){
		
		
		$query = $this->db->query('SELECT A.id,A.realname,B.enroll_time 
		FROM weixin_user as A  
		left join `user_event` as B 
		on A.id=B.userid 
		WHERE B.eventid='.$eventid.'
		ORDER BY B.enroll_time DESC'.'
		LIMIT 0,'.$num_of_user );
		
		 if($query->num_rows>0){
				$data = $query->result_array();
				$query->free_result();
				return $data;
		 }

	}

	function get_user_number_for_event($eventid){
		$query = $this->db->query('SELECT count(*) as count FROM `user_event` where eventid='.$eventid );
		
		 if($query->num_rows>0){
				$data = $query->result_array();
				$query->free_result();
				return $data;
		 }
		
	}
	

	
	/**
	 * 
	 * 返回user所有参加的活动
	 * @param unknown_type $userid
	 */
	function get_all_events($userid) {
	$query = $this->db->query('SELECT A.* FROM event as A, `user_event` as B where B.userid='.$userid.' and A.id=B.eventid');
		
		 if($query->num_rows>0){
			$data = $query->result_array();
			$query->free_result();
			return $data;
		 }
	}
	
}