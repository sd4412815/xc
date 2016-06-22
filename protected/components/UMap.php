<?php
class UMap {
	
	const DEF_PI = 3.14159265359; // PI
	const DEF_2PI= 6.28318530712; // 2*PI
	const DEF_PI180= 0.01745329252; // PI/180.0
	const DEF_R =6370693.5; // radius of earth
	
	public static function GetShortDistance( $lon1, $lat1, $lon2, $lat2){
		$ew1; $ns1; $ew2; $ns2;
		$dx; $dy; $dew;
		$distance;
		// 角度转换为弧度
		$ew1 = $lon1 * UMap::DEF_PI180;
		$ns1 = $lat1 * UMap::DEF_PI180;
		$ew2 = $lon2 * UMap::DEF_PI180;
		$ns2 = $lat2 * UMap::DEF_PI180;
		// 经度差
		$dew = $ew1 - $ew2;
		// 若跨东经和西经180 度，进行调整
		if ($dew > UMap::DEF_PI){
			$dew = UMap::DEF_2PI - $dew;
		} else if ($dew < -UMap::DEF_PI){
			$dew = UMap::DEF_2PI + $dew;
		}
		$dx = UMap::DEF_R * cos($ns1) * $dew; // 东西方向长度(在纬度圈上的投影长度)
		$dy = UMap::DEF_R * ($ns1 - $ns2); // 南北方向长度(在经度圈上的投影长度)
		// 勾股定理求斜边长
		$distance = sqrt($dx * $dx + $dy * $dy);
		return $distance;
	}
	/**
	 * c长距离
	 * @param unknown $lon1
	 * @param unknown $lat1
	 * @param unknown $lon2
	 * @param unknown $lat2
	 * @return number
	 */
	public static function GetLongDistance($lon1, $lat1, $lon2, $lat2) {
		$ew1;
		$ns1;
		$ew2;
		$ns2;
		$distance;
		// 角度转换为弧度
		$ew1 = $lon1 * UMap::DEF_PI180;
		$ns1 = $lat1 * UMap::DEF_PI180;
		$ew2 = $lon2 * UMap::DEF_PI180;
		$ns2 = $lat2 * UMap::DEF_PI180;
		// 求大圆劣弧与球心所夹的角(弧度)
		$distance = sin ( $ns1 ) * sin ( $ns2 ) + cos ( $ns1 ) * cos ( $ns2 ) * cos ( $ew1 - $ew2 );
		// 调整到[-1..1]范围内，避免溢出
		if ($distance > 1.0)
			$distance = 1.0;
		else if ($distance < - 1.0) {
			$distance = - 1.0;
		}
		// 求大圆劣弧长度
		$distance = UMap::DEF_R * acos ( $distance );
		return $distance;
	}
	
	public static function getGeoIP($ip){
		$baseUrl='http://api.map.baidu.com/location/ip';
		
	}
	
	
	
	/**
	 * 获取百度地图需要的必要参数
	 */
	public static function getMapAttributes() {
		$attributes = array (
				'ak' => 'atV54I5hflatOH00IebtxSwR',
				'geotable_id' => '66526',
// 				'sn' => 'not use now' 
		);
		
		return $attributes;
	}
	private static $_map_urls = array (
			'lbs_search_nearby' => 'http://api.map.baidu.com/geosearch/v3/nearby', 
			'lbs_search_local'=>'http://api.map.baidu.com/geosearch/v3/local',
			'lbs_search_bound'=>'http://api.map.baidu.com/geosearch/v3/bound',
			'lbs_storage_create'=>'http://api.map.baidu.com/geodata/v3/geotable/create',
			'lbs_storage_list'=>'http://api.map.baidu.com/geodata/v3/geotable/list',
			'lbs_storage_list'=>'http://api.map.baidu.com/geodata/v3/geotable/list',
			'lbs_storage_detail'=>'http://api.map.baidu.com/geodata/v3/geotable/detail',
			'lbs_storage_update'=>'http://api.map.baidu.com/geodata/v3/geotable/update ',
			'lbs_poi_create'=>'http://api.map.baidu.com/geodata/v3/poi/create',
			'lbs_poi_list'=>'http://api.map.baidu.com/geodata/v3/poi/list',
			'lbs_poi_update'=>'http://api.map.baidu.com/geodata/v3/poi/update',
			'lbs_poi_delete'=>'http://api.map.baidu.com/geodata/v3/poi/delete',
			'ip_location'=>'http://api.map.baidu.com/location/ip',
	);
	public static function getMapUrl($map_url_type) {
		try {
			new UMapURLType ( $map_url_type );
		} catch ( UnexpectedValueException $e ) {
			return $e->getMessage ();
		}
		
		return UMap::$_map_urls [$map_url_type].'&'.http_build_query(UMap::getMapAttributes());
	}
	
	
	/**
	 * 百度地图坐标转化api
	 * @param string $coords
	 * @param number $from
	 * @param number $to
	 * @return Ambigous <string, number, mixed>
	 */
	public static function convertGEO($coords, $from=1, $to=5){
		$url = 'http://api.map.baidu.com/geoconv/v1/?';
		$ak='atV54I5hflatOH00IebtxSwR';
		$url = $url.'&coords='.$coords.'&ak='.$ak.'&from='.$from.'&to='.$to;
// 		Yii::log($url,CLogger::LEVEL_INFO,'mngr.geoconvert');
		$opts = array(
				'http'=>array(
						'method'=>"GET",
						'timeout'=>60,
				)
		);
		
		$context = stream_context_create($opts);
		$maprlt_ini= file_get_contents($url,false,$context);
		$maprlt = json_decode($maprlt_ini);
		return $maprlt;
		
		
	}
	
	
	public static function getInfoByLocation($location){
		$url = 'http://api.map.baidu.com/geocoder/v2/?';
		$ak='atV54I5hflatOH00IebtxSwR';
		$url .= '&ak='.$ak.'&location='.$location.'&output=json';
// 		$url = 'http://api.map.baidu.com/geocoder/v2/?ak=atV54I5hflatOH00IebtxSwR&callback=renderReverse&location='.$location.'&output=json&pois=0';
		
		$rlt = UTool::https_request($url);
		return $rlt;
	}
	
	
	/***
	 * 
	 * @param unknown $location
	 * @param number $redius
	 * @param string $q
	 * @param string $sortby
	 * @param string $filter
	 * @param number $page_index
	 * @param number $page_size
	 * @return Ambigous <string, number, mixed>
	 */
	public static function getLocationDistance($location, $radius=3000,
			 $page_index=0, $page_size=8,$q=NULL, $filter=NULL, $sortby='distance:1' ){
		$url = UMap::getMapUrl(UMapURLType::lbs_search_nearby);
		$opts = array(
				'http'=>array(
						'method'=>"GET",
						'timeout'=>60,
				)
		);
		
		$context = stream_context_create($opts);
		$params = array();
		$params['location']=$location;
		$params['radius']=$radius;
		$params['page_index']=$page_index;
		$params['page_size']=$page_size;
		$params['sortby']=$sortby;
		if (isset($q)){
			$params['q']=$q;
		}
		if (isset($filter)){
			$params['filter']=$filter;
		}
		
		$url = $url.'&'.http_build_query($params);
		$maprlt_ini= file_get_contents($url,false,$context);
		if ($maprlt_ini ===false){
			$maprlt_ini = CJSON::encode(array('status'=>-1,'total'=>0,'size'=>0,'contents'=>array()));
		}
		return $maprlt_ini;
		
	}
	
	
	
	
}

/**
 * 地图可用服务枚举列表
 *
 * @author cxliuneapp
 *        
 */
class UMapURLType extends Enum {
	/**
	 * 周边检索
	 */
	const lbs_search_nearby = 'lbs_search_nearby';
	/**
	 * 本地检索
	 */
	const lbs_search_local = 'lbs_search_local';
	/**
	 * 矩形检索
	 */
	const lbs_search_bound = 'lbs_search_bound';
	/**
	 * 创建存储表
	 */
	const lbs_storage_create = 'lbs_storage_create';
	/**
	 * 查询表
	 */
	const lbs_storage_list ='lbs_storage_list';
	/**
	 * 查询指定表id
	 */
	const lbs_storage_detail = 'lbs_storage_detail';
	/**
	 * 修改表
	 */
	const lbs_storage_update='lbs_storage_update';
	/**
	 * 位置数据创建
	 */
	const lbs_poi_create = 'lbs_poi_create';
	/**
	 * 查询指定条件的数据列表
	 */
	const lbs_poi_list = 'lbs_poi_list';
	/**
	 * 查询指定id的数据
	 */
	const lbs_poi_detail ='lbs_poi_detail';
	
	/**
	 * 修改位置数据
	 */
	const lbs_poi_update ='lbs_poi_update';
	
	/**
	 * 删除位置数据
	 */
	const lbs_poi_delete='lbs_poi_delete';
	


	
}

