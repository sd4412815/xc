<?php
class UPlace {
	public static function getCityId() {
		$cid = @$_COOKIE ['_ucid'];
		if (! UCom::checkInt ( $cid )) {
			$criteria = new CDbCriteria ();
			$ip = Yii::app ()->geoip->getRemoteIpAddress ();
			$address_information = Yii::app ()->geoip->getCityInfoForIp ( $ip );
			$criteria->addSearchCondition ( 'c_spell', $address_information ['city'] );
			$criteria->addCondition ( 'c_state>=1' );
			
			$city = City::model ()->find ( $criteria );
			
			if ($city === null) {
				
				$city = City::model ()->findByAttributes ( array (
						'c_name' => '沈阳' 
				) );

			}
			
			$cookie = new CHttpCookie ( '_ucid', $city ['id'] );
			$cookie->expire = time () + 60 * 60 * 24 * 30; // 有限期30天
			Yii::app ()->request->cookies ['_ucid'] = $cookie;
			$cid = $city ['id'];
		}
		
		return $cid;
	}
}

