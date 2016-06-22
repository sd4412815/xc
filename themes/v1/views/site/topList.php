<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - 关于我们';
?>
<?php 
// $staffs = Staff::model()->getTopStaffs(10,1);
// echo CJSON::encode($staffs);
?>
<section class="page-head-holder">
	<div class="col-sm-12 col-xs-12">



			<h2>风云榜</h2>

		</div>
</section>
<div class="container">
<?php 
$shops = WashShop::model()->getTopWSs(10,1);

$staffs = Staff::model()->getTopStaffs(10,1);
$users = User::model()->getTopUsers(10, 1);
// echo CJSON::encode($staffs);
?>
<div class="row">
<div class="col-sm-4">
<label>车行风云榜</label><br />
  <div id="shopTop" style="height: 300px;"></div>

</div>
<div class="col-sm-4">
<label>员工风云榜</label><br />
  <div id="staffTop" style="height: 300px;"></div>

</div>
<div class="col-sm-4">
<label>车主风云榜</label><br />
  <div id="userTop" style="height: 300px;"></div>

</div>
</div>
</div>


           <!-- FLOT CHARTS -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/admin/js/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/admin/js/plugins/flot/jquery.flot.time.js"></script>
        <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/admin/js/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
        <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/admin/js/plugins/flot/jquery.flot.pie.min.js" type="text/javascript"></script>
        <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/admin/js/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
    
<script>

$(document).ready(function (){

    var shop_data = {
            data: [
                   <?php 
                   foreach ($shops as $name=>$value){
echo '["'.$value['ws_no'].'",'.$value['ws_score'].'],';
}
                   ?>],
//                    ["df", 4], ["February", 8], ["March", 4], ["April", 13], ["May", 17], ["June", 9]],
            color: "#3c8dbc"
        };
        $.plot("#shopTop", [shop_data], {
            grid: {
                borderWidth: 1,
                borderColor: "#f3f3f3",
                tickColor: "#f3f3f3"
            },
            series: {
                bars: {
                    show: true,
                    barWidth: 0.5,
                    align: "center"
                }
            },
            xaxis: {
                mode: "categories",
                tickLength: 0
            }
        });

    var staff_data = {
            data: [
                   <?php 
                   foreach ($staffs as $name=>$value){
echo '["*'.substr($value['s_tel'],7,4).'",'.$value['s_score'].'],';
}
                   ?>],
//                    ["df", 4], ["February", 8], ["March", 4], ["April", 13], ["May", 17], ["June", 9]],
            color: "#3c8dbc"
        };
        $.plot("#staffTop", [staff_data], {
            grid: {
                borderWidth: 1,
                borderColor: "#f3f3f3",
                tickColor: "#f3f3f3"
            },
            series: {
                bars: {
                    show: true,
                    barWidth: 0.5,
                    align: "center"
                }
            },
            xaxis: {
                mode: "categories",
                tickLength: 0
            }
        });


	
    var user_data = {
            data: [
                   <?php 
                   foreach ($users as $name=>$value){
echo '["*'.substr($value['u_tel'],7,4).'",'.$value['u_score'].'],';
}
                   ?>],
//                    ["df", 4], ["February", 8], ["March", 4], ["April", 13], ["May", 17], ["June", 9]],
            color: "#3c8dbc"
        };
        $.plot("#userTop", [user_data], {
            grid: {
                borderWidth: 1,
                borderColor: "#f3f3f3",
                tickColor: "#f3f3f3"
            },
            series: {
                bars: {
                    show: true,
                    barWidth: 0.5,
                    align: "center"
                }
            },
            xaxis: {
                mode: "categories",
                tickLength: 0
            }
        });


        
});
</script>
