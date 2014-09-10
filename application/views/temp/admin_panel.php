<div class="panel-group" id="accordion">
  
  <?php 
  	foreach ($paneldata as $pdata) {
  		?>
   <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
  		 <a  data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          <?php echo $pdata['title']?>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
     
     	 <ul class="list-group">
		  <li class="list-group-item"><a href="#">Cras justo odio</a></li>
		  <li class="list-group-item">Dapibus ac facilisis in</li>
		  <li class="list-group-item">Morbi leo risus</li>
		  <li class="list-group-item">Porta ac consectetur ac</li>
		  <li class="list-group-item">Vestibulum at eros</li>
		</ul>

    </div>
  </div>
  		
  		<?php 
  	}
  ?>
  </div>
<!--  -->
<!--  <div class="panel panel-default">-->
<!--    <div class="panel-heading">-->
<!--      <h4 class="panel-title">-->
<!--        <a  data-toggle="collapse" data-parent="#accordion" href="#collapseOne">-->
<!--          微信管理-->
<!--        </a>-->
<!--      </h4>-->
<!--    </div>-->
<!--    <div id="collapseOne" class="panel-collapse collapse in">-->
<!--     -->
<!--     	 <ul class="list-group">-->
<!--		  <li class="list-group-item"><a href="#">Cras justo odio</a></li>-->
<!--		  <li class="list-group-item">Dapibus ac facilisis in</li>-->
<!--		  <li class="list-group-item">Morbi leo risus</li>-->
<!--		  <li class="list-group-item">Porta ac consectetur ac</li>-->
<!--		  <li class="list-group-item">Vestibulum at eros</li>-->
<!--		</ul>-->
<!---->
<!--    </div>-->
<!--  </div>-->
<!--  -->
<!--  <div class="panel panel-default">-->
<!--    <div class="panel-heading">-->
<!--      <h4 class="panel-title">-->
<!--        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">-->
<!--         活动管理-->
<!--        </a>-->
<!--      </h4>-->
<!--    </div>-->
<!--    <div id="collapseTwo" class="panel-collapse collapse">-->
<!--      <ul class="list-group">-->
<!--		  <li class="list-group-item"><a href="#">Cras justo odio</a></li>-->
<!--		  <li class="list-group-item">Dapibus ac facilisis in</li>-->
<!--		  <li class="list-group-item">Morbi leo risus</li>-->
<!--		  <li class="list-group-item">Porta ac consectetur ac</li>-->
<!--		  <li class="list-group-item">Vestibulum at eros</li>-->
<!--		</ul>-->
<!--    </div>-->
<!--  </div>-->
<!--  <div class="panel panel-default">-->
<!--    <div class="panel-heading">-->
<!--      <h4 class="panel-title">-->
<!--        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">-->
<!--         租房管理-->
<!--        </a>-->
<!--      </h4>-->
<!--    </div>-->
<!--    <div id="collapseThree" class="panel-collapse collapse">-->
<!--       <ul class="list-group">-->
<!--		  <li class="list-group-item"><a href="#">Cras justo odio</a></li>-->
<!--		  <li class="list-group-item">Dapibus ac facilisis in</li>-->
<!--		  <li class="list-group-item">Morbi leo risus</li>-->
<!--		  <li class="list-group-item">Porta ac consectetur ac</li>-->
<!--		  <li class="list-group-item">Vestibulum at eros</li>-->
<!--		</ul>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->