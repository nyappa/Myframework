<?php

//route か何かのパス定義を読み込み
//require('Smarty.class.php');

class Controller extends View {

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

        $param_array = array('params','app','action','filter');

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

        $check_file = APP.'/route/route_conf/check_route.php';
        $check_current = serialize( $set_path );
        file_put_contents($check_file, $check_current);

        $file = APP.'/route/route_conf/serialize.php';
        //ファイルに追加します
        $current = serialize( $new_set_path );
        //結果をファイルに書き出します
        return file_put_contents($file, $current) ? 1 : 0;
    }

    function check_url(){

        $route_config = new ROUTE_CONFIG();
        $now_route = serialize( $route_config->set_path );

        $file = APP.'/route/route_conf/check_route.php';
        $old_route = file_get_contents( $file );

        if ( $now_route !== $old_route || !$old_route ) {
            return $this->create_conf();
        }else{
            return ;
        }

    }

    /*
     *URL作成関数
     */
    function create_url( $path ){

        //若干セキュリティの意味もかねて一旦ばらす
        $params = explode("/", $path);
        unset($params[0]);

        $path = join('/',$params);

        if ( !$path ) {
            $path = '/';
        }

        $file = APP.'/route/route_conf/serialize.php';

        $get_file = file_get_contents( $file );

        if( !$get_file ) {
            $this->create_conf();
            return $this->create_url( $path );
        }

        //パス設定の更新をリアルタイムに行いたいので
        if( $this->check_url() ){
            $get_file = file_get_contents( $file );
        }

        $set_path = unserialize( $get_file );

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

        #エラー処理
        if( !$use_path ){
                echo 'error';
        }

        define('APP_NAME',APPLICATION.'/'.$set_path[$use_path]['app']);

        $req_params = array();

        if( ereg('^'.$use_path.'$', $path, $array) ){

            unset( $array[0] );

            foreach ( $array as $param_key => $param_val ){
                $req_params[ $set_path[$use_path]['params'][$param_key] ] = $param_val;
            }

            $controller_path = APP_NAME.'/'.'C.php';
        }

        $this->request = $req_params + $_GET + $_POST;

        $params = array(
            'path'   => $controller_path,
            'class'  => 'C',
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
