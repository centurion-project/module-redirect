<?php

class Redirect_Model_DbTable_Log extends Centurion_Db_Table_Abstract
{
    protected $_rowClass = 'Redirect_Model_DbTable_Row_Log';
    
    protected $_referenceMap = array(
        'lifo'   =>  array(
            'columns'       => 'url',
            'refColumns'    => 'old_permalink',
            'refTableClass' => 'Redirect_Model_DbTable_Lifo',
        )
    );
}
