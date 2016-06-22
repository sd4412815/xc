<?php
class Utest {
            
        public  function getAccessToken()  
        {  
           /*  $corpid = 'wx26b60310f8d30366';
            $corpsecret = '4gLczYNWgzEHAjIbxzAvONBfzbe_fT0NDhV35xJBVuDt6jpmPnxfByIIDfQ-sWP5';
            $url = 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid='.$corpid.'&corpsecret='.$corpsecret;
            $data = array();
            $token = Utest::curlPost($url,$data);
            print_r($token); */
            
            //如果目录不存在则创建目录
            if(!file_exists("./cache")){
                mkdir("./cache",0755);
            }
            //缓存目录
            $cachefile = "./cache/access_token.php.json";
            	
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
                //$CopyID="wx02fa1a2147676758";
                //ctect 权限id 可更改
                $Secrect="4gLczYNWgzEHAjIbxzAvONBfzbe_fT0NDhV35xJBVuDt6jpmPnxfByIIDfQ-sWP5";
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
        
        
        //zhuyu 20150907
    	public function getPro(){
    	   
    	   $provin = Province::model()->findAll();
    	   $a = array();
    	   foreach($provin as $v){
    	       //echo $v->attributes['p_name'].' ';
    	       $a[] = $v->attributes['p_name'];
    	   }
    	   //var_dump($a[0]);
    	   //echo '/n';
    	   //echo json_encode($a[0]);
    	   
    	   return $a;
    	
    	}
    	
    	
    	public function getWeixinPro(){
    	    
    	    $token = Utest::getAccessToken();
    	    $url ='https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token='.$token.'&id=1';
    	    $pro = Utest::curlGet ($url);
    	    return $pro;
    	    
    	     	    
    	}
    	
    	
    	
    	
    	public function updateWeixinPro(){
    	    	
    	    $token = Utest::getAccessToken();
    	    $url ='https://qyapi.weixin.qq.com/cgi-bin/department/update?access_token='.$token;
    	    $list = Utest::curlPost($url);
    	    return $list;
    	    	
    	     
    	}
    	
    	//创建省份部门
    	public function CreatePro($a){
    	     
    	    $token = Utest::getAccessToken();
    	    //$curlPostFields = array('name'=>'天津','parentid'=>'1');
    	    $data = array('name'=>$a,'parentid'=>'1');
    	    $b = json_encode($data,JSON_UNESCAPED_UNICODE);
    	     
    	    // print_r($b);
    	    $url = 'https://qyapi.weixin.qq.com/cgi-bin/department/create?access_token='.$token;
    	    $prolist = Utest::curlpost($url,$b);
    	    //$urlRlt = CJSON::decode($urlRlt);
    	    //print_r($prolist);
    	    return  $prolist;
    	    // 		return CJSON::encode( $rlt);
    	}
    	
    	//根据省份名称查找通讯录部门ID,根据城市名称查找通讯录部门ID
    	public function SearchProid($pro_name){
    	    
    	    $pro = Utest::getWeixinPro();
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
    	    $token = Utest::getAccessToken();
    	    //$curlPostFields = array('name'=>'天津','parentid'=>'1');
    	    $data = array('name'=>$x,'parentid'=>$y);
    	    $b = json_encode($data,JSON_UNESCAPED_UNICODE);
    	    
    	    // print_r($b);
    	    $url = 'https://qyapi.weixin.qq.com/cgi-bin/department/create?access_token='.$token;
    	    $prolist = Utest::curlpost($url,$b);
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
    	    $access_token=Utest::getAccessToken();
    	    $boss=json_encode($arr,JSON_UNESCAPED_UNICODE);
    	    $url="https://qyapi.weixin.qq.com/cgi-bin/user/create?access_token=".$access_token;
    	    $re=Utest::curlPost($url,$boss);
    	    $re=json_decode($re);
    	
    	   // return $re->errcode;
    	    return $re;
    	   
    	}
    	
    	
    	
}
?>