<?php
class History_AdminLogController extends Centurion_Controller_CRUD
{
    public function preDispatch()
    {
        $this->_helper->authCheck();
        $this->_helper->aclCheck();
        $this->_helper->layout->setLayout('admin');
        parent::preDispatch();
    }

    public function init()
       {
           $this->_model = Centurion_Db::getSingleton('history/log');

           $this->_formClassName = 'History_Form_Model_Log';

           $this->view->placeholder('headling_1_content')->set($this->view->translate('Manage log'));
           $this->view->placeholder('headling_1_add_button')->set($this->view->translate('log'));

           $this->_displays = array(
               'url'      =>  array(
                   'type'  => self::COL_TYPE_FIRSTCOL,
                   'label' => $this->view->translate('Url'),
                   'param' => array(
                                   'title' => 'url',
                                   'cover' => null,
                                   'subtitle' => 'message',
                   ),
               ),
               'left|lifo__new_url'     => $this->view->translate('Redirected ?'),
               'created_at'       => $this->view->translate('First Time'),
               'updated_at'       => $this->view->translate('Last time'),
               'nb'               => $this->view->translate('Number'),
           );

           parent::init();
       }
}
