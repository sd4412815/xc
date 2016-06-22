
<div class="row">

   </div>
   <!-- 左侧导航 -->
   <div class="row">
       <div class="col-sm-2 col-lg-offset-1 skin-blue">
	     <?php 
	     
	     $this->renderPartial('pages/_sideMenu');
	     ?>
	   
	   </div>
	   <div class="col-sm-10 col-lg-8"> 
          <div class="box box-warning">
		   <div class="box-head">
		        <h4> &nbsp&nbsp用户等级说明</h4>
		   </div>
		   <div class="box-body">	
		   
		   <div class="row">
			 <div class="col-sm-8">
			 <img width="100%" alt="" src="<?php echo Yii::app()->theme->baseUrl?>/img/score.png">
             
                		
             </div>
           </div>
           </div>
         </div>			 
	   </div>
	</div>
	

<?php
Yii::app ()->clientScript->registerScript ( 'changeMenuStyle', "
 $('#mhelp').addClass('active');
$('#smlevel').addClass('active');		
		
", CClientScript::POS_READY );

?>	