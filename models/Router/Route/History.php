<?php

class History_Model_Router_Route_History extends Zend_Controller_Router_Route_Abstract
{
    protected $_path = null;

    public static function getInstance(Zend_Config $config)
    {
        return new self();
    }
    
    public function assemble($data = array(), $reset = false, $encode = false, $partial = false)
    {
        return $this->_path;
    }
    
    public function match($path, $partial = false)
    {
        $this->_path = $path->getPathInfo();
        
        $row = Centurion_Db::getSingleton('history/lifo')->findOneByOld_permalink($path->getPathInfo());
        
        if ($row === null) {
            return null;
        } else {
            $path->setParam('history', $row);
            $path->setParam('controller', 'history');
            $path->setParam('module', 'history');
            $path->setParam('action', 'history');
            return $path;
        }
    }
}