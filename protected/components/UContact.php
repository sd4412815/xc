<?php
class UContact {
            
        public  function getToken()  
        {  
            //如果目录不存在则创建目录
            if(!file_exists("./cache")){
                mkdir("./cache",0755);
            }
            //缓存目录
            $cachefile = "./cache/Access_Token.php.json";
            	
            //2.设置缓存文件的生命周期
            $cache_lifetime = 7200;
            	
            //3.判断缓存文件是否存在并且是否过期
            if(file_exists($cachefile)&&time()-filemtime($cachefile)<=$cache_lifetime){
                	
                //读取缓存文件
                $str = file_get_contents($cachefile);
                	
                //将字符串转回成二维数组
                $data = json_decode($str,true);
                return $data['access_token'];
            }else{
                //copyid 企业id 可更改
                $CopyID="wx26b60310f8d30366";
                //$CopyID="wxd52129f308a5007e";
                //$CopyID="wx02fa1a2147676758";
                //ctect 权限id 可更改
                $Secrect="4gLczYNWgzEHAjIbxzAvONBfzbe_fT0NDhV35xJBVuDt6jpmPnxfByIIDfQ-sWP5";
                //$Secrect="uZoq9zw4rirsP5Dz5BBSLEG88BxgiKBI8rECOvyu5kauxNFiwOEtztompNjWE54W";
                //$Secrect="yMsdQ-r1j4XWr73ABQZdfzjXFb_jORo4IJYYA1GOv7yhoF4IS4WRqDB4rPkuQm6Y";
            
                $url="https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=".$CopyID."&corpsecret=".$Secrect;
                //返回 access_token
                $url=file_get_contents($url);
                //将 access_token 的缓存保存到  /cache/access_token.php.json
                file_put_contents($cachefile,$url);
                //返回 access_token 对象
                $url=json_decode($url);
                return $url->access_token;
               } 
        
        }
	
	
	 
        public function curlPost ($url,$data){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
            curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (compatible; MSIE 5.01;Windows NT 5.0)');
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($ch, CURLOPT_AUTOREFERER,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            $info = curl_exec($ch);
            if(curl_errno($ch)){
                echo 'Errno'.curl_error($ch);
            }
            curl_close($ch);
            return $info;
        }
        
        public function curlGet ($url){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
            curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (compatible; MSIE 5.01;Windows NT 5.0)');
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($ch, CURLOPT_AUTOREFERER,1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            $info = curl_exec($ch);
            if(curl_errno($ch)){
                echo 'Errno'.curl_error($ch);
            }
            curl_close($ch);
            return $info;
        }
        
        //获取通讯录所有部门列表
    	public function getWeixinPro(){
    	    
    	    $token = UContact::getToken();
    	    $url ='https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token='.$token.'&id=11';
    	    $pro = UContact::curlGet ($url);
    	    return $pro;
    	       	     	    
    	}
    	
    	
    	
    	//创建省份部门
    	public function CreatePro($a){
    	     
    	    $token = UContact::getToken();
    	    //$curlPostFields = array('name'=>'天津','parentid'=>'1');
    	    $data = array('name'=>$a,'parentid'=>'11');
    	    $b = json_encode($data,JSON_UNESCAPED_UNICODE);
    	     
    	    // print_r($b);
    	    $url = 'https://qyapi.weixin.qq.com/cgi-bin/department/create?access_token='.$token;
    	    $prolist = UContact::curlpost($url,$b);
    	    //$urlRlt = CJSON::decode($urlRlt);
    	    //print_r($prolist);
    	    return  $prolist;
    	    // 		return CJSON::encode( $rlt);
    	}
    	
    	//根据省份名称查找通讯录部门ID,根据城市名称查找通讯录部门ID
    	public function SearchProid($pro_name){
    	    
    	    $pro = UContact::getWeixinPro();
    	    $prolist = json_decode($pro);
    	    //全部部门列表
    	    //$zhuyu = array();
    	    //$zhuyu[] = $prolist->department['2']->name;
    	    $length = count($prolist->department);
    	    //print_r($prolist->department['2']->parentid);
    	    
    	    //获取通讯录省ID
    	    $mm = array();
    	    for($i=0;$i < $length;$i++){
    	        //$zhuyu[$i] = $prolist->department[$i];
    	        if ($prolist->department[$i]->name == $pro_name) {
    	            //$wprovince[] = $prolist->department[$i];
    	            $mm = $prolist->department[$i]->id;
    	        }
    	    
    	    }
    	    return $mm;
    	    
    	}
    	
    	//创建城市部门 $x城市名称，$y省部门ID  或者创建区域部门，$x区域名称，$y城市部门ID
    	public function CreateCity($x,$y){
    	    $token = UContact::getToken();
    	    //$curlPostFields = array('name'=>'天津','parentid'=>'1');
    	    $data = array('name'=>$x,'parentid'=>$y);
    	    $b = json_encode($data,JSON_UNESCAPED_UNICODE);
    	    
    	    // print_r($b);
    	    $url = 'https://qyapi.weixin.qq.com/cgi-bin/department/create?access_token='.$token;
    	    $prolist = UContact::curlpost($url,$b);
    	    //$urlRlt = CJSON::decode($urlRlt);
    	    //print_r($prolist);
    	    return  $prolist;
    	    
    	    
    	}
    	
    	
    	
    	
    	
    	
    	//根据区ID添加成员
    	public function addlist($areaid){
    	
    	    	
    	    $boss=Boss::model()->findAll(array('limit'=>'1','order'=>'id DESC'));
    	    // print_r($id['0']->id);exit;
    	    // print_r($id);exit();
    	    $arr=array(
    	        "userid"=>$boss['0']->id,
    	        "name"=>$boss['0']->b_nick_name,
    	        "position"=>$boss['0']->b_name,
    	        "mobile"=>$boss['0']->b_tel,
    	        "department"=>$areaid,
    	    );
    	    // var_dump($arr);exit;
    	    $access_token=UContact::getToken();
    	    $boss=json_encode($arr,JSON_UNESCAPED_UNICODE);
    	    $url="https://qyapi.weixin.qq.com/cgi-bin/user/create?access_token=".$access_token;
    	    $re=UContact::curlPost($url,$boss);
    	    $re=json_decode($re);
    	
    	   // return $re->errcode;
    	    return $re;
    	   
    	}
    	
    	
    	
    	//获取企业号通讯录成员信息
    	public function getuserinfo(){
    	    
    	    $token = UContact::getToken();
    	    //$userid = '000';
    	    $url ='https://qyapi.weixin.qq.com/cgi-bin/user/get?access_token='.$token.'&userid=000';
    	    $userinfo = UContact::curlGet ($url);
    	    //return $userinfo;
    	    $user = json_decode($userinfo,true);
    	    //print_r($user);
    	    
    	    $id = $user['userid'];
    	    $data = array('userid' => $id);
    	    $data = json_encode($data);
    	    return $data;
    	    
    	    
    	}
    	
    	
    	//获取企业号通讯录一个成员对应的数据库userid
    	public function getone(){
    	    $token = UContact::getToken();
    	    //$userid = '000';
    	    $url ='https://qyapi.weixin.qq.com/cgi-bin/user/get?access_token='.$token.'&userid=xc_26';
    	    $userinfo = UContact::curlGet ($url);
    	    $user = json_decode($userinfo,true);
    	    $id = $user['userid'];
    	    
    	    $id = substr($id, 3); 
    	    return $id;
    	    
    	}
    	
    	
    	//将userid转化为openid
    	public function changeid(){
    	    
    	    $data = UContact::getuserinfo();
    	    //$data = json_encode($userinfo,JSON_UNESCAPED_UNICODE);
    	    $token = UContact::getToken();
    	    $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/convert_to_openid?access_token='.$token;
    	    $openid = UContact::curlPost($url,$data);
    	    $openid = json_decode($openid);
    	    return $openid;
    	    
    	    
    	} 
    	
    	//上传文件获取media_id
    	/* public function upload(){
    	    
    	    
    	    
    	} */
    	
    	
    	//上传文件CSV，批量修改、增加、删除通讯录部门
    	/* public function freshmore(){
    	    
    	    
    	} */
    	
    	
    	/*
    	 *加盟同时把车行老板信息添加到企业号通讯录
    	 *
    	 */
    	
    	public function adduser($boss){
    	    //加盟的信息
    	    //通过手机号查询加盟的信息
    	    $userpro=User::model()->find('u_tel=:tel',array(":tel"=>$boss['tel']));
    	    //通过userid查询wash_shop_id
    	    // $id=$userpro->id;
    	    	
    	    $bosspro=WashShop::model()->find('ws_boss_id=:id',array(":id"=>$userpro->id));
    	
    	    //区域名称
    	    $area=Area::model()->find('id=:id',array(":id"=>$boss['aid']));
    	
    	    // 通讯录部门名称
    	    $departmentAll = UContact::getdepartment();
    	    	
    	    for($i=0;$i<=count($departmentAll);$i++){
    	        if($area->a_name==$departmentAll[$i]->name){
    	            $department=$departmentAll[$i]->id;
    	            break;
    	        }
    	    }
    	    // print_r($bosspro);
    	    /*加盟时，传过来的数据格式
    	     Array (
    	     [pid] => 1
    	     [cid] => 1
    	     [aid] => 1
    	     [address] => 三好街
    	     [name] => 测试
    	     [contactor] => yuan
    	     [tel] => 15642091931
    	     [smsCode] => 706193
    	     )*/
    	    //添加到通讯录里面的数据
    	    $arr=array(
    	        "userid"=>$bosspro->id,
    	        "name"=>$boss['contactor'],
    	        "position"=>$boss['name'],
    	        "mobile"=>$boss['tel'],
    	        "department"=>$department,
    	    );
    	
    	    $access_token=UContact::getToken();
    	    $boss=json_encode($arr,JSON_UNESCAPED_UNICODE);
    	    $url="https://qyapi.weixin.qq.com/cgi-bin/user/create?access_token=".$access_token;
    	    $re=UContact::curlPost($url,$boss);
    	    $re=json_decode($re);
    	
    	    return $re->errcode;
    	}
    	
    	
    	// 获取企业号的所有部门信息
    	public static function getdepartment(){
    	    $access_token=UContact::getToken();
    	    //print_r($access_token);
    	    $url="https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token=".$access_token."&id=1";
    	    // $re=UWeixinQYH::curlget($url);
    	    $re=file_get_contents($url);
    	    $re=json_decode($re);
    	    // return $re;
    	    return $re->department;
    	}
}
?>