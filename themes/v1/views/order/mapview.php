<?php
$this->pageTitle = Yii::app ()->name . ' - 预约';
$ak = UMap::getMapAttributes ()['ak'];
$url = 'http://api.map.baidu.com/api?v=2.0&ak='.$ak;
echo $url;
echo CHtml::scriptFile ( $url );
?>
<!-- 加载百度地图样式信息窗口 -->
<script type="text/javascript"
	src="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
<link rel="stylesheet"
	href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />
	<!--加载鼠标绘制工具-->
<script type="text/javascript" src="http://api.map.baidu.com/library/DrawingManager/1.4/src/DrawingManager_min.js"></script>
<link rel="stylesheet" href="http://api.map.baidu.com/library/DrawingManager/1.4/src/DrawingManager_min.css" />
<p>
	<?php
	
	echo CHtml::dropDownList ( 'province', 'id', CHtml::listData ( Province::model ()->findAll ( array (
			'order' => 'p_spell' 
	) ), 'id', 'p_name' ), array (
			'id' => 'province_list',
			'empty' => '请选择省份',
			'ajax' => array (
					'type' => 'POST',
					'url' => Yii::app ()->createUrl ( 'city/dynamicCities' ),
					'update' => '#city_list',
					'data' => array (
							'province_id' => 'js:this.value' 
					) 
			) 
	) );
	echo CHtml::dropDownList ( 'city', 'id', array (), array (
			'id' => 'city_list',
			'empty' => '请选择城市',
			'ajax' => array (
					'type' => 'POST',
					'url' => Yii::app ()->createUrl ( 'area/dynamicAreas' ),
					'update' => '#area_list',
					'data' => array (
							'city_id' => 'js:this.value' 
					) 
			) 
	) );
	
	echo CHtml::dropDownList ( 'area', 'id', array (), array (
			'id' => 'area_list',
			// 'prompt'=>'选择区域',
			'empty' => '请选择区域' 
	) );
	?>
		<?php
		
		$this->widget ( 'bootstrap.widgets.TbButton', array (
				'buttonType' => 'link',
				'type' => 'primary',
				'label' => '搜索',
				'size' => 'norm',
				'url' => 'order/search' 
		) );
		?>
</p>
<style type="text/css">
#allmap {width: 1000px;height: 500px;overflow: hidden;margin:0;float:left;}
#l-map{height:100%;width:78%;float:left;border-right:2px solid #bcbcbc;}
#r-result{height:100%;width:20%;float:left;}
</style>
<h1>预约洗车</h1>
<div id="allmap"></div>
<div id="r-result"></div>

<script type="text/javascript">

// 百度地图API功能
var map = new BMap.Map("allmap");          // 创建地图实例
var point = new BMap.Point(123.438482,41.777428);  // 创建点坐标
map.centerAndZoom(point, 15);                 // 初始化地图，设置中心点坐标和地图级别
map.enableScrollWheelZoom();
map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件

var options = {
    renderOptions: {
        map: map,panel: "r-result"
    },
  onSearchComplete: function(results){
  }
};
var localSearch = new BMap.LocalSearch(map,options);

var drawingManager = new BMapLib.DrawingManager(map, {
        isOpen: true, //是否开启绘制模式
        enableDrawingTool: true, //是否显示工具栏
        drawingToolOptions: {
            anchor: BMAP_ANCHOR_TOP_RIGHT, //位置
            offset: new BMap.Size(5, 5), //偏离值
            scale: 0.8, //工具栏缩放比例
			drawingModes : [
				BMAP_DRAWING_CIRCLE
			 ]
		}
});
drawingManager.setDrawingMode(BMAP_DRAWING_CIRCLE);
var circle = null;
drawingManager.addEventListener('circlecomplete', function(e) {
       circle = e;
	   var radius= parseInt(e.getRadius());
	   var center= e.getCenter();
       drawingManager.close();
	   localSearch.searchNearby('店', center,radius,{customData:{geotableId:66526}});});
window.onload = function() {
	// var circle = new BMap.Circle(point,2000,{fillColor:"blue", strokeWeight: 1 ,fillOpacity: 0.3, strokeOpacity: 0.3});
    // map.addOverlay(circle);
	localSearch.searchNearby('店', point,2000,{customData:{geotableId:66526}});}



</script>