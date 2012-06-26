<?php

class Redirect_Model_DbTable_Row_Log extends Centurion_Db_Table_Row
{

    public function init()
    {
        parent::init();

        $this->_specialGets['is_redirected'] = 'isRedirected';
    }

    public function isRedirected()
    {
        if ($this->lifo === null) {
            return '<strong>No treated</strong>';
        }

        if ('' !== trim($this->lifo->new_url)) {
            return $this->lifo->new_url;
        }

        return '<strong>410</strong>';
    }
}
