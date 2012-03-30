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

	        $json_data = json_decode (ROOT_PATHS);

		//ＵＲＬマッチとパラメーター取り出しはＯＫ
		//類似パスを取得する可能性。。

		$set_path = array(

			'Sample/([a-z]+)/lists/([0-9]+)/edit' => array(
				'params' => array( 1 => 'id', 2 => 'id2'),
				'controller' => '/Sample/controller_Sample.php',
			),

                        'Sample/read/lists/123/edit' => array(
				'controller' => '/Sample/controller_Sample.php',
			)

		);

		
		foreach( $set_path as $key => $val ){

			if( ereg('^'.$key.'$', $path, $array) ){
				$serces[] = $key; 
			}
		}

		if( count( $serces ) > 1 ){

			foreach( $serces as $serces_key => $serces_val ){
				if($serces_val == $path){
					$use_path = $serces_val;
				}else{
					unset( $serces[ $serces_key ] );
				}
			}

		}else{
                    $use_path = $serces[0];
		}

		if( !$use_path ){
                   echo 'error';
		}

		if( ereg('^'.$use_path.'$', $path, $array) ){

			unset( $array[0] );

			foreach ( $array as $param_key => $param_val ){
				$req_params[ $set_path[$use_path]['params'][$param_key] ] = $param_val;
			}

			$controller_path = APPLICATION.$set_path[$use_path]['controller'];
		}

echo $controller_path;
debug($req_params);


		#$serialize = serialize( $params_list );
                #debug( unserialize( $serialize ) );

		#debug($params_list);

		

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
