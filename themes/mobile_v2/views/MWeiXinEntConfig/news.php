<?php
$this->pageTitle = '动态发布';

?>
<?php
  if (Yii::app ()->user->hasFlash ( 'shopnews' )) :
?>

  <div class="alert alert-danger" role="alert" style="text-align:center;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <span style="font-size:16px;"><?php echo Yii::app()->user->getFlash('shopnews');?></span>
  </div>
<?php endif;?>    



    <?php $form=$this->beginWidget('CActiveForm',array('action'=>array('mweixinentconfig/news'))); ?>
            <div class="">
                <!--<div class="box-header" style="background:#26dcfa;width:150px;border-radius: 10px 10px;margin-left:10px;margin-top:10px; ">
                    <img style="width:20px;height:20px;" src="<?php /*echo Yii::app()->theme->baseUrl*/?>/img/new/information.png" alt="">
                    <h3 class="box-title">动态发布</h3>
                </div>-->
                <div class="box-body">                                 
					<?php 
						echo $form->textArea($model,'sn_desc',array(
                                "class"=>"form-control",
                                'rows'=>"6",
                                'placeholder'=>'填写适合自己店面的营销内容',
                                'style'=>'border-radius: 15px 15px;'));
					?>
                </div><!-- /.box-body -->
                <div class="row">
                    <div class="col-xs-offset-4 col-xs-4" style="margin-bottom: 20px;">
                        <button class="btn btn-warning" type="submit">立刻发布</button>
                    </div>
                </div>
            </div>
	<?php $this->endWidget(); ?>

<table class="table" id="color">
	<tr style="font-size:20px;">   
		<th style="background:#f2851c;" width="25%">
            <img src="<?php echo Yii::app()->theme->baseUrl ?>/img/new/time.png" style="width:20px;height:20px;" alt="">&nbsp;&nbsp;
            <span style="margin-top:10px;font-size: 12px;">时间</span>
        </th>
 		<th style="background:#999;" >
            <img src="<?php echo Yii::app()->theme->baseUrl ?>/img/new/information.png" style="width:20px;height:20px;" alt="">&nbsp;&nbsp;
            <span style="margin-top:10px;font-size: 12px;">内容</span>
        </th>
 	</tr>
	<?php foreach ($shopnews as $key=>$new):?>
	<tr>
		<th><?php echo date('m-d',strtotime($new['sn_date'])) ;?></th>
		<td><?php echo $new['sn_desc'];?></td>
	</tr>
	<?php endforeach;?>
</table>


<style type="text/css">
    .odd {
        background-color: #efefef; /* pale blue for even rows */
} 
</style>
<script type="text/javascript">
    $(document).ready(function() {
    $('tr:odd').addClass('odd');
    $('tr:even').addClass('even'); //奇偶变色，添加样式
    }); 
</script>