<?php
$this->pageTitle = Yii::app ()->name . ' - 车行信息维护';
?>
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
						'enctype' => 'multipart/form-data',
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
// 'readonly'=>'readonly'
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
// 'readonly'=>'readonly'
					) );
					?>
    </div>
	
		
	</div>
		<div class="form-group">
		<?php
		
echo $form->labelEx ( $model, 'ws_desc', array (
				'class' => 'col-sm-2 control-label' 
		) );
		?>
		  <div class="col-sm-10">
     <?php
					
echo $form->textArea ( $model, 'ws_desc', array (
// 							'placeholder' => '密码只包含数字、字母、下划线',
							'class' => 'form-control' ,
'row'=>3,
// 'readonly'=>'readonly'
					) );
					?>
    </div>
	
		
	</div>
		<div class="form-group">
		<?php
		
echo $form->labelEx ( $model, 'ws_boss_id', array (
				'class' => 'col-sm-2 control-label' 
		) );
		?>
		  <div class="col-sm-10">
     <?php
     $boss = $model->wsBoss;
     echo $form->dropDownList($model,'ws_boss_id',CHtml::listData(Boss::model()->findAll(array('order'=>'b_real_name ASC')), 'id', 
function($boss) {return $boss->b_user_id.'('.$boss->b_real_name.')';}), array (
// 							'placeholder' => '密码只包含数字、字母、下划线',
							'class' => 'form-control' ,
					) );
					?>
    </div>

		
	</div>
		<div class="form-group">
		<?php
		
echo $form->labelEx ( $model, 'ws_num', array (
				'class' => 'col-sm-2 control-label' 
		) );
		?>
		  <div class="col-sm-10">
     <?php
					
echo $form->textField ( $model, 'ws_num', array (
// 							'placeholder' => '密码只包含数字、字母、下划线',
							'class' => 'form-control' ,
// 'readonly'=>'readonly'
					) );
					?>
    </div>
	
		
	</div>
		<div class="form-group">
		<?php
		
echo $form->labelEx ( $model, 'ws_time_zone_id', array (
				'class' => 'col-sm-2 control-label' 
		) );
		?>
		  <div class="col-sm-10">
     <?php
     $tz = $model->wsTimeZone;
     echo $form->dropDownList($model,'ws_time_zone_id',CHtml::listData(TimeZone::model()->findAll(), 'id', 
function($tz) {return substr($tz->tz_start,0,5).'-'.substr($tz->tz_stop, 0,5);}), array (
// 							'placeholder' => '密码只包含数字、字母、下划线',
							'class' => 'form-control' ,
					) );
					?>
    </div>

		
	</div>
		<div class="form-group">
		<?php
		
echo $form->labelEx ( $model, 'ws_count', array (
				'class' => 'col-sm-2 control-label' 
		) );
		?>
		  <div class="col-sm-10">
     <?php
					
echo $form->textField ( $model, 'ws_count', array (
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
				'class' => 'btn btn-primary col-sm-2' 
		) );
// echo CHtml::submitButton ( '返回列表', array (
// 		'class' => 'btn btn-default col-sm-2'
// ) );

echo CHtml::Link('返回列表', Yii::app()->createUrl('mngr/shopList'),array (
		'class' => 'btn btn-default col-sm-2'
));
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


