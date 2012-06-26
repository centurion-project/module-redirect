<?php
/**
 * Centurion module : redirect
*
* LICENSE
*
* This source file is subject to the new BSD license that is bundled
* with this package in the file LICENSE.txt.
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@centurion-project.org so we can send you a copy immediately.
*
* @category    Redirect
* @package     Redirect_Controller
* @copyright   Copyright (c) 2008-2011 Octave & Octave (http://www.octaveoctave.com)
* @license     http://centurion-project.org/license/new-bsd     New BSD License
* @version     $Id$
*/

/**
 * @category    Redirect
* @package     Redirect_Controller
* @copyright   Copyright (c) 2008-2011 Octave & Octave (http://www.octaveoctave.com)
* @license     http://centurion-project.org/license/new-bsd     New BSD License
* @author      Laurent Chenay <lc@centurion-project.org>
*/
class Redirect_HistoryController extends Centurion_Controller_Action
{
    /**
     * 
     * @throws Centurion_Controller_Action_Exception When the request is not valid
     * @throws Centurion_Controller_Action_Gone_Exception Tell the browser (or bot) that the ressource has gone. HTTP code 410
     */
    public function historyAction()
    {
        $history = $this->_getParam('history');
        
        if ($history == null || !($history instanceof Centurion_Db_Table_Row_Abstract)) {
            throw new Centurion_Controller_Action_Exception();
        }
        if (null !== $history->new_url) {
            $this->_redirect($history->new_url, array('code' => 301));
        } else if (null !== ($row = $history->getProxy())) {
            $this->_redirect($row->permalink, array('code' => 301));
        } else {
            $this->getResponse()->setHttpResponseCode(410);
            $this->getHelper('layout')->disableLayout();
            $this->getHelper('ViewRenderer')->setNoRender();
            $this->getResponse()->sendHeaders();
            die();
        }
    }
}
