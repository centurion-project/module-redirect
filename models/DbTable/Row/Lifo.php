<?php

class Redirect_Model_DbTable_Row_Lifo extends Centurion_Db_Table_Row
{
    protected $_proxy = null;
    /**
     * Get the proxy
     *
     * @return Centurion_Db_Table_Row_Abstract
     */
    public function getProxy()
    {
        if (null === $this->_proxy) {
            if (null !== $this->proxymodel) {
                $this->_getProxy($this->proxymodel->name, $this->proxy_pk);
            }
        }
        
        return $this->_proxy;
    }

    /**
     * Get the proxy
     *
     * @return Centurion_Db_Table_Row_Abstract
     */
    protected function _getProxy($model, $pk)
    {
        if (null === $this->_proxy && null !==  $pk) {
            $proxyTable = Centurion_Db::getSingletonByClassName($model);
            $this->_proxy = $proxyTable->find($pk)->current();
        }

        return $this->_proxy;
    }
}