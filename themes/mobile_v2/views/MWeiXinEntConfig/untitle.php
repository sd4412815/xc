

 			<p><span style="color:#ff9900;font-weight:bold;font-size:14px;">选择服务</span>
						
						<span class="serviceTypeRatio icheck">
					<?php 					
						$shopServices = WashShopService::model()->getServices($shop['id'])['data'];
						foreach ($shopServices as $key=>$service):
						?>		
				<label>
					<input type="radio" name="sType" value="<?php echo $service['wss_st_id'];?>"  
						<?php if ( $sType==$service['wss_st_id']) {						
							echo 'checked';
						}?>   <?php if ($service['wss_state']!=1) {
							echo 'disabled';
						} ?>>
						<span id="sTypeRatioStr1" <?php if ($service['wss_state']!=1):?>
							style="color: #D3D3D3;"
							<?php endif;?>>
						<?php echo  $service->wssSt['st_name'];?>

						</span>   
				</label>				
						
						
<?php endforeach;?>				
</span>   
<?php 
Yii::app()->clientScript->registerScript('getShopCount',"
		function getShopCount(){
		var loadi;

$.ajax({
url:'".Yii::app()->createUrl('mweixinentconfig/getShopCount')."',
	  		dataType: 'json',
		data:{
	  		'id':".$shopId.",
	  'bias':$('input[name=\"serviceDate\"]:checked').val(),
	'sType':$('input[name=\"sType\"]:checked').val(),
	},
 		'beforeSend':function(){ loadi = layer.load(".Yii::app()->params['loadString'].");},
		'error':function(){ layer.msg('加载失败12');},
		'complete':function(){ layer.close(loadi);},
		'success':function(data){
		$('#availableCount').html(data.availableCount);
		$('#totalCount').html(data.totalCount);

}
});
};
		
		",CClientScript::POS_END);
?>

<?php 
 Yii::app()->clientScript->registerScript('dateRatio1',"

		
$('.serviceTypeRatio input').on('ifChecked', function(event){
			getShopCount();
	//	getProcessList();
});	
getShopCount();		
getTimeList();		
                    		",CClientScript::POS_READY);
 ?>  


</p>




  <p><span style="color:#ff9900;font-weight:bold;font-size:14px;">服务日期</span>
					
					<span class="dateRatio icheck">
					<label>    <input type="radio" name="serviceDate" value="0" id="serviceDate0" <?php if ($bias == 0) {
						echo 'checked';
					}?> > 
				<span id="dateRatioStr0"><?php echo  date('m月d日',time());?> </span>	  
				</label>
<label>  <input type="radio" name="serviceDate" value="1" id="serviceDate1" <?php if ($bias == 1) {
						echo 'checked';
					}?> >
<span id="dateRatioStr1"><?php  echo  date('m月d日',time()+24*60*60*1);?> </span>
</label>  
<label>  <input type="radio" name="serviceDate" value="2" <?php if ($bias == 2) {
						echo 'checked';
					}?>  id="serviceDate2"> 
<span id="dateRatioStr2"><?php echo date('m月d日',time()+24*60*60*2);?> </span>
</label> 
 
				</span></p>




				<?php 
 Yii::app()->clientScript->registerScript('dateRatio',"
	
$('.dateRatio input').on('ifChecked', function(event){
		getTimeList();
});	   

$('.carTypeRatio input').on('ifChecked', function(event){
	//	$('#carType').html($('#carTypeRatioStr'+this.value).html());

	getTimeList();
});	
			
$('.serviceTypeRatio input').on('ifChecked', function(event){

//		$('#sType').html($('#sTypeRatioStr'+this.value).html());
		getTimeList();
});		

$('.positionRatio input').on('ifChecked', function(event){

		getTimeList();
});	
                    		",CClientScript::POS_READY);
 ?>  




 
				
						
						<p><span style="color:#ff9900;font-weight:bold;font-size:14px;">选择车型</span>
						<span class="carTypeRatio icheck">
						<label><input type="radio" name="carType" value="1" checked>
						<span id="carTypeStr1"><?php echo Yii::app()->params['carType'][1];?></span>   </label>
						<label>
<input type="radio" name="carType" value="2">
<span id="carTypeStr1"><?php echo Yii::app()->params['carType'][2];?></span></label></span> </p>


			
                   
						
						<p> <span style="color:#ff9900;font-weight:bold;font-size:14px;">选择位置</span>
						<span class="positionRatio icheck">
		<label><input type="radio" name="position" value="1" checked>
						<span id="sTypeRatioStr1">车位1</span>   </label>				
						<?php 
						for ($i = 1; $i < $shop['ws_num']; $i++):?>
<label><input type="radio" name="position" value="<?php echo $i+1;?>">
						<span id="sTypeRatioStr<?php echo $i+1;?>">车位<?php echo $i+1;?></span>   </label>							
						
							
						
						<?php endfor;?>
						</span>
</p>	

  <p style="color:#ff9900;font-weight:bold;font-size:14px;">选择时间
                        
                        </p>
                        