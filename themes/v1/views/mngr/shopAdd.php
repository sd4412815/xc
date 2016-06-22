<?php
$this->pageTitle = Yii::app ()->name . ' - 添加车行';
Yii::app()->clientScript->registerScriptFile("http://api.map.baidu.com/api?v=2.0&ak=atV54I5hflatOH00IebtxSwR", CClientScript::POS_HEAD);
?>
         <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
          添加车行
                    
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo Yii::app()->createUrl('mngr/Profile');?>"><i class="fa fa-dashboard"></i> 我的主页</a></li>
                        <li class="active">车行列表</li>
                    </ol>
                </section>
                
                 <section class="content">
                  <div class="row">
                  <div class="col-md-6">
                <div id="allmap" style="width: 100%;height: 300px;"></div>
                  </div>
                  <div class="col-md-6">
                  
                  <div class="row">
                  <>
                  </div>
                  </div>
                  </div>
                 
                 </section>
                 
                 <script type="text/javascript">
	// 百度地图API功能
	var map = new BMap.Map("allmap");            
	map.centerAndZoom("沈阳",12);           
	//单击获取点击的经纬度
	map.addEventListener("click",function(e){
		alert(e.point.lng + "," + e.point.lat);
	});
</script>
