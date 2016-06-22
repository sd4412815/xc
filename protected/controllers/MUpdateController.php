<?php

class MUpdateController extends Controller
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
                    'REST.DELETE'
                )
                ,
                'users' => array(
                    '*'
                )
            )
        );
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
        $this->onRest('req.get.androidVersion.render', function () {
//             // Custom logic for this route.
//             $rlt = UTool::iniFuncRlt();
//             $tel = Yii::app()->request->getParam('userName');
//             $pwd = Yii::app()->request->getParam('pwd');
//             // $loginModel = new LoginForm ();
//             // $loginModel ['u_tel'] = $tel;
//             // $loginModel ['u_pwd'] = $pwd;
            
//             // if (! $loginModel->validate ()) {
//             // $rlt ['msg'] = '用户名或密码格式错误';
//             // } elseif ($loginModel->login ()) {
//             // $rlt['status']=true;
//             // }
//             // MUserController::login($us, $pwd)
            $rlt = $this->getAndroidVersion();
            // Should output results.
            $this->emitRest('req.render.json', [
                $rlt
            ]);
        });
    }

    private function getAndroidVersion()
    {
        $rlt = UTool::iniFuncRlt();
        $url = Yii::app()->request->hostInfo.Yii::app()->request->baseUrl . '/updates/android/woxiche' . '1.0.0' . '.apk';
        $rlt['status'] = TRUE;
        $rlt['data'] = array(
            'latestVersion' => '1.0.0',
            'minVersion' => '1.0.0',
            'updateUrl' => $url
        );
        // $rlt['msg']='获取成功';
        
        return $rlt;
    }
}