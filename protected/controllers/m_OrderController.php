<?php

class MOrderController extends Controller
{

    /**
     *
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            array(
                'ext.starship.RestfullYii.filters.ERestFilter + 
                REST.GET, REST.PUT, REST.POST, REST.DELETE'
            )
        );
    }

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        Yii::app()->clientScript->reset();
        return true;
    }

    public function actions()
    {
        return array(
            'REST.' => 'ext.starship.RestfullYii.actions.ERestActionProvider'
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     *
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array(
                'allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(
                    'REST.GET',
                    'REST.PUT',
                    'REST.POST',
                    'REST.DELETE'
                ),
                'users' => array(
                    '*'
                )
            ),
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    'update'
                ),
                'users' => array(
                    '@'
                )
            )
        );
        // array('allow', // allow admin user to perform 'admin' and 'delete' actions
        // 'actions'=>array('admin','delete'),
        // 'users'=>array('admin'),
        // ),
        // array('deny', // deny all users
        // 'users'=>array('*'),
        // ),
        
    }

    public function restEvents()
    {
        $this->onRest('post.filter.req.auth.ajax.user', function ($validation) {
            // return true;
            // if(!$validation) {
            // return false;
            // }
            switch ($this->getAction()
                ->getId()) {
                case 'REST.GET':
                    return true;
                case 'REST.POST':
                    // return Yii::app()->user->checkAccess('REST-CREATE');
                    // return !Yii::app()->user->isGuest;
                    return true;
                    break;
                case 'REST.POST':
                    return Yii::app()->user->checkAccess('REST-UPDATE');
                    break;
                case 'REST.DELETE':
                    return Yii::app()->user->checkAccess('REST-DELETE');
                    break;
                default:
                    return false;
                    break;
            }
            // return ($this->getAction()->getId() == 'REST.GET');
            // return true;
        });
        $this->onRest('req.get.orderList.render', function () {
            // Custom logic for this route.
            $rlt = UTool::iniFuncRlt();
            $userId = Yii::app()->request->getParam('uid');
            $pageIndex = Yii::app()->request->getParam('pageIndex', 0);
            $pageSize = Yii::app()->request->getParam('pageSize', 10);
            $startTime = Yii::app()->request->getParam('startTime', NULL);
            $endTime = Yii::app()->request->getParam('endTime', NULL);
            
            $rlt = $this->getList($userId, $pageIndex, $pageSize, $startTime, $endTime);
            
            // Should output results.
            $this->emitRest('req.render.json', [
                $rlt
            ]);
        });
        
        $this->onRest('req.post.add.render', function () {
            // Custom logic for this route.
            $rlt = UTool::iniFuncRlt();
            $userId = Yii::app()->request->getParam('uid');
            $carType = Yii::app()->request->getParam('carType', 0);
            $otId = Yii::app()->request->getParam('otId');
            $ip = Yii::app()->request->getParam('ip');
            $mac = Yii::app()->request->getParam('mac');
            $cardId = Yii::app()->request->getParam('cardId');
            
            $rlt = $this->add($userId, $carType, $otId, $ip, $mac, $cardId);
            
            // Should output results.
            $this->emitRest('req.render.json', [
                $rlt
            ]);
        });
        
        $this->onRest('req.post.orderAck.render', function () {
            // Custom logic for this route.
            $rlt = UTool::iniFuncRlt();
            $userId = Yii::app()->request->getParam('uid');
            $orderId = Yii::app()->request->getParam('oid');
            $comment = Yii::app()->request->getParam('comment');
            $score = Yii::app()->request->getParam('score');
            
            $rlt = $this->orderAckbyUserOk($userId, $orderId, $comment, $score);
            
            // Should output results.
            $this->emitRest('req.render.json', [
                $rlt
            ]);
        });
        
        $this->onRest('req.post.orderCancel.render', function () {
            // Custom logic for this route.
            $rlt = UTool::iniFuncRlt();
            $userId = Yii::app()->request->getParam('uid');
            $orderId = Yii::app()->request->getParam('oid');
            // $comment = Yii::app()->request->getParam('comment');
            // $score = Yii::app()->request->getParam('score');
            
            $rlt = $this->orderAckbyUserCancel($userId, $orderId);
            
            // Should output results.
            $this->emitRest('req.render.json', [
                $rlt
            ]);
        });
    }

    private function add($userId, $carType, $otId, $ip, $mac, $cardId)
    {
        $rlt = UTool::iniFuncRlt();
        $otStaffs = '0,0';
        $updateRlt = OrderTemp::model()->updateOrder($otId, $otStaffs, $userId, $carType);
        if (! $updateRlt['status']) {
            // return CJSON::encode($updateRlt);
            return $updateRlt;
        }
        
        $rlt = OrderHistory::model()->getOrderNew($otId, $cardId, 0, $ip, $mac, $userId);
        
        if ($rlt['status']) {
            $rltSendSms = USms::sendSmsOrder($rlt['data']);
            $msg = new Message();
            $msg['m_datetime'] = date('Y-m-d H:i:s');
            $msg['m_user_id'] = $userId;
            $msg['m_status'] = 0;
            $msg['m_level'] = Message::LEVEL_PRIORITY;
            $msg['m_type'] = Message::TYPE_ORDER;
            $msg['m_src'] = UTool::getRequestInfo();
            $orderItem = $rlt['data'];
            $msg['m_content'] = $rltSendSms['data'];
            if ($msg->save()) {}
            
            // UTool::orderSubmitSms ( $rlt ['data'] );
            // Yii::app ()->user->setFlash ( 'orderAddSuccess', $orderItem['id'] );
            $rlt['msg'] = '预约成功';
            $rlt['status'] = true;
            $orderInfo = $rlt['data'];
            $rlt['data'] = array(
                'id' => $orderInfo['id'],
                'no' => $orderInfo['oh_no']
            );
            
            // return CJSON::encode($rlt);
            return $rlt;
            // echo 'true';
        } else {
            $rlt['msg'] = '预约失败，请刷新页面重试';
            // echo 'false';
            // echo CJSON::encode($rlt);
            return $rlt;
        }
    }

    /**
     * 车主确认订单
     * 刘长鑫
     * 20140415
     * 
     * @param 车主id $uid            
     * @param 订单id $oid            
     * @param string $comment            
     * @param float $score            
     * @return Ambigous <multitype:, boolean, string, number, mixed>
     */
    private function orderAckbyUserOk($uid, $oid, $comment, $score)
    {
        $rlt = UTool::iniFuncRlt();
        $model = new CommentForm();
        $model->setScenario('ack');
        $model['comment'] = $comment;
        $model['id'] = $oid;
        $model['score'] = $score;
        
        if ($model->validate()) {
            
            $purifier = new CHtmlPurifier();
            $model['comment'] = $purifier->purify($model['comment']);
            $ackRlt = OrderHistory::model()->getOrderAckbyUser($model['id'], $uid, 1, $model['score'], $model['comment']);
            if ($ackRlt['status']) {
                $rlt['msg'] = '订单确认成功';
                $rlt['status'] = true;
            } else {
                $rlt['status'] = false;
                $rlt['msg'] = $ackRlt['msg'];
            }
        } else {
            $rlt['msg'] =CJSON::decode( CActiveForm::validate($model));
        }
        
        return $rlt;
    }

    /**
     * 车主取消订单
     * 刘长鑫
     * 20150415
     */
    private function orderAckbyUserCancel($uid, $oid)
    {
        $rlt = UTool::iniFuncRlt();
        $model = new CommentForm();
        $model['id'] = $oid;
        
        if ($model->validate()) {
            $rlt = UTool::iniFuncRlt();
            
            $cancelRlt = OrderHistory::model()->getOrderAckbyUser($model['id'], $uid, 0, 5, '');
            if ($cancelRlt['status']) {
                
                $rlt['status'] = true;
                $rlt['msg'] = '订单取消成功';
            } else {
                
                $rlt['msg'] = $cancelRlt['msg'];
            }
        } else {
            $rlt['msg'] = CActiveForm::validate($model);
        } // end isset
        
        return $rlt;
    }

    /**
     * 根据用户id获取订单列表
     *
     * @param int $userId            
     * @param string $q
     *            搜索关键字
     * @param int $page            
     * @param int $pageSize            
     * @return multitype:multitype:string unknown Ambigous <CActiveRecord, unknown, Ambigous <CActiveRecord, NULL>> Ambigous <CActiveRecord, unknown, Ambigous <CActiveRecord, NULL>, unknown, Ambigous <unknown, NULL>, unknown>
     */
    private function getList($userId, $pageIndex, $pageSize, $startTime, $endTime)
    {
        $rlt = UTool::iniFuncRlt();
        $orderListRlt = OrderHistory::model()->getUserOrderList($userId, $pageIndex, $pageSize, $startTime, $endTime);
        $orderList = array();
        $totalOrder = 0;
        $currentPageCount = 0;
        
        if ($orderListRlt['status']) {
            $list = $orderListRlt['data']->getData();
            $totalOrder = $orderListRlt['data']->getTotalItemCount();
            $currentPageCount = $orderListRlt['data']->getItemCount();
            
            foreach ($list as $key => $value) {
                $shop = $value->ohWashShop;
                $type = $value->serviceType;
                $orderList[] = array(
                    'id' => $value['id'],
                    'no' => $value['oh_no'],
                    'shopId' => $shop['id'],
                    'shopName' => $shop['ws_name'],
                    'serviceTypeId' => $type['id'],
                    'serviceTypeName' => $type['st_name'],
                    'orderTime' => $value['oh_order_date_time'],
                    'timeBegin' => $value['oh_date_time'],
                    'timeEnd' => $value['oh_date_time_end'],
                    'value' => $value['oh_value'],
                    'value_discount' => $value['oh_value_discount'],
                    'user_ack' => $value['oh_user_ack'],
                    'bass_ack' => $value['oh_boss_ack'],
                    'status' => $value['oh_state']
                );
            }
        }
        
        $rlt['status'] = true;
        $rlt['data']['size'] = $totalOrder;
        $rlt['data']['currentPageCount'] = $currentPageCount;
        $rlt['data']['data'] = $orderList;
        $rlt['msg'] = '查询成功';
        
        return $rlt;
        // $criteria = new CDbCriteria();
        // $criteria->addCondition('ws_state=1');
        // $searchForm = new SearchForm ();
        // $searchForm ['bias'] = 0;
        
        // $model = new WashShop ();
        // $criteria = new CDbCriteria ();
        
        // $searchForm->q=$q;
        
        // if ($searchForm->validate ()) {
        // ;
        // }
        
        // $criteria->addCondition ( "ws_city_id=:cityId" );
        // $criteria->params [':cityId'] = $cityId;
        // $criteria->addCondition ( "ws_state=1" );
        
        // $criteria->limit = $pageSize;
        // $criteria->offset = $page*$pageSize;
        // // $criteria->with = array (
        // // 'washShopServices' => array (
        // // 'select' => 'wss_value_min'
        // // // 'group' => 'wss_value_min'
        // // )
        // // );
        
        // // $criteria->together = true;
        
        // $shopList = WashShop::model()->findAll($criteria);
        
        // $shopInfos = array();
        // foreach ($shopList as $key=>$value){
        // // $shopServices = $value->washShopServices;/
        // $stdWash = WashShopService::model()->findByAttributes(array('wss_st_id'=>1,'wss_ws_id'=>$value['id']));
        
        // $shopInfos[]=array(
        // 'id'=>$value['id'],
        // 'img'=>Yii::app()->request->hostInfo. Yii::app()->baseUrl.'/images/shops/'.$value['id'].'/shop'.$value->id.'.jpg',
        // 'name'=>$value['ws_name'],
        // 'address'=>$value['ws_address'],
        // 'minValue'=>$stdWash['wss_value_min'],
        
        // );
        // }
        // $rlt['status']=true;
        // $rlt['data']=$shopInfos;
        // return $rlt;
    }
}