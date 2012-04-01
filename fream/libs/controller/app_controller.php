<?php

//route か何かのパス定義を読み込み
//require('Smarty.class.php');

class Controller {
	
	public $request;
	var $item = "コンピュータ";
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
				'class' => 'Sample',
				'action' => 'index',
				'filter' => array('validation'),
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

                $this->request = $req_params;

		#$serialize = serialize( $params_list );
                #debug( unserialize( $serialize ) );

		#debug($params_list);
		
		$params = array(
			'path'   => $controller_path,
			'class'  => $set_path[$use_path]['class'],
			'method' => $set_path[$use_path]['action']
		);

		if( $set_path[$use_path]['filter'] ){
                    $params['filter'] = $set_path[$use_path]['filter'];
		}else{
                    $params['filter'] = array();
		}

		return $params;

	}
}

$c = new Controller();

?>
