<?php

class Redirect_Bootstrap extends Centurion_Application_Module_Bootstrap
{
    protected $_savedPermalink = array();

    protected function _initSignal()
    {
        Centurion_Signal::factory('pre_delete')->connect(array($this, 'deleteRow'), 'Centurion_Db_Table_Row_Abstract');
        Centurion_Signal::factory('pre_update')->connect(array($this, 'preUpdate'), 'Centurion_Db_Table_Row_Abstract');
        Centurion_Signal::factory('post_update')->connect(array($this, 'postUpdate'), 'Centurion_Db_Table_Row_Abstract'
        );
    }


    protected function _initPlugins()
    {
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $front->registerPlugin(new Redirect_Model_Plugin_ErrorControllerBootstrap());
    }

    public function getKey($row)
    {
        return sprintf('%s_%s', get_class($row), spl_object_hash($row));
    }

    public function deleteRow($signal, Centurion_Db_Table_Row_Abstract $row)
    {
        if (!($row instanceof Redirect_Model_DbTable_Row_Interface)) {
            return;
        }

        if (trim($row->permalink) !== '') {
            Centurion_Db::getSingleton('redirect/lifo')->push($row->permalink, null);
        }
    }

    public function preUpdate($signal, Centurion_Db_Table_Row_Abstract $row)
    {
        if (!($row instanceof Redirect_Model_DbTable_Row_Interface)) {
            return;
        }

        $key = $this->getKey($row);
        $row = clone $row;
        $row->reset();

        $this->_savedPermalink[$key] = $row->permalink;
    }

    public function postUpdate($signal, Centurion_Db_Table_Row_Abstract $row)
    {
        if (!($row instanceof Redirect_Model_DbTable_Row_Interface)) {
            return;
        }
        $savedPermalink = $this->_savedPermalink[$this->getKey($row)];

        if ($this->_savedPermalink[$this->getKey($row)] !== $row->permalink && trim($savedPermalink) !== '') {
            Centurion_Db::getSingleton('redirect/lifo')->push($savedPermalink, $row);
        }
    }

}
