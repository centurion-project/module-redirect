<?php

class Redirect_Form_Model_Lifo extends Centurion_Form_Model_Abstract
{
    protected $_oldUrl = null;

    public function __construct($options = array())
    {
        $this->_model = Centurion_Db::getSingleton('redirect/lifo');

        $this->_elementLabels = array(
            'new_url'            =>  $this->_translate('New Url'),
        );

        $this->setLegend($this->_translate('Edit User'));

        parent::__construct($options);
    }

    public function setOldUrl($url) {
        $this->_oldUrl = $url;
    }

    public function _preSave()
    {
        $this->_instance->old_permalink = $this->_oldUrl;
        parent::_preSave();
    }
}