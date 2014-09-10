<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Testqiniu extends CI_Controller {

	


	function __construct(){
		parent::__construct();
		
		//$this->load->helpers(array('rs','http','auth_digest','conf','utils','resumable_io_helper'));
	}
	
	public function index()
	{
		echo 'tushare';
		
		//
	}
	
 	public function message($to = 'World')
	  {
	    echo "Hello {$to}!".PHP_EOL;
	  }
	
	  
	function export(){
	
		$data['pics'] = nil;
		$this->load->view('tushare',$data);
	}

	function qiniu(){
	
		echo 'qiniu';

		$bucket = "xappqiniu";
		$key = "apartment_1.jpg";
		$accessKey = 'f9zK0PZeWtFNGY5lxrXeOM6MphG2xxNYBuXv6fGn';
		$secretKey = 'PFSvanHSINAYXoW_-PBTUUNpkA7IU-w7q3pQ1JNj';
		
		Qiniu_SetKeys($accessKey, $secretKey);
		$client = new Qiniu_MacHttpClient(null);
		list($ret, $err) = Qiniu_RS_Stat($client, $bucket, $key);
		echo "Qiniu_RS_Stat result: \n";
		if ($err !== null) {
		    var_dump($err);
		} else {
		    var_dump($ret);
		}

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */