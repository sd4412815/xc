<?php
class TestweixinController extends Controller{
    
    //测试输出token
    public function actiontest(){
        $access_token=UWeitest::getAccessToken();
        print_r($access_token);
    }
    
    
    //获取公众平台某个用户信息,返回对应车行id
    public function actiongetuserinfo(){
        $userinfo = UWeitest::getuserinfo();
        $userinfo = json_decode($userinfo);
        $openid = $userinfo->openid;
        $user = WeixinOpenid::model()->find('wo_open_id=:id',array(":id"=>$openid));

        $boss_id = $user->wo_user_id;
        $washshop = WashShop::model()->find('ws_boss_id=:id',array(":id"=>$boss_id));
        
        //return $user->wo_user_id;

        print_r($washshop->id);
        
    }
    
    
    //获取企业号用户的userid并与微信平台用户比较，判断是否同一人
    public function actioncompare(){
        
        
    }

    

    //获取公众平台用户列表
    public function actiongetuserlist(){
        $list = UWeitest::getlistinfo();
        $list = json_decode($list);
        
        //return $list;
        print_r($list->data->openid[1]);
    }

    
}


?>