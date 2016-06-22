
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
		        <h4>加盟须知</h4>
		   </div>
		   <div class="box-body">	
		   
		   <div class="row">
			 <div class="col-xs-12">	 				
              <p class="text-justify"><strong>一、入驻</strong></p>
			<p class="text-justify">1.	我洗车开放平台面向全国各大中城市诚招加盟车行。
			</p>
            <p class="text-justify">2.	我洗车开放平台有权根据包括地区需求、车行经营状况、服务水平等因素退回车行申请。</p>	
            <p class="text-justify">3.	我洗车开放平台有权在申请加盟时要求卖家提供资质。</p>	
			<p class="text-justify">4.	我洗车开放平台将结合洗车行业发展动态、国家相关规定及消费者需求，不定期更新招商标准。</p>	
            <p class="text-justify">5.	请务必确保申请加盟及后续经营阶段提供的相关资质和信息的真实性、完整性、有效性，一旦发现虚假资质或信息的，我洗车开放平台将不再与车行进行合作并有权根据与车行签署的相关协议之约定进行处理。</p>	
			<p class="text-justify"><strong>二、 加盟费</strong></p>
			<p class="text-justify">1.	车行依照与我洗车签署的相关协议使用我洗车开放平台各项服务时缴纳的固定服务费用。新加盟车行须在申请加盟获得批准后购买服务卡，并一次性缴纳相应服务期间的加盟费用；</p>
            <p class="text-justify">2.	车行主动要求停止服务的不返还加盟费；</p>	
            <p class="text-justify">3.	车行因违规行为或资质造假被清退的不返还加盟费。</p>			
             </div>
           </div>
           </div>
         </div>			 
	   </div>
	</div>
	<?php
Yii::app ()->clientScript->registerScript ( 'changeMenuStyle', "
 $('#mhelp').addClass('active');
$('#smjoin_readme').addClass('active');

", CClientScript::POS_READY );

?>	