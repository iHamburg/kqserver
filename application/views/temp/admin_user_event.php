

<?php
	echo "<table class='table table-striped table-bordered table-hover table-responsive'>";
			
			$headers = array('活动编号','活动名称','活动时间');
			echo "<tr>";
			foreach ($headers as $header) {
				echo "<th>".$header."</th>";
			}
			echo "</tr>";
			foreach ($events as $key => $list) {
				echo "<tr>";
				echo "<td>".$list['id']."</td>";
				echo "<td>".$list['name']."</td>";
				echo "<td>".$list['date']."</td>";
//				echo "<td align='center'>".anchor('admin/users/events/'.$list['id'],'参加活动')."</td>";
				echo "</tr>";
				
			}
			echo "</table>";