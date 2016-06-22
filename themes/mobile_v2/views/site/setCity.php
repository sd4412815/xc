<?php
$this->pageTitle = '';
?>
<div class="row">
	<div class="col-xs-12">
		<h4 class="text-yellow text-center">
			切换至：
			<span class="btn btn-item current">
				<span id="current_city"  class="h4"></span>
			</span>
		</h4>

	</div>
</div>
<div class="citylist">	
<?php
$cityId = UPlace::getCityId ();
$provinceList = Province::model ()->getProvinceList ( TRUE );

foreach ( $provinceList as $key => $province ) :
	?>
<div class="row">
		<div class="col-xs-3 text-right">
			<b><?php echo $province['p_name'];?><code><?php echo strtoupper(substr($province['p_spell'],0,1)); ?></code>：</b>
		</div>
		<div class="col-xs-9 text-left">
<?php
	$cityList = City::model ()->getCityList ( $province ['id'], FALSE );
	foreach ( $cityList as $index => $city ) :
		?>	
	   
  <a class="btn btn-item <?php echo $city['id']==$cityId? 'current': ''?>  <?php echo $city['c_state']<1?'disabled' : 'enable';?> "
				data-value='<?php echo $city['id'];?>' name="cityname"><?php echo $city['c_name'];?></a>		
<?php endforeach;?>
	</div>
	</div>
	<br>
<?php endforeach;?>	
</div>

<?php

Yii::app ()->clientScript->registerScript ( 'setcity', "
set_city_ini();			   			   		
		", CClientScript::POS_READY);


?>