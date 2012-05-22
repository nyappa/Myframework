<?php
class C extends View
{

    private $req;

    function __construct( $reqest ) {
        $this->req = $reqest;
    }

    function validation ()
    {
        $this->assign('validation','validation ugoki');
    }

    function top ()
    {
        $this->render('top.tpl');
    }

    function index ()
    {
        debug($this->req);
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
