<?php

class History_Form_Model_Log extends Centurion_Form_Model_Abstract
{
    protected $_exclude = array('url', 'message', 'nb');

    public function __construct($options = array())
    {
        $this->_model = Centurion_Db::getSingleton('history/log');

        $this->_elementLabels = array(
            'lifo' => 'lifo'
        );

        $this->setLegend($this->_translate('Edit Log'));

        parent::__construct($options);
    }

    public function init()
    {
        $this->addReferenceSubForm(new History_Form_Model_Lifo(), 'lifo');
        parent::init();
    }

    public function setInstance(Centurion_Db_Table_Row_Abstract $instance = null) {
        parent::setInstance($instance);
        if (null !== $instance) {
            $this->getReferenceSubForm('lifo')->setOldUrl($instance->url);
        }
    }
}