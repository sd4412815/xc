<?php

class WdepartController extends Controller
{
	
    //zhuyu 20150907
   /*  public function getProCA(){
        $this->layout = 'depart';
        $provin = Province::model()->findAll();
        $a = array();
        foreach($provin as $v){
            $a[] = $v->attributes['p_name'];
        }
        $this->render('index',array(
            'a' => $a
        ));
         
    } */
	
	/* public function actionGetToken(){
	    $corpid = 'wx26b60310f8d30366';
	    $corpsecret = '4gLczYNWgzEHAjIbxzAvONBfzbe_fT0NDhV35xJBVuDt6jpmPnxfByIIDfQ-sWP5';
	    $url = 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid='.$corpid.'&corpsecret='.$corpsecret;
        $data = array();
	    $token = Utest::curlPost($url,$data);
	    print_r($token);
	    
	} */
	
    public function actionGetPro(){
        $pro = Utest::getWeixinPro();
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
               /*  $token = Utest::getAccessToken();
                $cityparentid = $wprovince[$x]->id;
                $url ='https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token='.$token.'&id='.$cityparentid;
                $localcity = Utest::curlGet ($url);
                print_r($localcity); */
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
                $member = Utest::addlist($areaid);
                print_r($member);
                
            }
        
        }
        
        
        
        //echo $prolist;
       // print_r($warea);
        
        
    
    }
    
    
    //更新部门信息
   /*  public function actionUpdatePro(){
        $list = Utest::updateWeixinPro();
        $prolist = json_decode($list);
        print_r($list);
        
    } */
	
	public function actionGetToken(){
	    $token = Utest::getAccessToken();
	    print_r($token);
	     
	}
	
	public function actionCreatePro(){	 
	    
	    $token = Utest::getAccessToken();
	    //$curlPostFields = array('name'=>'天津','parentid'=>'1');
	    $a = array('name'=>'山西','parentid'=>'1');
	    $b = json_encode($a,JSON_UNESCAPED_UNICODE);
	    
	   // print_r($b);
	    $url = 'https://qyapi.weixin.qq.com/cgi-bin/department/create?access_token='.$token;
	    $prolist = Utest::curlpost($url,$b);
	    //$urlRlt = CJSON::decode($urlRlt);
	    print_r($prolist);
	    // 		return CJSON::encode( $rlt);
	}
	
	
	
        public function actionaddall(){

			$this->layout = "kong";
			$boss=Boss::model()->find('id=:id',array(":id"=>55));

			$arr=array(
					"userid"=>$boss->id,
					"name"=>$boss->b_real_name,
					"mobile"=>$boss->b_tel,
					"department"=>1,
				);
			$boss=json_encode($arr,JSON_UNESCAPED_UNICODE);
			// print_r($boss);

			//$this->render("index",array('boss'=>$arr,'user'=>$boss));
		}
	
	
}
?>