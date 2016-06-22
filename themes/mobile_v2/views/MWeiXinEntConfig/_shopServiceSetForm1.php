<?php
$xichetype=ServiceType::model()->findAll("id<=6");
$meirongtype=ServiceType::model()->findAll("id>6");
//print_r($meirongtype);
?>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <h4 class="panel-title" >
                <span style="color:orange;">
                    <b>洗车</b>
                    <span class="glyphicon glyphicon-chevron-down pull-right"></span>
                </span>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <form id="xiche-form">
                            <table class="table table-bordered text-center">
                                <tr>
                                    <th class="col-xs-2">服务</th>
                                    <th class="col-xs-2">用时(分)</th>
                                    <th class="col-xs-2">休息(分)</th>
                                    <th class="col-xs-2">轿车(元)</th>
                                    <th class="col-xs-2">小型SUV(元)</th>
                                    <th class="col-xs-2">中大型SUV(元)</th>
                                </tr>
                                <?php foreach($xichetype as $k => $value){
            //                        echo $key;
                                    $criteria = new CDbCriteria();
                                    $criteria->addCondition('wss_ws_id=:shopId');
                                    $criteria->params[':shopId']=$shop->id;
                                    $criteria->addCondition('wss_st_id='.$value->id);
                                    $criteria->addCondition('wss_state>=0');
                                    $serviceinfo=WashShopService::model()->findAll($criteria);
            //                        print_r($serviceinfo);
                                    ?>
                                    <tr>
                                        <td><?php echo $value['st_name'] ?></td>
                                        <td>
                                            <?php if(!empty($serviceinfo['0']->wss_service_time)){?>
                                                <input type="text" name="wss_service_time<?php echo $value['id']?>" id="<?php echo $value['id'] ?>" class="input-sm col-xs-12" value="<?php echo $serviceinfo['0']->wss_service_time;?>">
                                            <?php }else{
                                                echo "—";
                                            }?>
                                        </td>
                                        <td>
                                            <?php if(!empty($serviceinfo['0']->wss_service_time_rest)){?>
            <!--                                    <input type="text" class="input-sm col-xs-12" value="--><?php //echo $serviceinfo['0']->wss_service_time_rest;?><!--">-->
                                                <select name="wss_service_time_rest<?php echo $value['id']?>">
                                                    <option>5</option>
                                                    <option selected>10</option>
                                                    <option>20</option>
                                                    <option>30</option>

                                                </select>
                                            <?php }else{
                                                echo "—";
                                            }?>

                                        </td>
                                        <td>
                                            <?php if(!empty($serviceinfo['0']->wss_value)){?>
                                                <input type="text" name="wss_value<?php echo $value['id']?>1" class="input-sm col-xs-12" value="<?php echo $serviceinfo['0']->wss_value ?>">
                                            <?php }else{
                                                echo "—";
                                            }?>
                                        </td>
                                        <td>
                                            <?php if(!empty($serviceinfo['1']->wss_value)){?>
                                                <input type="text" name="wss_value<?php echo $value['id']?>2" class="input-sm col-xs-12" value="<?php echo $serviceinfo["1"]->wss_value ?>">
                                            <?php }else{
                                                echo "—";
                                            }?>
                                        </td>
                                        <td>
                                            <?php if(!empty($serviceinfo['2']->wss_value)){?>
                                                <input type="text" name="wss_value<?php echo $value['id']?>3" class="input-sm col-xs-12" value="<?php echo $serviceinfo["2"]->wss_value ?>">
                                            <?php }else{
                                                echo "—";
                                            }?>

                                        </td>
                                    </tr>
                                <?php }?>
                            </table>
                            <a class="btn btn-info pull-right" id="xc" onclick="xiche();">修改</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            <h4 class="panel-title collapsed" >
                <span style="color:orange;">
                    <b>美容</b>
                    <span class="glyphicon glyphicon-chevron-down pull-right"></span>
                </span>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
                <form id="meirong-form">
                <table class="table table-bordered table-hover text-center">
                    <tr>
                        <th class="col-xs-2">服务</th>
                        <th class="col-xs-2">用时</th>
                        <th class="col-xs-2">休息</th>
                        <th class="col-xs-2">品牌</th>
                        <th class="col-xs-2">价格</th>
                    </tr>
                    <?php foreach($meirongtype as $k => $value){
                        $criteria = new CDbCriteria();
                        $criteria->addCondition('wss_ws_id=:shopId');
                        $criteria->params[':shopId']=$shop->id;
                        $criteria->addCondition('wss_st_id='.$value->id);
                        $criteria->addCondition('wss_state>=0');
                        $serviceinfo=WashShopService::model()->findAll($criteria);
//                        print_r($serviceinfo);
                    ?>
                    <tr>
                        <td><?php echo $value['st_desc'] ?></td>
                        <td>
                            <?php if(!empty($serviceinfo['0']->wss_service_time)){?>
                                <input type="text" name="wss_service_time<?php echo $value['id']?>" class="input-sm col-xs-12" value="<?php echo $serviceinfo["$k"]->wss_service_time;?>">
                            <?php }else{
                                echo "—";
                            }?>
                        </td>

                        <td>
                            <?php if(!empty($serviceinfo['0']->wss_service_time_rest)){?>
                                <!--                                    <input type="text" class="input-sm col-xs-12" value="--><?php //echo $serviceinfo['0']->wss_service_time_rest;?><!--">-->
                                <select name="wss_service_time_rest<?php echo $value['id']?>">
                                    <option>5</option>
                                    <option selected>10</option>
                                    <option>20</option>
                                    <option>30</option>
                                </select>
                            <?php }else{
                                echo "—";
                            }?>

                        </td>

                        <td>
                            <?php
                                $typename=CarGroup::model()->find("id=:id",array(":id"=>$serviceinfo["$k"]->wss_car_group));
                                echo $typename->cg_name;
                            ?>
                        </td>
                        <td>
                            <?php if(!empty($serviceinfo['0']->wss_value)){?>
                                <input type="text" name="wss_value<?php echo $value['id']?>" class="input-sm col-xs-12" value="<?php echo $serviceinfo["$k"]->wss_value ?>">
                            <?php }else{
                                echo "—";
                            }?>
                        </td>
                        <?php } ?>
                    </tr>
                </table>
                    <a class="btn btn-info pull-right" id="mr" onclick="meirong();">修改</a>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    function xiche() {
        var data = $("#xiche-form").serialize();
        $.ajax({
            type: 'POST',
            url: 'updatexiche?shopid='+<?php echo $shop->id?>,
            data: data,
            //      async:true,
            beforeSend:function(){
                $("#xc").addClass('disabled');
                $("#xc").html('修改中..');
                layer.open({type: 2});
            },
            'success': function (rlt) {
                layer.closeAll();
                layer.open({
                    content:rlt,
                    time:2,
                })
                $('#xc').removeClass('disabled');
                $("#xc").html('修改');
            },
        });
    }

    function meirong(){
//        var data=$("#meirong-form").serialize();
        var data = $("#meirong-form").serialize();
        console.log(data);
        $.ajax({
            type:'POST',
            url:'updatemeirong?shopid='+<?php echo $shop->id?>,
            data: data,
            beforeSend:function(){
                $("#mr").addClass('disabled');
                $("#mr").html('修改中..');
                layer.open({type: 2});
            },
            'success': function (rlt) {
                layer.closeAll()
                layer.open({
                    content:rlt,
                    time:2,
                })
                $('#mr').removeClass('disabled');
                $("#mr").html('修改');
            },
        });
    }

</script>
