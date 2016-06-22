<?php
$this->pageTitle = '当前城市';
?>
    <div class="row" >
	    <div class="col-xs-12">
		   <h4 class="text-yellow text-center">当前城市：<code><span id="current_city" class="h3"></span></code></h4>
		     
		</div>
	</div>
<div class="citylist">	
<?php 
$cityId = UPlace::getCityId();
$provinceList = Province::model()->getProvinceList(TRUE);

foreach ($provinceList as $key=>$province):
?>
<div class="row" >	
	<div class="col-xs-3 text-right" ><b><?php echo $province['p_name'];?><code><?php echo strtoupper(substr($province['p_spell'],0,1)); ?></code>：</b></div>
	<div class="col-xs-9 text-left">
<?php
$cityList = City::model()->getCityList($province['id'],FALSE);
foreach ($cityList as $index=>$city):
?>	
	   
  <a class="btn <?php echo $city['id']==$cityId? 'btn-app1': 'btn-app'?> btn-app <?php echo $city['c_state']<1?'disabled' : 'enable';?> " data-value='<?php echo $city['id'];?>' name="cityname"><?php echo $city['c_name'];?></a>		
<?php endforeach;?>
	</div>	
	</div><br >
<?php endforeach;?>	
</div>
	
 <?php 

   Yii::app ()->session ['send_code'] = UTool::randomkeys ( 6 );

Yii::app()->clientScript->registerScript('citychoose',
"
$(\"a[name='cityname']\").click(function(){
$('.citylist').find('.btn-app1').addClass('btn-app');
$('.citylist').find('.btn-app1').removeClass('btn-app1');
 $(this).addClass('btn-app1');
 $(this).removeClass('btn-app');
$('#current_city').html($('.citylist').find('.btn-app1').html());
	document.cookie='_ucid='+$('.citylist').find('.btn-app1').data('value')+';path=/';
});
$('#current_city').html($('.citylist').find('.btn-app1').html());		   		
		",CClientScript::POS_READY);


?>