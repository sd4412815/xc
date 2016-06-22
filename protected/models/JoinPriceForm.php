<?php

class JoinPriceForm extends CFormModel
{

//     public $pid;
    public $cid;
    // 城市id
    public $free_date_long;

    public $silver_one_date_long;

    public $silver_one_price;

    public $silver_one_date_long_free;

    public $silver_more_date_long;

    public $silver_more_price;

    public $silver_more_date_long_free;

    public $golden_one_date_long;

    public $golden_one_price;

    public $golden_one_date_long_free;

    public $golden_more_date_long;

    public $golden_more_price;

    public $golden_more_date_long_free;

    public $diamond_one_date_long;

    public $diamond_one_price;

    public $diamond_one_date_long_free;

    public $diamond_more_date_long;

    public $diamond_more_price;

    public $diamond_more_date_long_free;

    public function rules()
    {
        return array(
            array(
                'cid',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'cid,free_date_long, silver_one_date_long, silver_one_price, silver_one_date_long_free,
						silver_more_date_long, silver_more_price, silver_more_date_long_free,
						golden_one_date_long, golden_one_price, golden_one_date_long_free,
						golden_more_date_long, golden_more_price, golden_more_date_long_free,
						diamond_one_date_long, diamond_one_price, diamond_one_date_long_free,
						diamond_more_date_long,diamond_more_price,diamond_more_date_long_free',
                'required',
                'message'=>'不可为空',
            ),
            array(
                'free_date_long, silver_one_date_long, silver_one_price, silver_one_date_long_free,
						silver_more_date_long, silver_more_price, silver_more_date_long_free,
						golden_one_date_long, golden_one_price, golden_one_date_long_free,
						golden_more_date_long, golden_more_price, golden_more_date_long_free,
						diamond_one_date_long, diamond_one_price, diamond_one_date_long_free,
						diamond_more_date_long,diamond_more_price,diamond_more_date_long_free',
                'numerical',
                'integerOnly' => true,
                'message'=>'必须为数字'
            
            )
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'cid' => '城市',
            'free_date_long' => '免费时长',
            'silver_one_date_long' => '银卡时长(单车位)',
            'silver_one_price' => '银卡价格(单车位)',
            'silver_one_date_long_free' => '银卡赠送时长(单车位)',
            'silver_more_date_long' => '银卡时长(多车位)',
            'silver_more_price' => '银卡价格(多车位)',
            'silver_more_date_long_free' => '银卡赠送时长(多车位)',
            'golden_one_date_long' => '金卡时长(单车位)',
            'golden_one_price' => '金卡价格(单车位)',
            'golden_one_date_long_free' => '金卡赠送时长(单车位)',
            'golden_more_date_long' => '金卡时长(多车位)',
            'golden_more_price' => '金卡价格(多车位)',
            'golden_more_date_long_free' => '金卡赠送时长(多车位)',
            'diamond_one_date_long' => '钻石卡时长(单车位)',
            'diamond_one_price' => '钻石卡价格(单车位)',
            'diamond_one_date_long_free' => '钻石卡赠送时长(单车位)',
            'diamond_more_date_long' => '钻石卡时长(多车位)',
            'diamond_more_price' => '钻石卡价格(多车位)',
            'diamond_more_date_long_free' => '钻石卡赠送时长(多车位)'
        );
    }

    /**
     * 保存加盟费信息
     * 刘长鑫
     * 20150310
     * @return string|Ambigous <string, multitype:, boolean>
     */
    public function save()
    {
        $rlt = UTool::iniFuncRlt();
        $city = City::model()->findByPk($this->cid);
        if (! isset($city)) {
            $rlt['msg'] = '城市信息不存在';
            return $rlt;
        }
        
        $joinStd = array();
        $joinStd['free'] = array(
            'dateLong' => $this->free_date_long,
            'price' => 0,
            'dateLongFree' => 0
        );
        $one = array(
            'dateLong' => $this->silver_one_date_long,
            'price' => $this->silver_one_price,
            'dateLongFree' => $this->silver_one_date_long_free
        );
        $more = array(
            'dateLong' => $this->silver_more_date_long,
            'price' => $this->silver_more_price,
            'dateLongFree' => $this->silver_more_date_long_free
        );
        $joinStd['silver'] = array(
            'one' => $one,
            'more' => $more
        );
        
        $one = array(
            'dateLong' => $this->golden_one_date_long,
            'price' => $this->golden_one_price,
            'dateLongFree' => $this->golden_one_date_long_free
        );
        $more = array(
            'dateLong' => $this->golden_more_date_long,
            'price' => $this->golden_more_price,
            'dateLongFree' => $this->golden_more_date_long_free
        );
        $joinStd['golden'] = array(
            'one' => $one,
            'more' => $more
        );
        
        $one = array(
            'dateLong' => $this->diamond_one_date_long,
            'price' => $this->diamond_one_price,
            'dateLongFree' => $this->diamond_one_date_long_free
        );
        $more = array(
            'dateLong' => $this->diamond_more_date_long,
            'price' => $this->diamond_more_price,
            'dateLongFree' => $this->diamond_more_date_long_free
        );
        $joinStd['diamond'] = array(
            'one' => $one,
            'more' => $more
        );
        
        $city['c_join_value'] = CJSON::encode($joinStd);
        if ($city->save()) {
            $rlt['msg'] = '加盟费信息更新成功';
            $rlt['status'] = true;
        } else {
            $rlt['msg'] = '保存加盟费信息失败';
        }
        
        return $rlt;
    }
    
    /**
     * 根据城市id加载该城市加盟费信息
     * 刘长鑫
     * 20150310
     * @param int $cid
     * @return string|Ambigous <multitype:, boolean>
     */
    public function load($cid)
    {
        $rlt = UTool::iniFuncRlt();
        $this->cid = $cid;
        City::model()->findByPk($cid);
        $city = City::model()->findByPk($this->cid);
        if (! isset($city)) {
            $rlt['msg'] = '城市信息不存在';
            return $rlt;
        }
        
        $joinStd = CJSON::decode($city['c_join_value']);
        
        // $joinStd = array();
        @$this->free_date_long = $joinStd['free']['dateLong'];
        
        @$this->silver_one_date_long = $joinStd['silver']['one']['dateLong'];
        @$this->silver_one_price = $joinStd['silver']['one']['price'];
        @$this->silver_one_date_long_free = $joinStd['silver']['one']['dateLongFree'];
        @$this->silver_more_date_long = $joinStd['silver']['more']['dateLong'];
        @$this->silver_more_price = $joinStd['silver']['more']['price'];
        @$this->silver_more_date_long_free = $joinStd['silver']['more']['dateLongFree'];
        
        @$this->golden_one_date_long = $joinStd['golden']['one']['dateLong'];
        @$this->golden_one_price = $joinStd['golden']['one']['price'];
        @$this->golden_one_date_long_free = $joinStd['golden']['one']['dateLongFree'];
        @$this->golden_more_date_long = $joinStd['golden']['more']['dateLong'];
        @$this->golden_more_price = $joinStd['golden']['more']['price'];
        @$this->golden_more_date_long_free = $joinStd['golden']['more']['dateLongFree'];
        
        @$this->diamond_one_date_long = $joinStd['diamond']['one']['dateLong'];
        @$this->diamond_one_price = $joinStd['diamond']['one']['price'];
        @$this->diamond_one_date_long_free = $joinStd['diamond']['one']['dateLongFree'];
        @$this->diamond_more_date_long = $joinStd['diamond']['more']['dateLong'];
        @$this->diamond_more_price = $joinStd['diamond']['more']['price'];
        @$this->diamond_more_date_long_free = $joinStd['diamond']['more']['dateLongFree'];
        
        // if ($city->save()){
        $rlt['msg'] = '加载加盟费信息成功';
        $rlt['status'] = true;
        $rlt['data']=$this;
        // }else{
        // $rlt['msg']='保存加盟费信息失败';
        // }
        
        return $rlt;
    }

}
