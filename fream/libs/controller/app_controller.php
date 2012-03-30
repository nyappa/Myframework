<?php

//route か何かのパス定義を読み込み
//require('Smarty.class.php');

class Controller {
	
	public $template_path;
	
	/*
	*ｽﾏｰﾃｨｰ初期設定
	*/	
	function __construct() {
		//まだ不確定　本格的に開発する前に決定
        }
	
	/*
	*URL作成関数
	*/
	function create_url($path){
		//若干セキュリティの意味もかねて一旦ばらす
		$params = explode("/", $path);
		unset($params[0]);

		$path = join('/',$params);
                print $path.'<br>';

	        $json_data = json_decode (ROOT_PATHS);

		//ＵＲＬマッチとパラメーター取り出しはＯＫ
		//類似パスを取得する可能性。。

		$set_path = 'Sample/([0-9]+)/lists/([0-9]+)/edit';

		if( ereg('^'.$set_path.'$', $path, $array) ){
			unset( $array[0] );
			debug( $array );
		}
		
		$serialize = serialize( $params_list );
                debug( unserialize( $serialize ) );

		debug($params_list);

		

		$file_no = count($params);

		//root 設定がされている場合の処理
		if($file_no == 0 && INDEX != ''){
		    $class_name = INDEX;
		    $method_name = 'index';
		}else{
		    if(!isset($params[2]) or $params[2] == '') $params[2] = 'index';
		    $class_name = $params[1];
		    $method_name = $params[2];
		}
		
		//index 判断用
                $dir_index = implode("/", $params);
		$url_index = APP.'/application/'.$dir_index.'/index.php';
		
		//ﾌｧｲﾙを除外
		unset($params[$file_no]);
		
		$url = APP.'/application/'.$class_name.'/controller_'.$class_name.'.php';

		if(!file_exists(APP.'/application/'.$class_name.'/controller_'.$class_name.'.php')){
			echo 'The controller of myfream does not exist.';
			die;
		}

		$params = array(
			'url'         => $url,
			'class_name'  => $class_name,
			'method_name' => $method_name
		);
		
		return $params;

	}
}

$controller = new Controller();

?>
