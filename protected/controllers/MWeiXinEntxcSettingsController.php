<?php

/**
 * User: Yuan
 * Date: 2016-01-20
 * Time: 9:32
 */

class MWeiXinEntxcSettingsController extends Controller {
    // const TOKEN = 'wXC.2015.?';
    /**
     *
     * @return array action filters
     */
    public function filters() {
        return array (
            'accessControl', // perform access control for CRUD operations
            array (
                'ext.starship.RestfullYii.filters.ERestFilter +
                REST.GET, REST.PUT, REST.POST, REST.DELETE'
            )
        );
    }

    public function beforeAction($action) {
        parent::beforeAction ( $action );
        Yii::app ()->clientScript->reset ();
        return true;
    }

    public function actions() {
        return array (
            'REST.' => 'ext.starship.RestfullYii.actions.ERestActionProvider'
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     *
     * @return array access control rules
     */
    public function accessRules() {
        return array (
            array (
                'allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array (
                    'REST.GET',
                    'REST.PUT',
                    'REST.POST',
                    'REST.DELETE',
                    'index'
                ),
                'users' => array (
                    '*'
                )
            ),
            array (
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array (
                    'update'
                ),
                'users' => array (
                    '@'
                )
            )
        );

    }

    public function restEvents() {
        $this->onRest ( 'post.filter.req.auth.ajax.user', function ($validation) {
            // return true;
            // if(!$validation) {
            // return false;
            // }
            switch ($this->getAction ()->getId ()) {
                case 'REST.GET' :
                    return true;
                case 'REST.POST' :
                    return true;
                    break;
                case 'REST.UPDATE' :
                    return Yii::app ()->user->checkAccess ( 'REST-UPDATE' );
                    break;
                case 'REST.DELETE' :
                    return Yii::app ()->user->checkAccess ( 'REST-DELETE' );
                    break;
                default :
                    return false;
                    break;
            }
            // return ($this->getAction()->getId() == 'REST.GET');
            // return true;
        } );
    }

    var $_token = 'w111';


    public function actionIndex() {

        include_once('emoji.php');

        $weixinEnt = new UWeChatEnt (AppName::$EntConfigMngr, Yii::app()->request->getParam('nonce'),
            Yii::app()->request->getParam('msg_signature'),
            Yii::app()->request->getParam('timestamp'),
            Yii::app()->request->getParam('echostr',NULL)
        );
        $weixinEnt->debug=TRUE;

        $weixinEnt->init();

        $this->
        $reply= '';
        $msg = $weixinEnt->msg;
        $msgType =(string) ($msg->MsgType);
        $msgType=empty($msgType) ? '' : strtolower($msgType);

        switch ($msgType){

            case 'text':
                $content = $this->receiveText($weixinEnt);

                break;
            case 'event':
                $content = $this->receiveEvent ( $weixinEnt );
                break;
            default:

                break;
        }

        $weixinEnt->reply($content);

    }


    private function getMenuData(){

//        return $jsonMenu;
    }

    /**
     * 更新位置信息
     * @param unknown $weChat
     * @return string
     */
    private function receiveLocation($weChat ,$autoUpload=FALSE){
        $msg = $weChat->msg;
        $userOpenId = $msg->FromUserName;
        if ($autoUpload==TRUE){
            $latitude = $msg->Latitude;
            $longitude = $msg-> Longitude;
        }else{
            $latitude = $msg->Location_X;
            $longitude = $msg-> Location_Y;
        }
        $weiUser = WeixinOpenid::model()->getUserByOpenId($userOpenId);
        if (isset($weiUser)){
            $locationRlt = UMap::convertGEO($longitude.','.$latitude);

            if ($locationRlt->status == 0){

                $longitude_x = $locationRlt->result[0]->x;
                $latitude_y = $locationRlt->result[0]->y;
                $weiUser['wo_location']=$longitude_x.','.$latitude_y;
                Yii::app()->session['currLocation']=$weiUser['wo_location'];

                $userLocation = new UserLocation();
                $userLocation['ul_datetime']=date('Y-m-d H:i:s',time());
                $userLocation['ul_latitude']=$latitude_y;
                $userLocation['ul_longitude']=$longitude_x;
                $userLocation['ul_user_openid'] = $weiUser['id'];
                $userLocation->save();


            }
            $weiUser['wo_update_time']=date('Y-m-d H:i:s',time());
            $weiUser->save();

        }
        return $longitude.','.$latitude.$msg->FromUserName.':'.$t.":".$weiUser->id;
    }

    public function loadModel($id) {
        $model = WashShop::model ()->with (
            "washShopServices.serviceType",
            "washShopServices.carGroup",
            "area",
            "favoriteCount",
            "memberCount",
            'orderCount' ,
            'latestNews',
            'commentCount'
        )->findByPk ( $id ,array('condition'=>'wss_st_id<=6'));
        return $model;

    }

    public function actionOrderUpdate() {
        if (Yii::app ()->request->isAjaxRequest && Yii::app ()->request->isPostRequest) {
            @$uType = $_POST ['ut'];
            @$otIds = $_POST ['dates'];
            @$sType = $_POST ['sType'];
            @$sValue = $_POST ['sValue'];
            // @$otStaffs = $_POST['staffs'];
            @$carType = $_POST ['carType'];
            $otStaffs = '';
            $rlt = OrderTemp::model ()->updateOrderByBoss ( $otIds, $otStaffs, $sType, $sValue, $uType, $carType );
            // Yii::app()->user->setFlash('orderAddRlt','Order add successfully!');
            if ($rlt ['status']) {
            } else {
                Yii::app ()->user->setFlash ( 'discountNumWarning', $rlt ['msg'] );
                //
            }
            echo CJSON::encode ( $rlt );
        }
    }

    /**
     * 获得车型分组代码
     * @return multitype:Ambigous <unknown, Ambigous <unknown, NULL>>
     */
    private function getCarGroup(){
        // 数据缓存设置
        $carGroupList = Yii::app ()->cache->get ( 'carGroupListData' );
        if ($carGroupList === false) {
            $carGroupListRlt = CarGroup::model ()->findAll ();
            $carGroupList = array ();
            foreach ( $carGroupListRlt as $key => $carGroup ) {
                $carGroupList [$carGroup ['id']] =array(
                    'id'=>$carGroup['id'],
                    'name'=>$carGroup['cg_name'],
                    'desc'=>$carGroup['cg_desc'],
                );
            }
            // 缓存列表数据
            Yii::app ()->cache->set ( 'carGroupListData', $carGroupList, 300 );
        }
        return $carGroupList;
    }



    private function getServiceType(){
        // 数据缓存设置
        $serviceTypeList = Yii::app ()->cache->get ( 'serviceTypeListData' );
        if ($serviceTypeList === false) {
            $serviceTypeListRlt = ServiceType::model ()->findAll ();
            $serviceTypeList = array ();
            foreach ( $serviceTypeListRlt as $key => $serviceType ) {
                $serviceTypeList [$serviceType ['id']] =array(
                    'id'=>'id',
                    'name'=>$serviceType['st_name'],
                    'desc'=>$serviceType['st_desc'],
                    'code'=>$serviceType['st_code'],
                );
            }
            // 缓存列表数据
            Yii::app ()->cache->set ( 'serviceTypeListData', $serviceTypeList, 300 );
        }
        return $serviceTypeList;
    }

    private function getShopService($shopServices){
        //获取车行提供的服务
        $serviceList = array ();
        foreach ( $shopServices as $key => $service ) {
            if (isset ( $serviceList [$service ['wss_st_id']] )) {
                $serviceList [$service ['wss_st_id']] ['carGroupList'] [$service ['wss_car_group']] = array (
                    'groupId' => $service ['wss_car_group'],
                    'groupValue'=> $service ['wss_value'],
                );
            } else {
                $serviceList [$service ['wss_st_id']] = array (
                    'id' => $service ['wss_st_id'],
                    'name' => $service->serviceType ['st_name'],
                    'carGroupList' => array ( $service ['wss_car_group']=>
                        array (
                            'groupId' => $service ['wss_car_group'],
                            'groupValue'=> $service ['wss_value'],
                            // 'groupname'=>$service['cg_name'],
                        )
                    ),
                );
            }
        } // end shop service
        return $serviceList;
    }

    public function actiontimeList() {
        $this->layout=  "main_weixin";
        $id=55;
        //$id=UWeChatEnt::getUserId(AppName::$EntConfigMngr,Yii::app()->request->getParam('code'));
        Yii::app()->session['user_id']=$id;
        if (!isset($id)) {
            echo "<div style='margin:50% 20%;font-size:50px;'>参数错误，请联系客服</div>";
            exit;
        }
        if(Yii::app()->request->isAjaxRequest){
            $sType = UCom::getCookieInt("sType", 1);
            $sDate = UCom::getCookieInt("sDate", 1);
            $sCarType = UCom::getCookieInt("sCarType", 1);
        }else{
            $sType = UCom::getCookieInt("sTypeFilter", 1);
            $sDate = UCom::getCookieInt("sDateFilter", 1);
            $sCarType = UCom::getCookieInt("sCarType", 1);

            setcookie('sType',$sType,0,'/');
            setcookie('sDate',$sDate,0,'/');
            setcookie('sCarType',$sCarType,0,'/');
        };

        $selectedParams = array(
            'sType'=>$sType,
            'sDate'=>$sDate,
            'sCarType'=>$sCarType
        );

        $shop =WashShop::model()->findByAttributes(array('ws_boss_id' =>$id));
        Yii::app()->session['shop']=$shop;
        $shopload = $this->loadModel($shop->id);
        $serviceList=$this->getShopService($shopload->washShopServices);
        $newsContent = NULL;
        if ( !empty($shop->latestNews) ){
            $newsContent = $shop->latestNews[0]['sn_desc'];
        }
        $shopInfo = array (
            'id' => $shop ['id'],
            'status'=>$shop['ws_state'],
            'address' => $shop ['ws_address'],
            'name' => $shop ['ws_name'],
            'score' => $shop ['ws_score'],
            'serviceList' => $serviceList,
            'keyWords' => array_filter ( explode( '[; ,]', $shop->ws_key_words ) ),
            'area' => $shop->area ['a_name'] ,
            'memberCount'=>$shop->memberCount,
            'favoriteCount'=>$shop->favoriteCount,
            'orderCount'=>$shop->orderCount,
            'latestNews'=>$newsContent,
            'commentCount'=>$shop->commentCount
        );

        $serviceTypeList = $this->getServiceType();
        $timeList = OrderTemp::model()->getTimeInfoList($shop['id'], $sType, $sDate-1);
        $this->render ( 'timelist', array (
            'model' => $shop,
            'shop'=>$shopInfo,
            'serviceTypeList'=>$serviceTypeList,
            'carGroupList'=>$this->getCarGroup(),
            'selectedParams'=>$selectedParams,
            'timeList'=>$timeList,
        ) );
    }


    public function actionAjaxTimeList(){
        $sDate = Yii::app ()->request->getParam ( 'sDate', 0 );
        $sCarType = Yii::app ()->request->getParam ( 'carType', 1);
        $sType = Yii::app ()->request->getParam ( 'sType', 1 );
        $shopId =  Yii::app()->request->getParam('id');

        $shop = $this->loadModel($shopId);

// 		车型划分
        $serviceList=$this->getShopService($shop->washShopServices);
        $sTypeCarGroup =$serviceList[$sType]['carGroupList'];
        $carGroupList = $this->getCarGroup();
        $scartypelistStr =  $this->renderPartial('_timelist_car_type',array(
            'selectedType'=>$sCarType,
            'sTypeCarGroup'=>$sTypeCarGroup,
            'carGroupList'=>$carGroupList
        ),TRUE,TRUE);

        $rlt['scartypelist']=$scartypelistStr;
// 		时间段信息
        $timeList = OrderTemp::model()->getTimeInfoList($shopId, $sType, $sDate-1);

        $timeListStr = $this->renderPartial('_time_list',array(
            'selectedType'=>$sType,
            'timeList'=>$timeList
        ),true,TRUE);

        $rlt['stimelist'] = $timeListStr;
        echo json_encode($rlt);
    }

    public function actionAjaxPrice(){
        $orderId = Yii::app()->request->getParam('orderId');
        $ordertemp= OrderTemp::model()->findByPk($orderId);
        $sCarType = Yii::app ()->request->getParam ( 'carType', 1);
        $sType = Yii::app ()->request->getParam ( 'sType', 1 );
        $shopId =  Yii::app()->request->getParam('id');

        $criteria=new CDbCriteria ();
        $criteria->addCondition ( 'wss_ws_id = :shopId' );
        $criteria->params [':shopId'] = $shopId;
        $criteria->addCondition ( 'wss_st_id = :sType' );
        $criteria->params [':sType'] = $sType;
        $criteria->addCondition ( 'wss_car_group = :sCarType' );
        $criteria->params [':sCarType'] = $sCarType;
        $service=WashShopService::model()->find($criteria);

        if($ordertemp->ot_value_discount!=0){
            $pricenew=$service->wss_value * $ordertemp->ot_value_discount;
//        Yii::log(CJSON::encode($pricenew),'warning','config.price.service');
            echo $pricenew;
        }else{
            echo $pricenew=$service->wss_value;
        }
//		echo json_encode($order->ot_value);
    }

    public function actionserviceSet(){
        $this->layout = 'main_weixin';
        $id=55;

        Yii::app ()->user->id=$id;
        if (!isset($id)) {
            echo "<div style='margin:50% 20%;font-size:50px;'>参数错误，请联系客服</div>";
            exit;
        }
        $model = new ShopServiceSetForm ();
/*        if (isset ( $_POST ['ShopServiceSetForm'] )) {
            // print_r($_POST);exit();
            $model->attributes = $_POST ['ShopServiceSetForm'];
            if ($model->save()) {
                // $setRlt = $model->save ();
                $msg = new Message ();
                $msg ['m_content'] = '更新车行服务基准设置' . $setRlt ['msg'];
                $msg ['m_datetime'] = date ( 'Y-m-d H:i:s' );
                $msg ['m_type'] = Message::TYPE_ACCOUNT;
                $msg ['m_user_id'] = $id;
                $msg ['m_src'] = UTool::getRequestInfo ();
                $msg ['m_level'] = Message::LEVEL_NORM;
                $msg->save ();

                Yii::app ()->user->setFlash ( 'serviceSetError', $setRlt ['msg'] );
            }else {
                Yii::app ()->user->setFlash ( 'serviceSetError', CJSON::encode($model->errors) );
            }

            Yii::app ()->end ( 0, true );
        }*/
        $shop =WashShop::model()->find('ws_boss_id=:ws_boss_id',array(':ws_boss_id' =>$id));
        Yii::app()->session['shop']=$shop;
//        $serviceinfo=WashShopService::model()->findAll('wss_ws_id=:ws_id',array(":ws_id"=>$shop->id));
        $this->render ( 'serviceSet', array (
            'shop' => $shop,
//            'serviceinfo'=>$serviceinfo,
            'model' => $model
        ) );
    }



    public function actionupdatexiche(){
        $shopId=Yii::app()->request->getParam('shopid');
//		$shopId=22;
        $data=$_POST;
//        print_r($data);
//        exit();
        $model = new ShopServiceSetForm ();
        $model->attributes = $data;
        if($model->validate ()){
            $setRlt = $model->savexiche();
            $msg = new Message ();
            $msg ['m_content'] = '更新车行服务基准设置' . $setRlt ['msg'];
            $msg ['m_datetime'] = date ( 'Y-m-d H:i:s' );
            $msg ['m_type'] = Message::TYPE_ACCOUNT;
            $msg ['m_user_id'] = Yii::app ()->user->id;
            $msg ['m_src'] = UTool::getRequestInfo ();
            $msg ['m_level'] = Message::LEVEL_NORM;
            $msg->save ();
            echo $setRlt['msg'];
        }else {
            echo $setRlt['msg']."-".CJSON::encode ( $model->errors );
        }
    }



}


