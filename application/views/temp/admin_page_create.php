
<?php echo $this->tinyMce;?>
<h1>Create Page</h1>
<?php 

echo form_open_multipart('admin/pages/create');

echo form_label('Name').'<br/>';
echo form_input(array('name'=>'name','id'=>'catname','size'=>25));
echo '<br/>';
echo form_label('Keywords').'<br/>';
echo form_input(array('name'=>'keywords','id'=>'short','size'=>40));
echo '<br/>';
echo form_label('Description').'<br/>';
echo form_input(array('name'=>'description','id'=>'desc','size'=>40));
echo '<br/>';
echo form_label('Path/URL').'<br/>';
echo form_input(array('name'=>'path','id'=>'desc','size'=>40));
echo '<br/>';
echo form_label('Status').'<br/>';
echo form_dropdown('status', array('active'=>'active','inactive'=>'inactive'));
echo '<br/>';
echo form_label('Content').'<br/>';
echo form_textarea(array('name'=>'content','id'=>'long','rows'=>5,'cols'=>40));
echo '<br/>';
echo form_submit('submit','create product');
echo form_close();