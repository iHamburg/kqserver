
<h1>Create Product</h1>
<?php 

echo form_open_multipart('admin/products/create');
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
echo form_label('Upload image').'<br/>';
echo form_upload(array('name'=>'image','id'=>'uimage'));
echo '<br/>';
echo form_label('Grouping').'<br/>';
echo form_input(array('name'=>'grouping','id'=>'group','size'=>10));
echo form_submit('submit','create product');
echo form_close();