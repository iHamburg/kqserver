<?php
class Someclass{
	public function display(){
		echo 'some class';
		
		$CI =& get_instance();
		$CI->load->helper('array');
		$arr2 = random_element(array());
		print_r($arr2);
	}
	
	
}

/* End of file Someclass.php */