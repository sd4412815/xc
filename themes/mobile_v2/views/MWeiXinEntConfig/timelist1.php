<?php
$this->pageTitle = '时间段管理';
?>

 <!-- Custom Tabs -->
    
        <div class="nav-tabs-custom" style="padding-top:10px;width:98%;margin:0 auto">
            <div class="tab-content">
                <div class="tab-pane active" id="tab-order">
                    <div class="row">
                        <div class=" col-xs-2 text-right h6">类型</div>
                        <div class=" col-xs-10">
                            <select class="cs-select cs-skin-elastic-service" style="width:80%" id="sType">
                                <option value="1"  selected>普洗（车内＋车外）</option>
                                <option value="3" >普洗＋打蜡（车内＋车外＋精品蜡＋手工）</option>
                                <option value="5" >精洗（精细车内＋车外）</option>
                                <option value="6" >快洗 （只洗车外）</option>
                            </select>
                        </div>
                    </div>                

                    <div class="row">
                        <div class=" col-xs-2 text-right h6">日期</div>
                        <div class="col-xs-10">
                            <a id="serviceDate" value="0" class="btn btn-item time-info current">今天(<?php echo date('d日')?>)</a>
                            <a id="serviceDate" value="1" class="btn btn-item time-info">明天(<?php echo date('d日',time()+24*60*60);?>)</a>
                            <a id="serviceDate" value="2" class="btn btn-item time-info">后天(<?php echo date('d日',time()+2*24*60*60);?>)</a>
                        </div>
                    </div>      
                    <div class="row">
                      <div class=" col-xs-2 text-right h6">车型</div>
                      <div class="col-xs-10">
                            <a id="carType"  value="0" class="btn btn-item time-info current">轿车</a>
                            <a id="carType" value="1" class="btn btn-item time-info">小型SUV</a>
                            <a id="carType" value="2" class="btn btn-item time-info">中大型SUV</a>
                      </div>
                    </div>
                    <div class="row">
                        <div class=" col-xs-2 text-right h6">车位</div>
                        <div class="col-xs-10">
                            <a id="position" value="0" class="btn btn-item time-info current">车位A</a>
                            <a id="position" value="1" class="btn btn-item time-info">车位B</a>
                            <a id="position" value="2" class="btn btn-item time-info">车位C</a>
                         </div>
                    </div>
                    <div class="row">
                        <div class=" col-xs-2 text-right h6">时间</div>
                        <div class="col-xs-10" id="timelist">
                            <a class="btn btn-item time-info" id="time" onclick="time(1);" data-text="赠" >9:00<span class="zhe-stick" data-text="折" ></span></a>
                            <a class="btn btn-item time-info ">10:00<span class="" data-text="折" ></span></a>
                            <a class="btn btn-item time-info free-stick" data-text="赠" >11:00<span class="zhe-stick" data-text="折" ></span></a>
                            <a class="btn btn-item time-info "  >12:00<span class="zhe-stick" data-text="折" ></span></a>
                            <a class="btn btn-item time-info free-stick" data-text="赠" >13:00<span class="zhe-stick" data-text="折" ></span></a>
                            <a class="btn btn-item time-info free-stick" data-text="赠" >14:00<span class="zhe-stick" data-text="折" ></span></a>
                            <!-- <a class="btn btn-item time-info free-stick disabled " data-text="赠" >8:00<span class="zhe-box" data-text="折" ><i class="fa fa-jpy"></i>5</span></a> -->
                            <a class="btn btn-item time-info " data-text="赠" >9:00<span class="zhe-stick" data-text="折" ></span></a>
                            <a class="btn btn-item time-info ">10:00<span class="" data-text="折" ></span></a>
                            <a class="btn btn-item time-info free-stick" data-text="赠" >11:00<span class="zhe-stick" data-text="折" ></span></a>
                            <a class="btn btn-item time-info "  >12:00<span class="zhe-stick" data-text="折" ></span></a>
                            <a class="btn btn-item time-info free-stick" data-text="赠" >13:00<span class="zhe-stick" data-text="折" ></span></a>
                            <a class="btn btn-item time-info free-stick" data-text="赠" >14:00<span class="zhe-stick" data-text="折" ></span></a>
                            <?php 
                                // $this->renderPartial('_timelistInfo');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group has-warning">
                <div class=" col-xs-2 text-right h6">价格</div>
                <input type="text" class="form-control" style="width:150px;margin-top:20px;" name="svalue" id="svalue"  placeholder="￥"/>
                <p style="color:red;margin-left:16%;">您的价格低于初始价格，页面会显示‘折’标注</p>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-md-2">
                    <input type="button" class="btn btn-info col-xs-12" id="btnDisableOrder" style="margin:5px;height:50px;width:70%;margin-left:15%;"  onclick="orderAdd(1)" value="禁用选中车位" />
                </div>
            
                <div class="col-xs-12 col-md-2">
                    <input type="button" id="btnEnableOrder" class="btn btn-success col-xs-12" style="margin:5px;height:50px;width:70%;margin-left:15%;" onclick="orderAdd(2)" value="启用选中车位" />
                </div>
                <div class="col-xs-12 col-md-3">
                    <button type="submit" id="btnOrderAdd" style="margin:5px;height:50px;width:70%;margin-left:15%;" class="btn btn-warning col-xs-12" onclick="orderAdd(3)">重新设置选中时间段信息</button>
                </div>
            </div>
        </div>
         <div id="sDateList" class="sDateListClass"></div>

<?php $shopId=22;?>

<script type="text/javascript">
    function time(type,id){
        if ($('#'+type).hasClass('current')) {
            $('#'+type).removeClass('current');
        }else{
            $('#'+type).addClass('current');
            $('#svalue').val(1);
            getTimeList();
        }
    };

    function getTimeList(){
        $.ajax({
            url:'"<?php Yii::app()->createUrl('MWeiXinEntConfig/getTimelist') ?>"',
            data:{
                'id':"<?php echo $shopId ?>",
                'sType':$('#sType').val(),
                'bias':$('#serviceDate').val(),
                'carType':$('#carType').val(),
                'position':$('#position').val()
            },
            async: false, 
            //beforeSend:function(){ loadi = layer.load("加载中...");},
            success:function(html){
                $('#sDateList').html(html);
                // $('#svalue').val('');
            },
        });
    };

    function serviceDate(){
        var type='serviceDate';
        time(type);
        // getTimeList();
    }
    

    //var timelist=$('#timelist current').val();
    // alert(timelist);
</script>


