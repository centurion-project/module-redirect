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
class Redirect_AdminLogController extends Centurion_Controller_CRUD
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
        $this->_model = Centurion_Db::getSingleton('redirect/log');

        $this->_formClassName = 'Redirect_Form_Model_Log';

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
