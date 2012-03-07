<?php
class Sample extends View
{

	function index(){
		//ﾍﾟｰｼﾞ描写処理
		$this->assign('log_list',$log_list);
		$this->create();
	}

	function list(){
		//ﾍﾟｰｼﾞ描写テンプレート
		$this->create('none');
	}

}
?>
