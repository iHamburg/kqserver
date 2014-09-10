<?php

$search = $this->input->post('searchterm');
echo 'search :'.$search.'<br/>'; 
if($search === false){
	redirect('','refresh');
}

echo form_open('hello/search');
echo form_hidden('id', '414');
echo form_hidden('searchtype', 'basic');

$data = array(
'name'=> 'searchterm',
'id' => 'search',
'maxlength' => '100',
'size' => '50',
'style' => 'background-color:#f1f1f1'
);
echo form_input($data);

$values = array(
'high' => 'high',
'medium' => 'medium',
'low' => 'low'
);
echo form_dropdown('priority', $values, 'medium');
echo form_submit('submit', 'search');
echo form_close();

echo anchor('news','Start news!!');