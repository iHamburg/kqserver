<?php
class Admin_m extends MY_Model{
	
	public $_table = 'admins';
	protected $return_type = 'array';

	
	/**
	 * 
	 * 如果登陆成功，加入session， 如果不成功 flashdata： error
	 * @param string $u
	 * @param string $pw
	 */

	
	function login($u,$pw) {
		$query = $this->db->get_where('admins',array('username'=>$u,'password'=>$pw));
		if($query->num_rows()>0){
			
			//成功verify, session中加入userid & username
			$row = $query->row_array();
			
			
			$_SESSION['username']=$row['username'];
			
			return $row;
		}
		else{
			//没有成功
			
			unset($_SESSION['username']);

			$this->session->set_flashdata('error','抱歉，用户名或密码错误');

		}
	}
	
}