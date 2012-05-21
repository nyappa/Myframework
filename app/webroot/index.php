<?php
/*
 *作成中　すべての動作をここからできるように
 *定数設定がここなのでここからview modelを読み込み
 *ここから読み込まないとｴﾗｰを起こすので注意
 */

//ﾌﾚｰﾑﾜｰｸﾙｰﾄ
define('MYFREAM',dirname(dirname(dirname(__FILE__))));

//本体ﾊﾟｽ
define('FREAM',MYFREAM.'/fream');

//各種基本ﾌｧｲﾙへのﾊﾟｽ
define('LIB',FREAM.'/libs');
define('VIEW',LIB.'/view/app_view.php');
define('CONTROLLER',LIB.'/controller/app_controller.php');
define('MODEL',LIB.'/model/app_model.php');
define('APP',MYFREAM.'/app');
define('CONFIG',APP.'/configs');
define('APPLICATION',APP.'/app');
define('DATABASE_CONF',CONFIG.'/database.php');

//ﾃﾝﾌﾟﾚｰﾄの場所
define('TEMPLATE',APP.'/templates/');
define('TEMPLATE_C',APP.'/templates/templates_c/');

//パス設定定義　読み込み
require_once(APP.'/route/root.php');

//共通処理設定読み込み
require_once(LIB.'/function.php');

//各種ｸﾗｽ読み込み
require_once(VIEW);
require_once(CONTROLLER);


//mod_rewite用　場所は跡で考える 頓挫中(js 以外ならOK)
if(MOD_REWEIT_SET == 'on'){
    $view->assign("ROOT",'/');
}else{
    $view->assign("ROOT",'/index.php');
}

if($_SERVER['PATH_INFO']){
    $path = $_SERVER['PATH_INFO'];
}
elseif( $_SERVER['ORIG_PATH_INFO'] ){
    $path = $_SERVER['ORIG_PATH_INFO'];
}else{
    $path = '/';
}

//role を使った形
$params = $c->create_url( $path );

//url構築処理 urlが不正な場合はｴﾗｰ処理
#$params = $view->create_url( $path );

#include($params['url']);//コントローラーファイル読み込み
#$instance = new $params['class_name']();  //クラスのインスタンスを生成
#$instance->$params['method_name']();    //クラスのメソッドを呼ぶ

include($params['path']);
$instance = new $params['class']();

foreach( $params['filter'] as $key => $val ){
    $instance->$val();
}

$instance->$params['method']();
?>
