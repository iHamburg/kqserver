<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	


	function __construct(){
		parent::__construct();
		
//		session_start();
		
		$this->load->library('table');
		
	}
	
	public function index()
	{
		echo 'base:'.base_url();
		$this->load->view('welcome_message');
	}
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */