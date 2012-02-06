<?php

class Redirect_Bootstrap extends Centurion_Application_Module_Bootstrap
{
    protected $_savedPermalink = array();

    protected function _initPlugins()
    {
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $front->registerPlugin(new Redirect_Model_Plugin_ErrorControllerBootstrap());
    }

    protected function _initSignal()
    {
        Centurion_Signal::factory('pre_delete')->connect(array($this, 'deleteRow'), 'Centurion_Db_Table_Row_Abstract');
        Centurion_Signal::factory('pre_update')->connect(array($this, 'preUpdate'), 'Centurion_Db_Table_Row_Abstract');
        Centurion_Signal::factory('post_update')->connect(array($this, 'postUpdate'), 'Centurion_Db_Table_Row_Abstract');
    }

    public function deleteRow($signal, Centurion_Db_Table_Row_Abstract $row)
    {
        if (!($row instanceof Redirect_Model_DbTable_Row_Interface)) {
            return;
        }

        if ('' !== trim($row->permalink)) {
            Centurion_Db::getSingleton('redirect/lifo')->push($row->permalink, null);
        }
    }

    /**
     * We temporaly save the permalink, because in postUpdate, permalink will already have been change
     * @param unknown_type $signal
     * @param Centurion_Db_Table_Row_Abstract $row
     */
    public function preUpdate($signal, Centurion_Db_Table_Row_Abstract $row)
    {
        if (!($row instanceof Redirect_Model_DbTable_Row_Interface)) {
            return;
        }

        $key = Centurion_Inflector::id($row);
        //We clone, in order to make reset without changing the row that will be saved after the signal
        $row = clone $row;
        //We reset because, if not, the permalink will be the new one and not the old one
        $row->reset();

        $this->_savedPermalink[$key] = $row->permalink;
    }

    public function postUpdate($signal, Centurion_Db_Table_Row_Abstract $row)
    {
        if (!($row instanceof Redirect_Model_DbTable_Row_Interface)) {
            return;
        }
        
        $key = Centurion_Inflector::id($row);
        $savedPermalink = $this->_savedPermalink[$key];

        if ($savedPermalink !== $row->permalink && '' !== trim($savedPermalink)) {
            Centurion_Db::getSingleton('redirect/lifo')->push($savedPermalink, $row);
        }
    }

}
