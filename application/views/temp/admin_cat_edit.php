<?php 

echo form_open('admin/categories/edit');
echo form_label('Name').'<br/>';
echo form_input(array('name'=>'name','id'=>'catname','value'=>$category['name'],'size'=>25));
echo '<br/>';
echo form_label('Short Description').'<br/>';
echo form_input(array('name'=>'shortdesc','id'=>'short','value'=>$category['shortdesc'],'size'=>40));
echo '<br/>';
echo form_label('Long Description').'<br/>';
echo form_textarea(array('name'=>'longdesc','id'=>'long','value'=>$category['longdesc'],'rows'=>5,'cols'=>40));
echo '<br/>';
echo form_label('Status').'<br/>';
echo form_dropdown('status', array('active'=>'active','inactive'=>'inactive'),$category['status']);
echo '<br/>';
echo form_label('Category parent').'<br/>';
echo form_dropdown('parentid', $categories,$category['parentid']);
echo '<br/>';
echo form_hidden('id',$category['id']);
echo form_submit('submit','update category');
echo form_close();