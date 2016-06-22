<?php

class WContactController extends Controller
{	
    public function actionGetPro(){
        $pro = UContact::getWeixinPro();
        $prolist = json_decode($pro);
        //全部部门列表
        $zhuyu = array();
        //$zhuyu[] = $prolist->department['2']->name;
        $length = count($prolist->department);
        //print_r($prolist->department['2']->parentid);
        
        //获取通讯录省列表
        $wprovince = array();
        for($i=0;$i < $length;$i++){
            $zhuyu[$i] = $prolist->department[$i];
            if ($prolist->department[$i]->parentid == 1) {
                $wprovince[] = $prolist->department[$i];
            }
            
        }
        
        
        //获取市列表
        $wcity = array();
        //获取省数量
        $plength = count($wprovince);
        //print_r($wprovince[0]->id);
        for($i=0;$i < $length;$i++){   
            for($k=0;$k < $plength;$k++){
                if($wprovince[$k]->id == $prolist->department[$i]->parentid){
                    $wcity[] = $prolist->department[$i];
                }
            }       
        }
        
        
        //获取区列表
        $warea = array();
        //获取城市数量
        $clength = count($wcity);
        for($i=0;$i < $length;$i++){
            for($k=0;$k < $clength;$k++){
                if($wcity[$k]->id == $prolist->department[$i]->parentid){
                    $warea[] = $prolist->department[$i];
                }
            }
        }
        
        //获取区数量
        $alength = count($warea);
        //print_r($alength);
        
        $wewe = array();
        $wewe[0] = '辽宁';
        $wewe[1] = '大连';
        $wewe[2] = '站前区';
        
        
        //print_r($wprovince[0]->name);
        for($x = 0;$x < $plength;$x ++){
            
            if(($wprovince[$x]->name) == $wewe[0]){
                //判断省是否存在
               // echo $wprovince[$x]->id;              
               for($y = 0;$y < $clength;$y++){
                   if(($wcity[$y]->name) == $wewe[1]){
                       //echo '市已存在';
                       for($z = 0;$z < $alength;$z++){
                           if(($warea[$z]->name) == $wewe[2]){
                               echo '区已存在,可以添加成员了！！！  ';
                           }
                           
                       }
                   }
               }
            
            }
        }
        
        
        //20150925 朱玉 根据表单中区数据 匹配通讯录的部门，获取ID
        for($z=0;$z < $length;$z++){
            if ($prolist->department[$z]->name == $wewe[2]) {
                echo '找到区部门ID了  ';
                $areaid =  $prolist->department[$z]->id;
                $member = UContact::addlist($areaid);
                print_r($member);
                
            }
        
        }
        
        
        
        //echo $prolist;
       // print_r($warea);
        
        
    
    }
	
	public function actionGetToken(){
	    $token = UContact::getToken();
	    print_r($token);
	     
	}
	
	public function actionCreatePro(){	 
	    
	    $token = UContact::getToken();
	    //$curlPostFields = array('name'=>'天津','parentid'=>'1');
	    $a = array('name'=>'山西','parentid'=>'1');
	    $b = json_encode($a,JSON_UNESCAPED_UNICODE);
	    
	   // print_r($b);
	    $url = 'https://qyapi.weixin.qq.com/cgi-bin/department/create?access_token='.$token;
	    $prolist = UContact::curlpost($url,$b);
	    //$urlRlt = CJSON::decode($urlRlt);
	    print_r($prolist);
	    // 		return CJSON::encode( $rlt);
	}
	
	
	
        /* public function actionaddall(){

			$this->layout = "kong";
			$boss=Boss::model()->find('id=:id',array(":id"=>55));

			$arr=array(
					"userid"=>$boss->id,
					"name"=>$boss->b_real_name,
					"mobile"=>$boss->b_tel,
					"department"=>1,
				);
			$boss=json_encode($arr,JSON_UNESCAPED_UNICODE);
			
		} */
	
	
    	/*添加之前加盟的老板信息到企业号通讯录
    	 * yuan 2015/09/07
    	 */
    	public function actionaddall(){
    	
    	    // $bossall=Boss::model()->findAll(count('id'));
    	
    	    // $bossall=UWeixinQYH::objectToArray($bossall);
    	
    	    $access_token=UContact::getToken();
    	    // echo $access_token;
    	    $boss=Boss::model()->find('id=:id',array(":id"=>33));
    	
    	    $arr=array(
    	        "userid"=>$boss->id,
    	        "name"=>$boss->b_real_name,
    	        "mobile"=>$boss->b_tel,
    	        "department"=>2,
    	    );
    	
    	    $boss=json_encode($arr,JSON_UNESCAPED_UNICODE);
    	    	
    	    $url="https://qyapi.weixin.qq.com/cgi-bin/user/create?access_token=".$access_token;
    	
    	    $re=UContact::curlPost($url,$boss);
    	    $re=json_decode($re);
    	    // print_r($re);
    	    if ($re->errcode==0) {
    	        echo '<div style="margin:0 auto;margin-top:200px;width:200px;height:300px; border:1 solid red;"><p>';
    	        echo '添加成员成功</p><p>';
    	        echo '<a href="http://www.woxiche.com">返回首页</a></p></div>';
    	    }else {
    	        echo '<div style="margin:0 auto;margin-top:200px;width:200px;height:300px; border:1 solid red;"><p>';
    	        echo '添加成员失败</p>';
    	        echo "<p>错误码：".$re->errcode;
    	        echo '</p><p>如有问题，请联系管理员。</p></div>';
    	    }
    	}
		
		
		//获取通讯录成员信息
		public function actionGetuser(){
		    $info = UContact::getuserinfo();
		    print_r($info);
		
		}
				
		
		//判断企业号通讯录和微信公众平台是否是同一人
		public function actionJudge(){
		    
		    $openid = UContact::changeid();
		    print_r($openid);
		    
		}
	    
		
		//获取省市区全部数据，新建表
		public function actionGetall(){
		
		    $ProvinceAll = Province::model()->findAll();
		    $CityAll = City::model()->findAll();
		    $AreaAll = Area::model()->findAll();
		
		    $weixin=array();
		    //print_r(count($AreaAll));
		    $weixin[0] = array('name'=>'我洗车','id'=>'1','parentid'=>'0');
		    //获取省市区数量
		    $pcount = count($ProvinceAll);
		    $ccount = count($CityAll);
		    $acount = count($AreaAll);
		    
		    for ($i=1; $i < $pcount+1+$ccount; $i++) {
		         
    		     //$Boss = Boss::model()->find('b_user_id=:id',array(":id"=>$User['$i']+$i));
    		     
    		     //$City = City::model()->find('id=:id',array(":id"=>$WashShop["$i"]->ws_city_id));
    		     //$Area = Area::model()->find('id=:id',array(":id"=>$WashShop["$i"]->ws_area_id));
    		    if ($i < $pcount+1){
    		     $weixin[$i] = array(
        		     'name'=>$ProvinceAll[$i-1]->p_name,
    		         //'id' => $ProvinceAll[$i]->id,
    		         'id' => $i+1,
    		         'parentid' => '1',        		    
    		     );
    		    }
    		    
    		    if($i < $ccount+1){
    		     $weixin[$i+$pcount] = array(
    		         'name'=>$CityAll[$i-1]->c_name,
    		         'id' => $i + $pcount +1,
    		         'parentid' => '1',   		         
    		     ); 
    		    }
    		    
    		    
		    }
		    
		    
		    print_r($weixin);
		
		
		}
		
		
		//获取一个企业号通讯录成员信息
		public function actiongetone(){
		    
		    $user = UContact::getone();
		    print_r($user);
		    
		}
		
		
		//比较两个平台用户是否是同一个，比较数据库对应的userid
		public function actioncompare(){
		    
		    $qiyeuser = UContact::getone();
		    $a = WashShop::model()->find('id=:id',array(":id"=>$qiyeuser));
		    $qiye = $a->ws_boss_id;
		    
		    
		    $weiuser = UWeitest::getuserinfo();
		    $userinfo = json_decode($weiuser);
		    $openid = $userinfo->openid;
		    
		    //获取openid对应表中信息
		    $b = WeixinOpenid::model()->find('wo_open_id=:id',array(":id"=>$openid));
		    $weixin = $b->wo_user_id;
		    
		    if ($qiye == $weixin) {
		        echo "是同一个人";
		    }else{
		        
		        echo "不是一个人呢";
		    }
		    
		}



        /*根据车行id 查找车行老板id，继而查找openid，最终根据微信用户列表openid值，
        判断企业号用户对应的是微信公众平台的哪一个*/
        public function actionsearchweixin(){
            $shop_id = UContact::getone();
            $boss = WashShop::model()->find('id=:id',array(":id"=>$shop_id));
            $boss_id = $boss->ws_boss_id;

            $info = WeixinOpenid::model()->find('wo_user_id=:id',array(":id"=>$boss_id));
            $openid = $info->wo_open_id;
            //print_r($openid);

            $list = UWeitest::getlistinfo();
            $list = json_decode($list);
        
            //return $list;
            //print_r($list->data->openid[1]);
            //print_r($list->total);

            $count = $list->total;
            for ($i =0;$i < $count; $i++){
                if($list->data->openid[$i] == $openid){
                    $a = $list->data->openid[$i];
                    $username = UWeitest::getusername($a);
                    $username = json_decode($username);
                    echo "企业号用户 " .$shop_id. " 对应的微信号是 ".$username->nickname;
                }

            }




        }


		
		
}





?>