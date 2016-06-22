<?php

class ShopServiceSetForm extends CFormModel
{

    public $shopId;

    public $wss_service_time1;

    public $wss_service_time_rest1;

    public $wss_value11;

    public $wss_value12;

    public $wss_value13;

    public $wss_service_time3;

    public $wss_service_time_rest3;

    public $wss_value31;

    public $wss_value32;

    public $wss_value33;

    public $wss_service_time5;

    public $wss_service_time_rest5;

    public $wss_value51;

    public $wss_value52;

    public $wss_value53;

    public $wss_service_time6;

    public $wss_service_time_rest6;

    public $wss_value61;

    public $wss_value62;

    public $wss_value63;

//    public $wss_value;

    public $wss_service_time7;

    public $wss_service_time_rest7;

    public $wss_value7;

    public function rules()
    {
        return array(
//            array(
//                'shopId',
//                'required',
//                'message' => '{attribute}不能为空'
//            ),
//            array(
//                'wss_service_time1,,wss_value11,wss_value21,
//				wss_service_time3,,wss_value13,wss_value23,
//				wss_service_time5,,wss_value15,wss_value25,
//				wss_service_time6,,wss_value16,wss_value26',
//                'checkOnlyUsed',
//                'message' => '{attribute}不能为空'
//            ),
            array(
                'shopId,
                wss_service_time1,wss_service_time_rest1,wss_value11,wss_value12,wss_value13,
				wss_service_time3,wss_service_time_rest3,wss_value31,wss_value32,wss_value33,
				wss_service_time5,wss_service_time_rest5,wss_value51,wss_value52,wss_value53,
				wss_service_time6,wss_service_time_rest6,wss_value61,wss_value62,wss_value63,
				wss_service_time7,wss_service_time_rest7,wss_value7',
                'numerical',
                'integerOnly' => true,
                'message' => '{attribute}需为整数'
            )
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'shopId' => '车行id',
            'wss_service_time1' => '普洗时间',
            'wss_service_time_rest1' => '普洗休息间隔',
            'wss_value11' => '普洗轿车基准价',
            'wss_value12' => '普洗小型基准价',
            'wss_value13' => '普洗大型基准价',

            'wss_service_time6' => '快洗时间',
            'wss_service_time_rest6' => '快洗休息间隔',
            'wss_value61' => '快洗轿车基准价',
            'wss_value62' => '快洗小型基准价',
            'wss_value63' => '快洗大型基准价',

            'wss_service_time3' => '普洗+打蜡时间',
            'wss_service_time_rest3' => '普洗+打蜡休息间隔',
            'wss_value31' => '普洗+打蜡轿车基准价',
            'wss_value32' => '普洗+打蜡小型基准价',
            'wss_value33' => '普洗+打蜡大型基准价',

            'wss_service_time5' => '精洗时间',
            'wss_service_time_rest5' => '精洗休息间隔',
            'wss_value51' => '精洗轿车基准价',
            'wss_value52' => '精洗小型基准价',
            'wss_value53' => '精洗大型基准价'
        );
    }
    
    public function checkOnlyUsed($attribute,$params){
        $this->shopId=Yii::app()->session['shop']->id;
//      $services = WashShopService::model()->getServices($this->shopId)['data'];

        $criteria = new CDbCriteria();
        $criteria->addCondition('wss_ws_id=:shopId');
        $criteria->params[':shopId']=$this->shopId;
        $criteria->addCondition('wss_state>=0');
        $criteria->alias = 'prefix';
        $criteria->with='wssSt';
        $criteria->order = 'wssSt.st_flag ASC';
        $criteria->group='wss_car_group';
        $services=WashShopService::model()->findAll($criteria);

//        var_dump($services);
      foreach ($services as $key=>$value){
          $stId = $value['wss_st_id'];
          if (empty($this[$attribute] ) && (substr($attribute, -1,1)==$stId)
//               || empty($this['wss_service_time_rest' . $stId]) 
//               || empty($this['wss_value1' . $stId])
//               || empty($this['wss_value2' . $stId])
              ){
              $this->addError($attribute, $this->getAttributeLabel($attribute).'不能为空!');
//               $this->addError($attribute,$attribute);
          }
    }

    }

    public function savexiche()
    {
        $rlt = UTool::iniFuncRlt();
        $shop = WashShop::model()->findByPk(Yii::app()->session['shop']->id);

        $criteria = new CDbCriteria();
        $criteria->addCondition('wss_ws_id=:shopId');
        $criteria->params[':shopId']=$shop->id;
        $criteria->addCondition('wss_st_id<=6');
        $criteria->addCondition('wss_state>=0');
//        $criteria->group='wss_st_id';
        $shopServiceList=WashShopService::model()->findAll($criteria);
//        print_r($shopServiceList);
//        exit;
        $rlt['status'] = true;
        $rlt['msg'] = '保存成功';
        foreach ($shopServiceList as $key => $value) {
            $stId = $value['wss_st_id'];
            $carid = $value['wss_car_group'];
//            echo $stId."<br>";
            $value['wss_service_time'] = $this['wss_service_time'.$stId];
            $value['wss_service_time_rest'] = $this['wss_service_time_rest'.$stId];

            $value['wss_value'] = $this['wss_value'.$stId.$carid];

//            echo 'wss_value'.$stId.$carid;

//            print_r($value);
            if (! $value->save()) {
                $rlt['status'] = false;
                $rlt['msg'] = "保存失败";
                $rlt['data'][] = CJSON::encode($value);
            }else{
                $rlt['data'][] = $value;
            }
//
//             return $rlt;
//            print_r($value);
        }
        
        if ($shop['ws_state'] == 2) {
            $shopId = $shop['id'];
            $shop->deleteOrderTempTable($shopId, 0);
            $shop->deleteOrderTempTable($shopId, 1);
            $shop->deleteOrderTempTable($shopId, 2);
            $shop->generateOrderTempTable($shopId, 0);
            $shop->generateOrderTempTable($shopId, 1);
            $shop->generateOrderTempTable($shopId, 2);
        }
        
        return $rlt;
        
        // $shopService =WashShopService::model()->findByAttributes(array('wss_ws_id'=>$this->shopId,'wss_st_id'=>1));
    }



    public function savemeirong()
    {
        $rlt = UTool::iniFuncRlt();
        $shop = WashShop::model()->findByPk(Yii::app()->session['shop']->id);

        $criteria = new CDbCriteria();
        $criteria->addCondition('wss_ws_id=:shopId');
        $criteria->params[':shopId']=$shop->id;
        $criteria->addCondition('wss_st_id>6');
        $criteria->addCondition('wss_state>=0');
//        $criteria->group='wss_st_id';
        $shopServiceList=WashShopService::model()->findAll($criteria);
//        print_r($shopServiceList);
//        exit;
        $rlt['status'] = true;
        $rlt['msg'] = '保存成功';
        foreach ($shopServiceList as $key => $value) {
            $stId = $value['wss_st_id'];
//            $carid = $value['wss_car_group'];
//            echo $stId."<br>";
            $value['wss_service_time'] = $this['wss_service_time'.$stId];
            $value['wss_service_time_rest'] = $this['wss_service_time_rest'.$stId];

            $value['wss_value'] = $this['wss_value'.$stId];

//            echo 'wss_value'.$stId.$carid;

//            print_r($value);
            if (! $value->save()) {
                $rlt['status'] = false;
                $rlt['msg'] = "保存失败";
                $rlt['data'][] = CJSON::encode($value);
            }else{
                $rlt['data'][] = $value;
            }
//
//             return $rlt;
//            print_r($value);
        }

        if ($shop['ws_state'] == 2) {
            $shopId = $shop['id'];
            $shop->deleteOrderTempTable($shopId, 0);
            $shop->deleteOrderTempTable($shopId, 1);
            $shop->deleteOrderTempTable($shopId, 2);
            $shop->generateOrderTempTable($shopId, 0);
            $shop->generateOrderTempTable($shopId, 1);
            $shop->generateOrderTempTable($shopId, 2);
        }

        return $rlt;

        // $shopService =WashShopService::model()->findByAttributes(array('wss_ws_id'=>$this->shopId,'wss_st_id'=>1));
    }

    public function load($shopId)
    {
        $this->shopId = $shopId;
        $shop = WashShop::model()->findByPk($this->shopId);
        $shopServiceList = WashShopService::model()->findAllByAttributes(array('wss_ws_id' => $this->shopId));
        foreach ($shopServiceList as $key => $value) {
            $stId = $value['wss_st_id'];
            $this['wss_service_time'] = $value['wss_service_time'];
//            $this['wss_service_time'.$stId] = $value['wss_service_time'];
            $this['wss_service_time_rest'] = $value['wss_service_time_rest'];
//            $this['wss_service_time_rest'.$stId] = $value['wss_service_time_rest'];
            // $this['wss_value'] = $value['wss_value'];
            $this['wss_value'] = $value['wss_value'];
        }
//        print_r($shopServiceList);exit();
    }
}
