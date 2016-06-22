 <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        车行信息维护
                    </h1>
                   <!--  <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> 个人主页</a></li>
                        <li class="active">我的收藏</li>
                    </ol> -->
                </section>
                    
                <!-- Main content -->
                <section class="content">
				    
                    <div class="row">
					    <div class="col-md-12">
                            <div class="box box-primary">
                                <!-- <div class="box-header">
                                    <h3 class="box-title"></h3>
                                </div> -->
                                <div class="box-body">                                 
									<form class="form-horizontal">
									  <div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">加盟号</label>
										<div class="col-sm-8">
										  <p class="form-control-static"><?php echo $model['ws_no'];?></p>
										</div>
									  </div>
									  <div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label"><span class="text-red">*</span>车行名称</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control" placeholder="我洗车-水调歌城店">
										</div>
									  </div>
									  <div class="form-group">
										<label for="inputPassword3" class="col-sm-2 control-label"><span class="text-red">*</span>车行地址</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control" placeholder="沈阳市于洪区细河南路号1门">
										</div>
									  </div>
									  <div class="form-group">
										<label for="inputPassword3" class="col-sm-2 control-label">车行描述</label>
										<div class="col-sm-8">
										  <textarea class="form-control" rows="3"></textarea>
										  
										</div>
									  </div>
									  <div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label"><span class="text-red">*</span>店长</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control" placeholder="崔亚军">
										</div>
									  </div>
									  <div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label"><span class="text-red">*</span>电话</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control" placeholder="18809832157">
										</div>
									  </div>
									  <div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label"><span class="text-red">*</span>洗车休息间隔</label>
										<div class="col-sm-8">
										  <select class="form-control">
										      <option>0</option>
										      <option>5</option>
											  <option>10</option>
											  <option>15</option>
										  </select>
										</div>
									  </div>
									  <div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">洗车位个数</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control" placeholder="2" disabled>
										</div>
									  </div>
									  <div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">服务类型</label>
										<div class="col-sm-8">
										    <label class="checkbox-inline">
											  <input type="checkbox" value="option1" checked disabled> 洗车
											</label>
											<label class="checkbox-inline">
											  <input type="checkbox" value="option2" checked disabled> 打蜡
											</label>
											<label class="checkbox-inline">
											  <input type="checkbox" value="option3" disabled> 精洗
											</label>
										</div>
									  </div>
									  <div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">洗车价格</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control" placeholder="30" disabled>
										</div>
									  </div>
									  <div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">打蜡价格</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control" placeholder="80" disabled>
										</div>
									  </div>
									  <div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">营业时间</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control" placeholder="7:00 - 21:00" disabled>
										</div>
									  </div>
									  <div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">特色服务</label>
										<div class="col-sm-8">
										    <label class="checkbox-inline">
											  <input type="checkbox" value="option1" checked disabled> WIFI
											</label>
											<label class="checkbox-inline">
											  <input type="checkbox" value="option2" checked disabled> 赠饮
											</label>
											<label class="checkbox-inline">
											  <input type="checkbox" value="option3" checked disabled> 休息室
											</label>
											<label class="checkbox-inline">
											  <input type="checkbox" value="option4" checked disabled> 电视
											</label>
											<label class="checkbox-inline">
											  <input type="checkbox" value="option5" disabled> 电脑
											</label>
											<label class="checkbox-inline">
											  <input type="checkbox" value="option6" disabled> 麻将棋牌
											</label>
											<label class="checkbox-inline">
											  <input type="checkbox" value="option7" disabled> 免费停车
											</label>
											<label class="checkbox-inline">
											  <input type="checkbox" value="option8" disabled> 刷卡
											</label>
										</div>
									  </div>
									  <div class="form-group">
										<label for="inputEmail3" class="col-sm-2 control-label">银行账户</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control" placeholder="6227 **** **** **** 098  中国银行  崔亚军" disabled>
										</div>
									  </div>
									  <div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
										   <button type="submit" class="btn btn-primary">修改</button>
										</div>
									  </div>
									</form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
					    </div>
					</div>
                </section><!-- /.content -->
<div class="container">
<!-- ddd -->
<?php


$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'ws-form',
		'enableAjaxValidation'=>true, //是否启用ajax验证
		'enableClientValidation' => true,
		'clientOptions' => array (
				'validateOnSubmit' => true ,
				'validateOnChange'=>true, //输入框值改变时验证
		),
		'htmlOptions' => array (
		// 				'enctype' => 'multipart/form-data',
				'class' => 'form-horizontal'
		)
) );




// echo CHtml::listBox('','', CHtml::listData (Staff::model ()->findAllByAttributes (array(
// 	's_wash_shop_id'=>Boss::model()->findByAttributes(array(
// 'b_user_id'=>Yii::app()->user->id))->washShop['id'],
// )), 'id', function($model){
	
// 	return CHtml::encode('编号:'.$model->s_tag.' (电话：'.$model->s_tel.')');
// }  ),array('class'=>'form-control'));
?>

	<div class="form-group">
		<?php
		
echo $form->labelEx ( $model, 'ws_name', array (
				'class' => 'col-sm-2 control-label' 
		) );
		?>
		  <div class="col-sm-10">
     <?php
					
echo $form->textField ( $model, 'ws_name', array (
// 							'placeholder' => '密码只包含数字、字母、下划线',
							'class' => 'form-control' ,
'readonly'=>'readonly'
					) );
					?>
    </div>

		
	</div>
		<div class="form-group">
		<?php
		
echo $form->labelEx ( $model, 'ws_address', array (
				'class' => 'col-sm-2 control-label' 
		) );
		?>
		  <div class="col-sm-10">
     <?php
					
echo $form->textField ( $model, 'ws_address', array (
// 							'placeholder' => '密码只包含数字、字母、下划线',
							'class' => 'form-control' ,
'readonly'=>'readonly'
					) );
					?>
    </div>
	
		
	</div>
	
		<div class="form-group">
		<?php
		
echo $form->labelEx ( $model, 'ws_rest', array (
				'class' => 'col-sm-2 control-label' 
		) );
		?>
		  <div class="col-sm-10">
     <?php
     
     echo $form->dropDownList($model,'ws_rest',array('0'=>'0','5'=>'5','10'=>'10','15'=>'15','20'=>'20','25'=>'25','30'=>'30'), array (
// 							'placeholder' => '密码只包含数字、字母、下划线',
							'class' => 'form-control' ,
					) );
					?>
    </div>

		
	</div>
		<div class="form-group">
					<div class="col-sm-12">
		<?php
		
echo CHtml::submitButton ( '更新', array (
				'class' => 'btn btn-primary col-sm-4' 
		) );
		?>
		</div>

				</div>
				
				<div>
				<?php if(Yii::app()->user->hasFlash('success')):?> 
<div class="alert alert-success alert-dismissable">
  <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<?php echo Yii::app()->user->getFlash('success'); ?> 
</div>
<?php endif; ?> 
				</div>
	
	<?php $this->endWidget();?>

</div>

<?php 

Yii::app()->clientScript->registerScript('ready',"
		 $('#menu-wsinfo').addClass('active');	

",CClientScript::POS_READY);
?>

