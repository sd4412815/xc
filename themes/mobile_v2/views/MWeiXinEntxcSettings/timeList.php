<?php
$this->pageTitle = '时间段管理';
// Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/selectFx.js", CClientScript::POS_END );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/loaders.css.js", CClientScript::POS_END );
Yii::app ()->clientScript->registerScriptFile ( Yii::app ()->theme->baseUrl . "/js/flavr.min.js", CClientScript::POS_END );
/*$criteria = new CDbCriteria ();
$criteria->addCondition ( 'wss_ws_id = :shopId' );
$criteria->params [':shopId'] = $shop['id'];
$criteria->with='carGroup,serviceType';*/
//$serviceinfo=WashShopService::model()->findAll($criteria);
$serviceinfo=WashShopService::model()->with ("serviceType","carGroup")->findAll ('wss_ws_id=:ws_id and wss_st_id<=6',array('ws_id'=>$shop['id']) );

//print_r($serviceinfo);

?>


<br>
<div class="col-xs-12">
 	<?php 
     	$bias = 0;
     	$sType=1;
        $shopId = $shop['id'];
 	?>



    <div class="row" style="margin: 5px 0;">
        <div class=" col-xs-2 text-right h6">类型</div>
        <div class=" col-xs-10">

            <select class="cs-select cs-skin-elastic-service" id="sTypeList">
                <?php
                $sTypeSelectedValue = $selectedParams['sType'] ;

                foreach ($shop['serviceList'] as $key=>$service):
                    ?>
                    <option value="<?php echo $service['id'] ?>" <?php echo UCom::selectedStr($service['id'], $sTypeSelectedValue);?>>
                        <?php echo '【'.$service['name'].'】'.$serviceTypeList[$service['id']]['desc'];?>
                    </option>
                <?php endforeach;?>

            </select>

        </div>
    </div>
    <div class="row" style="margin: 5px 0;">
        <div class="col-xs-2 text-right h6"> 车型 </div>
        <div class="col-xs-10" id="scartypelist">
            <?php
            // 设置初始值
            $selectedType =$selectedParams['sCarType'];
            $sTypeCarGroup = $shop['serviceList'][$sTypeSelectedValue]['carGroupList'];
                // echo json_encode($sTypeCarGroup);
                $this->renderPartial('_timelist_car_type',array(
                    'selectedType'=>$selectedType,
                    'sTypeCarGroup'=>$sTypeCarGroup,
                    'carGroupList'=>$carGroupList));    
            ?>  
        </div>
    </div>


    <div class="row" style="margin: 5px 0;">
        <div class="col-xs-2 text-right h6"> 日期 </div>
        <div class="col-xs-10" id="sdatelist">
            <a name="sDate" class="btn btn-item time-info current" data-value="1">今天(<?php echo date('d日')?>)</a>
            <a name="sDate" class="btn btn-item time-info" data-value="2">明天(<?php echo date('d日',time()+24*60*60);?>)</a>
            <a name="sDate" class="btn btn-item time-info" data-value="3">后天(<?php echo date('d日',time()+2*24*60*60);?>)</a>
        </div>
    </div>




   <!--  <p>
        <span> 车位 </span>
        <span id="scarlist">
            <?php //for ($i=0; $i <$shop->ws_num; $i++) { ?>
                <a name="location" value="<?php //echo $i?>" class="btn btn-item time-info">车位<?php //echo $i+1 ?></a>
            <?php //}?>
        </span>
    </p>  
 -->

	<div class="row" style="margin: 5px 0;">
        <div class="col-xs-2 text-right h6"> 时间 </div>
    	<div class="col-xs-10" id="stimelist">
			<?php 
				$this->renderPartial('_time_list',array(
                    'selectedType'=>$selectedType,
                    'timeList'=>$timeList
				));
			?>		
		</div>
    </div>
    <div class="row" style="margin: 5px 0;">
        <div class="col-xs-2"></div>
        <div class="col-xs-10 text-left" style="margin-top: 10px;">
            <button class="btn btn-info" id="selall">全选</button>
        </div>
    </div>

    <div class="row" style="margin: 10px;">
        <div class="col-xs-2 text-right h6">价格</div>
        <div class="col-sm-10 input-group margin">
            <input type="text" class="form-control" name="svalue" id="svalue" placeholder="￥"/>
            <span class="input-group-btn">
                <button type="submit" id="btnOrderAdd"  class="btn btn-warning btn-flat" onclick="orderAdd(3)">确定</button>
            </span>
        </div>
    </div>

    <div class="row margin">
        <div class="col-xs-6 text-right col-md-2">
            <input type="button" class="btn btn-info" id="btnDisableOrder"   onclick="orderAdd(1)" value="禁用车位" />
        </div>
        <div class="col-xs-6 text-left col-md-2">
            <input type="button" id="btnEnableOrder" class="btn btn-info"  onclick="orderAdd(2)" value="启用车位" />
        </div>
    </div>
					
</div>

<script type="text/javascript">
    function select_service_ini() {
        [].slice.call($("#sTypeList")).forEach(function(el) {
            new SelectFx(el, {
                stickyPlaceholder : false,
                onChange : function(val) {
                    document.cookie = 'sType=' + val + ';path=/';
                    ajaxUpdateTimelist();
                }
            });
        });
    }

    // 设置日期

        $("a[name='sDate']").on("click",function() {
            $('#sdatelist').find('.current').removeClass('current');
            $(this).addClass('current');
            document.cookie = 'sDate=' + $(this).data("value") + ';path=/;expires=60;';

            ajaxUpdateTimelist();
            ajaxUpdatePrice();
        });

    //设置时间
    function set_time_change_ini() {
        $("a[name='sTime']").on("click",function() {
            if($(this).hasClass('current')){
                $(this).removeClass('current');
            }else{
                $(this).addClass('current');
                document.cookie = 'sTime=' + $(this).data('value') + ';path=/';
                ajaxUpdatePrice();
            }

            if($('#sTime').find('.current')<1){
                $('#svalue').html('');
            }

        });
    }
    // 设置车型
    function set_cartype_change_ini() {
        $("a[name='sCarType']").on("click",function() {
            $('#scartypelist').find('.current').removeClass('current');
            $(this).addClass('current');
            document.cookie = 'sCarType=' + $(this).data('value') + ';path=/;expires= 60';
            ajaxUpdatePrice();
        });
    }




//    $('#sTypeList').change(function(){
//       ajaxUpdateTimelist();
//    });

    function ajaxUpdateTimelist(){

        $.ajax({
            type:'GET',
            url:'AjaxTimeList',
            dataType:'JSON',
            data:{
                'id':"<?php echo $shop['id'] ?>",
                'sType':$("#sTypeList  option:selected").val(),
                'sDate':$('#sdatelist').find('.current').data('value'),
                'carType':$('#scartypelist').find('.current').data('value'),
            },
    //      async:true,
            'beforeSend':function(){layer.open({type: 2})},
            'success':function(rlt){
                layer.closeAll();
//                console.log(rlt['stimelist']);
                $('#scartypelist').html(rlt['scartypelist']);
                $('#stimelist').html(rlt['stimelist']);
//                $.each(rlt, function(i,val){
//                    $('#'+i).html(val);
//                });
            }
        });
    }

    function ajaxUpdatePrice(){
        $.ajax({
            type:'GET',
            url:'ajaxPrice',
            dataType:'JSON',
            data:{
                'id':'<?php echo $shop['id']; ?>',
                'orderId':$('#stimelist').find('.current').data('value'),
                'carType':$('#scartypelist').find('.current').data('value'),
                'sType':$("#sTypeList  option:selected").val(),
            },
    //      async:true,
            'beforeSend':function(){    $('#uPrice').html(' <i class=\"fa fa-spinner fa-pulse\"></i>');},
            'complete':function(){},
            'success':function(rlt){
                $('#svalue').val(rlt);
            }
        });
    }

    $("#selall").click(function () {//全选
        var aa=$("a[name='sTime']").hasClass('current');
        if(aa){
            $("a[name='sTime']").removeClass('current');
            $(this).html('全选');
        }else{
            $("a[name='sTime']").addClass('current');
            $(this).html('清空');
        }

    });

//    $("#unSel").click(function () {//反选
//        $('#scartypelist').find('.current').each(function(){
//            $(this).attr("checked", !$(this).attr("checked"));
//        });
//    });

   /* $("#clear").click(function () {//清空
        $("a[name='sTime']").removeClass('current');
    });*/
</script>


<?php
Yii::app()->clientScript->registerScript('selectFx','select_service_ini();',CClientScript::POS_READY);
Yii::app()->clientScript->registerScript('orderAdd',"
    function orderAdd(utype){
        var arr_d=new Array();
        $('#stimelist').find('.current').each(function(){
            arr_d.push($('#stimelist').find('.current').data('value'));
        });
        var loadi;
        $.ajax({
            type : 'POST',
            url:'".Yii::app()->createUrl('MWeiXinEntxcSettings/orderUpdate')."',
            data:{
                'ut':utype,
                'sValue':$('#svalue').val(),
                'dates':arr_d.join(','),
                'sType':$('#sTypeList  option:selected').val(),
                'sDate':$('#sdatelist').find('.current').data('value'),
                'carType':$('#scartypelist').find('.current').data('value'),
                // 'position':$('#position').val(),
            },
            dataType:'JSON',
            async:false,
            'beforeSend':function(){ loadi = layer.open({type: 2})},
            'error':function(){
                layer.open({
                        content:'加载失败',
                        time: 2
                    });
            },
            'complete':function(){ layer.close(loadi);},
            'success':function(rlt){
                if(rlt['status']){
                    layer.open({
                        content:rlt['msg'],
                        time: 2
                    });
                    ajaxUpdateTimelist();
                }else{
                    ajaxUpdateTimelist();
                }
            }
        });
    };
        ",CClientScript::POS_END);
?>