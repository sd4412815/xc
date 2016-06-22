
   <div class="row">
       <div class="col-sm-2 col-lg-offset-1 skin-blue">
	   <?php 
	     
	     $this->renderPartial('pages/_sideMenu');
	     ?>
	   </div>
	   <div class="col-sm-10 col-lg-8"> 
          <div class="box box-warning">
		   <div class="box-body">	
		   
		   <div class="row">
			 <div class="col-xs-12">	   
				<h4>电话：024-83997646</h4>  
				<h4>邮箱：contact@woxiche.com</h4>  
				<h4>新浪微博：<img src="<?php echo Yii::app()->theme->baseUrl;?>/img/weibo.png" style="width:94px;"/></h4>  
				<h4>微信平台：<img src="<?php echo Yii::app()->theme->baseUrl;?>/img/erwei.png" style="width:100px;"/></h4> 
             </div>
           </div>
           </div>
         </div>			 
	   </div>
	</div>
	<?php
Yii::app ()->clientScript->registerScript ( 'changeMenuStyle', "
 $('#mhelp').addClass('active');
 $('#smaboutus').addClass('active');
", CClientScript::POS_READY );

?>	