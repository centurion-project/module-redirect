<?php

class Redirect_Form_Model_Lifo extends Centurion_Form_Model_Abstract
{
    protected $_oldUrl = null;

    public function __construct($options = array())
    {
        $this->_exclude[] = 'proxy_model';
        $this->_model = Centurion_Db::getSingleton('redirect/lifo');

        $this->_elementLabels = array(
            'new_url' =>  $this->_translate('New Url'),
        );

        $this->setLegend($this->_translate('Edit User'));

        parent::__construct($options);
    }

    public function init()
    {
        $this->_elementLabels['old_permalink'] = $this->_translate('Old url');
        $this->addElement('text', 'old_permalink', array('description' => 'Must be relative', 'label' => $this->_elementLabels['old_permalink']));
    }

    public function setInstance(Centurion_Db_Table_Row_Abstract $instance = null) {
       $return = parent::setInstance($instance);

        if (null !== $instance) {
            $this->getElement('old_permalink')->setAttrib('disabled', true);
            $this->getElement('old_permalink')->setDescription(null);
        }

        return $return;
    }

    public function setOldUrl($url) {
        $this->_oldUrl = $url;
        $this->getElement('old_permalink')->setValue($url);
        $this->getElement('old_permalink')->setAttrib('disabled', true);
        $this->getElement('old_permalink')->setDescription(null);
    }

    public function _preSave()
    {
        if (null !== $this->_oldUrl) {
            $this->_instance->old_permalink = $this->_oldUrl;
        }

        parent::_preSave();
    }
}
