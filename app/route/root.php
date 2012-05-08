<?php
class ROUTE_CONFIG {

    public $set_path = array(

        '/' => array(
            'controller' => '/Sample/controller_Sample.php',
            'class' => 'Sample',
            'action' => 'top',
        ),

        'Sample/([a-z]+)/lists/([0-9]+)' => array(

            'params' => array( 1 => 'id', 2 => 'id2'),
            'controller' => '/Sample/controller_Sample.php',
            'class' => 'Sample',
            'action' => 'index',
            'filter' => array('validation'),

            '/edit' => array(
                'action' => 'edit',	
                'filter' => array('validation'),
            ),

            '/add' => array(
                'action' => 'add',	
                'filter' => array('validation'),
            ),

        ),

    );

}
?>
