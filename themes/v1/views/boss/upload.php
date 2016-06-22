<div class="row">
		<div class="col-xs-12">
		<?php 
$form = $this->beginWidget('CActiveForm',array('id'=>'upload-form',
'enableAjaxValidation'=>false, 
'htmlOptions' => array('enctype'=>'multipart/form-data'),
))		
		?>
	<div class="row">  
      <div></div>
        <?php echo CHtml::activeFileField($upload,'url'); ?>  
        <?php echo $form->error($upload,'url'); ?>  
    </div>  	
		<?php $this->endWidget();?>
			
		</div>
</div>	