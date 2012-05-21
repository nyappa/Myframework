<?php
class C extends View
{

    function validation() {
        $this->assign('validation','validation ugoki');
    }

    function top(){
        $this->render('Sample/template/top.tpl');
    }

    function index(){
        //ﾍﾟｰｼﾞ描写処理
        $sample_text = 'A sample is started.';

        $this->assign('sample_text',$sample_text);
        $this->render('Sample/template/index.tpl');
        #$this->create();
    }

    function lists(){
        //ﾍﾟｰｼﾞ描写テンプレート
        #$this->create();
        $this->render('Sample/template/lists.tpl');
    }

    function edit(){
        //ﾍﾟｰｼﾞ描写テンプレート
        #$this->create();
        $this->render('Sample/template/edit.tpl');
    }



}
?>
