<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	


	function __construct(){
		parent::__construct();
		
		
		
	}
	
	public function index()
	{
		echo 'base:'.base_url();
		echo 'test';
		echo 'ssssss';
		$this->load->view('welcome_message');
	}
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */