
<h1><?php echo $title;?></h1>
<div class="row">
		
		<div class="col-md-10">
<?php 	
		if($this->session->flashdata('msg')){
			echo "<div class='message'>".$this->session->flashdata('msg')."</div>";	
		}
		?>
	

 <a href="<?php echo site_url('admin/coupons/create');?>" class="btn btn-primary">新建优惠券</a>
	 <br/>
	<br/>
		
	<table class='table table-striped table-bordered table-hover table-responsive'>
	<tr><th>编号</th><th>名称</th><th>管理</th></tr>	
	<?php 
	foreach ($models as $key => $list) {
//		$subtypecount = count($list['shopBranches']);
	?>
		
	<tr>
		<td><?php echo $list['objectId'];?></td>
		<td><?php echo $list['title'];?></td>
		<td align="center"><?php echo anchor('admin/coupons/edit/'.$list['objectId'],'编辑')." | ".anchor('admin/coupons/delete/'.$list['objectId'],'删除');?></td>
	</tr>
		
	<?php }?>	
	</table>
	
	<?php echo $this->pagination->create_links()?>
		
	
	</div>
</div>