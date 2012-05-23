<?php
class Controller extends View {

    /*
     *パラメーター取得
     */
    function params(){

        if( $_SERVER['PATH_INFO'] ){
            $path = $_SERVER['PATH_INFO'];
        }
        elseif( $_SERVER['ORIG_PATH_INFO'] ){
            $path = $_SERVER['ORIG_PATH_INFO'];
        }
        else{
            $path = '/';
        }

        //若干セキュリティの意味もかねて一旦ばらす
        $params = explode("/", $path);
        unset($params[0]);

        $path = join('/',$params);

        if ( !$path ) {
            $path = '/';
        }

        $file = APP.'/route/route_conf/serialize.php';

        $get_file = file_get_contents( $file );
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

        $req_params = array();

        if( ereg('^'.$use_path.'$', $path, $array) ){
            unset( $array[0] );
            foreach ( $array as $param_key => $param_val ){
                $req_params[ $set_path[$use_path]['params'][$param_key] ] = $param_val;
            }
        }

        return $req_params + $_GET + $_POST;
    }
}
?>
