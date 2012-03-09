<?php
class Sample extends View
{

	function index(){
		//ﾍﾟｰｼﾞ描写処理
		
		$sample_text = 'A sample is started.';

		$this->assign('sample_text',$sample_text);
		$this->create();
	}

	function lists(){
		//ﾍﾟｰｼﾞ描写テンプレート
		$this->create();
	}

}
?>
