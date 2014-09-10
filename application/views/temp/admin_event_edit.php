<h1><?php echo $title;?></h1>


<form action="<?php echo site_url('admin/events/edit')?>" method="post" class="form-horizontal well" enctype="multipart/form-data">
<div class='form-group'>
	<label class="control-label">活动名称</label>
	<input type="text" name="name" value="<?php echo $event['name']?>" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">活动类型</label>
	<input type="text" name="tag" value="<?php echo $event['tag']?>" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">活动图片</label>
	<input type="file" name="image" value="" class="form-control"/>
	<?php 
		if(!empty($event['image'])){
			
			// imagename
//			echo "<span class='help-block'>abcdef.jpg</span>";
			// preview image
			$imgurl = base_url($event['image']);
			echo "<img src='".$imgurl."'/>";
		}
	?>
</div>
<div class='form-group'>
	<label class="control-label">活动介绍</label>
	<textarea name="description" class="form-control" rows="5"><?php echo $event['description']?></textarea>
</div>
<div class='form-group'>
	<label class="control-label">活动主办</label>
	<input type="text" name="sponsor" value="<?php echo $event['sponsor']?>" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">活动日期</label>
	<input type="date" name="date" value="<?php echo $event['date']?>" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">活动时间</label>
	<input type="time" name="time" value="<?php echo $event['time']?>" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">活动地点</label>
	<input type="text" name="location" value="<?php echo $event['location']?>" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">活动费用</label>
	<input type="text" name="cost" value="<?php echo $event['cost']?>" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">活动人数</label>
	<input type="number" name="population" value="<?php echo $event['population']?>" class="form-control"  />
</div>
<div class='form-group'>
	<label class="control-label">活动流程</label>
	<textarea name="flow" class="form-control" rows="5"><?php echo $event['flow']?></textarea>
</div>
<div class='form-group'>
<label class="control-label">其他内容</label>  
<!--    <div id="alerts"></div>-->
    <div class="btn-toolbar" data-role="editor-toolbar" data-target="#contenteditor">
      <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
          <ul class="dropdown-menu">
          </ul>
        </div>
      <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
          <ul class="dropdown-menu">
          <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
          <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
          <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
          </ul>
      </div>
      <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Color"><i class="icon-tint"></i>&nbsp;<b class="caret"></b></a>
          <ul class="dropdown-menu">
          <li><a data-edit="foreColor #000000"><font size="3" color="000000">Black</font></a></li>
          <li><a data-edit="foreColor #ff0000"><font size="3" color="ff0000">Red</font></a></li>
          <li><a data-edit="foreColor #00ff00"><font size="3" color="00ff00">Green</font></a></li>
          <li><a data-edit="foreColor #0000ff"><font size="3" color="0000ff">Blue</font></a></li>
	  <li><a data-edit="foreColor #FFCC00"><font size="3" color="ffcc00">Yellow</font></a></li>
          </ul>
	  </div>
      <div class="btn-group">
        <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
        <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
        <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
        <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
        <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
        <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
        <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
        <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
        <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
        <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
      </div>
      <div class="btn-group">
		  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>
		    <div class="dropdown-menu input-append">
			    <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
			    <button class="btn" type="button">Add</button>
        </div>
        <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="icon-cut"></i></a>

      </div>
      
      <div class="btn-group">
        <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="icon-picture"></i></a>
        <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
        <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
      </div>

    </div>

      <div id="contenteditor"  class="form-control editor"><?php echo $event['content']?></div>
      <span class="help-block">注意：每张上传的图片大小不要超过100k</span>
 </div>
 <div class='form-group'>
	<label class="control-label">微信群二维码图片</label>
	<input type="file" name="qrimage" value="" class="form-control"/>
	<?php 
		if(!empty($event['qrimage'])){
			
			// imagename
//			echo "<span class='help-block'>abcdef.jpg</span>";
			// preview image
			$imgurl = base_url($event['qrimage']);
			echo "<img src='".$imgurl."'/>";
		}
	?>
</div>
<!--  <span class="help-block">注意：每张上传的图片大小不要超过100k</span>-->
<input type="hidden" name="content" value="content" id="content"  />
<input type="hidden" name="id" value="<?php echo $event['id']?>" />
<input type="submit" name="" value="提交" class="btn btn-primary"  />
<!--<a class="btn btn-primary" target="_blank" href="<?php echo site_url('events/enrollajaxapi/'.$event['id'])?>">预览</a>-->
<a class="btn btn-primary"  href="<?php echo site_url('admin/events/delete/'.$event['id'])?>">删除</a>
</form>


