<?php
class Sample extends View
{

    function validation() {
        print 'validation!!=====';
        $this->assign('validation','validation ugoki');
    }

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

    function edit(){
        //ﾍﾟｰｼﾞ描写テンプレート
        $this->create();
    }



}
?>
