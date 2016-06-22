<?php
class UWeitest {
            
        public  function getAccessToken()  
        {  
            //如果目录不存在则创建目录
            if(!file_exists("./cache")){
                mkdir("./cache",0755);
            }
            //缓存目录
            $cachefile = "./cache/accesstoken.php.json";
            	
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
                $appID="wxecb6ae8a2ce06f21";
                //$CopyID="wx02fa1a2147676758";
                //ctect 权限id 可更改
                $appsecrect="07b7eaa16e4b5198bbe3f2587e6f12c1";
                //$Secrect="yMsdQ-r1j4XWr73ABQZdfzjXFb_jORo4IJYYA1GOv7yhoF4IS4WRqDB4rPkuQm6Y";
            
                $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appID."&secret=".$appsecrect;
                //返回 access_token
                $url=file_get_contents($url);
                //将 access_token 的缓存保存到  /cache/access_token.php.json
                file_put_contents($cachefile,$url);
                //返回 access_token 对象
                $url=json_decode($url);
                return $url->access_token;
               } 
        
        }
	
	    //输出accesstoken
        public function test() {
            $access_token=UWeitest::getAccessToken();
            print_r($access_token);
        }
        
        
        //获取微信公众号某个用户信息
        public  function getuserinfo(){
            
            $token = UWeitest::getAccessToken();
            $url ='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$token.'&openid=obmJywwBIAC4kvl-b-RmBpihGsIE&lang=zh_CN';
            $wuserinfo = UWeitest::curlGet ($url);
            
            
            return $wuserinfo;
        }
        
        
        //获取微信公众平台的用户列表
        public function getlistinfo(){
            
            $token = UWeitest::getAccessToken();
            $url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$token;
            $wuserlist = UWeitest::curlGet ($url);
            
            return $wuserlist;
        }

        
        //获取微信公众平台某个用户名称
        public  function getusername($a){
            
            $token = UWeitest::getAccessToken();
            $url ='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$token.'&openid='.$a.'&lang=zh_CN';
            $wuserinfo = UWeitest::curlGet ($url);
            
            
            return $wuserinfo;
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
        
        
        
       
    	
}
?>