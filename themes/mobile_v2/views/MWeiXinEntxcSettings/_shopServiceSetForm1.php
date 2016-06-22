<?php
//普洗
$criteriap = new CDbCriteria ();
$criteriap->addCondition ( 'wss_ws_id = :shopId' );
$criteriap->params [':shopId'] = $shop->id;
$criteriap->addCondition ( 'wss_st_id =1' );
$Pservice=WashShopService::model()->findAll($criteriap);
//print_r($Pservice);

//打蜡
$criteriad = new CDbCriteria ();
$criteriad->addCondition ( 'wss_ws_id = :shopId' );
$criteriad->params [':shopId'] = $shop->id;
$criteriad->addCondition ( 'wss_st_id =3' );
$Dservice=WashShopService::model()->findAll($criteriad);

//精洗
$criteriaj = new CDbCriteria ();
$criteriaj->addCondition ( 'wss_ws_id = :shopId' );
$criteriaj->params [':shopId'] = $shop->id;
$criteriaj->addCondition ( 'wss_st_id =5' );
$Jservice=WashShopService::model()->findAll($criteriaj);

//快洗
$criteriak = new CDbCriteria ();
$criteriak->addCondition ( 'wss_ws_id = :shopId' );
$criteriak->params [':shopId'] = $shop->id;
$criteriak->addCondition ( 'wss_st_id =6' );
$Kservice=WashShopService::model()->findAll($criteriak);
?>

<style type="text/css">
    table{
        font-size: 12px;
    }
</style>
<form id="xiche-form">
    <div id="accordion" class="box-group">

        <?php if(!empty($Pservice)){?>
        <div class="panel box box-primary">
            <a class="" href="#collapseOne" data-parent="#accordion" data-toggle="collapse" aria-expanded="true">
                <div class="box-header with-border">
                    <h4 class="">
                        普洗
                        <i class="fa fa-angle-double-down pull-right"></i>
                    </h4>
                </div>
            </a>
            <div id="collapseOne" class="panel-collapse collapse" aria-expanded="true" style="">
                <div class="box-body">
                    <table class="table table-bordered text-center">
                        <tr>
                            <th class="col-xs-2">普洗</th>
                            <th class="col-xs-2">用时(分)</th>
                            <th class="col-xs-2">休息(分)</th>
                            <th class="col-xs-2">价格(元)</th>
                        </tr>
                        <?php if(!empty($Pservice['0'])){?>
                        <tr>
                            <td>轿车</td>
                            <td>
                                <input type="text" name="wss_service_time1" id="1" class="input-sm col-xs-12" value="<?php echo $Pservice[0]->wss_service_time ?>">
                            </td>
                            <td>
                                <select class="form-control"name="wss_service_time_rest" id="">
                                    <option <?php if($Pservice['0']->wss_service_time_rest==5) echo("selected");?> value="5">5</option>
                                    <option <?php if($Pservice['0']->wss_service_time_rest==10) echo("selected");?> value="10">10</option>
                                    <option <?php if($Pservice['0']->wss_service_time_rest==15) echo("selected");?> value="15">15</option>
                                    <option <?php if($Pservice['0']->wss_service_time_rest==20) echo("selected");?> value="20">20</option>
                                </select class="form-control"class="form-control">
                            </td>
                            <td>
                                <input type="text" name="wss_value11" id="1" class="input-sm col-xs-12" value="<?php echo $Pservice[0]->wss_value ?>">
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(!empty($Pservice['1'])){?>
                        <tr>
                            <td>小型SUV</td>
                            <td>
                                <input type="text" name="" id="1" class="input-sm col-xs-12" value="<?php echo $Pservice[1]->wss_service_time ?>">
                            </td>
                            <td>
                                <select class="form-control"name="" id="">
                                    <option <?php if($Pservice['0']->wss_service_time_rest==5) echo("selected");?> value="5">5</option>
                                    <option <?php if($Pservice['0']->wss_service_time_rest==10) echo("selected");?> value="10">10</option>
                                    <option <?php if($Pservice['0']->wss_service_time_rest==15) echo("selected");?> value="15">15</option>
                                    <option <?php if($Pservice['0']->wss_service_time_rest==20) echo("selected");?> value="20">20</option>
                                </select class="form-control"class="form-control">
                            </td>
                            <td>
                                <input type="text" name="wss_value12" id="1" class="input-sm col-xs-12" value="<?php echo $Pservice[1]->wss_value ?>">
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(!empty($Pservice['2'])){?>
                        <tr>
                            <td>中大型SUV</td>
                            <td>
                                <input type="text" name="" id="1" class="input-sm col-xs-12" value="<?php echo $Pservice[2]->wss_service_time ?>">
                            </td>
                            <td>
                                <select class="form-control"name="" id="">
                                    <option <?php if($Pservice['0']->wss_service_time_rest==5) echo("selected");?> value="5">5</option>
                                    <option <?php if($Pservice['0']->wss_service_time_rest==10) echo("selected");?> value="10">10</option>
                                    <option <?php if($Pservice['0']->wss_service_time_rest==15) echo("selected");?> value="15">15</option>
                                    <option <?php if($Pservice['0']->wss_service_time_rest==20) echo("selected");?> value="20">20</option>
                                </select class="form-control"class="form-control">
                            </td>
                            <td>
                                <input type="text" name="wss_value13" id="1" class="input-sm col-xs-12" value="<?php echo $Pservice[2]->wss_value ?>">
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if(!empty($Dservice)){?>
        <div class="panel box box-danger">
            <a class="collapsed" href="#collapseTwo" data-parent="#accordion" data-toggle="collapse" aria-expanded="false">
                <div class="box-header with-border">
                    <h4 class="">
                        打蜡
                        <i class="fa fa-angle-double-down pull-right"></i>
                    </h4>
                </div>
            </a>
            <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="box-body">
                    <table class="table table-bordered text-center">
                        <tr>
                            <th class="col-xs-2">打蜡</th>
                            <th class="col-xs-2">用时(分)</th>
                            <th class="col-xs-2">休息(分)</th>
                            <th class="col-xs-2">价格(元)</th>
                        </tr>
                        <?php if(!empty($Dservice['0'])){?>
                        <tr>
                            <td>轿车</td>
                            <td>
                                <input type="text" name="wss_service_time3" id="1" class="input-sm col-xs-12" value="<?php echo $Dservice[0]->wss_service_time ?>">
                            </td>
                            <td>
                                <select class="form-control"name="wss_service_time_rest" id="">
                                    <option <?php if($Dservice['0']->wss_service_time_rest==5) echo("selected");?> value="5">5</option>
                                    <option <?php if($Dservice['0']->wss_service_time_rest==10) echo("selected");?> value="10">10</option>
                                    <option <?php if($Dservice['0']->wss_service_time_rest==15) echo("selected");?> value="15">15</option>
                                    <option <?php if($Dservice['0']->wss_service_time_rest==20) echo("selected");?> value="20">20</option>
                                </select class="form-control"class="form-control">

                            </td>
                            <td>
                                <input type="text" name="wss_value31" id="1" class="input-sm col-xs-12" value="<?php echo $Dservice[0]->wss_value ?>">
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(!empty($Dservice['1'])){?>
                        <tr>
                            <td>小型SUV</td>
                            <td>
                                <input type="text" name="" id="1" class="input-sm col-xs-12" value="<?php echo $Dservice[1]->wss_service_time ?>">
                            </td>
                            <td>
                                <select class="form-control"name="" id="">
                                    <option <?php if($Dservice['0']->wss_service_time_rest==5) echo("selected");?> value="5">5</option>
                                    <option <?php if($Dservice['0']->wss_service_time_rest==10) echo("selected");?> value="10">10</option>
                                    <option <?php if($Dservice['0']->wss_service_time_rest==15) echo("selected");?> value="15">15</option>
                                    <option <?php if($Dservice['0']->wss_service_time_rest==20) echo("selected");?> value="20">20</option>
                                </select class="form-control"class="form-control">
                            </td>
                            <td>
                                <input type="text" name="" id="1" class="input-sm col-xs-12" value="<?php echo $Dservice[1]->wss_value ?>">
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(!empty($Dservice['2'])){?>
                        <tr>
                            <td>中大型SUV</td>
                            <td>
                                <input type="text" name="wss_value32" id="1" class="input-sm col-xs-12" value="<?php echo $Dservice[2]->wss_service_time ?>">
                            </td>
                            <td>
                                <select class="form-control"name="" id="">
                                    <option <?php if($Dservice['0']->wss_service_time_rest==5) echo("selected");?> value="5">5</option>
                                    <option <?php if($Dservice['0']->wss_service_time_rest==10) echo("selected");?> value="10">10</option>
                                    <option <?php if($Dservice['0']->wss_service_time_rest==15) echo("selected");?> value="15">15</option>
                                    <option <?php if($Dservice['0']->wss_service_time_rest==20) echo("selected");?> value="20">20</option>
                                </select class="form-control"class="form-control">
                            </td>
                            <td>
                                <input type="text" name="wss_value33" id="1" class="input-sm col-xs-12" value="<?php echo $Dservice[3]->wss_value ?>">
                            </td>
                        </tr>
                        <?php } ?>

                    </table>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if(!empty($Jservice)){?>
        <div class="panel box box-success">
            <a class="collapsed" href="#collapseThree" data-parent="#accordion" data-toggle="collapse" aria-expanded="false">
                <div class="box-header with-border">
                    <h4 class="">
                        精洗
                        <i class="fa fa-angle-double-down pull-right"></i>
                    </h4>
                </div>
            </a>
            <div id="collapseThree" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="box-body">
                    <table class="table table-bordered text-center">
                        <tr>
                            <th class="col-xs-2">精洗</th>
                            <th class="col-xs-2">用时(分)</th>
                            <th class="col-xs-2">休息(分)</th>
                            <th class="col-xs-2">价格(元)</th>
                        </tr>
                        <?php if(!empty($Jservice['0'])){?>
                        <tr>
                            <td>轿车</td>
                            <td>
                                <input type="text" name="wss_service_time5" id="1" class="input-sm col-xs-12" value="<?php echo $Jservice[0]->wss_service_time ?>">
                            </td>
                            <td>
                                <select class="form-control"name="wss_service_time_rest" id="">
                                    <option <?php if($Jservice['0']->wss_service_time_rest==5) echo("selected");?> value="5">5</option>
                                    <option <?php if($Jservice['0']->wss_service_time_rest==10) echo("selected");?> value="10">10</option>
                                    <option <?php if($Jservice['0']->wss_service_time_rest==15) echo("selected");?> value="15">15</option>
                                    <option <?php if($Jservice['0']->wss_service_time_rest==20) echo("selected");?> value="20">20</option>
                                </select class="form-control"class="form-control">
                            </td>
                            <td>
                                <input type="text" name="wss_value51" id="1" class="input-sm col-xs-12" value="<?php echo $Jservice[0]->wss_value ?>">
                            </td>
                        </tr>
                        <?php } ?>
                        <?php if(!empty($Jservice['1'])){?>
                        <tr>
                            <td>小型SUV</td>
                            <td>
                                <input type="text" name="" id="1" class="input-sm col-xs-12" value="<?php echo $Jservice[1]->wss_service_time ?>">
                            </td>
                            <td>
                                <select class="form-control"name="" id="">
                                    <option <?php if($Jservice['0']->wss_service_time_rest==5) echo("selected");?> value="5">5</option>
                                    <option <?php if($Jservice['0']->wss_service_time_rest==10) echo("selected");?> value="10">10</option>
                                    <option <?php if($Jservice['0']->wss_service_time_rest==15) echo("selected");?> value="15">15</option>
                                    <option <?php if($Jservice['0']->wss_service_time_rest==20) echo("selected");?> value="20">20</option>
                                </select class="form-control"class="form-control">
                            </td>
                            <td>
                                <input type="text" name="wss_value52" id="1" class="input-sm col-xs-12" value="<?php echo $Jservice[1]->wss_value ?>">
                            </td>
                        </tr>
                        <?php } ?>
                        <?php if(!empty($Jservice['2'])){?>
                        <tr>
                            <td>中大型SUV</td>
                            <td>
                                <input type="text" name="" id="1" class="input-sm col-xs-12" value="<?php echo $Jservice[2]->wss_service_time ?>">
                            </td>
                            <td>
                                <select class="form-control"name="" id="">
                                    <option <?php if($Jservice['0']->wss_service_time_rest==5) echo("selected");?> value="5">5</option>
                                    <option <?php if($Jservice['0']->wss_service_time_rest==10) echo("selected");?> value="10">10</option>
                                    <option <?php if($Jservice['0']->wss_service_time_rest==15) echo("selected");?> value="15">15</option>
                                    <option <?php if($Jservice['0']->wss_service_time_rest==20) echo("selected");?> value="20">20</option>
                                </select class="form-control"class="form-control">
                            </td>
                            <td>
                                <input type="text" name="wss_value53" id="1" class="input-sm col-xs-12" value="<?php echo $Jservice[2]->wss_value ?>">
                            </td>
                        </tr>
                        <?php } ?>

                    </table>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if(!empty($Kservice)){?>
            <div class="panel box box-warning">
            <a class="collapsed" href="#collapseFour" data-parent="#accordion" data-toggle="collapse" aria-expanded="false">
                <div class="box-header with-border">
                    <h4 class="">
            快洗
                        <i class="fa fa-angle-double-down pull-right"></i>
                    </h4>
                </div>
            </a>
            <div id="collapseFour" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="box-body">
                    <table class="table table-bordered text-center">
                        <tr>
                            <th class="col-xs-2">普洗</th>
                            <th class="col-xs-2">用时(分)</th>
                            <th class="col-xs-2">休息(分)</th>
                            <th class="col-xs-2">价格(元)</th>
                        </tr>
                        <tr>
                            <td>轿车</td>
                            <td>
                                <input type="text" name="wss_service_time6" id="1" class="input-sm col-xs-12" value="<?php echo $Kservice[0]->wss_service_time ?>">
                            </td>
                            <td>
                                <select class="form-control"name="wss_service_time_rest" id="">
                                    <option <?php if($Kservice['0']->wss_service_time_rest==5) echo("selected");?> value="5">5</option>
                                    <option <?php if($Kservice['0']->wss_service_time_rest==10) echo("selected");?> value="10">10</option>
                                    <option <?php if($Kservice['0']->wss_service_time_rest==15) echo("selected");?> value="15">15</option>
                                    <option <?php if($Kservice['0']->wss_service_time_rest==20) echo("selected");?> value="20">20</option>
                                </select class="form-control"class="form-control">

                            </td>
                            <td>
                                <input type="text" name="wss_value61" id="1" class="input-sm col-xs-12" value="<?php echo $Kservice[0]->wss_value ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>小型SUV</td>
                            <?php if(!empty($Kservice['0'])){?>
                            <td>
                                <input type="text" name="" id="1" class="input-sm col-xs-12" value="<?php echo $Kservice[1]->wss_service_time ?>">
                            </td>
                            <?php } ?>
                            <?php if(!empty($Kservice['1'])){?>
                            <td>
                                <select class="form-control"name="" id="">
                                    <option <?php if($Kservice['0']->wss_service_time_rest==5) echo("selected");?> value="5">5</option>
                                    <option <?php if($Kservice['0']->wss_service_time_rest==10) echo("selected");?> value="10">10</option>
                                    <option <?php if($Kservice['0']->wss_service_time_rest==15) echo("selected");?> value="15">15</option>
                                    <option <?php if($Kservice['0']->wss_service_time_rest==20) echo("selected");?> value="20">20</option>
                                </select class="form-control"class="form-control">
                                <!--                                        <input type="text" name="wss_service_time1" id="1" class="input-sm col-xs-12" value="--><?php //echo $serviceinfo[1]->wss_service_time_rest ?><!--">-->
                            </td>
                            <?php } ?>
                            <?php if(!empty($Kservice['2'])){?>
                            <td>
                                <input type="text" name="wss_value62" id="1" class="input-sm col-xs-12" value="<?php echo $Kservice[1]->wss_value ?>">
                            </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td>中大型SUV</td>
                            <td>
                                <input type="text" name="" id="1" class="input-sm col-xs-12" value="<?php echo $Kservice[2]->wss_service_time ?>">
                            </td>
                            <td>
                                <select class="form-control"name="" id="">
                                    <option <?php if($Kservice['0']->wss_service_time_rest==5) echo("selected");?> value="5">5</option>
                                    <option <?php if($Kservice['0']->wss_service_time_rest==10) echo("selected");?> value="10">10</option>
                                    <option <?php if($Kservice['0']->wss_service_time_rest==15) echo("selected");?> value="15">15</option>
                                    <option <?php if($Kservice['0']->wss_service_time_rest==20) echo("selected");?> value="20">20</option>
                                </select class="form-control"class="form-control">
                                <!--                                        <input type="text" name="wss_service_time1" id="1" class="input-sm col-xs-12" value="--><?php //echo $serviceinfo[2]->wss_service_time_rest ?><!--">-->
                            </td>
                            <td>
                                <input type="text" name="wss_value63" id="1" class="input-sm col-xs-12" value="<?php echo $Kservice[2]->wss_value ?>">
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
        <?php } ?>

    </div>

    <div  style="position: fixed;bottom:0px;background-color: rgba(146, 151, 152, 0.39);height: 50px;width: 100%;">
        <div class="row"  style="line-height: 50px;">
            <div class="col-xs-8 col-xs-offset-3">
                <span style="color:#fff">已设置完成？</span>
<!--                <a href="#" class="btn btn-app" style="background-color: orange;">-->
<!--                    确定-->
                    <a type="button" onclick="xiche();" class="btn btn-warning">
                        <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> 确定
                    </a>
<!--                </a>-->
            </div>

        </div>
    </div>
</form>
<script>
    function xiche() {
        var data = $("#xiche-form").serialize();
//        console.log(data);
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


</script>
