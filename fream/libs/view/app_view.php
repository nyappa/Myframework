<?php
/*
 *ﾃﾝﾌﾟﾚｰﾄ共通ｸﾗｽ
 *
 */
require('Smarty.class.php');

class View extends Smarty{

    public $template_path;

    /*
     *ｽﾏｰﾃｨｰ初期設定
     *
     */	
    function __construct() {
        //$smarty->force_compile = true;
        /*
        $this->debugging = true;
        $this->caching = true;
        $this->cache_lifetime = 120;
         */
        //$smarty->config_dir   = 'configs/';

        //まだ不確定　本格的に開発する前に決定
        $this -> left_delimiter = "{*";
        $this -> right_delimiter = "*}";
    }


    /*
     *ﾃﾝﾌﾟﾚｰﾄの設定などを決定
     *create_url 実行後に使用しないと正しく動きません
     *$template_name 使用ﾃﾝﾌﾟﾚｰﾄ名
     *基本的にファイルの一番最後で使用
     *type = none テンプレートを使わない
     */
    function create($template_name = null,$type = 'layout'){

        /*
         * テンプレート名無指定の場合無条件でレイアウトが適応されるので
         * 「none」を引数に渡すと無指定＆レイアウトなしに出来るように
         * するための設定
         */	
        $template_params = $template_name;

        //呼び出し元メソッド名を取得
        if(is_null($template_name) or $template_params == 'none'){
            $backtraces = debug_backtrace();
            $template_name = $backtraces[1]['function'];
        }

        //テンプレートをテンプレートフォルダにまとめる場合
        #$template_path = TEMPLATE.get_class($this).'/';
        //テンプレートをアプリケーションフォルダごとに持つ場合
        $template_path = APPLICATION.'/'.get_class($this).'/'.'template/';
        $template_path = APPLICATION.'/'.get_class($this).'/'.'template/';

        //type オプションにnone が渡された時の処理(layoutを使用しない場合)
        if($type == 'none' or $template_params == 'none'){
            $this->template_dir = $template_path;
            $this->compile_dir  = TEMPLATE_C;
            $this->display($template_name.'.tpl');
            die;
        }

        if(!file_exists($template_path.$template_name.'.tpl')){
            echo 'A template does not exist. ';
            die;
        }

        //contentﾃﾝﾌﾟﾚｰﾄﾌｫﾙﾀﾞを設定
        #$this->assign('content_tpl',$this->template_path.$template_name.'.tpl');
        $this->assign('content_tpl',$template_path.$template_name.'.tpl');

        /*
         *ﾚｲｱｳﾄﾌｧｲﾙがapp以下のtemplateにない場合
         *ﾌﾚｰﾑﾜｰｸ本体にあるﾌｧｲﾙを使用する
         */
        if(file_exists(TEMPLATE.'/layouts/default.tpl')){
            //ﾚｲｱｳﾄﾃﾝﾌﾟﾚｰﾄの描写
            $this->template_dir = TEMPLATE.'/layouts/';
            $this->compile_dir  = TEMPLATE_C;
            $this->display('default.tpl');
        }else{
            $this->template_dir = LIB.'/view/templates/layouts/';
            $this->compile_dir  = LIB.'/view/templates/templates_c/';
            $this->display('default.tpl');
        }
    }


    function render( $temp_path ){

        $template_path = APP_NAME.'/template/'.$temp_path;

        if(!file_exists( $template_path )){
            echo 'A template does not exist. ';
            die;
        }

        //contentﾃﾝﾌﾟﾚｰﾄﾌｫﾙﾀﾞを設定
        $this->assign( 'content_tpl', $template_path );

        /*
         *ﾚｲｱｳﾄﾌｧｲﾙがapp以下のtemplateにない場合
         *ﾌﾚｰﾑﾜｰｸ本体にあるﾌｧｲﾙを使用する
         */
        if(file_exists(TEMPLATE.'/layouts/default.tpl')){
            //ﾚｲｱｳﾄﾃﾝﾌﾟﾚｰﾄの描写
            $this->template_dir = TEMPLATE.'/layouts/';
            $this->compile_dir  = TEMPLATE_C;
            $this->display('default.tpl');
        }else{
            $this->template_dir = LIB.'/view/templates/layouts/';
            $this->compile_dir  = LIB.'/view/templates/templates_c/';
            $this->display('default.tpl');
        }
    }

}

$view = new View();

?>
