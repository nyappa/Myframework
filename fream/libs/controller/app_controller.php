<?php

//route か何かのパス定義を読み込み
//require('Smarty.class.php');

class Controller {
	
	public $request;
	/*
	*ｽﾏｰﾃｨｰ初期設定
	*/	
	function __construct() {
		//まだ不確定　本格的に開発する前に決定
        }


	/*
	 *設定作成
	 */
	function create_conf(){

		$route_config = new ROUTE_CONFIG();

		$set_path = $route_config->set_path;

		$param_array = array('params','controller','class','action','filter');

		foreach( $set_path as $key => $val ){

			$main_path  = $key;

		        foreach( $param_array as $main_key => $main_val ){	
			    $main_params[$main_val] = $val[$main_val];
			    
			    if( $val[$main_val] ) {
				    unset($val[$main_val]);
			    }
			}

			#main のパス情報
			$new_set_path[ $main_path ] = $main_params;

			#main 以外のパス情報作成
			foreach ( $val as $sub_path => $sub_val ){

				$create_path = $main_path.$sub_path;

				$new_set_path[ $create_path ] = array();

				foreach ($param_array as $param_key => $param_val ){

					if ( $sub_val[$param_val] ) {
						$new_set_path[ $create_path ][$param_val] = $sub_val[$param_val];
					} 
					else {
						$new_set_path[ $create_path ][$param_val] = $main_params[$param_val];
					}

				}

			}

		}

		$file = APP.'/route/route_conf/serialize.php';
		//ファイルに追加します
		$current = serialize( $new_set_path );
		//結果をファイルに書き出します
		return file_put_contents($file, $current) ? 1 : 0;
	}

	/*
	*URL作成関数
	*/
	function create_url($path){
		//若干セキュリティの意味もかねて一旦ばらす
		$params = explode("/", $path);
		unset($params[0]);

		$path = join('/',$params);

	        $this->create_conf();
		$file = APP.'/route/route_conf/serialize.php';
		$set_path = unserialize( file_get_contents( $file ) );

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
