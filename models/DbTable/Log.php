<?php

class History_Model_DbTable_Log extends Centurion_Db_Table_Abstract
{
    protected $_referenceMap = array(
        'lifo'   =>  array(
            'columns'       => 'url',
            'refColumns'    => 'old_permalink',
            'refTableClass' => 'History_Model_DbTable_Lifo',
            'onDelete'      => self::CASCADE,
            'onUpdate'      => self::CASCADE
        )
    );
}
