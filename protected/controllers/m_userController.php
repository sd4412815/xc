<?php

class MUserController extends Controller
{

    /**
     *
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            array(
                'ext.starship.RestfullYii.filters.ERestFilter + 
                REST.GET, REST.PUT, REST.POST, REST.DELETE'
            )
        );
    }

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        Yii::app()->clientScript->reset();
        return true;
    }

    public function actions()
    {
        return array(
            'REST.' => 'ext.starship.RestfullYii.actions.ERestActionProvider'
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     *
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array(
                'allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(
                    'REST.GET',
                    'REST.PUT',
                    'REST.POST',
                    'REST.DELETE',
                    'login',
                    'getSendCode',
                    'CheckTelReg',
                    'getSessionId',
                    'closeSession'
                ),
                'users' => array(
                    '*'
                )
            ),
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    'update'
                ),
                'users' => array(
                    '@'
                )
            )
        )
        // array('allow', // allow admin user to perform 'admin' and 'delete' actions
        // 'actions'=>array('admin','delete'),
        // 'users'=>array('admin'),
        // ),
        // array('deny', // deny all users
        // 'users'=>array('*'),
        // ),
        ;
    }

    public function restEvents()
    {
        $this->onRest('post.filter.req.auth.ajax.user', function ($validation) {
            // return true;
            // if(!$validation) {
            // return false;
            // }
            switch ($this->getAction()
                ->getId()) {
                case 'REST.GET':
                    return true;
                case 'REST.POST':
                    return true;
                    break;
                case 'REST.POST':
                    return Yii::app()->user->checkAccess('REST-UPDATE');
                    break;
                case 'REST.DELETE':
                    return Yii::app()->user->checkAccess('REST-DELETE');
                    break;
                default:
                    return false;
                    break;
            }
            // return ($this->getAction()->getId() == 'REST.GET');
            // return true;
        });
        $this->onRest('req.get.login.render', function () {
            // Custom logic for this route.
            $rlt = UTool::iniFuncRlt();
            $tel = Yii::app()->request->getParam('userName');
            $pwd = Yii::app()->request->getParam('pwd');
            // $loginModel = new LoginForm ();
            // $loginModel ['u_tel'] = $tel;
            // $loginModel ['u_pwd'] = $pwd;
            
            // if (! $loginModel->validate ()) {
            // $rlt ['msg'] = '用户名或密码格式错误';
            // } elseif ($loginModel->login ()) {
            // $rlt['status']=true;
            // }
            // MUserController::login($us, $pwd)
            $rlt = $this->login($tel, $pwd);
            // Should output results.
            $this->emitRest('req.render.json', [
                $rlt
            ]);
        });
        
        $this->onRest('req.get.userInfo.render', function () {
            // Custom logic for this route.
            $rlt = UTool::iniFuncRlt();
            $userId = Yii::app()->request->getParam('uid');
            // $pwd = Yii::app ()->request->getParam ( 'pwd' );
            // $loginModel = new LoginForm ();
            // $loginModel ['u_tel'] = $tel;
            // $loginModel ['u_pwd'] = $pwd;
            
            // if (! $loginModel->validate ()) {
            // $rlt ['msg'] = '用户名或密码格式错误';
            // } elseif ($loginModel->login ()) {
            // $rlt['status']=true;
            // }
            // MUserController::login($us, $pwd)
            $rlt = $this->getUserInfo($userId);
            // Should output results.
            $this->emitRest('req.render.json', [
                $rlt
            ]);
        });
        

            $this->onRest('req.post.sendRegSms.render', function () {
                $mobile = Yii::app()->request->getParam('tel');
                 $send_code = Yii::app()->request->getParam('send_code');
                // Custom logic for this route.
                $rlt = UTool::iniFuncRlt();
               
                // $pwd = Yii::app ()->request->getParam ( 'pwd' );
                // $loginModel = new LoginForm ();
                // $loginModel ['u_tel'] = $tel;
                // $loginModel ['u_pwd'] = $pwd;
            
                // if (! $loginModel->validate ()) {
                // $rlt ['msg'] = '用户名或密码格式错误';
                // } elseif ($loginModel->login ()) {
                // $rlt['status']=true;
                // }
                // MUserController::login($us, $pwd)
                $rlt = $this->sendSmsCode($mobile, $send_code);
                // Should output results.
                $this->emitRest('req.render.json', [
                    $rlt
                ]);
            });
            

                $this->onRest('req.post.reg.render', function () {
                    $mobile = Yii::app()->request->getParam('tel');
                    $pwd = Yii::app()->request->getParam('pwd');
                    // Custom logic for this route.
                    $rlt = UTool::iniFuncRlt();
                     
                    // $pwd = Yii::app ()->request->getParam ( 'pwd' );
                    // $loginModel = new LoginForm ();
                    // $loginModel ['u_tel'] = $tel;
                    // $loginModel ['u_pwd'] = $pwd;
                
                    // if (! $loginModel->validate ()) {
                    // $rlt ['msg'] = '用户名或密码格式错误';
                    // } elseif ($loginModel->login ()) {
                    // $rlt['status']=true;
                    // }
                    // MUserController::login($us, $pwd)
                    $rlt = $this->reg($mobile, $pwd);
                    // Should output results.
                    $this->emitRest('req.render.json', [
                        $rlt
                    ]);
                });
    }

    private function getUserInfo($userId)
    {
        $rlt = UTool::iniFuncRlt();
        
        $user = User::model()->findByPk($userId);
        if (isset($user)){
            
            $rlt['data']=array(
                'nickName'=>$user['u_nick_name'],
                'gender'=>$user['u_sex'],
                'age'=>$user['u_age'],
                'carBrand'=>$user['u_car_brand'],
                'carType'=>$user['u_car_type'],
            );
           $rlt['status']=TRUE;
           $rlt['msg']='获取成功';
        }

        
        return $rlt;
    }

    /**
     * 根据用户名和密码判断用户是否登陆成功
     * 
     * @param unknown $tel            
     * @param unknown $pwd            
     * @return Ambigous <string, multitype:, multitype:NULL >
     */
    private static function login($tel, $pwd)
    {
        $rlt = UTool::iniFuncRlt();
        
        $loginModel = new LoginForm();
        $loginModel->setScenario('login');
        $loginModel['u_tel'] = $tel;
        $loginModel['u_pwd'] = $pwd;
        
        if (! $loginModel->validate()) {
            $rlt['msg'] = '用户名或密码格式错误';
        } else 
            if ($loginModel->login()) {
                // $operationId = UTool::mSetCsrfValidator ();
                $rlt['status'] = true;
                // Yii::app()->session['csrfId']=$operationId;
                $rlt['data'] = array(
                    // 'oi' => $operationId,
                    'id' => Yii::app()->user->id,
                    // 'PHPSESSID' => Yii::app ()->session->sessionID,
                    'nickName' => Yii::app()->user->_nickName
                )
                // 'session'=>Yii::app()->session,
                ;
            } else {
                $rlt['msg'] = '用户名或密码错误';
                // $rlt['data']=$loginModel->errors;
            }
        
        $logInfo = array(
            'date' => date('Y-m-d H:i:s'),
            'tel' => $tel,
            // 'pwd'=>$pwd,
            'ip' => Yii::app()->request->userHostAddress,
            'url' => Yii::app()->request->getUrl()
        );
        Yii::log(CJSON::encode($logInfo), CLogger::LEVEL_INFO, 'mngr.muser.login');
        return $rlt;
        // echo CJSON::encode ( $rlt );
    }

    public function actionLogin()
    {
        $rlt = UTool::iniFuncRlt();
        // if (!Yii::app()->request->isAjaxRequest){
        // $rlt['msg']='非法请求';
        // // $rlt['data']='00023';
        // echo CJSON::encode($rlt);
        // return ;
        // }
        $tel = Yii::app()->request->getParam('userName');
        $pwd = Yii::app()->request->getParam('pwd');
        
        $loginModel = new LoginForm();
        $loginModel['u_tel'] = $tel;
        $loginModel['u_pwd'] = $pwd;
        
        if (! $loginModel->validate()) {
            $rlt['msg'] = '用户名或密码格式错误';
        } elseif ($loginModel->login()) {
            $operationId = UTool::mSetCsrfValidator();
            $rlt['status'] = true;
            // Yii::app()->session['csrfId']=$operationId;
            $rlt['data'] = array(
                'oi' => $operationId,
                'id' => Yii::app()->user->id,
                'PHPSESSID' => Yii::app()->session->sessionID,
                'name' => Yii::app()->user->name
            )
            // 'session'=>Yii::app()->session,
            ;
        } else {
            $rlt['msg'] = '用户名或密码错误';
            // $rlt['data']=$loginModel->errors;
        }
        
        echo CJSON::encode($rlt);
    }

    public function actionGetSessionId()
    {
        $rlt = UTool::iniFuncRlt();
        $rlt['status'] = true;
        $rlt['data'] = Yii::app()->session->sessionID;
        
        echo CJSON::encode($rlt);
    }

    public function actionCloseSession()
    {
        $rlt = UTool::iniFuncRlt();
        
        Yii::app()->session->clear();
        Yii::app()->session->destroy();
        $rlt['status'] = true;
        
        echo CJSON::encode($rlt);
    }

    /**
     * 获取发送短信验证码身份标识
     * 刘长鑫
     * 20150305
     */
    public function actionGetSendCode()
    {
        $rlt = UTool::iniFuncRlt();
        $rltCheck = UTool::checkRepeatAction(10);
        if ($rltCheck['status']) {
            // 如果频繁请求
            $rlt = $rltCheck;
        } else {
            // 设置服务器段发送短信验证码身份标识
            $send_code = UTool::randomkeys(6);
            Yii::app()->session['send_code'] = $send_code;
            $rlt['status'] = true;
            $rlt['data'] = $send_code;
        }
        echo CJSON::encode($rlt);
    }

    public function actionCheckTelReg()
    {
        $rlt = UTool::iniFuncRlt();
        $mobile = Yii::app()->request->getParam('tel');
        if (! preg_match('/^1\d{10}$/', $mobile)) {
            $rlt['msg'] = '手机号码格式不正确';
            echo CJSON::encode($rlt);
            Yii::app()->end();
        }
        
        $userCount = User::model()->countByAttributes(array(
            'u_tel' => $mobile
        ));
        if ($userCount > 0) {
            $rlt['msg'] = '该手机号码已注册';
            $rlt['data'] = true;
        } else {
            $rlt['data'] = false;
            $rlt['msg'] = '该手机号码尚未注册';
        }
        $rlt['status'] = true;
        echo CJSON::encode($rlt);
    }

    /**
     * 发送短信验证码
     * 刘长鑫
     * 20150416
     * 发送短信验证码
     * $tel 电话号码
     * $send_code 发送请求码
     */
    private  function sendSmsCode($mobile, $send_code)
    {
//         Yii::log(date('Y-m-d H:i:s'),CLogger::LEVEL_INFO,'mUserC');
        $rlt = UTool::iniFuncRlt();
//         $mobile = Yii::app()->request->getParam('tel');
//         $send_code = Yii::app()->request->getParam('send_code');
        if ( ! preg_match('/\d{6}$/', $send_code) || empty($send_code)) {
            $rlt['msg'] = '请求参数错误';
//             echo CJSON::encode($rlt);
//             return;
            
            return $rlt;
        }
        
        // $checkRlt = UTool::checkRepeatAction(60);
        // if ($checkRlt['status']) {
        // $rlt = $checkRlt;
        // $rlt['status'] = false;
        // echo CJSON::encode($rlt);
        // return ;
        // }
        
        // $target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
        
        $mobile_code = UTool::randomkeys(6);
        if (! preg_match('/^1\d{10}$/', $mobile)) {
            $rlt['msg'] = '手机号码格式不正确';
//             echo CJSON::encode($rlt);
//             Yii::app()->end();
            return $rlt;
        }
        
//         if (empty(Yii::app()->session['send_code']) or $send_code != Yii::app()->session['send_code']) {
//             // 防用户恶意请求
//             $rlt['msg'] = '请求超时，请刷新页面后重试';
//             echo CJSON::encode($rlt);
//             Yii::app()->end();
//         }
        
        $rlt = USms::sendSmsReg($mobile, $send_code);
        

//         echo CJSON::encode($rlt);
        return $rlt;
    }

    /**
     * 新用户注册
     */
    private function reg($tel,$pwd)
    {
        $rlt=UTool::iniFuncRlt();
        $model = new LoginForm();
        $model->setScenario('mreg');
//         $tel = Yii::app()->request->getParam('tel');
//         $pwd = Yii::app()->request->getParam('pwd');
        $model->u_tel = $tel;
        $model->u_pwd = $pwd;
        $model->u_pwd2 = $pwd;
        
//         // if it is ajax validation request
//         if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
//             echo CActiveForm::validate($model);
//             Yii::app()->end();
//         }
        
//         // collect user input data
//         if (isset($_POST['LoginForm'])) {
//             // 校验令牌
//             if (! UTool::checkCsrf()) {
//                 echo '错误请求';
//                 Yii::app()->end();
//             }
//             $model->attributes = $_POST['LoginForm'];
            if ($model->validate()) {
//                 $rltCheck = UTool::checkRepeatAction(10);
//                 if ($rltCheck['status']) {
//                     // echo CJSON::encode($rltCheck);
//                     Yii::app()->user->setFlash('regError', $rltCheck['msg']);
//                     // Yii::app()->end();
//                 } else {
                    $regRlt = User::model()->reg($model);
//                     if ($regRlt['status']) {
//                         $rlt = $regRlt;
//                         // $this->redirect(array('profile'));
//                         $this->layout = 'admin_user';
//                         $this->redirect(array(
//                             'user/profile'
//                         ), true);
                        
//                         Yii::app()->end();
//                     } else {
//                         Yii::app()->user->setFlash('regError', $regRlt['msg'] . '，请稍后重试');
//                     }
$rlt=$regRlt;
$rlt['data']=array('id'=>$regRlt['data']['id']);
//                 }
            } else{
                $rlt['msg']=CJSON::decode( CActiveForm::validate($model));
            }
//         }
        // 显示登录表单
//         $this->layout = 'main_simple';
//         $this->render('reg', array(
//             'model' => $model
//         ));
return $rlt;
    }

    public function actionUpdate()
    {
        $rlt = UTool::iniFuncRlt();
        $oi = Yii::app()->request->getPost('oi');
        if (empty($oi)) {
            // if (empty($oi) || UTool::mCheckCsrf($oi)) {
            $rlt['msg'] = '非法请求';
            echo CJSON::encode($rlt);
            return;
        }
        
        if (UTool::mCheckCsrf($oi)) {
            $rlt['status'] = true;
            $rlt['msg'] = '操作成功';
        } else {
            // $rlt['status']=false;
            $rlt['msg'] = '操作失败';
        }
        $rlt['data'] = Yii::app()->session['csrfId'];
        
        echo CJSON::encode($rlt);
    }

    public function actionLogout()
    {}
    
    // Uncomment the following methods and override them if needed
    /*
     * public function filters() { // return the filter configuration for this controller, e.g.: return array( 'inlineFilterName', array( 'class'=>'path.to.FilterClass', 'propertyName'=>'propertyValue', ), ); } public function actions() { // return external action classes, e.g.: return array( 'action1'=>'path.to.ActionClass', 'action2'=>array( 'class'=>'path.to.AnotherActionClass', 'propertyName'=>'propertyValue', ), ); }
     */
}