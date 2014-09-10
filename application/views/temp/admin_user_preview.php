<?php
	echo "<table class='table table-striped table-bordered table-hover table-responsive'>";
			
			$headers = array('会员编号','会员昵称','open_id','会员管理');
			echo "<tr>";
			foreach ($headers as $header) {
				echo "<th>".$header."</th>";
			}
			echo "</tr>";
				$list = $user;
				echo "<tr>";
				echo "<td>".$list['id']."</td>";
				echo "<td>".$list['username']."</td>";
				echo "<td>".$list['openid']."</td>";
				echo "<td align='center'>".anchor('admin/users/participate/'.$list['id'],'参加活动')."</td>";
				echo "</tr>";
				
			
			echo "</table>";