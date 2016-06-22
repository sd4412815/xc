<?php
$this->pageTitle = '会员统计';
?>
<?php Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/tablesorter/jquery.tablesorter.js", CClientScript::POS_END ); ?>


<div class="box box-widget widget-user-2">
	<div class="box-footer">
		<div>
			<div class="col-xs-4 border-right">
				<div class="description-block" style="background-color: #d1bad9;border-radius:8px;">                    
					<span class="description-text">
						<img style="width: 35px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/book.png" >
					</span>                
					<br>
					<span class="description-text" style="color: #fff;font-size:12px;">今日新增</span>
					<br>
					<span class="description-text" style="color: #fff;font-size:12px;">
						<?php 
							$shopid = Yii::app()->session['shop']->id;
						    $criteria = new CDbCriteria ();
						    $criteria->addCondition ( 'sm_shop_id = :shopId' );
						    $criteria->params [':shopId'] = $shopid;
						    $timestart = date("Y-m-d 00:00:00");
						    $timeend = date("Y-m-d 23:59:59");
					        $criteria->addCondition ( 'sm_join_time>=:start' );
					        $criteria->addCondition ( 'sm_join_time<=:end' );
					        $criteria->params [':start'] = $timestart;
					        $criteria->params [':end'] = $timeend;	
						    $member=ShopMember::model()->findAll($criteria);
						    $count=count($member);
							if ($count>0){
								echo $count."人";
							}else{
								echo '无';
							}		
						?>	
					</span>
				</div>
			</div>
								
			<div class="col-xs-4 border-right">
				<div class="description-block" style="background-color: #26dcfa;border-radius:8px;">                    
					<span class="description-text">
						<img style="width: 35px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/people.png" >
					</span>                
					<br>
					<span class="description-text" style="color: #fff;font-size:12px;">本月新增</span>
					<br>
					<span class="description-text" style="color: #fff;font-size:12px;">
						<?php 
							$shopid = Yii::app()->session['shop']->id;
						    $criteria = new CDbCriteria ();
						    $criteria->addCondition ( 'sm_shop_id = :shopId' );
						    $criteria->params [':shopId'] = $shopid;
						    $timestart = date("Y-01-01 00:00:00");
						    $timeend = date("Y-m-d 23:59:59");
					        $criteria->addCondition ( 'sm_join_time>=:start' );
					        $criteria->addCondition ( 'sm_join_time<=:end' );
					        $criteria->params [':start'] = $timestart;
					        $criteria->params [':end'] = $timeend;	
						    $member=ShopMember::model()->findAll($criteria);
						    $count=count($member);
							if ($count>0){
								echo $count."人";
							}else{
								echo '无';
							}		
						?>
					</span>
				</div>
			</div>
							 
			<div class="col-xs-4 border-right">
				<div class="description-block" style="background-color: #4ed113;border-radius:8px;">                    
					<span class="description-text">
						<img style="width: 35px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/car.png" >
					</span>
					<br>
					<span class="description-text" style="color: #fff;font-size:12px;">累计会员</span>
					<br>
					<span class="description-text" style="color: #fff;font-size:12px;">                   
						<?php 
							$shopid = Yii::app()->session['shop']->id;
						    $criteria = new CDbCriteria ();
						    $criteria->addCondition ( 'sm_shop_id = :shopId' );
						    $criteria->params [':shopId'] = $shopid;
						    $member=ShopMember::model()->findAll($criteria);
						    $total=count($member);
							if ($total>0){
								echo $total."人";
							}else{
								echo '无';
							}		
						?>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
			
<style type="text/css">
 	.input{
 		/*width: 10%;*/
 		padding-left: 10px;
 	}
	.yuan{ 
		-ms-transform: scale(2); /* IE */
		-moz-transform: scale(2); /* FireFox */
		-webkit-transform: scale(2); /* Safari and Chrome */
		-o-transform: scale(2); /* Opera */
	}
</style>
<?php if ($total==0) {
	echo "<p class='text-conter'>暂无会员</p>";
}else{
?>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
				<table class="table table-bordered" width="98%" cellpadding="0" cellspacing="10" id="mytable">
					<thead>
						<tr class="text-center">
							<th class="text-center">手机号</th>
							<th class="text-center">加入时间<i class="fa fa-fw fa-caret-square-o-up"></i></th>
							<th class="text-center">消费次数<i class="fa fa-fw fa-caret-square-o-up"></i></th>
							<th class="text-center">操作</th>
						</tr>
					</thead>
					<?php foreach ($model as $key => $val) {?>
					<tr class="text-center">
						<td><?php echo  substr_replace($tel=User::model()->find('id=:id', array(':id' => $val->sm_user_id))->u_tel,'****',3,4);?></td>
						<td><?php echo substr($val->sm_join_time, 0,10);?></td>
						<td>
							<?php 
							    $criteria=new CDbCriteria;  
							    $criteria->condition='oh_wash_shop_id=:shopid AND oh_user_id=:userid';  
							    $criteria->params=array(':shopid'=>$shop->id,':userid'=>$val->sm_user_id);  
							    $count=OrderHistory::model()->findAll($criteria);
							    echo count($count);
							 ?>
						</td>
						<td class="input">
							<input name="tel" class="yuan" id="userid<?php echo $val->sm_user_id;?>" style="width:20px;height:20px;" type="checkbox">
						</td>
					</tr>
				<?php } ?>
				<tr>
				<!-- <td colspan="4" class="text-right" style="margin:0;padding:0;height:30px;"> -->
					<?php
						// $this->widget('CLinkPager',array(
						// 	'pages'=>$pager,
						// 	'header'=>'',
						// 	'nextPageLabel'=>'下一页',
						// 	'prevPageLabel'=>'上一页',
						// 	'firstPageLabel'=>'首页',
						// 	'lastPageLabel'=>'尾页',
						// ));

					?>
					<?php
						// $this->widget('CListPager',array(
						// 	'pages'=>$pager,
						// 	'header'=>'跳转至：'
						// ));
					?>	
				<!-- </td> -->
				</tr>


				</table>
				<!-- <span style="float:right">
        			<button class="btn btn-info" id="selecty">全选</button>  
        			<button class="btn btn-info" id="offall">清空</button>
        			<button class="btn btn-info" id="sms">发送</button>
	          </span>   -->
		</div>
	</div>
</div>

<?php }?>
<script>
 //    $("#selecty").click(function(){
 //        $("input[name='tel']").attr("checked",true);
 //    });

 //    $("#offall").click(function(){
 //        $("input[name='tel']").attr("checked",false);
 //    });

  
	// $("#sms").click(function(){
	// 	var id_array=new Array(); 
	// 	$('input[name="tel"]:checked').each(function(){  
	// 	    id_array.push($(this).attr('id'));//向数组中添加元素  
	// 	});  
	// 	var idstr=id_array.join(',');//将数组元素连接起来以构建一个字符串  

	// 	$.ajax({
	// 		type:'POST',
	// 		url:'sms',
	//   		dataType: 'json',
	// 		data:{
	// 			'userid':idstr,
	// 		},
	// 		'success':function(data){
	// 			//loadi = layer.load("已发送")；
	// 		}
	// 	});
	// });

     
	$(document).ready(function(){
		$.tablesorter.defaults.headers = {0: {sorter: false}};
		$("#mytable").tablesorter();
	});   
</script>
			
			



