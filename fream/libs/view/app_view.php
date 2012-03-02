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
	*URL作成関数
	*$path には$_SERVER['PATH_INFO']を入れること
	*ﾃﾝﾌﾟﾚｰﾄとPHPﾌｧｲﾙが両方あるときにURLが帰る
	*ﾃﾝﾌﾟﾚｰﾄの場所はPHPファイルと同じに設定される
	*/
	function create_url($path){
		//若干セキュリティの意味もかねて一旦ばらす
		$params = explode("/", $path);
		unset($params[0]);

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
		
		$params = array(
			'url'         => $url,
			'class_name'  => $class_name,
			'method_name' => $method_name
		);
		
		return $params;

	/*
		//phpとtplの両方のファイルが存在しない場合はエラー処理
		if (file_exists( $url) && file_exists($this->template_path.$file.'.tpl')) {

			return $url;
		}
		//index ファイル存在確認
		elseif(file_exists($url_index) && file_exists(TEMPLATE.$dir_index.'/index.tpl')){
		       $this->template_path = TEMPLATE.$dir_index.'/';
		       return $url_index;
		}
		elseif(!file_exists($this->template_path.$file.'.tpl')){
                        echo 'テンプレートが存在しません！<br>この警告は本番環境だと微妙なので出し方考える';
		}
		else{
			$this->template_dir = LIB.'/view/templates/';
			$this->compile_dir  = LIB.'/view/templates/templates_c/';
			$this->display('no_page.tpl');
			die;
		}
	 */
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
		
		//type オプションにnone が渡された時の処理(layoutを使用しない場合)
		if($type == 'none' or $template_params == 'none'){
		    $this->template_dir = $template_path;
                    $this->compile_dir  = TEMPLATE_C;
		    $this->display($template_name.'.tpl');
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
	
}

$view = new View();

?>
