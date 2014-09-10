<?php 

echo form_open('admin/categories/create');
echo form_label('Name').'<br/>';
echo form_input(array('name'=>'name','id'=>'catname','size'=>25));
echo '<br/>';
echo form_label('Short Description').'<br/>';
echo form_input(array('name'=>'shortdesc','id'=>'short','size'=>40));
echo '<br/>';
echo form_label('Long Description').'<br/>';
echo form_textarea(array('name'=>'longdesc','id'=>'long','rows'=>5,'cols'=>40));
echo '<br/>';
echo form_label('Status').'<br/>';
echo form_dropdown('status', array('active'=>'active','inactive'=>'inactive'));
echo '<br/>';
echo form_label('Category parent').'<br/>';
echo form_dropdown('parentid', $categories);
echo '<br/>';
echo form_submit('submit','create category');
echo form_close();