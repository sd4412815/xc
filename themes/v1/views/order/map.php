<?php $this->pageTitle = '地图浏览'; ?>
 <?php
	
	Yii::app ()->clientScript->registerCssFile ( "http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" );
	// Yii::app()->clientScript->registerScriptFile("http://api.map.baidu.com/api?v=2.0&ak=atV54I5hflatOH00IebtxSwR", CClientScript::POS_HEAD);
	
	?> 
<?php
// echo CHtml::encode('comming soon...');
// return ;
// Yii::app()->end();
?>
<br>

   <div class="row">
	
	  	<div class="col-xs-12">
		<div id="allmap" style="width: 100%; height: 500px;"></div>
	</div>
	  </div>



<?php
$city = City::model()->findByPk(UPlace::getCityId());

Yii::app ()->clientScript->registerScript ( 'mapend', '
var cloudsSearch;
var map;
var allShopInfo;
var pageNum=0;

	//百度地图API功能
	function loadJScript() {
		var script = document.createElement("script");
		script.type = "text/javascript";
		script.src = "http://api.map.baidu.com/api?v=2.0&ak=atV54I5hflatOH00IebtxSwR&callback=init";
		document.body.appendChild(script);
	}
	function init() {
	
		map = new BMap.Map("allmap");            // 创建Map实例
		if($.cookie("_ucid") != null){
			map.centerAndZoom("'.$city['c_name'].'",'.$city['c_disp_level'].');      
		}
		else
		{  

			var myCity = new BMap.LocalCity();
			
			myCity.get(function(result){
				 var cityName = result.name;
				    map.centerAndZoom(cityName); 
				});
		 
		}     
		map.addEventListener("moveend",function(){ zclouds(); });     
		map.addEventListener("zoomend",function(){ zclouds(); });     
		map.enableScrollWheelZoom();                 
		map.addControl(new BMap.NavigationControl()); 		
	}  // end init()


	function zclouds(tid){
			if(tid=="pageUp")
			{
				pageNum--;
				if(pageNum==-1)
				{
					pageNum++;
			
					return;
				}
			}else if(tid=="pageDown")
			{
				pageNum++;
			}
	  	    var url = "'.Yii::app()->createUrl('order/mapSearch').'";
	  		var bs = map.getBounds();   //获取可视区域
	  		var bssw = bs.getSouthWest();   //可视区域左下角
	  		var bsne = bs.getNorthEast();   //可视区域右上角
	  		var bounts = bssw.lng+","+bssw.lat+";"+bsne.lng+","+bsne.lat;
		    $.getJSON(url, {
			"page_index":pageNum,
"bounds":bounts,
			},function(data) {
				cloudsSearch = data.map;
				if(cloudsSearch.total == 0){
					$("#r-result").html("未找到符合条件车行，请更换地图显示范围再试");
}	else{
				$("#r-result").html(data.rlt);}
				if(cloudsSearch.size==0)
				{
					if(pageNum>0)
					{
						pageNum--;
					}
					return;
				}
				
				setShopInfo();
			});

		}  //end zclouds


		function setShopInfo()
		{
			var w = new Array();
			for(var e = 0;e < cloudsSearch.size; e++){
			  w[e] = cloudsSearch.contents[e].washshop_id;
			}
			var par={"shop_id":w};
			$.ajax({
				url: "'.Yii::app()->createUrl('Order/ShopInfos').'",  
				 type: "POST",
				 dataType:"JSON",
				 data:par,
			 error: function(){ 
				layer.msg("格式化返回结果失败！");  
			},  
			success: function(allShopInfo,status){

					map.clearOverlays();
				   
					openInfoWinFuns = [];

					for (var i = 0; i < allShopInfo.length; i ++){

						var marker=addMarker(map,new BMap.Point(cloudsSearch.contents[i].location[0],cloudsSearch.contents[i].location[1]),i);
						var openInfoWinFun = addInfoWindow(marker,cloudsSearch.contents[i],i);
						openInfoWinFuns.push(openInfoWinFun);

						var selected = "";
				

						   var shop = eval("(" + allShopInfo[i][0] + ")");
						   var infos = eval("(" + allShopInfo[i][1] + ")");

							var url="'.Yii::app()->createUrl('order/new/').'"+shop.data.id;

					
				
					}


				}  
			}); 
		}  // end getWashInfo	



	function addInfoWindow(marker,poi,index){
	    var maxLen = 10;	
		var url=		"'.Yii::app()->createUrl('order/new').'/"+poi.washshop_id; 		 		
	    var infoWindowTitle = "<div style=\"font-weight:bold;color:#666;font-size:18px\"><a href="+url+">" + poi.title + "</a></div>";
	    // infowindow的显示信息
	    var infoWindowHtml = [];
	    infoWindowHtml.push(\'<p>地址：\');
	    infoWindowHtml.push(poi.address);
	    infoWindowHtml.push(\'<br>\');
	    infoWindowHtml.push(\'<div class="btn btn-warning"><a href=\'+url+\' style="color:black;">去预定</a></div>\');
	    var infoWindow = new BMap.InfoWindow(infoWindowHtml.join(""),{title:infoWindowTitle,width:200}); 
	    var openInfoWinFun = function(){
	        marker.openInfoWindow(infoWindow);
	        for(var cnt = 0; cnt < maxLen; cnt++){
	            if(!document.getElementById("list" + cnt)){continue;}
	            if(cnt == index){
	                document.getElementById("list" + cnt).style.backgroundColor = "#f0f0f0";
	            }else{
	                document.getElementById("list" + cnt).style.backgroundColor = "#fff";
	            }
	        }
	    }
	    marker.addEventListener("click", openInfoWinFun);
	    return openInfoWinFun;
	}
	window.onload = loadJScript;  //异步加载地图			
			
', CClientScript::POS_END );
?>

<script type="text/javascript">

</script>

<?php
Yii::app ()->clientScript->registerScript ( 'changeMenuStyle', "
$('#mmap').addClass('active');
			
", CClientScript::POS_READY );
?>
 
