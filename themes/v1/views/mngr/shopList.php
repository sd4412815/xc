<?php
$this->pageTitle = '车行列表';
?>

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        车行列表
                        <small>统计</small>
                    </h1>
                    <ol class="breadcrumb hidden-xs">
                        <li><a href="<?php echo Yii::app()->createUrl('mngr/Profile');?>"><i class="fa fa-dashboard"></i> 我的账户</a></li>
                        <li class="active">车行列表</li>
                    </ol>
                </section>

                
                
                
                <!-- Main content -->
                <section class="content">
                  <div class="">
                            <div class="box">
         
                                <div class="box-body no-padding">
                                  <div id="list" >
 <?php 
  $this->renderPartial('_shopList',array(
 'dataProvider'=>$dataProvider,
 ));
 ?>
 </div>

                                        </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>

                </section><!-- /.content -->
                
<?php 
Yii::app()->clientScript->registerScript('shopOper',
"
function shopOper(id,type){
		var loadi;
$.ajax({
url:'".Yii::app()->createUrl('WashShop/oper')."',
		data:{
		'id':id,
        'oper':type,
	},
         dataType:'json',       		
		'beforeSend':function(){ loadi = layer.load(".Yii::app()->params['loadString'].");},
		'error':function(){ layer.msg('操作失败');},
		'complete':function(){ layer.close(loadi);},
		'success':function(html){layer.msg(html.msg,2,1);}
});
};
		",CClientScript::POS_END);


?> 
<?php
Yii::app ()->clientScript->registerScript ( 'ready', "
$('#menuShop').addClass('active');	
$('#menuShopList').addClass('active');	
", CClientScript::POS_READY );
?>