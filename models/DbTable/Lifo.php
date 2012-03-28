<?php

class Redirect_Model_DbTable_Lifo extends Centurion_Db_Table_Abstract
{
    protected $_name = 'redirect_lifo';
    protected $_rowClass = 'Redirect_Model_DbTable_Row_Lifo';
    
    public function push($permalink, $row = null)
    {
        $data = array();
        
        if ($row !== null) {
            list($contentType, $created) = Centurion_Db::getSingleton('core/contentType')->getOrCreate(array('name' => get_class($row)));
            $data['proxy_model'] = $contentType->id;
            $data['proxy_pk'] = $row->id;
        }
        $data['old_permalink'] = $permalink;
        return $this->insert($data);
    }
    
    protected $_referenceMap = array(
        'proxymodel' => array(
                'columns' => 'proxy_model',
                'refColumns' => 'id',
                'refTableClass' => 'Core_Model_DbTable_ContentType',
                'onDelete'      => self::SET_NULL
        ),
        'log' => array(
                'columns' => 'old_permalink',
                'refColumns' => 'url',
                'refTableClass' => 'Redirect_Model_DbTable_Log',
        )
    );
}
