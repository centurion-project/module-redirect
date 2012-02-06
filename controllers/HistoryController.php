<?php
class Redirect_HistoryController extends Centurion_Controller_Action
{
    public function historyAction()
    {
        $history = $this->_getParam('history');
        if ($history == null) {
            throw new Centurion_Controller_Action_Exception();
        }
        if (null !== $history->new_url) {
            $this->_redirect($history->new_url, array('code' => 301));
        } elseif ($row = $history->getProxy()) {
            $this->_redirect($row->old_permalink, array('code' => 301));
        } else {
            $this->view->message = 'Sorry, this ressource no longer exists.';
            throw new Centurion_Controller_Action_Gone_Exception('Ressource has gone', 410);
        }
    }
}