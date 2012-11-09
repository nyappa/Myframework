<?php
class C extends Controller
{

    function validation ()
    {
        $this->assign('validation','validation ugoki');
    }

    function index ()
    {
        $params = $this->params();
        //debug( $params );
        //ﾍﾟｰｼﾞ描写処理
        $sample_text = 'A sample is started.';

        $this->assign('sample_text',$sample_text);
        $this->render('index.tpl');
    }

    function lists ()
    {
        //ﾍﾟｰｼﾞ描写テンプレート
        $this->render('lists.tpl');
    }

    function edit ()
    {
        //ﾍﾟｰｼﾞ描写テンプレート
        $this->render('edit.tpl');
    }

    function sample ()
    {
        $this->render('sample.tpl');
    }

}
?>
