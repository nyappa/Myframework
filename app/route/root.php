<?php
class ROUTE_CONFIG {

    public $set_path = array(

        '/' => array(
            'app' => 'Sample',
            'action' => 'top',
        ),

        'Sample' => array(
            'app'    => 'Sample',
            'action' => 'sample',
        ),

        'Sample/([a-z]+)/lists/([0-9]+)' => array(

            'params' => array( 1 => 'id', 2 => 'id2'),
            'app' => 'Sample',
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
