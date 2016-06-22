
   <div class="row">
       <div class=" col-sm-2 col-lg-offset-1 skin-blue">
	          <?php 
	     
	     $this->renderPartial('pages/_sideMenu');
	     ?>
	   
	   </div>
	   <div class="col-sm-10 col-lg-8"> 
          <div class="box box-warning">
		   <div class="box-head">
		        <h4> &nbsp&nbsp特色服务标识</h4>
		   </div>
		   <div class="box-body">	
		   
		  			
                <p><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/zuan.png" />  带有此标识的车行是购买了我洗车网站钻石服务卡的车行，钻石卡服务时长为2年，是和我洗车长期合作的稳定商家。</p>
				<p><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/jin.png" />  带有此标识的车行是购买了我洗车网站金卡服务卡的车行，金卡服务时长为1年。</p>
				<p><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/yin.png" />  带有此标识的车行是购买了我洗车网站银卡服务卡的车行，银卡服务时长为6个月。</p>
				<p><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/shi.png" />  带有此标识的车行是购买了我洗车网站体验卡的车行，体验卡服务时长为2个月。</p>
				<p><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/bao.png" />  带有此标识的车行已在我洗车抵押了保证金，车主可以放心在该车行购买“我洗车预定次卡”。如果在有“我洗车预定次卡”未使用的情况下，该车行失去服务能力，不能退款给车主，我洗车将承担车主的损失。</p>
				<p><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/shou.png" />  带有此标识的车行有免费“首次预定优惠卡”发放。</p>
				<p><img src="<?php echo Yii::app()->theme->baseUrl;?>/img/ci.png" />  带有此标识的车行有“次卡”出售。</p>
				<p> <label class="label label-primary" title="免费WIFI">网</label>  带有此标识的车行为车主提供免费WIFI网络。</p>
				<p><label class="label label-success" title="休息室">室</label> 带有此标识的车行为车主提供休息室。</p>
				<p><label class="label label-info" title="免费赠饮">饮</label>  带有此标识的车行为车主提供免费咖啡饮料。</p>	
				<p><label class="label label-warning" title="免费停车">P</label>  带有此标识的车行为车主提供免费停车位。</p>	
				<p><label class="label label-primary" title="专用毛巾">专</label>  带有此标识的车行为每个被服务车辆提供专用毛巾。</p>	
				<p><label class="label label-info" title="免费赠品">赠</label>  带有此标识的车行为在线预定到店消费的车主提供赠品。</p>				
          
           </div>
         </div>			 
	   </div>
	</div>
	<?php
Yii::app ()->clientScript->registerScript ( 'changeMenuStyle', "
 $('#mhelp').addClass('active');
$('#smicon').addClass('active');
", CClientScript::POS_READY );

?>	