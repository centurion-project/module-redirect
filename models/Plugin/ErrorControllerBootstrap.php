<?php

class Redirect_Model_Plugin_ErrorControllerBootstrap extends Zend_Controller_Plugin_Abstract
{
    public function postDispatch(Zend_Controller_Request_Abstract $request) {
        $response = $this->getResponse();

        if ($response->isException()) {
            $datas = array();

            $exceptions = $response->getException();
            foreach ($exceptions as $exception) {
                if ($exception instanceof Zend_Controller_Dispatcher_Exception || $exception->getCode() == '404') {
                    $row = Centurion_Db::getSingleton('redirect/lifo')->findOneByOld_permalink($request->getRequestUri());

                    if (null !== $row) {
                        $request->setParam('history', $row);
                        $request->setControllerName('redirect');
                        $request->setModuleName('redirect');
                        $request->setActionName('history');

                        $request->setDispatched(false);
                    } else {
                        $datas['url'] = $request->getRequestUri();
                        $datas['message'] = $exception->getMessage();
                        list($row, ) = Centurion_Db::getSingleton('redirect/log')->getOrCreate($datas);

                        $row->nb++;
                        $row->save();
                    }
                }
            }
        }

        /*
        if ($response->isRedirect()) {

        }
        */

    }
}
